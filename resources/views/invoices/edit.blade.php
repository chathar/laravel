<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Invoice: #') }}{{ $invoice->invoice_number }}
            </h2>
            <a href="{{ route('invoices.show', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                Cancel
            </a>
        </div>
    </x-slot>

    <div class="py-12" x-data="invoiceForm()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('invoices.update', $invoice) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column: Invoice Details -->
                    <div class="lg:col-span-2 space-y-8">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 shadow-blue-50/50">
                            <h3 class="text-lg font-bold text-gray-800 mb-6">Update Invoice Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700">Invoice Number *</label>
                                    <input type="text" name="invoice_number" required value="{{ old('invoice_number', $invoice->invoice_number) }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none font-mono font-bold">
                                    @error('invoice_number') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700">Client *</label>
                                    <select name="client_id" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none">
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}" {{ old('client_id', $invoice->client_id) == $client->id ? 'selected' : '' }}>
                                                {{ $client->name }} ({{ $client->company }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('client_id') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700">Invoice Date *</label>
                                    <input type="date" name="invoice_date" required value="{{ old('invoice_date', $invoice->invoice_date->format('Y-m-d')) }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none">
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700">Due Date *</label>
                                    <input type="date" name="due_date" required value="{{ old('due_date', $invoice->due_date->format('Y-m-d')) }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none">
                                </div>
                            </div>

                            <!-- Dynamic Items -->
                            <div class="mt-12">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">Line Items</h3>
                                <div class="space-y-4">
                                    <template x-for="(item, index) in items" :key="index">
                                        <div class="flex flex-col md:flex-row gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100 relative group">
                                            <div class="flex-grow space-y-2">
                                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">Description</label>
                                                <input type="text" :name="`items[${index}][description]`" x-model="item.description" required
                                                    class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none text-sm font-medium">
                                            </div>
                                            <div class="w-full md:w-24 space-y-2">
                                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">Qty</label>
                                                <input type="number" :name="`items[${index}][quantity]`" x-model="item.quantity" required @input="calculateTotal()"
                                                    class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none text-sm font-bold text-center">
                                            </div>
                                            <div class="w-full md:w-32 space-y-2">
                                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">Unit Price</label>
                                                <input type="number" step="0.01" :name="`items[${index}][unit_price]`" x-model="item.unit_price" required @input="calculateTotal()"
                                                    class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none text-sm font-bold text-right">
                                            </div>
                                            <div class="w-full md:w-32 space-y-2">
                                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">Total</label>
                                                <div class="w-full px-4 py-2 bg-white rounded-lg border border-gray-100 text-sm font-black text-right text-gray-900" x-text="'$' + (item.quantity * item.unit_price).toFixed(2)">
                                                </div>
                                            </div>
                                            <button type="button" @click="removeItem(index)" class="absolute -right-2 -top-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg shadow-rose-200">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" /></svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                                <button type="button" @click="addItem()" class="mt-6 flex items-center text-blue-600 font-bold text-sm hover:underline decoration-blue-200 decoration-2 underline-offset-4">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                    Add Another Item
                                </button>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 shadow-blue-50/50">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Notes / Terms</label>
                            <textarea name="notes" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none text-sm">{{ old('notes', $invoice->notes) }}</textarea>
                        </div>
                    </div>

                    <!-- Right Column: Summary & Save -->
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-indigo-950 rounded-2xl shadow-xl p-8 text-white sticky top-24 shadow-indigo-100/50">
                            <h3 class="text-sm font-bold text-indigo-300 uppercase tracking-widest mb-8">Summary Updates</h3>
                            
                            <div class="space-y-6">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-indigo-300 font-bold uppercase tracking-tight">Subtotal</span>
                                    <span class="font-black text-lg" x-text="'$' + subtotal.toFixed(2)"></span>
                                </div>
                                
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-indigo-300 uppercase tracking-widest">Tax Rate (%)</label>
                                    <input type="number" name="tax_rate" x-model="taxRate" @input="calculateTotal()"
                                        class="w-full bg-indigo-900/50 border border-indigo-800 rounded-xl px-4 py-2 text-white font-bold outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-indigo-300 uppercase tracking-widest">Discount Amount ($)</label>
                                    <input type="number" step="0.01" name="discount_amount" x-model="discountAmount" @input="calculateTotal()"
                                        class="w-full bg-indigo-900/50 border border-indigo-800 rounded-xl px-4 py-2 text-white font-bold outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                </div>

                                <div class="pt-6 border-t border-indigo-900 flex justify-between items-center">
                                    <span class="text-sm font-black uppercase tracking-widest text-blue-400">Grand Total</span>
                                    <span class="text-3xl font-black tracking-tighter" x-text="'$' + total.toFixed(2)"></span>
                                </div>

                                <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 rounded-2xl font-black text-sm uppercase tracking-widest shadow-lg shadow-blue-500/20 transition-all transform active:scale-95">
                                    Update Invoice
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function invoiceForm() {
            return {
                items: {!! json_encode($invoice->items->map(fn($i) => ['description' => $i->description, 'quantity' => $i->quantity, 'unit_price' => $i->unit_price])) !!},
                taxRate: {{ $invoice->tax_rate }},
                discountAmount: {{ $invoice->discount_amount }},
                subtotal: 0,
                total: 0,
                
                init() {
                    this.calculateTotal();
                },
                
                addItem() {
                    this.items.push({ description: '', quantity: 1, unit_price: 0 });
                },
                
                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                        this.calculateTotal();
                    }
                },
                
                calculateTotal() {
                    this.subtotal = this.items.reduce((sum, item) => sum + (parseFloat(item.quantity) * parseFloat(item.unit_price)), 0);
                    let tax = (this.subtotal * (this.taxRate / 100));
                    this.total = this.subtotal + tax - parseFloat(this.discountAmount || 0);
                }
            }
        }
    </script>
</x-app-layout>
