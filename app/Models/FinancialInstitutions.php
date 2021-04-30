<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialInstitutions extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->morphOne(User::class, 'entity');
    }

    public function contracts()
    {
        return $this->hasMany(Contracts::class);
    }

    public function accounts()
    {
        return $this->hasMany(Accounts::class);
    }

    public function financialProducts()
    {
        return $this->hasMany(FinancialProducts::class);
    }

}
