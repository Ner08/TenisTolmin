<?php

namespace App\Mail;

use App\Models\CustomMatchUp;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MatchResultSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $submitterName,
        public CustomMatchUp $matchup,
        public string $t1Name,
        public string $t2Name,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Teniški klub Tolmin - Nov rezultat igre');
    }

    public function content(): Content
    {
        return new Content(view: 'mail.match-result-submitted');
    }

    public function attachments(): array { return []; }
}
