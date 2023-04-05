<?php

namespace App\Charts;

use Carbon\Carbon;
use App\Models\Transaction;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class TransactionPriceChart extends Chart
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
    public function getTransactionPriceData($numberOfMonths)
    {
        $labels = [];
        $pendingCounts = [];
        $successCounts = [];
        $cancelledCounts = [];

        for ($i = $numberOfMonths - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $pendingCount = Transaction::where('status', '=', 'PENDING')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                // ->count();
                ->sum('total_price');

            $successCount = Transaction::where('status', '=', 'SUCCESS')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                // ->count();
                ->sum('total_price');
            $cancelledCount = Transaction::where('status', '=', 'CANCELLED')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                // ->count();
                ->sum('total_price');

            $labels[] = $date->format('M Y');
            $pendingCounts[] = $pendingCount;
            $successCounts[] = $successCount;
            $cancelledCounts[] = $cancelledCount;
        }

        return [
            'labels' => $labels,
            'pendingCounts' => $pendingCounts,
            'successCounts' => $successCounts,
            'cancelledCounts' => $cancelledCounts,
        ];
    }
}
