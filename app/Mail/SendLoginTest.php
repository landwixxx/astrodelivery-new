<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendLoginTest extends Mailable
{
    use Queueable, SerializesModels;

    protected $userTest = null;
    protected $pass = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userTest, $pass)
    {
        $this->userTest =  $userTest;
        $this->pass =  $pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this
            ->subject('Login para teste')
            ->markdown('front.solicitar_teste.email_enviar_login_teste', [
                'userTest' => $this->userTest,
                'pass' => $this->pass,
            ]);
    }
}
