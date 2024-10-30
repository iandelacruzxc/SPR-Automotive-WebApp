<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function generateInvoice($id)
    {
        $transaction = Transaction::with(['products', 'services'])->findOrFail($id);
        $pdf = Pdf::loadView('invoice.invoice', compact('transaction'));

        // Use stream() to display the PDF in the browser
        return $pdf->stream("invoice_{$transaction->id}.pdf");
    }
}
