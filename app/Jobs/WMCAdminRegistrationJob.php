<?php

namespace App\Jobs;

use App\Mail\WMCAdminRegistrationMail;
use App\VerifyEmail;
use App\WasteCompanyAdmin;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class WMCAdminRegistrationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $token;

    public $admin;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(WasteCompanyAdmin $admin, VerifyEmail $token)
    {
        $this->admin = $admin;

        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->admin)

        ->queue(new WMCAdminRegistrationMail($this->admin, $this->token));
    }
}
