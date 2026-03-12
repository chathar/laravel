@extends('layouts.app')

@section('header', 'Create New Invoice')

@section('actions')
    <a href="{{ route('invoices.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        Back to List
    </a>
@endsection

@section('content')
<div class="max-w-6xl mx-auto">
    <form action="{{ route('invoices.store') }}" method="POST" id="invoice-form">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Details -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">Invoice Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="invoice_number" class="block text-sm font-semibold text-gray-700">Invoice Number *</label>
                            <input type="text" name="invoice_number" id="invoice_number" required value="{{ old('invoice_number', $nextNumber) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 font-mono">
                        </div>

                        <div class="space-y-2">
                            <label for="client_id" class="block text-sm font-semibold text-gray-700">Client *</label>
                            <select name="client_id" id="client_id" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 appearance-none bg-no-repeat bg-right" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23666%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-size: .65em auto; padding-right: 2.5rem;">
                                <option value="">Select a Client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }} ({{ $client->company }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="invoice_date" class="block text-sm font-semibold text-gray-700">Invoice Date *</label>
                            <input type="date" name="invoice_date" id="invoice_date" required value="{{ old('invoice_date', date('Y-m-d')) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="space-y-2">
                            <label for="due_date" class="block text-sm font-semibold text-gray-700">Due Date *</label>
                            <input type="date" name="due_date" id="due_date" required value="{{ old('due_date', date('Y-m-d', strtotime('+14 days'))) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Line Items Section -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Line Items</h3>
                        <button type="button" onclick="addItem()" class="text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            Add Item
                        </button>
                    </div>

                    <div id="items-container" class="space-y-4">
                        <!-- Items will be injected here -->
                    </div>
                    
                    @if($errors->has('items'))
                        <p class="text-rose-500 text-sm mt-4 font-bold">{{ $errors->first('items') }}</p>
                    @endif
                </div>
            </div>

            <!-- Right Column: Settings & Summary -->
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 sticky top-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">Summary</h3>
                    
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label for="tax_rate" class="block text-sm font-semibold text-gray-700">Tax Rate (%)</label>
                            <input type="number" step="0.01" name="tax_rate" id="tax_rate" value="{{ old('tax_rate', 0) }}" onchange="calculateTotals()"
                                class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="space-y-2">
                            <label for="discount_amount" class="block text-sm font-semibold text-gray-700">Discount Amount ($)</label>
                            <input type="number" step="0.01" name="discount_amount" id="discount_amount" value="{{ old('discount_amount', 0) }}" onchange="calculateTotals()"
                                class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="pt-4 border-t border-gray-50 space-y-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500 font-medium">Subtotal</span>
                                <span class="text-gray-900 font-bold" id="subtotal-display">$0.00</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500 font-medium">Tax</span>
                                <span class="text-gray-900 font-bold" id="tax-display">$0.00</span>
                            </div>
                            <div class="flex justify-between items-center text-lg pt-2 border-t border-gray-100">
                                <span class="text-gray-900 font-black uppercase tracking-tighter">Total</span>
                                <span class="text-blue-600 font-black" id="total-display">$0.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <textarea name="notes" id="notes" rows="3"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 text-sm"
                            placeholder="Additional notes or payment instructions...">{{ old('notes') }}</textarea>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-2xl font-black text-lg shadow-xl shadow-blue-100 hover:bg-blue-700 hover:shadow-blue-200 transition-all active:scale-[0.98]">
                            Create Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<template id="item-template">
    <div class="item-row bg-gray-50 rounded-xl p-6 border border-gray-100 relative group animate-fade-in">
        <button type="button" onclick="removeItem(this)" class="absolute -top-2 -right-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 shadow-md transition-all hover:bg-rose-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-6">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Description</label>
                <input type="text" name="items[{index}][description]" required
                    class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            <div class="md:col-span-2">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Qty</label>
                <input type="number" name="items[{index}][quantity]" required step="1" onchange="calculateTotals()"
                    class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 text-sm qty-input">
            </div>
            <div class="md:col-span-2">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Price</label>
                <input type="number" name="items[{index}][unit_price]" required step="0.01" onchange="calculateTotals()"
                    class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 text-sm price-input">
            </div>
            <div class="md:col-span-2 flex flex-col justify-end">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 text-right">Total</label>
                <div class="text-sm font-bold text-gray-900 text-right py-2 item-row-total">$0.00</div>
            </div>
        </div>
    </div>
</template>

<script>
    let itemIndex = 0;
    const container = document.getElementById('items-container');
    const template = document.getElementById('item-template').innerHTML;

    function addItem() {
        const entry = template.replace(/{index}/g, itemIndex++);
        const div = document.createElement('div');
        div.innerHTML = entry;
        container.appendChild(div.firstElementChild);
        calculateTotals();
    }

    function removeItem(btn) {
        btn.closest('.item-row').remove();
        calculateTotals();
    }

    function calculateTotals() {
        let subtotal = 0;
        const rows = document.querySelectorAll('.item-row');
        
        rows.forEach(row => {
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const rowTotal = qty * price;
            subtotal += rowTotal;
            row.querySelector('.item-row-total').innerText = '$' + rowTotal.toFixed(2);
        });

        const taxRate = parseFloat(document.getElementById('tax_rate').value) || 0;
        const discount = parseFloat(document.getElementById('discount_amount').value) || 0;
        
        const taxAmount = (subtotal * (taxRate / 100));
        const total = (subtotal + taxAmount) - discount;

        document.getElementById('subtotal-display').innerText = '$' + subtotal.toFixed(2);
        document.getElementById('tax-display').innerText = '$' + taxAmount.toFixed(2);
        document.getElementById('total-display').innerText = '$' + total.toFixed(2);
    }

    // Initialize with one item
    document.addEventListener('DOMContentLoaded', () => {
        addItem();
    });
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
</style>
@endsection
