<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\TransactionWifi;
use Illuminate\Queue\SerializesModels;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TransactionWifiNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $transactionWifi;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(TransactionWifi $transactionWifi, User $user)
    {
        $this->transactionWifi = $transactionWifi;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.transaction_wifi')->subject('Transaction Wifi Confirmation');
    }
}

