<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;

class ClientRepository
{
    public function all(): Collection
    {
        return Client::withCount('invoices')->get();
    }

    public function find(int $id): ?Client
    {
        return Client::with(['invoices' => function($query) {
            $query->orderBy('invoice_date', 'desc');
        }])->findOrFail($id);
    }

    public function create(array $data): Client
    {
        return Client::create($data);
    }

    public function update(Client $client, array $data): bool
    {
        return $client->update($data);
    }

    public function delete(Client $client): bool
    {
        return $client->delete();
    }
}
