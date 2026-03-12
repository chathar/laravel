<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Users
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }

        if (!User::where('email', 'staff@example.com')->exists()) {
            User::create([
                'name' => 'Staff User',
                'email' => 'staff@example.com',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]);
        }

        // 2. Create Clients
        $clients = Client::factory()->count(15)->create();

        // 3. Create Invoices for the last 12 months
        foreach ($clients as $client) {
            // Each client gets 2-5 invoices
            $invoiceCount = rand(2, 5);
            
            for ($i = 0; $i < $invoiceCount; $i++) {
                $date = Carbon::now()->subMonths(rand(0, 11))->subDays(rand(0, 28));
                
                $invoice = Invoice::create([
                    'invoice_number' => 'INV-' . strtoupper(bin2hex(random_bytes(3))),
                    'client_id' => $client->id,
                    'invoice_date' => $date,
                    'due_date' => (clone $date)->addDays(14),
                    'status' => 'draft', // Initial status
                    'subtotal' => 0,
                    'tax_rate' => 10,
                    'tax_amount' => 0,
                    'discount_amount' => rand(0, 1) ? rand(10, 50) : 0,
                    'total' => 0,
                    'notes' => 'Sample invoice for ' . $client->name,
                ]);

                // Create 1-4 items per invoice
                $subtotal = 0;
                $itemCount = rand(1, 4);
                for ($j = 0; $j < $itemCount; $j++) {
                    $qty = rand(1, 5);
                    $price = rand(100, 1000);
                    $itemTotal = $qty * $price;
                    
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'description' => 'Service/Product Item ' . ($j + 1),
                        'quantity' => $qty,
                        'unit_price' => $price,
                        'total' => $itemTotal,
                    ]);
                    $subtotal += $itemTotal;
                }

                $taxAmount = $subtotal * ($invoice->tax_rate / 100);
                $total = $subtotal + $taxAmount - $invoice->discount_amount;

                $invoice->update([
                    'subtotal' => $subtotal,
                    'tax_amount' => $taxAmount,
                    'total' => $total,
                ]);

                // Randomly set status and create payments
                $statusType = rand(1, 10);
                if ($statusType <= 5) { // 50% Paid
                    $invoice->update(['status' => 'paid']);
                    Payment::create([
                        'invoice_id' => $invoice->id,
                        'payment_date' => (clone $date)->addDays(rand(1, 10)),
                        'amount' => $total,
                        'payment_method' => collect(['Bank Transfer', 'Credit Card', 'Cash'])->random(),
                        'transaction_reference' => 'TXN-' . strtoupper(bin2hex(random_bytes(4))),
                    ]);
                } elseif ($statusType <= 7) { // 20% Sent/Partially Paid
                    $isPartially = rand(0, 1);
                    $invoice->update(['status' => $isPartially ? 'partially_paid' : 'sent']);
                    if ($isPartially) {
                        Payment::create([
                            'invoice_id' => $invoice->id,
                            'payment_date' => (clone $date)->addDays(rand(1, 5)),
                            'amount' => $total * 0.5,
                            'payment_method' => 'Credit Card',
                            'transaction_reference' => 'PARTIAL-' . strtoupper(bin2hex(random_bytes(3))),
                        ]);
                    }
                } elseif ($statusType <= 9) { // 20% Overdue (if date is old)
                    if ($invoice->due_date->isPast()) {
                        $invoice->update(['status' => 'overdue']);
                    } else {
                        $invoice->update(['status' => 'sent']);
                    }
                } else { // 10% Draft/Cancelled
                    $invoice->update(['status' => rand(0, 1) ? 'draft' : 'cancelled']);
                }
            }
        }
    }
}
