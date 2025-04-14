<?php

namespace App\Http\Controllers;

use App\Models\Dependent;
use App\Models\Member;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'username' => 'required|min:3|max:30',
                'password' => 'required|min:5|max:32'
            ],
            [
                'username.required' => 'O Usuário é obrigatório.',
                'username.min' => 'O Usuário deve ter pelo menos :min caracteres.',
                'username.max' => 'O Usuário não pode ter mais de :max caracteres.',
                'password.required' => 'A Senha é obrigatória.',
                'password.min' => 'A senha deve ter pelo menos :min caracteres.',
                'password.max' => 'A senha não pode ter mais de :max caracteres.'
            ]
        );

        $user = User::withTrashed()->where('nickname', $request->username)->first();

        if (!$user) {
            $member = Member::where('registration_number', $request->username)->first();

            if ($member) {
                $user = User::withTrashed()->where('member_id', $member->id)->first();
            }
        }

        if (!$user) {
            $dependent = Dependent::where('registration_number', $request->username)->first();

            if ($dependent) {
                $user = User::withTrashed()->where('dependent_id', $dependent->id)->first();
            }
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withInput()->with(['invalid_login' => 'Usuário ou Senha inválidos.']);
        }

        if ($user->trashed()) {
            return back()->withInput()->with(['invalid_login' => 'Você foi desativado pela gerência, entre em contato com o grêmio através do e-mail: contato@gremiopetros.com ou <a href="mailto:contato@gremiopetros.com">clicando aqui</a>. ']);
        }

        Auth::login($user);
        $user->update(['last_login_at' => now()]);
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }

    public function showRegistrationForm()
    {
        return view('auth.signup');
    }

    public function register(Request $request)
    {
        $request->validate(
            [
                'username' => 'required|min:3|max:30|unique:users,nickname',
                'registration_number' => [
                    'required',
                    function ($attributes, $value, $fail) {
                        $member = Member::where('registration_number', $value)->first();
                        $dependent = null;

                        if (!$member) {
                            $dependent = Dependent::where('registration_number', $value)->first();
                        }

                        if (!$member && !$dependent) {
                            return $fail('Essa matrícula é inválida.');
                        }

                        $registrationNumberInUse = User::where('member_id', $member?->id)->orWhere('dependent_id', $dependent?->id)->exists();

                        if ($registrationNumberInUse) {
                            return $fail('Essa matrícula já está vinculada a outro usuário.');
                        }
                    }
                ],
                'birth_date' => 'required|date',
                'password' => 'required|min:5|max:32',
                'password_confirmation' => 'required|same:password',
                'photo' => 'required|image|mimes:jpg,jpeg,png'
            ],
            [
                'username.required' => 'O campo Usuário é obrigatório.',
                'username.min' => 'O Usuário deve conter no mínimo :min caracteres.',
                'username.max' => 'O Usuário deve conter no máximo :max caracteres.',
                'username.unique' => 'Esse nickname não pode ser usado.',
                'registration_number.required' => 'O campo Matrícula é obrigatório.',
                'birth_date.required' => 'A Data de Nascimento é obrigatória.',
                'password.required' => 'A senha é obrigatória.',
                'password.min' => 'A Senha deve conter no mínimo :min caracteres.',
                'password.max' => 'A Senha deve conter no máximo :max caracteres.',
                'password_confirmation.required' => 'A Confirmação da Senha é Obrigatória.',
                'password_confirmation.same' => 'As senhas não conferem.',
                'photo.image' => 'O arquivo enviado deve ser uma imagem.',
                'photo.required' => 'A foto é obrigatória.',
                'photo.mimes' => 'A imagem deve estar nos formatos: JPG, JPEG ou PNG.',
            ]
        );

        $user = new User();
        $user->nickname = $request->username;
        $user->birth_date = $request->birth_date;
        $user->password = Hash::make($request->password);

        $dependent = Dependent::where('registration_number', $request->registration_number)->first();
        if ($dependent) {
            $user->dependent_id = $dependent->id;
            $user->role = 'dependent';
        } else {
            $member = Member::where('registration_number', $request->registration_number)->first();
            if ($member) {
                $user->member_id = $member->id;
                $user->role = 'member';
            }
        }

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $file = $request->file('photo');
            $filename = time() . '.jpg';
            $photoPath = 'profile_photos/' . $filename;
            $storagePath = storage_path('app/' . $photoPath);

            $manager = new ImageManager(new Driver());

            $image = $manager->read($file->getContent());

            $image->cover(472, 472);
            $image->toJpeg(75)->save($storagePath);

            $user->photo = $photoPath;
        } else {
            $user->photo = null;
        }

        $user->save();
        Auth::login($user);

        return redirect()->route('home');
    }

    public function profile()
    {
        return view('auth.profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate(
            [
                'current_password' => 'required|min:5|max|32',
                'new_password' => 'required|min:5|max:32|different:current_password',
                'new_password_confirmation' => 'required|same:new_password',
            ],
            [
                'current_password.required' => 'A senha atual é obrigatória.',
                'current_password.min' => 'A senha atual deve conter no mínimo :min caracteres.',
                'current_password.max' => 'A senha atual deve conter no máximo :max caracteres.',
                'new_password.required' => 'A nova senha é obrigatória.',
                'new_password.min' => 'A nova senha deve conter no mínimo :min caracteres.',
                'new_password.max' => 'A nova senha deve conter no máximo :max caracteres.',
                'new_password.different' => 'A nova senha deve ser diferente da senha atual.',
                'new_password_confirmation.required' => 'A confirmação da nova senha é obrigatória.',
                'new_password_confirmation.same' => 'As senhas não conferem.'
            ]
        );

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withInput()->with(['server_error' => 'A senha atual é inválida!.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('profile')->with(['success' => 'Senha alterada com sucesso!']);
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot_password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate(
            [
                'registration_number' => ['required'],
                'new_password' => 'required|min:5|max:32|confirmed',
            ],
            [
                'registration_number.required' => 'O campo Matrícula é obrigatório.',
                'new_password.required' => 'A nova senha é obrigatória.',
                'new_password.min' => 'A nova senha deve conter no mínimo :min caracteres.',
                'new_password.max' => 'A nova senha deve conter no máximo :max caracteres.',
                'new_password.confirmed' => 'As senhas não conferem.'
            ]
        );

        $registrationNumber = $request->registration_number;
        $newPassword = Hash::make($request->new_password);

        $member = Member::where('registration_number', $registrationNumber)->first();
        if ($member) {
            $user = User::where('member_id', $member->id)->first();
        }

        if (!isset($user)) {
            $dependent = Dependent::where('registration_number', $registrationNumber)->first();

            if ($dependent) {
                $user = User::where('dependent_id', $dependent->id)->first();
            }
        }

        if (empty($user)) {
            return back()->withInput()->withErrors(['registration_number' => 'Essa matrícula é inválida ou não possui cadastro.']);
        }

        $user->update(['password' => $newPassword]);

        return redirect()->route('login')->with('success', 'Senha alterada com sucesso! Você já pode fazer o login.');
    }
}
