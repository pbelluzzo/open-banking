<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialProducts extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'minimum_value' => 'float',
        'administration_fee' => 'float'
    ];

    public function path()
    {
        return '/financial_products/' . $this->id;
    }

    public function contracts()
    {
        return $this->hasMany(Contracts::class);
    }

    public function financialInstitutions()
    {
        return $this->belongsTo(FinancialInstitutions::class);
    }
}
