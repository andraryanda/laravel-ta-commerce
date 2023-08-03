<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\TransactionWifi;
use App\Models\NotificationTransaction;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            // Ambil dan hapus transaksi dengan status "PENDING" yang sudah satu hari atau lebih
            $transactions = Transaction::where('status', 'PENDING')
                ->where('created_at', '<=', now()->subDay())
                ->get();

            foreach ($transactions as $transaction) {
                $transaction->delete();
                TransactionItem::where('transactions_id', $transaction->id)->delete();
            }
        })->daily();

        $schedule->call(function () {
            // Ambil waktu saat ini
            $currentTime = Carbon::now();

            // Ambil dan update transaksi WiFi yang melebihi batas expired
            TransactionWifi::where('status', 'ACTIVE')
                ->where('expired_wifi', '<=', $currentTime)
                ->update(['status' => 'INACTIVE']);
        })->daily(); // Jalankan setiap hari

        $schedule->call(function () {
            // Hapus semua data dari tabel notification_transactions setiap hari
            NotificationTransaction::query()->delete();
        })->daily(); // Jalankan setiap hari

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
