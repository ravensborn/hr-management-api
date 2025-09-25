<?php

namespace App\Mail;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SalaryChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    private Employee $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('system@example.com', 'System'),
            to: $this->employee->email,
            subject: 'Salary Update Notification',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.salary-changed',
            with: [
                'employeeName' => $this->employee->name,
                'salary' => $this->employee->salary,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
