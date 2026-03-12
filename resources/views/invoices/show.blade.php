@extends('layouts.app')

@section('header', 'Invoice: #' . $invoice->invoice_number)

@section('actions')
    <a href="{{ route('invoices.pdf', $invoice) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
        Download PDF
    </a>
    <form action="{{ route('invoices.send', $invoice) }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition ease-in-out duration-150 ml-3">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            Send Email
        </button>
    </form>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Invoice Content -->
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <div class="flex flex-col md:flex-row justify-between mb-12">
                <div class="space-y-4">
                    <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">Invoice</h1>
                    <div class="space-y-1">
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Billed To</p>
                        <h3 class="text-xl font-bold text-gray-900">{{ $invoice->client->name }}</h3>
                        <p class="text-gray-500 font-medium whitespace-pre-line">{{ $invoice->client->address }}</p>
                        @if($invoice->client->tax_number)
                            <p class="text-sm text-gray-400 mt-2">Tax ID: {{ $invoice->client->tax_number }}</p>
                        @endif
                    </div>
                </div>
                
                <div class="mt-8 md:mt-0 text-left md:text-right space-y-4">
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Invoice Number</p>
                        <p class="text-lg font-black text-gray-900 font-mono">#{{ $invoice->invoice_number }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Issued On</p>
                        <p class="text-lg font-bold text-gray-900">{{ $invoice->invoice_date->format('M d, Y') }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Due Date</p>
                        <p class="text-lg font-bold text-gray-900">{{ $invoice->due_date->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto -mx-8">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-y border-gray-100">
                            <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Description</th>
                            <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Qty</th>
                            <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Unit Price</th>
                            <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($invoice->items as $item)
                        <tr>
                            <td class="px-8 py-5 text-gray-900 font-medium">{{ $item->description }}</td>
                            <td class="px-8 py-5 text-gray-600 font-bold text-center">{{ $item->quantity }}</td>
                            <td class="px-8 py-5 text-gray-600 font-medium text-right">${{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-8 py-5 text-gray-900 font-black text-right">${{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
            <div class="mt-12 flex justify-end">
                <div class="w-full lg:w-1/2 space-y-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-400 font-bold uppercase tracking-widest">Subtotal</span>
                        <span class="text-gray-900 font-bold">${{ number_format($invoice->subtotal, 2) }}</span>
                    </div>
                    @if($invoice->tax_amount > 0)
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-400 font-bold uppercase tracking-widest">Tax ({{ $invoice->tax_rate }}%)</span>
                        <span class="text-gray-900 font-bold">${{ number_format($invoice->tax_amount, 2) }}</span>
                    </div>
                    @endif
                    @if($invoice->discount_amount > 0)
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-400 font-bold uppercase tracking-widest">Discount</span>
                        <span class="text-rose-600 font-bold">-${{ number_format($invoice->discount_amount, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <span class="text-gray-900 font-black text-xl uppercase tracking-tighter">Grand Total</span>
                        <span class="text-blue-600 font-black text-3xl tracking-tighter">${{ number_format($invoice->total, 2) }}</span>
                    </div>
                </div>
            </div>

            @if($invoice->notes)
            <div class="mt-12 pt-8 border-t border-gray-50">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Invoice Notes</p>
                <p class="text-sm text-gray-600 leading-relaxed italic">{{ $invoice->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Sidebar: Payments & Actions -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Status Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Payment Status</p>
            <div class="flex items-center justify-between">
                @php
                    $statusClasses = [
                        'draft' => 'text-gray-500 bg-gray-50',
                        'sent' => 'text-blue-600 bg-blue-50',
                        'paid' => 'text-emerald-600 bg-emerald-50',
                        'overdue' => 'text-rose-600 bg-rose-50',
                        'cancelled' => 'text-slate-600 bg-slate-50',
                    ];
                @endphp
                <div class="px-4 py-2 rounded-xl border border-current {{ $statusClasses[$invoice->status] }} flex items-center">
                    <span class="w-2 h-2 rounded-full bg-current mr-2"></span>
                    <span class="text-sm font-black uppercase">{{ $invoice->status }}</span>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400 font-bold uppercase">Balance Due</p>
                    <p class="text-xl font-black text-gray-900">${{ number_format($invoice->balance, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Add Payment -->
        @if($invoice->balance > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h4 class="text-sm font-bold text-gray-900 mb-6">Record a Payment</h4>
            <form action="{{ route('payments.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase">Amount *</label>
                    <input type="number" step="0.01" name="amount" required value="{{ $invoice->balance }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 text-sm font-bold">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase">Method *</label>
                    <select name="payment_method" required class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 text-sm font-medium">
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Cash">Cash</option>
                        <option value="Online">Online</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase">Date *</label>
                    <input type="date" name="payment_date" required value="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 bg-emerald-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-emerald-50 hover:bg-emerald-700 transition-all">
                        Record Payment
                    </button>
                </div>
            </form>
        </div>
        @endif

        <!-- Payment History -->
        @if($invoice->payments->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h4 class="text-sm font-bold text-gray-900 mb-6 font-semibold">Payment History</h4>
            <div class="space-y-4">
                @foreach($invoice->payments as $payment)
                <div class="flex justify-between items-start pb-4 border-b border-gray-50 last:border-0 last:pb-0">
                    <div>
                        <p class="text-sm font-bold text-gray-900">${{ number_format($payment->amount, 2) }}</p>
                        <p class="text-[10px] text-gray-400 font-bold uppercase">{{ $payment->payment_date->format('M d, Y') }} via {{ $payment->payment_method }}</p>
                    </div>
                    <form action="{{ route('payments.destroy', $payment) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-rose-400 hover:text-rose-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
