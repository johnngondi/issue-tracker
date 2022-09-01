<?php

namespace App\Listeners;

use App\Events\IssueCreatedEvent;
use App\Mail\IssueCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendIssueCreatedNotificationListener
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
     * @param  IssueCreatedEvent  $event
     * @return void
     */
    public function handle(IssueCreatedEvent $event)
    {
        $issue = $event->issue;

        //send email to requester
        Mail::send(new IssueCreatedMail((object)[
            'to' => $issue->requester_email,
            'name' => $issue->requester_name,
            'message' => "Your issue has been created. <br><br> You will receive updates when anything changes",
            'subject' => "Issue: " . $issue->title . " added"
        ]));

        //send email to admin
        Mail::send(new IssueCreatedMail((object)[
            'to' => config('app.admin_mail_address'),
            'name' => 'Admin',
            'message' => "An issue has been created. <br><br> please assign it to a developer",
            'subject' => "Issue: " . $issue->title . " added from " . $issue->requester_name
        ]));
    }
}
