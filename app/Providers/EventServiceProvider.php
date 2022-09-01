<?php

namespace App\Providers;

use App\Events\IssueCreatedEvent;
use App\Events\IssueStateChangedEvent;
use App\Listeners\LiSendIssueStateChangedNotificationListener;
use App\Listeners\SendIssueCreatedNotificationListener;
use App\Listeners\SendIssueStateChangedNotificationListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        IssueCreatedEvent::class => [
            SendIssueCreatedNotificationListener::class
        ],
        IssueStateChangedEvent::class => [
            SendIssueStateChangedNotificationListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
