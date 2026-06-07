<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\PenaltyRule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CronController extends Controller
{
    /**
     * Called by Vercel cron at midnight daily.
     * Also callable via: GET /api/cron/update-overdue
     */
    public function updateOverdue(Request $request)
    {
        // Simple security: check for a cron secret header (set in vercel.json env)
        $secret = config('app.cron_secret');
        if ($secret && $request->header('Authorization') !== "Bearer {$secret}") {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $rule = PenaltyRule::active();
        $today = Carbon::today();

        $overdueLoans = Loan::where('status', 'active')
            ->where('due_date', '<', $today->toDateString())
            ->get();

        $updated = 0;
        foreach ($overdueLoans as $loan) {
            $daysOverdue = $today->diffInDays($loan->due_date) - ($rule ? $rule->grace_days : 0);

            $penalty = 0;
            if ($rule && $daysOverdue > 0) {
                $penalty = $daysOverdue * $rule->fine_per_day;
                if ($rule->max_fine) {
                    $penalty = min($penalty, $rule->max_fine);
                }
            }

            $loan->update([
                'status'         => 'overdue',
                'penalty_amount' => $penalty,
            ]);

            $updated++;
        }

        // Also update existing overdue loans' penalty amounts
        $existingOverdue = Loan::where('status', 'overdue')->get();
        foreach ($existingOverdue as $loan) {
            if ($rule) {
                $daysOverdue = $today->diffInDays($loan->due_date) - $rule->grace_days;
                $penalty = 0;
                if ($daysOverdue > 0) {
                    $penalty = $daysOverdue * $rule->fine_per_day;
                    if ($rule->max_fine) {
                        $penalty = min($penalty, $rule->max_fine);
                    }
                }
                $loan->update(['penalty_amount' => $penalty]);
            }
        }

        return response()->json([
            'message'       => 'Overdue loans updated.',
            'newly_overdue' => $updated,
        ]);
    }
}
