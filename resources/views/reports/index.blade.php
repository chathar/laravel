@extends('layouts.app')

@section('header', 'Financial Reports')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Revenue Report Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800">Monthly Revenue</h3>
            <span class="text-xs font-bold text-gray-400 uppercase">Last 12 Months</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/30 border-b border-gray-100">
                        <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase">Month</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase text-right">Revenue</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($revenueData as $data)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-700">{{ $data->month }}</td>
                        <td class="px-6 py-4 font-black text-gray-900 text-right">${{ number_format($data->total, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-6 py-8 text-center text-gray-400 font-medium italic">No revenue data available.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Outstanding Payments -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800">Outstanding Invoices</h3>
            <span class="text-xs font-bold text-gray-400 uppercase">Unpaid balance</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/30 border-b border-gray-100">
                        <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase">Client</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase text-right">Balance</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($outstandingInvoices as $invoice)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-700">{{ $invoice->client->name }}</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Invoice #{{ $invoice->invoice_number }}</p>
                        </td>
                        <td class="px-6 py-4 font-black text-rose-600 text-right">${{ number_format($invoice->balance, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-6 py-8 text-center text-gray-400 font-medium italic">No outstanding invoices.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
