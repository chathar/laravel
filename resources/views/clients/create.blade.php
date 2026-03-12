@extends('layouts.app')

@section('header', 'Add New Client')

@section('actions')
    <a href="{{ route('clients.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
        Back to List
    </a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('clients.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-semibold text-gray-700">Full Name *</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder-gray-400"
                        placeholder="e.g. John Doe">
                    @error('name') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="company" class="block text-sm font-semibold text-gray-700">Company Name</label>
                    <input type="text" name="company" id="company" value="{{ old('company') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder-gray-400"
                        placeholder="e.g. Acme Corp">
                    @error('company') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email Address *</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder-gray-400"
                        placeholder="john@example.com">
                    @error('email') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-semibold text-gray-700">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder-gray-400"
                        placeholder="+1 (555) 000-0000">
                    @error('phone') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label for="address" class="block text-sm font-semibold text-gray-700">Address</label>
                    <textarea name="address" id="address" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder-gray-400"
                        placeholder="Street, City, Country, Zip Code">{{ old('address') }}</textarea>
                    @error('address') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="tax_number" class="block text-sm font-semibold text-gray-700">Tax / VAT Number</label>
                    <input type="text" name="tax_number" id="tax_number" value="{{ old('tax_number') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder-gray-400"
                        placeholder="e.g. VAT123456789">
                    @error('tax_number') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label for="notes" class="block text-sm font-semibold text-gray-700">Internal Notes</label>
                    <textarea name="notes" id="notes" rows="2"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder-gray-400"
                        placeholder="Any additional information about this client...">{{ old('notes') }}</textarea>
                    @error('notes') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit"
                    class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-blue-300 transition-all focus:ring-4 focus:ring-blue-100">
                    Save Client
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
