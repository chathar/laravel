<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceSent;
use App\Models\Client;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class InvoiceController extends Controller implements HasMiddleware
{
    protected $service;

    public function __construct(InvoiceService $service)
    {
        $this->service = $service;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('can:viewAny,App\Models\Invoice', only: ['index']),
            new Middleware('can:view,invoice', only: ['show', 'downloadPdf']),
            new Middleware('can:create,App\Models\Invoice', only: ['create', 'store']),
            new Middleware('can:update,invoice', only: ['edit', 'update', 'sendEmail']),
            new Middleware('can:delete,invoice', only: ['destroy']),
        ];
    }

    public function index()
    {
        $invoices = Invoice::with('client')->latest()->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $clients = Client::all();
        $nextNumber = 'INV-' . str_pad(Invoice::count() + 1, 6, '0', STR_PAD_LEFT);
        return view('invoices.create', compact('clients', 'nextNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|string|unique:invoices',
            'client_id' => 'required|exists:clients,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'tax_rate' => 'required|numeric|min:0',
            'discount_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $items = $request->input('items');
        $this->service->createInvoice($validated, $items);

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['client', 'items', 'payments']);
        return view('invoices.show', compact('invoice'));
    }

    public function downloadPdf(Invoice $invoice)
    {
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
    }

    public function sendEmail(Invoice $invoice)
    {
        Mail::to($invoice->client->email)->send(new InvoiceSent($invoice));
        
        return back()->with('success', 'Invoice has been sent to the client via email.');
    }

    public function edit(Invoice $invoice)
    {
        $clients = Client::all();
        $invoice->load('items');
        return view('invoices.edit', compact('invoice', 'clients'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|string|unique:invoices,invoice_number,' . $invoice->id,
            'client_id' => 'required|exists:clients,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'tax_rate' => 'required|numeric|min:0',
            'discount_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $items = $request->input('items');
        $this->service->updateInvoice($invoice, $validated, $items);

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
