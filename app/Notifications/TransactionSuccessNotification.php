<?php

namespace App\Notifications;

use Ramsey\Uuid\Uuid;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TransactionSuccessNotification extends Notification
{
    use Queueable;
    protected $transactionData;

    // /**
    //  * The transaction data to be included in the notification.
    //  *
    //  * @var array
    //  */
    // protected $transactionData;

    // /**
    //  * Create a new notification instance.
    //  *
    //  * @param  array  $transactionData
    //  * @return void
    //  */
    // public function __construct($transactionData)
    // {
    //     $this->transactionData = $transactionData;
    // }

    // /**
    //  * Get the notification's delivery channels.
    //  *
    //  * @param  mixed  $notifiable
    //  * @return array
    //  */
    // public function via($notifiable)
    // {
    //     return ['mail'];
    // }

    // /**
    //  * Get the mail representation of the notification.
    //  *
    //  * @param  mixed  $notifiable
    //  * @return \Illuminate\Notifications\Messages\MailMessage
    //  */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //         ->subject('Transaksi Sukses')
    //         ->greeting('Halo!')
    //         ->line('Transaksi Anda berhasil dilakukan dengan rincian sebagai berikut:')
    //         ->line('Pembeli: ' . $this->transactionData['user'])
    //         ->line('Total Harga: ' . $this->transactionData['total_price'])
    //         ->line('Alamat: ' . $this->transactionData['address'])
    //         ->action('Lihat Transaksi', url('/transactions'))
    //         ->line('Terima kasih telah berbelanja di toko kami!');
    // }

    // /**
    //  * Get the array representation of the notification.
    //  *
    //  * @param  mixed  $notifiable
    //  * @return array
    //  */
    // public function toArray($notifiable)
    // {
    //     return [
    //         'transaction_id' => Uuid::uuid4()->getHex(),
    //         'message' => 'Transaksi berhasil dilakukan oleh ' . $this->transactionData['user'] . ' dengan total harga ' . $this->transactionData['total_price'] . '.'
    //     ];
    // }


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $transactionData)
    {
        $this->transactionData = $transactionData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Transaksi baru telah berhasil dilakukan.')
            ->line('Pembeli: ' . $this->transactionData['user'])
            ->line('Total Harga: ' . $this->transactionData['total_price'])
            ->line('Alamat Pengiriman: ' . $this->transactionData['address'])
            ->action('Lihat Transaksi', url('/transactions'))
            ->line('Terima kasih telah menggunakan layanan kami!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
