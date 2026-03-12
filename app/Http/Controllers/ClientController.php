<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ClientController extends Controller implements HasMiddleware
{
    protected $repository;

    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('can:viewAny,App\Models\Client', only: ['index']),
            new Middleware('can:view,client', only: ['show']),
            new Middleware('can:create,App\Models\Client', only: ['create', 'store']),
            new Middleware('can:update,client', only: ['edit', 'update']),
            new Middleware('can:delete,client', only: ['destroy']),
        ];
    }

    public function index()
    {
        $clients = $this->repository->all();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'tax_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $this->repository->create($validated);

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    public function show(Client $client)
    {
        $client = $this->repository->find($client->id);
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'tax_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $this->repository->update($client, $validated);

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $this->repository->delete($client);
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }
}
