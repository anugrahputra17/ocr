<?php

namespace App\Models;
use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table = 'invoices';

    protected $allowedFields = [
        'filename',
        'invoice_number',
        'invoice_date',
        'supplier',
        'total_amount',
        'currency',
        'raw_text',
        'status'
    ];
}
