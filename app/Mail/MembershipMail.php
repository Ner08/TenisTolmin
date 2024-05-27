<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class MembershipMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $telephone;
    public $membershipType;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $telephone, $membershipType)
    {
        $this->name = $name;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->membershipType = $membershipType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Teniški klub Tolmin - Novi član',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.membership',
            with: [
                'name' => $this->name,
                'email' => $this->email,
                'telephone' => $this->telephone,
                'membershipType' => $this->membershipType,
            ]
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
}
