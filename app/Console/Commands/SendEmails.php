<?php

namespace App\Console\Commands;

use App\Jobs\UserJob;
use App\Mail\TestMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       // $name = $this->argument('user');
       //   echo "hello, $name";
       $name = 'dhaval';
     try {

        Mail::to("dhaval.rajput@bytestechnolab.com")->send(new TestMail($name));

     } catch (\Throwable $th) {

        Log::info('SenEmails =>' . $th->getMessage());

     }
    }
}
