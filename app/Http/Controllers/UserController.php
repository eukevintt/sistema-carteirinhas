<?php

namespace App\Http\Controllers;

use App\Models\Dependent;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class UserController extends Controller
{
    public function index()
    {
        $isAdmin = Gate::allows('admin');

        $activeUsers = User::with('member')->when(!$isAdmin, function ($query) {
            $query->whereNot('role', 'admin');
        })->whereNull('deleted_at')->get();

        $inactiveUsers = User::with('member')->onlyTrashed()->when(!$isAdmin, function ($query) {
            $query->whereNot('role', 'admin');
        })->get();

        return view('users.index', compact('activeUsers', 'inactiveUsers'));
    }

    public function show(User $user)
    {
        $user->load('member.depedents');

        $dependents = optional($user->member)->dependents ?? collect();

        return view('user.details', compact('user', 'dependents'));
    }

    public function create()
    {
        $usedMemberIds = User::whereNotNull('member_id')->pluck('member_id')->toArray();
        $usedDependentIds = User::whereNotNull('dependent_id')->pluck('dependent_id')->toArray();

        $availableMembers = Member::whereNotIn('id', $usedMemberIds)->get();
        $availableDependents = Dependent::whereNotIn('id', $usedDependentIds)->get();

        return view('users.create', compact('availableMembers', 'availableDependents'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nickname' => 'required|string|min:3|max:255|unique:users,nickname',
                'birth_date' => 'nullable|date',
                'role' => 'required|in:admin,management,member,dependent',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg',
                'password' => 'required|min:5|max:32',
                'password_confirmation' => 'required|same:password',
                'option' => 'required|in:new_member,new_dependent,existing_member,existing_dependent,none',
                'member_name' => 'required_if:option,new_member|nullable|string|max:255',
                'member_registration_number' => 'required_if:option,new_member|nullable|string|max:255|unique:members,registration_number',
                'member_id' => 'required_if:option,existing_member|nullable|exists:members,id',
                'dependent_name' => 'required_if:option,new_dependent|nullable|string|max:255',
                'dependent_member_id' => 'required_if:option,new_dependent|nullable|exists:members,id',
                'dependent_id' => 'required_if:option,existing_dependent|nullable|exists:dependents,id',
            ],
            [
                'nickname.required' => 'O usuário é obrigatório.',
                'nickname.string' => 'O usuário deve ser uma string.',
                'nickname.min' => 'O usuário deve ter no mínimo :min caracteres.',
                'nickname.max' => 'O usuário deve ter no máximo :max caracteres.',
                'nickname.unique' => 'Esse usuário já está em uso.',
                'birth_date.date' => 'A data de nascimento deve ser uma data válida.',
                'role.required' => 'O nível é obrigatório.',
                'role.in' => 'O nível deve ser um dos seguintes: Administrador, Gerência, Associado ou Dependente.',
                'photo.image' => 'A foto deve ser uma imagem válida.',
                'photo.mimes' => 'A foto deve ser do tipo: jpeg, png, jpg.',
                'password.required' => 'A senha é obrigatória.',
                'password.min' => 'A senha deve ter no mínimo :min caracteres.',
                'password.max' => 'A senha deve ter no máximo :max caracteres.',
                'password_confirmation.required' => 'A confirmação da senha é obrigatória.',
                'password_confirmation.same' => 'As senhas não coincidem.',
                'option.required' => 'A opção é obrigatória.',
                'option.in' => 'A opção deve ser uma das seguintes: Novo Associado, Novo Dependente, Associado Existente, Dependente Existente ou Nenhum.',
                'member_name.required_if' => 'O nome do associado é obrigatório.',
                'member_name.string' => 'O nome do associado deve ser uma string.',
                'member_name.max' => 'O nome do associado deve ter no máximo :max caracteres.',
                'member_registration_number.required_if' => 'A matrícula do associado é obrigatória.',
                'member_registration_number.string' => 'A matrícula do associado deve ser uma string.',
                'member_registration_number.max' => 'A matrícula do associado deve ter no máximo :max caracteres.',
                'member_registration_number.unique' => 'Essa matrícula já está em uso.',
                'member_id.required_if' => 'O associado é obrigatório.',
                'member_id.exists' => 'O associado selecionado não existe.',
                'dependent_name.required_if' => 'O nome do dependente é obrigatório.',
                'dependent_name.string' => 'O nome do dependente deve ser uma string.',
                'dependent_name.max' => 'O nome do dependente deve ter no máximo :max caracteres.',
                'dependent_member_id.required_if' => 'O associado é obrigatório.',
                'dependent_member_id.exists' => 'O associado selecionado não existe.',
                'dependent_id.required_if' => 'O dependente é obrigatório.',
                'dependent_id.exists' => 'O dependente selecionado não existe.',
            ]
        );

        $memberId = null;
        $dependentId = null;

        if (User::where('role', '!=', 'admin')->count() >= 200) {
            return redirect()->route('users.create')->withErrors(['error' => 'Limite de usuários atingido. Se deseja aumentar o limite, entre em contato com o suporte.']);
        }

        switch ($request->option) {
            case 'new_member':
                $member = Member::create([
                    'name' => $request->member_name,
                    'registration_number' => $request->member_registration_number,
                ]);
                $memberId = $member->id;
                break;

            case 'new_dependent':
                $dependent = Dependent::create([
                    'name' => $request->dependent_name,
                    'member_id' => $request->dependent_member_id,
                ]);
                $dependentId = $dependent->id;
                break;

            case 'existing_member':
                $memberId = $request->member_id;
                break;

            case 'existing_dependent':
                $dependentId = $request->dependent_id;
                break;
        }

        $photoPath = null;
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $file = $request->file('photo');
            $filename = now()->timestamp . '.jpg';
            $photoPath = 'profile_photos/' . $filename;
            $storagePath = storage_path('app/' . $photoPath);

            $manager = new ImageManager(new Driver());

            $image = $manager->read($file->getContent());

            $image->cover(472, 472);
            $image->toJpeg(75)->save($storagePath);
        }

        User::create([
            'nickname' => $request->nickname,
            'birth_date' => $request->birth_date,
            'role' => $request->role,
            'photo' => $photoPath,
            'password' => Hash::make($request->password),
            'member_id' => $memberId,
            'dependent_id' => $dependentId,
        ]);

        return redirect()->route('users.create')->with('success', 'Usuário criado com sucesso.');
    }

    public function edit(User $user)
    {
        $user->load(['member', 'dependent']);

        $member = $user->member;
        $dependent = $user->dependent;

        return view('users.edit', compact('user', 'member', 'dependent'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate(
            [
                'nickname' => 'required|string|max:255|unique:users,nickname,' . $user->id,
                'birth_date' => 'nullable|date',
                'role' => 'required|in:admin,management,member,dependent',
                'password' => 'nullable|min:5|max:32|confirmed',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg',
                'member_id' => 'nullable|exists:members,id',
                'dependent_id' => 'nullable|exists:dependents,id',
            ],
            [
                'nickname.required' => 'O usuário é obrigatório.',
                'nickname.string' => 'O usuário deve ser uma string.',
                'nickname.max' => 'O usuário deve ter no máximo :max caracteres.',
                'nickname.unique' => 'Esse usuário já está em uso.',
                'birth_date.date' => 'A data de nascimento deve ser uma data válida.',
                'role.required' => 'O nível é obrigatório.',
                'role.in' => 'O nível deve ser um dos seguintes: Administrador, Gerência, Associado ou Dependente.',
                'password.min' => 'A senha deve ter no mínimo :min caracteres.',
                'password.max' => 'A senha deve ter no máximo :max caracteres.',
                'password.confirmed' => 'As senhas não coincidem.',
                'photo.image' => 'A foto deve ser uma imagem válida.',
                'photo.mimes' => 'A foto deve ser do tipo: jpeg, png, jpg.',
                'member_id.exists' => 'O associado selecionado não existe.',
                'dependent_id.exists' => 'O dependente selecionado não existe.',
            ]
        );

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {

            if ($user->photo) {
                $this->deletePhoto($user->photo);
            }

            $file = $request->file('photo');
            $filename = now()->timestamp . '.jpg';
            $photoPath = 'profile_photos/' . $filename;
            $storagePath = storage_path('app/' . $photoPath);

            $manager = new ImageManager(new Driver());

            $image = $manager->read($file->getContent());

            $image->cover(472, 472);
            $image->toJpeg(75)->save($storagePath);

            $user->photo = $photoPath;
        } else {
            $photoPath = $user->photo;
        }

        if ($request->has('member_id')) {
            $memberId = $request->member_id;
            $dependentId = null;
        } else if ($request->has('dependent_id')) {
            $dependentId = $request->dependent_id;
            $memberId = null;
        } else {
            $memberId = null;
            $dependentId = null;
        }

        $user->update([
            'nickname' => $request->nickname,
            'birth_date' => $request->birth_date,
            'role' => $request->role,
            'photo' => $photoPath,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            'member_id' => $memberId,
            'dependent_id' => $dependentId,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    public function suspend(User $user)
    {
        if ($user->member) {
            $user->member->membershipCards()->delete();

            $user->member->dependents()->with('membershipCards')->get()->each(function ($dependent) {
                $dependent->membershipCards()->delete();

                if ($dependent->user) {
                    $dependent->user->delete();
                }

                $dependent->delete();
            });

            $user->member->delete();
        }

        if ($user->dependent) {
            $user->dependent->membershipCards()->delete();

            $user->dependent->delete();
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuários e todos os seus vínculos foram suspensos com sucesso.');
    }

    public function reactivate(User $user)
    {
        $user = User::withTrashed()->with([
            'member' => function ($query) {
                $query->withTrashed();
            },
            'member.dependents' => function ($query) {
                $query->withTrashed();
            },
            'member.membershipCards' => function ($query) {
                $query->withTrashed();
            },
            'member.dependents.user' => function ($query) {
                $query->withTrashed();
            },
            'member.dependents.membershipCards' => function ($query) {
                $query->withTrashed();
            },
            'dependent' => function ($query) {
                $query->withTrashed();
            },
            'dependent.membershipCards' => function ($query) {
                $query->withTrashed();
            },
        ])->findOrFail($user->id);

        $user->restore();

        if ($user->member) {
            $user->member->restore();
            $user->member->membershipCards->each->restore();

            $user->member->dependents->each(function ($dependent) {
                $dependent->restore();
                optional($dependent->user)->restore();
                optional($dependent->membershipCards)->each->restore();
            });
        }

        if ($user->dependent) {
            $user->dependent->restore();
            optional($user->dependent->membershipCards)->each->restore();
        }

        return redirect()->route('users.index')->with('success', 'Usuário e seus vínculos reativados com sucesso.');
    }

    public function destroy(User $user)
    {
        $user = User::withTrashed()->with([
            'member' => function ($query) {
                $query->withTrashed();
            },
            'member.dependents' => function ($query) {
                $query->withTrashed();
            },
            'member.membershipCards' => function ($query) {
                $query->withTrashed();
            },
            'member.dependents.user' => function ($query) {
                $query->withTrashed();
            },
            'member.dependents.membershipCards' => function ($query) {
                $query->withTrashed();
            },
            'dependent' => function ($query) {
                $query->withTrashed();
            },
            'dependent.membershipCards' => function ($query) {
                $query->withTrashed();
            },
        ])->findOrFail($user->id);

        if ($user->photo) {
            $this->deletePhoto($user->photo);
        }

        if ($user->membershipCards()->exists()) {
            $user->membershipCards()->forceDelete();
            $this->deleteCardFile($user->role, $user->nickname);
        }

        if ($user->member) {
            $user->member->membershipCards->each->forceDelete();
            $this->deleteCardFile('member', $user->nickname);

            $user->member->dependents->each(function ($dependent) {
                optional($dependent->user)->membershipCards->each->forceDelete();
                if (optional($dependent->user)->photo) {
                    $this->deletePhoto($dependent->user->photo);
                }
                optional($dependent->user)->forceDelete();
                $dependent->forceDelete();
            });

            $user->member->forceDelete();
        }

        if ($user->dependent) {
            $user->dependent->membershipCards->each->forceDelete();
            $this->deleteCardFile('dependent', $user->nickname);
            $user->dependent->forceDelete();
        }

        $user->forceDelete();

        return redirect('users.index')->with('success', 'Usuário e todos os seus vínculos foram deletados com sucesso.');
    }

    public function getProfilePhoto(User $user)
    {
        $auth = auth()->user();

        if ($auth->id !== $user->id && !Gate::allows('admin') && !Gate::allows('management')) {
            abort(403, 'Acesso não autorizado.');
        }

        $path = storage_path('app/' . $user->photo);

        if (!file_exists($path)) {
            abort(404, 'Foto não encontrada.');
        }

        return response()->file($path);
    }

    private function deleteCardFile($role, $nickname)
    {
        $filename = $role === 'dependent' ? 'card_dependent_' . str_replace(' ', '_', $nickname) . '.pdf' : 'card_' . str_replace(' ', '_', $nickname) . '.pdf';

        Storage::disk('membership_cards')->delete($filename);
    }

    private function deletePhoto($path)
    {
        Storage::disk('profile_photos')->delete($path);
    }
}
