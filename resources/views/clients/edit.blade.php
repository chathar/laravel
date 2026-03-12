@extends('layouts.app')

@section('header', 'Edit Client: ' . $client->name)

@section('actions')
    <a href="{{ route('clients.show', $client) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
        Cancel
    </a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('clients.update', $client) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Same fields as create.blade.php but with $client data -->
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-semibold text-gray-700">Full Name *</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $client->name) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label for="company" class="block text-sm font-semibold text-gray-700">Company Name</label>
                    <input type="text" name="company" id="company" value="{{ old('company', $client->company) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email Address *</label>
                    <input type="email" name="email" id="email" required value="{{ old('email', $client->email) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-semibold text-gray-700">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $client->phone) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label for="address" class="block text-sm font-semibold text-gray-700">Address</label>
                    <textarea name="address" id="address" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">{{ old('address', $client->address) }}</textarea>
                </div>

                <div class="space-y-2">
                    <label for="tax_number" class="block text-sm font-semibold text-gray-700">Tax / VAT Number</label>
                    <input type="text" name="tax_number" id="tax_number" value="{{ old('tax_number', $client->tax_number) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label for="notes" class="block text-sm font-semibold text-gray-700">Internal Notes</label>
                    <textarea name="notes" id="notes" rows="2"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">{{ old('notes', $client->notes) }}</textarea>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100 flex justify-between items-center">
                <form action="{{ route('clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this client? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold text-sm transition-colors">
                        Delete Client
                    </button>
                </form>
                
                <button type="submit"
                    class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-blue-300 transition-all focus:ring-4 focus:ring-blue-100">
                    Update Client
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
