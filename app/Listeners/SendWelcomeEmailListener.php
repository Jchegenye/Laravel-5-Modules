<?php

namespace App\Listeners;

use App\Events\NewUserEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Mail\NewUserWelcome;

class SendWelcomeEmailListener
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
     * @param  NewUserEvent  $event
     * @return void
     */
    public function handle(NewUserEvent $event)
    {
        Mail::to($event->user->email)->send(new NewUserWelcome($event->user));
    }
}
