<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class K10StreamingPlusNeoClass extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $subject;
    public string $order_number, $student_name, $primary_email, $primary_mobile;
    public function __construct($subject, $order_number, $student_name, $primary_email, $primary_mobile)
    {
        $this->subject = $subject;
        $this->order_number = $order_number;
        $this->student_name = $student_name;
        $this->primary_email = $primary_email;
        $this->primary_mobile = $primary_mobile;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.k10streamingplusneoclass',
            with:
            [
                'order_number' => $this->order_number,
                'student_name' => $this->student_name,
                'primary_email' => $this->primary_email,
                'primary_mobile' => $this->primary_mobile
            ],
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
