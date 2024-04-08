<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offerservice extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'qty', 'price', 'invoice_id'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
