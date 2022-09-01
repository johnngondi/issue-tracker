<?php

namespace App\Http\Controllers\API\V1;

use App\Events\IssueCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use App\Models\Issue;
use App\Models\System;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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
        //validate email
        $email = $request->validate([
            'email' => 'required'
        ])['email'];

        //get system
        $system = $this->getCurrentSystem($request);

        //get issues in that system where requester email is equal to current email
        $issues = DB::table('issues')
            ->where('system_id', $system->id)
            ->where('requester_email', $email)
            ->get(['title', 'description', 'type', 'urgency', 'importance', 'status']);

        return response(new DataResource([
            'code' => 0,
            'issues' => $issues
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {

//        $input = $request->validate([
//            'title' => 'required|unique:issues',
//            'description' => '',
//            'type' => 'required',
//            'urgency' => 'required',
//            'importance' => 'required',
//            'requester_name' => 'required',
//            'requester_email' => 'required',
//            'requester_dept' => '',
//            'page_title' => '',
//            'page_url' => '',
//        ]);

        try {
            $input = $request->validate([
                'title' => 'required|unique:issues',
                'description' => '',
                'type' => 'required',
                'urgency' => 'required',
                'importance' => 'required',
                'requester_name' => 'required',
                'requester_email' => 'required',
                'requester_dept' => '',
                'page_title' => '',
                'page_url' => '',
            ]);

            $issue = Issue::create(array_merge($input, [
                'system_id' => $this->getCurrentSystem($request)->id
            ]));

            //add log to issue log
            $issue->logs()->create([
                'action' => 'created',
                'message' => 'Issue has been created'
            ]);

            //Trigger issue created event with payload
            event(new IssueCreatedEvent($issue));


            return response(new DataResource([
                'code' => 0,
                'issue' => $issue
            ]));

        } catch (Exception $exception) {
            return response(new DataResource([
                'code' => 1,
                'ex' => $exception->getMessage()
            ]));
        }
    }

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
//    public function destroy($id)
//    {
//        //
//    }

    /**
     * @param Request $request
     * @return System | mixed
     */
    private function getCurrentSystem(Request $request)
    {
        //user() is used to fetch system because we are validating requests against system api key.
        //This means that the system is the currently logged in user i.e. $request->user().
        return $request->user();
    }
}
