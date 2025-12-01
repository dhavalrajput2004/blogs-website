<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Mail\PostCreated as MailPostCreated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendPostNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostCreated $event): void
    {
      // dd('post created');

      //  Mail::to(Auth::user()->email)->send(new MailPostCreated());
    }
}
