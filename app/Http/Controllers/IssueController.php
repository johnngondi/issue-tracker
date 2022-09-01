<?php

namespace App\Http\Controllers;

use App\Events\IssueCreatedEvent;
use App\Events\IssueStateChangedEvent;
use App\Helpers\Classes\Issues;
use App\Helpers\Classes\Systems;
use App\Models\Issue;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class IssueController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $issues = Issues::getAccessibleByUser($request);

        return Inertia::render('Issues/Index', [
            'issues' => $issues,
            'canCreate' => Gate::check('create', new Issue()),
            'canDelete' => Gate::check('delete', new Issue()),
        ]);

    }

    /**
     * Display a listing of the filtered resources.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request): \Illuminate\Http\Response
    {
        $issues = Issues::getAccessibleByUser($request);

        return response([
            'issues' => $issues,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        Gate::authorize('create', new Issue());

        return Inertia::render('Issues/Create', [
            'systems' => Systems::getAccessibleByUser()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): \Illuminate\Http\Response
    {
        Gate::authorize('create', new Issue());

        try {
            $input = $request->validate([
                'title' => 'required|unique:issues',
                'system_id' => 'required|exists:systems,id',
                'description' => '',
                'type' => 'required',
                'urgency' => 'required',
                'importance' => 'required',
                'requester_name' => 'required',
                'requester_email' => 'required',
                'requester_dept' => '',
            ]);

            $issue = Issue::create($input);

            //add log to issue log
            $issue->logs()->create([
                'action' => 'created',
                'message' => 'Issue has been created'
            ]);

            //Trigger issue created event with payload
            event(new IssueCreatedEvent($issue));


            return response([
                'code' => 0,
                'issue' => $issue
            ]);

        } catch (Exception $exception) {
            return response([
                'code' => 1,
                'ex' => $exception->getMessage()
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param Issue $issue
     * @return Response
     */
    public function show(Issue $issue): Response
    {
        Gate::authorize('view', $issue);

        return Inertia::render('Issues/Show', [
            'canAssign' => user()->hasRole('admin'),
            'canUpdate' => $issue->user_id !== null && $issue->user->id === user()->id,
            'issue' => $issue->load(['user', 'logs'])->makeHidden(['system']),
            'issueSystem' => $issue->system->makeHidden(['users']),
            'developers' => user()->hasRole('admin') ? Systems::getDevelopers($issue->system) : null
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request | object $request
     * @param Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Issue $issue): \Illuminate\Http\Response
    {
        Gate::authorize('update', $issue);

        //check status type and update where necessary
        $date = [];
        $action = 'paused';
        if ($request->status === 3){
           $date = ['started_at' => Carbon::now()];
           $action = 'started';
        } elseif ($request->status === 5){
            $date = ['completed_at' => Carbon::now()];
            $action = 'completed';
        }

        $issue->update(array_merge([
            'status' => $request->status
        ], $date));

        //add log to issue log
        $log = $issue->logs()->create([
            'message' => $request->message,
            'action' => $action
        ]);

        //Trigger issue state changed event with payload
        event(new IssueStateChangedEvent([
            'issue' => $issue,
            'log' => $log
        ]));

        try {
            return response([
                'code' => 0,
                'issue' => $issue
            ]);
        } catch (Exception $exception) {
            return response([
                'code' => 1,
                'ex' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Assign issue to user.
     *
     * @param Request | object $request
     * @param Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function assign(Request $request, Issue $issue): \Illuminate\Http\Response
    {
        if (!user()->hasRole('admin'))
            return response([
                'code' => 1
            ], 401);

        try {
            //check status type and update where necessary
            $issue->update([
                'status' => 1,
                'user_id' => $request->user,
                'planned_start_at' => $request->planned_start,
                'assigned_at' => Carbon::now(),
                'days' => $request->days
            ]);

            //add log to issue log
            $log = $issue->logs()->create([
                'action' => 'assigned',
                'message' => 'issue assigned to developer'
            ]);

            //Trigger issue state changed event with payload
            event(new IssueStateChangedEvent([
                'issue' => $issue->load('user'),
                'log' => $log
            ]));

            return response([
                'code' => 0,
                'issue' => $issue
            ]);
        } catch (Exception $exception) {
            return response([
                'code' => 1,
                'ex' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Reject your issue.
     *
     * @param Request | object $request
     * @param Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request, Issue $issue): \Illuminate\Http\Response
    {
        if (!user()->hasRole('admin'))
            return response([
                'code' => 1
            ], 401);

        try {
            //check status type and update where necessary
            $issue->update([
                'status' => 6
            ]);

            //add log to issue log
            $log = $issue->logs()->create([
                'action' => 'rejected',
                'message' => $request->message
            ]);

            //Trigger issue state changed event with payload
            event(new IssueStateChangedEvent([
                'issue' => $issue->load('user'),
                'log' => $log
            ]));

            return response([
                'code' => 0,
                'issue' => $issue
            ]);
        } catch (Exception $exception) {
            return response([
                'code' => 1,
                'ex' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue): \Illuminate\Http\Response
    {
        Gate::authorize('delete', $issue);

        try {
            $issue->delete();

            return response([
                'code' => 0
            ]);
        } catch (Exception $exception) {
            return response([
                'code' => 1,
                'ex' => $exception->getMessage()
            ]);
        }
    }
}
