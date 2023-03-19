<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    public $newPassword;
    public $fullName;

    /**
     * Create a new message instance.
     */
    public function __construct($newPassword, $fullName)
    {
        $this->newPassword = $newPassword;
        $this->fullName = $fullName;
    }

   
    public function envelope(): Envelope
    {
        return new Envelope(
            subject:'Restablecer Contraseña',
        );
    }

   
    public function content(): Content
    {
        return new Content(
            view:'emails.reset_password',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this->view('emails.reset_password')
            ->subject('Nueva contraseña')
            ->with([
                'newPassword' => $this->newPassword,
            ]);
    }
}
