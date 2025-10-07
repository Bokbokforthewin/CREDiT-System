<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;

class MonthlyChargesReport extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $timeout = 300;

    public $family;
    public $charges;

    public function __construct($family, $charges)
    {
        $this->family = $family;
        $this->charges = $charges;
    }

    public function build()
    {
        $pdf = Pdf::loadView('emails.monthly-report', [
            'family' => $this->family,
            'charges' => $this->charges,
        ]);

        return $this->subject('Monthly Charges Report')
                    ->attachData($pdf->output(), 'charges.pdf')
                    ->view('emails.dummy'); // dummy blade required
    }
}
