<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeNewUserMail;
use App\User;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {

        $this->user = $user;
        print_r($this->user['name']);
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       
        Mail::to('it676@hotmail.com')->send(new WelcomeNewUserMail($this->user));
    }
}
