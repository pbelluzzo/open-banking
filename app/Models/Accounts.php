<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'balance' => 'float'
    ];

    public function financialInstitutions()
    {
        return $this->belongsTo(FinancialInstitutions::class);
    }

    public function clients()
    {
        return $this->belongsTo(Clients::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contracts::class);
    }
}
