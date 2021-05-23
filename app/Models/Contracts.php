<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Contracts extends Model
{
    use HasFactory;
    
    protected $dates = ['hiring_date'];

    protected $dateFormat = 'Y-m-d';

    protected $guarded = [];

    protected $casts = [
        'amount_invested' => 'float',
        'administration_fee' => 'float',
        'account_id' => 'integer',
        'product_id' => 'integer',
        'finished' => 'integer'
    ];

    public function path()
    {
        return '/contracts/' . $this->id;
    }

    public function getHiringDateAttribute($hiring_date)
    {
        if($hiring_date == null) return null;
        $newHiringDate = Carbon::parse($hiring_date);
        return $newHiringDate->format('d/m/Y');
    }

    public function setHiringDateAttribute($hiring_date)
    {
        if($hiring_date == null) {
            $this->attributes['hiring_date'] = null;
            return;
        }
        $this->attributes['hiring_date'] = Carbon::createFromFormat('d/m/Y', $hiring_date);
    }

    public function accounts()
    {
        return $this->belongsTo(Accounts::class);
    }

    public function financialProducts()
    {
        return $this->belongsTo(FinancialProducts::class);
    }
}
