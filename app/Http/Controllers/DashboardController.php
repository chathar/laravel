<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Payment::sum('amount');
        $totalInvoices = Invoice::count();
        $outstandingPayments = Invoice::all()->sum('balance');
        $overdueInvoices = Invoice::where('status', 'overdue')->count();

        // Monthly Revenue (last 6 months)
        $monthlyRevenue = Payment::select(
            DB::raw('SUM(amount) as total'),
            DB::raw("DATE_FORMAT(payment_date, '%Y-%m') as month")
        )
        ->where('payment_date', '>=', Carbon::now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Invoice Status Distribution
        $statusDistribution = Invoice::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        return view('dashboard', compact(
            'totalRevenue',
            'totalInvoices',
            'outstandingPayments',
            'overdueInvoices',
            'monthlyRevenue',
            'statusDistribution'
        ));
    }
}
