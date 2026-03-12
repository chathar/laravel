<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function createInvoice(array $data, array $items): Invoice
    {
        return DB::transaction(function () use ($data, $items) {
            $invoice = Invoice::create($data);

            foreach ($items as $item) {
                $itemTotal = $item['quantity'] * $item['unit_price'];
                $invoice->items()->create(array_merge($item, ['total' => $itemTotal]));
            }

            $this->calculateTotals($invoice);

            return $invoice;
        });
    }

    public function updateInvoice(Invoice $invoice, array $data, array $items): Invoice
    {
        return DB::transaction(function () use ($invoice, $data, $items) {
            $invoice->update($data);

            // Simple approach: delete existing items and recreate
            $invoice->items()->delete();
            foreach ($items as $item) {
                $itemTotal = $item['quantity'] * $item['unit_price'];
                $invoice->items()->create(array_merge($item, ['total' => $itemTotal]));
            }

            $this->calculateTotals($invoice);

            return $invoice;
        });
    }

    public function calculateTotals(Invoice $invoice): void
    {
        $subtotal = $invoice->items()->sum('total');
        $taxAmount = ($subtotal * ($invoice->tax_rate / 100));
        $total = ($subtotal + $taxAmount) - $invoice->discount_amount;

        $invoice->update([
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total' => $total,
        ]);

        $this->updateStatus($invoice);
    }

    public function updateStatus(Invoice $invoice): void
    {
        $balance = $invoice->balance;

        if ($balance <= 0 && $invoice->total > 0) {
            $invoice->update(['status' => 'paid']);
        } elseif ($invoice->due_date->isPast() && $invoice->status !== 'paid') {
            $invoice->update(['status' => 'overdue']);
        }
    }
}
