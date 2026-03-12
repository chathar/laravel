<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware(function (Request $request, $next) {
                if (!$request->user() || !$request->user()->isAdmin()) {
                    abort(403, 'Unauthorized action.');
                }
                return $next($request);
            }),
        ];
    }

    public function index()
    {
        // Get revenue data for last 12 months
        $revenueData = Payment::select(
            DB::raw('DATE_FORMAT(payment_date, "%b %Y") as month'),
            DB::raw('SUM(amount) as total'),
            DB::raw('MAX(payment_date) as latest_date')
        )
        ->groupBy('month')
        ->orderBy('latest_date', 'desc')
        ->limit(12)
        ->get();

        // Get outstanding invoices
        $outstandingInvoices = Invoice::with('client')
            ->whereIn('status', ['sent', 'overdue', 'partially_paid'])
            ->get()
            ->filter(function($invoice) {
                return $invoice->balance > 0;
            })
            ->take(10);

        return view('reports.index', compact('revenueData', 'outstandingInvoices'));
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
