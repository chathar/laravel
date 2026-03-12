<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Financial Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Revenue Report Table -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden shadow-blue-50/50">
                    <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                        <h3 class="text-lg font-bold text-gray-800 tracking-tight">Monthly Revenue</h3>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Last 12 Months</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/30 border-b border-gray-100">
                                    <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Month</th>
                                    <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Revenue</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($revenueData as $data)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-gray-700 tracking-tight">{{ $data->month }}</td>
                                    <td class="px-6 py-4 font-black text-gray-900 text-right tracking-tighter">${{ number_format($data->total, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-8 text-center text-gray-400 font-medium italic">No revenue data available for the selected period.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Outstanding Payments -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden shadow-blue-50/50">
                    <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                        <h3 class="text-lg font-bold text-gray-800 tracking-tight">Outstanding Invoices</h3>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Unpaid Balance</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/30 border-b border-gray-100">
                                    <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Client</th>
                                    <th class="px-6 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Balance</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($outstandingInvoices as $invoice)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-gray-700 tracking-tight underline decoration-blue-100 decoration-4 underline-offset-4">{{ $invoice->client->name }}</p>
                                        <p class="text-[9px] font-black text-gray-400 mt-1 uppercase tracking-tighter">#{{ $invoice->invoice_number }} · Due: {{ $invoice->due_date->format('M d') }}</p>
                                    </td>
                                    <td class="px-6 py-4 font-black text-rose-600 text-right tracking-tighter text-lg">${{ number_format($invoice->balance, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-8 text-center text-gray-400 font-medium italic italic">Excellent! No outstanding invoices found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 bg-gray-50/30 border-t border-gray-100 text-right">
                        <a href="{{ route('invoices.index') }}" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline decoration-blue-200 decoration-2 underline-offset-4">View All Invoices &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
