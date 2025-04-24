<?php

namespace App\Http\Controllers;

use App\Exports\DependentExport;
use App\Models\Dependent;
use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DependentController extends Controller
{
    public function index()
    {
        $dependents = Dependent::paginate(10);
        $inactiveDependents = Dependent::onlyTrashed()->orderBy('name')->get();
        $membersWithDependents = Member::whereHas('dependents')->with('dependents')->orderBy('name')->paginate(10);

        return view('dependents.index', compact('dependents', 'membersWithDependents', 'inactiveDependents'));
    }

    public function create()
    {
        $members = Member::all();

        return view('dependents.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'member_id' => 'required|exists:members,id',
            ],
            [
                'name.required' => 'O nome do dependente é obrigatório.',
                'name.string' => 'O nome do dependente deve ser uma string.',
                'name.max' => 'O nome do dependente deve ter no máximo :max caracteres.',
                'member_id.required' => 'O associado é obrigatório.',
                'member_id.exists' => 'O associado selecionado não existe.',
            ]
        );

        if (Dependent::count() >= 200) {
            return redirect()->route('dependents.create')->withErrors(['error', 'Limite de dependentes atingido. Se deseja aumentar o limite, entre em contato com o suporte.']);
        }

        $member = Member::find($request->member_id);
        $suffix = 1;

        do {
            $registrationNumber = $member->registration_number . '-' . $suffix;
            $exists = Dependent::where('registration_number', $registrationNumber)->withTrashed()->exists();
            $suffix++;
        } while ($exists);

        Dependent::create([
            'name' => $request->name,
            'registration_number' => $registrationNumber,
            'member_id' => $request->member_id,
        ]);

        return redirect()->route('dependents.create')->with('success', 'Dependente criado com sucesso!');
    }

    public function edit(Dependent $dependent)
    {
        $members = Member::all();

        return view('dependents.edit', compact('dependent', 'members'));
    }

    public function update(Request $request, Dependent $dependent)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'registration_number' => 'required|string|max:255|unique:dependents,registration_number,' . $dependent->id,
                'member_id' => 'required|exists:members,id',
            ],
            [
                'name.required' => 'O nome do dependente é obrigatório.',
                'name.string' => 'O nome do dependente deve ser uma string.',
                'name.max' => 'O nome do dependente deve ter no máximo :max caracteres.',
                'registration_number.required' => 'A matrícula é obrigatória.',
                'registration_number.string' => 'A matrícula deve ser uma string.',
                'registration_number.max' => 'A matrícula deve ter no máximo :max caracteres.',
                'registration_number.unique' => 'Essa matrícula já está em uso.',
                'member_id.required' => 'O associado é obrigatório.',
                'member_id.exists' => 'O associado selecionado não existe.',
            ]
        );

        $dependent->update(
            [
                'name' => $request->name,
                'registration_number' => $request->registration_number,
                'member_id' => $request->member_id,
            ]
        );

        return redirect()->route('dependents.index')->with('success', 'Dependente atualizado com sucesso!');
    }

    public function suspend(Dependent $dependent)
    {
        optional($dependent->user)->delete();

        optional($dependent->membershipCards)->each(function ($card) {
            $card->delete();
        });

        $dependent->delete();

        return redirect()->route('dependents.index')->with('success', 'O dependente, suas carteirinhas e seu usuário foram suspensos com sucesso.');
    }

    public function reactivate(Dependent $dependent)
    {
        $dependent = Dependent::withTrashed()->with([
            'user' => function ($query) {
                $query->withTrashed();
            },
            'membershipCards' => function ($query) {
                $query->withTrashed();
            },
        ])->findOrFail($dependent->id);

        $dependent->restore();
        optional($dependent->user)->restore();
        optional($dependent->membershipCards)->each(function ($card) {
            $card->restore();
        });

        return redirect()->route('dependents.index')->with('success', 'O dependente, suas carteirinhas e seu usuário foram reativados com sucesso.');
    }

    public function destroy(Dependent $dependent)
    {
        $dependent = Dependent::withTrashed()->with([
            'user' => function ($query) {
                $query->withTrashed();
            },
            'membershipCards' => function ($query) {
                $query->withTrashed();
            },
        ])->findOrFail($dependent->id);

        if ($dependent->membershipCards()->exists()) {
            $dependent->membershipCards()->forceDelete();
            $this->deleteCardFile('dependent', $dependent->user->nickname);
        }

        if (optional($dependent->user)->photo) {
            $this->deletePhoto($dependent->user->photo);
            $dependent->user->forceDelete();
        }

        $dependent->forceDelete();

        return redirect()->route('dependents.index')->with('success', 'O dependente, suas carteirinhas e seu usuário foram deletados com sucesso.');
    }

    private function deleteCardFile($role, $nickname)
    {
        $filename = $role === 'dependent' ? 'card_dependent_' . str_replace(' ', '_', $nickname) . '.pdf' : 'card_' . str_replace(' ', '_', $nickname) . '.pdf';

        Storage::disk('membership_cards')->delete($filename);
    }

    private function deletePhoto($path)
    {
        Storage::delete($path);
    }

    public function exportPDF()
    {
        $dependents = Dependent::with('member')->get();

        $pdf = Pdf::loadView('dependents.pdf-export', compact('dependents'));
        return $pdf->download('dependentes.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new DependentExport, 'dependentes.xlsx');
    }

    public function exportCSV()
    {
        return Excel::download(new DependentExport, 'dependentes.csv');
    }

    public function print()
    {
        $dependents = Dependent::with('member')->get();

        return view('dependents.pdf-export', compact('dependents'));
    }
}
