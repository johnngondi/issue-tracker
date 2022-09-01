<?php

namespace App\Listeners;

use App\Events\IssueStateChangedEvent;
use App\Mail\IssueStateChangedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendIssueStateChangedNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  IssueStateChangedEvent  $event
     * @return void
     */
    public function handle(IssueStateChangedEvent $event)
    {
        $payload = $event->payload;

        if ($payload->log->action == 'assigned') {
            //send notification to user
            Mail::send(new IssueStateChangedMail((object)[
                'reply_to' => config('app.admin_mail_address'),
                'to' => $payload->issue->requester_email,
                'name' => $payload->issue->requester_name,
                'subject' => "Issue: " . $payload->issue->title . " assigned to developer",
                'message' => "Your issue has been assigned to a developer",
                'message2' => "Start date has been set to: <b>" .
                    date('M d, Y', strtotime($payload->issue->planned_start_at)) .
                    "</b>.<br><br>" .
                    "It has been scheduled to last for " . $payload->issue->days . " days"
            ]));

            //send to programmer
            Mail::send(new IssueStateChangedMail((object)[
                'reply_to' => config('app.admin_mail_address'),
                'to' => $payload->issue->user->email,
                'name' => $payload->issue->user->name,
                'subject' => "Issue: " . $payload->issue->title . " assigned to you",
                'message' => "The " . $payload->issue->title . " issue has been assigned to you. See it at " .
                    "<a href = '" . route('issues.show', $payload->issue->id) . "'>" .
                    route('issues.show', $payload->issue->id) .
                    "</a> ",
                'message2' => "Start date has been set to: <b>" .
                    date('M d, Y', strtotime($payload->issue->planned_start_at)) .
                    "</b>.<br><br>" .
                    "It has been scheduled to last for " . $payload->issue->days . " days." .
                    "<br><br> Incase you need more information, set the status to <b>started</b> then" .
                    " <b>paused</b> and add the requested data as message"
            ]));

        } elseif ($payload->log->action == 'started') {
            //send notification to user
            Mail::send(new IssueStateChangedMail((object)[
                'reply_to' => config('app.admin_mail_address'),
                'to' => $payload->issue->requester_email,
                'name' => $payload->issue->requester_name,
                'subject' => "Issue: " . $payload->issue->title . " started",
                'message' => "Your issue is being worked on by the developer",
                'message2' => "In case more information is needed, you will be informed"
            ]));

        } elseif ($payload->log->action == 'paused') {
            //send notification to user
            Mail::send(new IssueStateChangedMail((object)[
                'reply_to' => $payload->issue->user->email,
                'to' => $payload->issue->requester_email,
                'name' => $payload->issue->requester_name,
                'subject' => "Issue: " . $payload->issue->title . " paused",
                'message' => "Your issue has been paused by the developer",
                'message2' => "The following message was provided: " . $payload->log->message .
                    "<br><br> Reply this message to provide any feedback"
            ]));

        } elseif ($payload->log->action == 'completed') {
            //send notification to user
            Mail::send(new IssueStateChangedMail((object)[
                'reply_to' => config('app.admin_mail_address'),
                'to' => $payload->issue->requester_email,
                'name' => $payload->issue->requester_name,
                'subject' => "Issue: " . $payload->issue->title . " completed",
                'message' => "Congratulations! Your issue has been addressed by the developer",
                'message2' => "The following message was provided: " . $payload->log->message
            ]));
        } elseif ($payload->log->action == 'rejected') {
            //send notification to user
            Mail::send(new IssueStateChangedMail((object)[
                'reply_to' => config('app.admin_mail_address'),
                'to' => $payload->issue->requester_email,
                'name' => $payload->issue->requester_name,
                'subject' => "Issue: " . $payload->issue->title . " rejected",
                'message' => "Sorry! Your issue has been rejected",
                'message2' => "The following message was provided: " . $payload->log->message
            ]));
        }
    }
}
