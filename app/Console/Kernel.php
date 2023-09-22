<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Transactions;
use App\Models\Sellers;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Clearing transactions scheduled for every day
        // get all transactions that are Paid and > 3 days old and cleared_at is null
        $schedule->call(function () {
            $transactions = Transactions::where('status', 'PAID')->where('cleared_at', null)->where('created_at', '<', now()->subDays(3))->with('store')->get();
            print_r($transactions);
            foreach ($transactions as $transaction) {
                $transaction->cleared_at = now();
                $transaction->save();

                // add transaction.amount_bersih to seller's balance
                $seller = Sellers::where('id', $transaction->store->id_seller)->first();
                $seller->balance += $transaction->amount_bersih;
                $seller->save();
            }
        })->dailyAt('00:00')->name('clearing_transactions')->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
