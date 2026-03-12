<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Clients') }}
            </h2>
            <a href="{{ route('clients.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Add Client
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Client Name</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Company</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Invoices</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($clients as $client)
                            <tr class="hover:bg-blue-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold mr-3 border border-blue-200">
                                            {{ strtoupper(substr($client->name, 0, 1)) }}
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $client->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 font-medium">{{ $client->company ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-600 font-medium">{{ $client->email }}</td>
                                <td class="px-6 py-4 text-center md:text-left">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                        {{ $client->invoices_count }} invoices
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-3">
                                    <a href="{{ route('clients.show', $client) }}" class="text-blue-600 hover:text-blue-800 font-bold text-sm transition font-semibold">View</a>
                                    <a href="{{ route('clients.edit', $client) }}" class="text-gray-600 hover:text-gray-800 font-bold text-sm transition font-semibold">Edit</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V4H2v16h5m10 0v2H7v-2m10 0a2 2 0 002-2V8a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2m10 0h-3.586a1 1 0 01-.707-.293l-1.414-1.414A1 1 0 0010.293 16H7" /></svg>
                                        <p class="text-gray-500 font-medium text-lg">No clients found.</p>
                                        <p class="text-gray-400 text-sm mb-4">You haven't added any clients to your system yet.</p>
                                        <a href="{{ route('clients.create') }}" class="text-blue-600 hover:underline font-bold">Add your first client &rarr;</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
