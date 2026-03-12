<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function recordPayment(array $data): Payment
    {
        return DB::transaction(function () use ($data) {
            $payment = Payment::create($data);
            
            $invoice = $payment->invoice;
            
            // Trigger status update in InvoiceService
            (new InvoiceService())->updateStatus($invoice);
            
            return $payment;
        });
    }

    public function deletePayment(Payment $payment): void
    {
        DB::transaction(function () use ($payment) {
            $invoice = $payment->invoice;
            $payment->delete();
            
            (new InvoiceService())->updateStatus($invoice);
        });
    }
}
