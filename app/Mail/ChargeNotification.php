<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Charge;

class ChargeNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $timeout = 300;

    public $charge;

    /**
     * Create a new message instance.
     */
    public function __construct(Charge $charge)
    {
        $this->charge = $charge;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Charge Transaction')
                    ->view('emails.charge-notification');
    }
}
