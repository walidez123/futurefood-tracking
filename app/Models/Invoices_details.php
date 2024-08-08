<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoices_details extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id', 'start_date', 'end_date', 'allcostfess',
        'allreturnCost', 'shippingCost', 'tax', 'totaltax', 'Glopaltotal', 'InvoceNum','company_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function Invoice_order()
    {
        return $this->hasMany(Invoice_order::class, 'invoice_id');
    }
}
