@extends('layouts.app')

@section('header', 'Invoices')

@section('actions')
    <a href="{{ route('invoices.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Create Invoice
    </a>
@endsection

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Invoice #</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Client</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Date / Due</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Amount / Balance</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($invoices as $invoice)
                <tr class="hover:bg-blue-50/30 transition-colors">
                    <td class="px-6 py-4">
                        <span class="font-bold text-gray-900 font-mono">#{{ $invoice->invoice_number }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <span class="font-medium text-gray-900">{{ $invoice->client->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <p class="text-gray-900 font-medium">{{ $invoice->invoice_date->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-400">Due: {{ $invoice->due_date->format('M d, Y') }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-900">${{ number_format($invoice->total, 2) }}</p>
                        <p class="text-xs {{ $invoice->balance > 0 ? 'text-rose-500 font-bold' : 'text-emerald-500 font-bold' }}">
                            {{ $invoice->balance > 0 ? 'Bal: $' . number_format($invoice->balance, 2) : 'Paid' }}
                        </p>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statusClasses = [
                                'draft' => 'bg-gray-100 text-gray-700 border-gray-200',
                                'sent' => 'bg-blue-50 text-blue-700 border-blue-100',
                                'paid' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                'overdue' => 'bg-rose-50 text-rose-700 border-rose-100',
                                'cancelled' => 'bg-slate-100 text-slate-700 border-slate-200',
                            ];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $statusClasses[$invoice->status] }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('invoices.show', $invoice) }}" class="text-blue-600 hover:text-blue-800 font-bold text-sm">View</a>
                        <a href="{{ route('invoices.pdf', $invoice) }}" class="text-gray-600 hover:text-gray-800 font-bold text-sm" target="_blank">PDF</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            <p class="text-gray-500 font-medium">No invoices created yet.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-6 border-t border-gray-50 bg-gray-50/50">
        {{ $invoices->links() }}
    </div>
</div>
@endsection
