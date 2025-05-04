<?php

namespace App\Http\Controllers;

use App\Exports\MemberExport;
use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class MemberController extends Controller
{
    public function index()
    {
        $activeMembers = Member::all();
        $inactiveMembers = Member::onlyTrashed()->get();

        return view('members.index', compact('activeMembers', 'inactiveMembers'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'registration_number' => 'required|max:255|unique:members,registration_number',
            ],
            [
                'name.required' => 'O campo nome é obrigatório.',
                'name.string' => 'O nome deve ser uma string.',
                'name.max' => 'O nome deve ter no máximo :max caracteres.',
                'registration_number.required' => 'A matrícula é obrigatória.',
                'registration_number.max' => 'A matrícula deve ter no máximo :max caracteres.',
                'registration_number.unique' => 'Essa matrícula já está em uso.',
            ]
        );

        if (Member::count() >= 200) {
            return redirect()->route('members.create')->withErrors(['error' => 'Limite máximo de associados atingido. Se deseja aumentar o limite, entre em contato com o suporte.']);
        }

        Member::create([
            'name' => $request->name,
            'registration_number' => $request->registration_number,
        ]);

        return redirect()->route('members.create')->with('success', 'Associado criado com sucesso!');
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'registration_number' => 'required|max:255|unique:members,registration_number,' . $member->id,
            ],
            [
                'name.required' => 'O campo nome é obrigatório.',
                'name.string' => 'O nome deve ser uma string.',
                'name.max' => 'O nome deve ter no máximo :max caracteres.',
                'registration_number.required' => 'A matrícula é obrigatória.',
                'registration_number.max' => 'A matrícula deve ter no máximo :max caracteres.',
                'registration_number.unique' => 'Essa matrícula já está em uso.',
            ]
        );

        $member->update([
            'name' => $request->name,
            'registration_number' => $request->registration_number,
        ]);

        return redirect()->route('members.edit', $member->id)->with('success', 'Associado atualizado com sucesso!');
    }

    public function suspend(Member $member)
    {
        optional($member->user)->delete();
        optional($member->membershipCards)->each(function ($card) {
            $card->delete();
        });

        $member->dependents->each(function ($dependent) {
            optional($dependent->user)->delete();
            optional($dependent->membershipCards)->each(function ($card) {
                $card->delete();
            });
            $dependent->delete();
        });

        $member->delete();

        return redirect()->route('members.index')->with('Success', 'O associado, seus dependentes e suas carteirinhas foram suspensos com sucesso.');
    }

    public function reactivate(Member $member)
    {
        $member = Member::withTrashed()->with([
            'user' => function ($query) {
                $query->withTrashed();
            },
            'membershipCards' => function ($query) {
                $query->withTrashed();
            },
            'dependents' => function ($query) {
                $query->withTrashed()->with([
                    'user' => function ($query) {
                        $query->withTrashed();
                    },
                    'membershipCards' => function ($query) {
                        $query->withTrashed();
                    }
                ]);
            }
        ])->findOrFail($member->id);

        $member->restore();
        optional($member->user)->restore();
        optional($member->membershipCards)->each(function ($card) {
            $card->restore();
        });

        $member->dependents->each(function ($dependent) {
            $dependent->restore();
            optional($dependent->user)->restore();
            optional($dependent->membershipCards)->each(function ($card) {
                $card->restore();
            });
        });

        return redirect()->route('members.index')->with('success', 'O associado, seus dependentes e suas carteirinhas foram reativados com sucesso.');
    }

    public function destroy(Member $member)
    {
        $member = Member::withTrashed()->with([
            'user' => function ($query) {
                $query->withTrashed();
            },
            'dependents' => function ($query) {
                $query->withTrashed()->with([
                    'user' => function ($query) {
                        $query->withTrashed();
                    }
                ]);
            }
        ])->findOrFail($member->id);

        $member->dependents->each(function ($dependent) {
            if ($dependent->membershipCards()->exists()) {
                $dependent->user->membershipCards()->forceDelete();
                $this->deleteCardFile('dependent', $dependent->user->nickname);
            }

            if (optional($dependent->user)->photo) {
                $this->deletePhoto($dependent->user->photo);
            }

            $dependent->user()->forceDelete();
            $dependent->forceDelete();
        });

        if ($member->membershipCards()->exists()) {
            $member->membershipCards()->forceDelete();
            $this->deleteCardFile($member->user->role, $member->user->nickname);
        }

        if (optional($member->user)->photo) {
            $this->deletePhoto($member->user->photo);
        }

        $member->user()->forceDelete();
        $member->forceDelete();

        return redirect()->route('members.index')->with('success', 'O associado, seus dependentes e suas carteirinhas foram deletados com sucesso.');
    }

    private function deleteCardFile($role, $nickname)
    {
        $filename = $role === 'dependent' ? 'membership_card_dependent_' . $nickname . '.pdf' : 'membership_card_' . $nickname . '.pdf';

        Storage::delete('membership_cards/' . $filename);
    }

    private function deletePhoto($path)
    {
        Storage::delete($path);
    }

    public function exportPDF()
    {
        $members = Member::all();
        $pdf = Pdf::loadView('members.pdf-export', compact('members'));
        return $pdf->download('associados.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new MemberExport, 'associados.xlsx');
    }

    public function exportCSV()
    {
        return Excel::download(new MemberExport, 'associados.csv');
    }

    public function print()
    {
        $members = Member::all();

        return view('members.pdf-export', compact('members'));
    }
}
