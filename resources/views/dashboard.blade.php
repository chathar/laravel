<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Revenue -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-slate-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Revenue</p>
                            <p class="text-2xl font-bold text-slate-900">${{ number_format($totalRevenue, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Invoices -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-slate-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Invoices</p>
                            <p class="text-2xl font-bold text-slate-900">{{ $totalInvoices }}</p>
                        </div>
                    </div>
                </div>

                <!-- Outstanding -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-slate-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-orange-100 text-orange-600 mr-4">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Outstanding</p>
                            <p class="text-2xl font-bold text-slate-900">${{ number_format($outstandingPayments, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Overdue -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-slate-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-red-100 text-red-600 mr-4">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Overdue</p>
                            <p class="text-2xl font-bold text-slate-900">{{ $overdueInvoices }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100 mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Quick Actions</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('clients.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            New Client
                        </a>
                        <a href="{{ route('invoices.create') }}" class="inline-flex items-center px-4 py-2 bg-slate-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-700 active:bg-slate-900 focus:outline-none focus:border-slate-900 focus:ring ring-slate-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Create Invoice
                        </a>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('reports.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:text-slate-500 focus:outline-none focus:border-blue-300 focus:ring ring-blue-200 disabled:opacity-25 transition ease-in-out duration-150">
                                View Reports
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100">
                <div class="p-6 text-slate-600">
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Welcome back, {{ Auth::user()->name }}!</h3>
                        {{ __("You're logged in to the Smart Invoice & Client Management System. Use the navigation menu above or the quick action buttons to manage your business.") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
