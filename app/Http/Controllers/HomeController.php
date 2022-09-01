<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\System;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        /* Assign super admin admin role automatically */
//        if (user()->email === 'super@admin.com'){
//            if (!user()->hasRole('admin'))
//                user()->assignRole('admin');
//        }
        /*  */

        //Get all systems count
        $systemsCount = System::all()->count();

        //get all developers
        list($developers) = User::all()->partition(function ($user) {
            return $user->hasRole(['developer']);
        });

        //get incomplete issues
        $incompleteIssues = Issue::whereCompletedAt(null)->where('status', '<>', 6)
            ->get();

        //get assigned tasks
        $assignedIssuesCount = $incompleteIssues->where('assigned_at', '<>' , null)
            ->count();

        //get unAssigned tasks
        $unAssignedIssuesCount = $incompleteIssues->where('assigned_at', null)
            ->count();

        return Inertia::render('Dashboard', [
            'systemsCount' => $systemsCount,
            'developersCount' => $developers->count(),
            'incompleteIssuesCount' => $incompleteIssues->count(),
            'assignedIssuesCount' => $assignedIssuesCount,
            'unAssignedIssuesCount' => $unAssignedIssuesCount,
        ]);
    }
}
