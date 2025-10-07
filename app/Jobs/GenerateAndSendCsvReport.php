<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Charge;
use App\Mail\ExcelReport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class GenerateAndSendCsvReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 300;
    protected $activeBillingCycles;
    protected $recipients;

    /**
     * Create a new job instance.
     *
     * @param array $activeBillingCycles The array of billing cycle timestamps.
     * @param array $recipients The array of email addresses to send the report to.
     * @return void
     */
    public function __construct(array $activeBillingCycles, array $recipients)
    {
        // Corrected variable name to match the property
        $this->activeBillingCycles = $activeBillingCycles;
        $this->recipients = $recipients;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('memory_limit', '256M');
        set_time_limit(120);

        try {
            $file = fopen('php://temp', 'w');
            
            // CSV headers
            fputcsv($file, ['Department', 'Family Name', 'Account Code', 'Total']);

            // Process data for the specified billing cycles
            Charge::whereIn('billing_cycle', $this->activeBillingCycles)
                ->with(['department', 'member.family'])
                ->chunk(1000, function ($charges) use ($file) {
                    $groupedCharges = $charges->groupBy(['department.name', 'member.family.family_name']);

                    foreach ($groupedCharges as $deptName => $families) {
                        foreach ($families as $familyName => $familyCharges) {
                            $family = optional($familyCharges->first()->member)->family;

                            if ($family) {
                                fputcsv($file, [
                                    $deptName,
                                    $familyName,
                                    $family->account_code,
                                    number_format($familyCharges->sum('price'), 2)
                                ]);
                            }
                        }
                    }
                });

            rewind($file);
            $csvData = stream_get_contents($file);
            fclose($file);

            // Determine the report title based on the billing cycles.
            // Using the first cycle date for the filename and subject.
            $reportDate = \Carbon\Carbon::parse($this->activeBillingCycles[0] ?? now())->format('Y-m');

            // Send to all recipients
            foreach ($this->recipients as $recipient) {
                Mail::to($recipient)->send(new ExcelReport($csvData, $reportDate));
            }

            Log::info('CSV report sent successfully.', [
                'billing_cycle' => $this->activeBillingCycles,
                'recipients' => $this->recipients
            ]);
        } catch (\Exception $e) {
            Log::error('CSV report generation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }
}
