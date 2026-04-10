<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

use App\Models\Borrowing;

#[Signature('app:check-overdue-books')]
#[Description('Mark borrowings as overdue if they pass the due date')]
class CheckOverdueBooks extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $overdueCount = Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', now())
            ->update(['status' => 'overdue']);

        $this->info("Successfully marked $overdueCount borrowings as overdue.");
    }
}
