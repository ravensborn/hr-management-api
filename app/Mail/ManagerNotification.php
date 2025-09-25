<?php

namespace App\Mail;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ManagerNotification extends Mailable
{
    use Queueable, SerializesModels;

    private Employee $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('system@example.com', 'System'),
            to: $this->employee->manager->email,
            subject: 'New Employee',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.manager-notification',
            with: [
                'employeeName' => $this->employee->name,
                'managerName' => $this->employee->manager->name,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
