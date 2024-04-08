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
}
