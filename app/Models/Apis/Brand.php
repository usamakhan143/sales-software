<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    public function mainLogo()
    {
        return $this->hasOne(File::class, 'brand_id')->where('file_type', 'original-logo');
    }

    public function mainSmallLogo()
    {
        return $this->hasOne(File::class, 'brand_id')->where('file_type', 'small-logo');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'brand_id');
    }
}
