<?php

namespace App\Console;

use Carbon\Carbon;
use Twilio\Rest\Client;
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

        //      $schedule->call(function () {
        //     // Ambil dan hapus transaksi dengan status "PENDING" yang sudah lebih dari 1 menit yang lalu
        //     $transactions = Transaction::where('status', 'PENDING')
        //         ->where('created_at', '<=', now()->subMinutes(1)) // Menghapus data lebih dari 1 menit yang lalu
        //         ->get();

        //     foreach ($transactions as $transaction) {
        //         $transaction->delete();
        //         TransactionItem::where('transactions_id', $transaction->id)->delete();
        //     }
        // })->everyMinute();

        $schedule->call(function () {
            // Ambil waktu saat ini
            $currentTime = Carbon::now();

            // Ambil dan update transaksi WiFi yang melebihi batas expired
            TransactionWifi::where('status', 'ACTIVE')
                ->where('expired_wifi', '<=', $currentTime)
                ->update(['status' => 'INACTIVE']);
        })->daily(); // Jalankan setiap hari
        // })->everyMinute(); // Jalankan setiap hari

        $schedule->call(function () {
            // Hapus semua data dari tabel notification_transactions setiap hari
            NotificationTransaction::query()->delete();
        })->daily(); // Jalankan setiap hari


        // $schedule->call(function () {
        //     $sid = "AC500ec6026deaa9eaad888c17c98c6f59";
        //     $token = "6adece88681c084b6245e9bdd5de7f11";
        //     $twilio = new Client($sid, $token);

        //     $message = $twilio->messages
        //         ->create(
        //             "whatsapp:+6285314005779", // to
        //             array(
        //                 "from" => "whatsapp:+14155238886",
        //                 "body" => "Your appointment is coming up on July 21 at 3PM"
        //             )
        //         );

        //     print($message->sid);
        // })->everyMinute(); // Jalankan setiap hari

        // $schedule->call(function () {
        //     $sid = "AC500ec6026deaa9eaad888c17c98c6f59";
        //     $token = "6adece88681c084b6245e9bdd5de7f11";
        //     $twilio = new Client($sid, $token);

        //     // Ambil transaksi WiFi dengan status ACTIVE dan expired_wifi mendekati 2 hari
        //     $transactionsWifi = TransactionWifi::where('status', 'ACTIVE')
        //         ->where('expired_wifi', '<=', \Carbon\Carbon::now()->addDays(2)) // Expired dalam 2 hari
        //         ->where('expired_wifi', '>=', \Carbon\Carbon::now()) // Pastikan masih dalam batas waktu yang mendekati
        //         ->get();

        //     $twilioPhoneNumber = '+14155238886';

        //     foreach ($transactionsWifi as $transactionWifi) {

        //         $phone_number = '+62' . substr_replace($transactionWifi->user->phone, '', 0, 1);

        //         $expiredDate = \Carbon\Carbon::parse($transactionWifi->expired_wifi)->locale('id_ID')->isoFormat('dddd, D MMMM Y');

        //         $message = "Halo *" . $transactionWifi->user->name . "*, terima kasih telah berlangganan WiFi bulanan di *AL-N3T Support Gesitnet*. Kami ingin memberitahukan bahwa masa berlangganan WiFi Anda akan segera berakhir dalam *2 hari*. Berikut adalah detail pesanan Anda:\n\n";
        //         $message .= "-----------------------------------\n";
        //         $message .= "*Detail Pesanan WiFi:*\n";
        //         $message .= "No: " . $transactionWifi->id . "\n";
        //         $message .= "Nama Produk: " . $transactionWifi->product->name . "\n";
        //         $message .= "Total Harga WIFI: Rp " . number_format($transactionWifi->total_price_wifi, 0, ',', '.') . "\n\n";
        //         // $message .= "Total Harga WIFI: " . $transactionWifi->total_price_wifi . "\n";
        //         $message .= "*Expired Tanggal WIFI:* " . $expiredDate . "\n";
        //         $message .= "*Status WIFI:* " . $transactionWifi->status . "\n";
        //         $message .= "-----------------------------------\n\n";

        //         $twilio->messages->create(
        //             'whatsapp:+6285314005779',
        //             [
        //                 // 'from' => 'whatsapp:' . '+14155238886',
        //                 'from' => 'whatsapp:' . $twilioPhoneNumber,
        //                 'body' => $message
        //             ]
        //         );
        //     }
        // })->everyMinute(); // Jalankan setiap menit

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
