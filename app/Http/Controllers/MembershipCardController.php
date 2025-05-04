<?php

namespace App\Http\Controllers;

use App\Models\Dependent;
use App\Models\MembershipCard;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class MembershipCardController extends Controller
{
    public function index()
    {
        //
    }

    public function destroy($id)
    {
        $membershipCard = MembershipCard::findOrFail($id);
        $membershipCard->forceDelete();

        return redirect()->route('cards.index')->with('success', 'Carterinha excluída com sucesso!');
    }

    public function generateForMember(User $user)
    {
        if (Auth::user()->role === 'dependent') {
            return redirect()->route('cards.dependent.generate', ['user' => Auth::user()->id]);
        }

        $user->load('member.dependents');
        $dependents = $user->member ? $user->member->dependents : collect();

        return DB::transaction(function () use ($user, $dependents) {
            $expires_at = now()->addMonthNoOverflow()->startOfMonth();

            if ($exists = MembershipCard::where('member_id', $user->member->id)->where('expires_at', '>', now())->first()) {
                return redirect()->route('users.cards', ['user' => $user->id]);
            }

            MembershipCard::where('member_id', $user->member->id)->where('expires_at', '<', now())->delete();

            $pdf = Pdf::loadView('cards.member-card', compact('user', 'dependents'))->setPaper([0, 0, 850, 540], 'landscape');

            $filename = "membership_card_{$user->nickname}.pdf";
            $filePath = "membership_cards/{$filename}";

            Storage::put($filePath, $pdf->output());

            MembershipCard::create(
                [
                    'member_id' => $user->member->id,
                    'issued_at' => now(),
                    'expires_at' => $expires_at,
                    'pdf_file' => $filePath,
                ]
            );

            return response()->file(storage_path("app/{$filePath}"));
        });
    }

    public function generateForDependent(User $user)
    {
        $user->load(['member', 'dependent']);
        $member = $user->member;
        $dependent = $user->dependent;

        return DB::transaction(function () use ($dependent, $member, $user) {
            $expires_at = now()->addMonthNoOverflow()->startOfMonth();

            if (MembershipCard::where('dependent_id', $user->dependent->id)->where('expires_at', '>', now())->first()) {
                return redirect()->route('users.cards', ['user' => $user->id]);
            }

            MembershipCard::where('dependent_id', $user->dependent->id)->where('expires_at', '<', now())->delete();

            $pdf = Pdf::loadView('cards.dependent-card', compact('dependent', 'member', 'user'))->setPaper([0, 0, 850, 540], 'landscape');

            $filename = 'membership_card_dependent_' . str_replace(' ', '_', $dependent->nome) . '.pdf';
            $filePath = "membership_cards/{$filename}";

            Storage::put($filePath, $pdf->output());

            MembershipCard::create(
                [
                    'dependent_id' => $user->dependent->id,
                    'issued_at' => now(),
                    'expires_at' => $expires_at,
                    'pdf_file' => $filePath,
                ]
            );

            return response()->file(storage_path("app/{$filePath}"));
        });
    }

    public function seeMembershipCard(User $user)
    {
        $auth = Auth::user();

        if ($auth->id !== $user->id && !Gate::allows('admin') && !Gate::allows('management')) {
            abort(403, 'Acesso não autorizado');
        }

        $path = storage_path($user->member ? 'app/' . $user->member->membershipCards()->first()->pdf_file : 'app/' . $user->dependent->membershipCards()->first()->pdf_file);


        if (!file_exists($path)) {
            abort(404, 'Carterinha não encontrada.');
        }

        return response()->file($path);
    }
}
