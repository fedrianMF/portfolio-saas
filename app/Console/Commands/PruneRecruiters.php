<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Carbon;

class PruneRecruiters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:prune-recruiters';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune users created more than 24 hours ago (ephemeral accounts)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cutoff = Carbon::now()->subHours(24);

        $this->info("Pruning users created before: " . $cutoff->toDateTimeString());

        // Admin emails to preserve
        $safeUsers = ['me@fedrian.dev', 'admin@fedrian.dev'];

        $count = User::where('created_at', '<', $cutoff)
            ->whereNotIn('email', $safeUsers)
            ->delete();

        $this->info("Pruned {$count} expired users.");
    }
}
