<?php

namespace App\Http\Controllers;

use App\Models\Dependent;
use App\Models\Member;
use App\Models\MembershipCard;
use App\Models\User;

use Carbon\Carbon;

class MainController extends Controller
{
    public function home()
    {
        $totalMembers = Member::count();
        $totalDependents = Dependent::count();
        $totalUsers = User::whereNot('role', 'admin')->count();
        $today = Carbon::now();
        $totalMembershipCards = MembershipCard::where('expires_at', '>', $today)->where(function ($query) {
            $query->whereNotNull('member_id')->orWhereNotNull('dependent_id');
        })->count();
        $lastsCards = MembershipCard::with(['member', 'dependent'])->orderBy('created_at', 'desc')->limit(5)->withTrashed()->get();

        return view('home', compact(
            'totalMembers',
            'totalDependents',
            'totalUsers',
            'totalMembershipCards',
            'lastsCards'
        ));
    }

    public function administration()
    {
        return view('administration');
    }
}
