<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationNotifyAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Teniški klub Tolmin - Nova registracija');
    }

    public function content(): Content
    {
        return new Content(view: 'mail.registration-notify-admin');
    }

    public function attachments(): array { return []; }
}
