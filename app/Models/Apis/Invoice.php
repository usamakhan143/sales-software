<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public function offerServices()
    {
        return $this->hasMany(Offerservice::class, 'invoice_id');
    }

    public function clientDetails()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function getPdfInvoice()
    {
        return $this->hasOne(File::class, 'invoice_id')->where('file_type', 'invoice-pdf');
    }
}
