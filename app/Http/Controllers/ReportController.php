<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function revenue(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth());

        $payments = Payment::with('invoice.client')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->latest()
            ->get();

        $totalRevenue = $payments->sum('amount');

        return view('reports.revenue', compact('payments', 'totalRevenue', 'startDate', 'endDate'));
    }

    public function outstanding()
    {
        $invoices = Invoice::with('client')
            ->whereIn('status', ['sent', 'overdue', 'partially_paid'])
            ->get()
            ->filter(function($invoice) {
                return $invoice->balance > 0;
            });

        return view('reports.outstanding', compact('invoices'));
    }
}
