<?php

namespace App\Charts;

use App\Models\Transaction;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class TransactionChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    public function pendingTransactions()
    {
        $total_amount_pending = Transaction::where('status', '=', 'PENDING')->sum('total_price');
        return $total_amount_pending;
    }

    public function getTransactionData()
    {
        $pending = Transaction::where('status', '=', 'PENDING')->sum('total_price');
        $success = Transaction::where('status', '=', 'SUCCESS')->sum('total_price');
        $cancelled = Transaction::where('status', '=', 'CANCELLED')->sum('total_price');

        return collect([$pending, $success, $cancelled]);
    }
}
