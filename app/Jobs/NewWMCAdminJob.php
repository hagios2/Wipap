<?php

namespace App\Jobs;

use App\Mail\NewWMCAdminMail;
use App\WasteCompanyAdmin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewWMCAdminJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $admin;

    public $password;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(WasteCompanyAdmin $admin, $password)
    {
        $this->admin = $admin;

        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->admin)

            ->queue(new NewWMCAdminMail($this->admin, $this->password));
    }
}
