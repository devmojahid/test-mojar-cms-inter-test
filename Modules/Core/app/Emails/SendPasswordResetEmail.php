<?php

namespace Modules\Core\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPasswordResetEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public $email, public $user, public $token)
    {
        //
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->view('backend::emails.reset-password')
            ->with([
                'email' => $this->email,
                'token' => $this->token,
                'user' => $this->user,
                'url'  => route(
                    'admin.reset-password',
                    [
                        'email' => $this->email,
                        'token' => $this->token

                    ]
                )
            ])
            ->subject('Reset Password')
            ->from("mojahid@gmail.com", "Mojahid");
    }
}
