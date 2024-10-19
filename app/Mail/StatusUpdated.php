<?php

namespace App\Mail;

use App\Models\Appointment; // Import the Appointment model
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public Appointment $appointment; // Store the appointment data

    /**
     * Create a new message instance.
     *
     * @param  Appointment  $appointment
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment; // Assign appointment data to the property
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment Status Updated', // Updated subject
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment_pending', // Specify the Blade view for the email content
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return []; // Return any attachments if needed; currently empty
    }
}
