<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TransactionSuccessNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction, User $user)
    {
        $this->transaction = $transaction;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.transactionSuccess')->subject('Transaction Success Confirmation');
    }
}
