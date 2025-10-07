<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExcelReport extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $csvContent;
    public $billingCycleDate; // Renamed to be more descriptive

    /**
     * Create a new message instance.
     *
     * @param string $csvContent The CSV data to attach.
     * @param string $billingCycleDate The billing cycle date string for the subject and filename.
     * @return void
     */
    public function __construct(string $csvContent, string $billingCycleDate)
    {
        $this->csvContent = $csvContent;
        // Corrected variable name from activateBillingCycles to billingCycleDate
        $this->billingCycleDate = $billingCycleDate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $filename = "monthly_charges_{$this->billingCycleDate}.csv";

        return $this->subject("Monthly Charges Report - {$this->billingCycleDate}")
            ->view('emails.csv-monthly-charges')
            ->attachData($this->csvContent, $filename, [
                'mime' => 'text/csv',
            ]);
    }
}
