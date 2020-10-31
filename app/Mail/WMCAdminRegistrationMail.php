<?php

namespace App\Mail;

use App\VerifyEmail;
use App\WasteCompanyAdmin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WMCAdminRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    public $admin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(WasteCompanyAdmin $admin, VerifyEmail $token)
    {
        $this->admin = $admin;

        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('Mail.WMCAdminRegistrationMail')
            ->subject('New Registration');
    }
}
