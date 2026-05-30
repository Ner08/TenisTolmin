<?php

namespace App\Console\Commands;

use App\Models\CustomMatchUp;
use Illuminate\Console\Command;

class FlagOldPendingResults extends Command
{
    protected $signature   = 'matchups:flag-old-pending';
    protected $description = 'Flag match results pending for more than 7 days as admin_review';

    public function handle(): void
    {
        $count = CustomMatchUp::where('result_status', 'pending')
            ->where('result_submitted_at', '<', now()->subDays(7))
            ->update(['result_status' => 'admin_review']);

        $this->info("Flagged {$count} matchup(s) for admin review.");
    }
}
