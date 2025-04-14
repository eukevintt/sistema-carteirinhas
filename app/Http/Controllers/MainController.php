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

        return view('home', compact(
            'totalMembers',
            'totalDependents',
            'totalUsers',
            'totalMembershipCards'
        ));
    }
}
