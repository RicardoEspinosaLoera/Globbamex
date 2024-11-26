<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VendorRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $data;
    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data['subject'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email-templates.vendor-registration', with: ['data' => $this->data]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        if (!is_null($this->data['constancy']) && !empty($this->data['constancy'])) {
            $constancyPath = storage_path('app/public/shop/constancy/' . $this->data['constancy']);
            if (file_exists($constancyPath)) {
                $attachments[] = Attachment::fromPath($constancyPath);
            }
        }

        if (!is_null($this->data['document']) && !empty($this->data['document'])) {
            $documentPath = storage_path('app/public/seller/document/' . $this->data['document']);
            if (file_exists($documentPath)) {
                $attachments[] = Attachment::fromPath($documentPath);
            }
        }

        return $attachments;
    }
}
