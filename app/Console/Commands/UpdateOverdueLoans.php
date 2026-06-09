<?php

namespace App\Console\Commands;

use App\Models\Loan;
use App\Models\PenaltyRule;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class UpdateOverdueLoans extends Command
{
    protected $signature   = 'loans:update-overdue';
    protected $description = 'Mark active loans as overdue and calculate penalty amounts';

    public function handle(): int
    {
        $rule  = PenaltyRule::active();
        $today = Carbon::today();

        // Step 1: Find active loans past due_date
        $overdueLoans = Loan::where('status', 'active')
            ->where('due_date', '<', $today->toDateString())
            ->get();

        $this->info("Found {$overdueLoans->count()} newly overdue loans.");

        foreach ($overdueLoans as $loan) {
            $graceDays   = $rule ? $rule->grace_days : 0;
            $daysOverdue = abs($today->diffInDays($loan->due_date)) - $graceDays;

            $penalty = 0.00;
            if ($rule && $daysOverdue > 0) {
                $penalty = $daysOverdue * $rule->fine_per_day;
                if ($rule->max_fine !== null) {
                    $penalty = min($penalty, $rule->max_fine);
                }
            }

            $loan->update([
                'status'         => 'overdue',
                'penalty_amount' => $penalty,
            ]);
        }

        // Step 2: Update existing overdue loans (penalty grows daily)
        $existingOverdue = Loan::where('status', 'overdue')->get();
        $this->info("Updating {$existingOverdue->count()} existing overdue loans.");

        foreach ($existingOverdue as $loan) {
            if ($rule) {
                $daysOverdue = max(0, abs($today->diffInDays($loan->due_date)) - $rule->grace_days);
                $penalty     = min($daysOverdue * $rule->fine_per_day, $rule->max_fine ?? PHP_INT_MAX);
                $loan->update(['penalty_amount' => $penalty]);
            }
        }

        $this->info('Done.');
        return Command::SUCCESS;
    }
}
