<x-mail::message>
# Invoice #{{ $invoice->invoice_number }}

Hello {{ $invoice->client->name }},

Please find your invoice attached to this email.

**Invoice Details:**
- **Invoice Number:** {{ $invoice->invoice_number }}
- **Date:** {{ $invoice->invoice_date->format('M d, Y') }}
- **Due Date:** {{ $invoice->due_date->format('M d, Y') }}
- **Total Amount:** ${{ number_format($invoice->total, 2) }}

<x-mail::button :url="route('invoices.show', $invoice)">
View Invoice Online
</x-mail::button>

If you have any questions regarding this invoice, please feel free to contact us.

Thanks,<br>
Smart Invoice System
</x-mail::message>
