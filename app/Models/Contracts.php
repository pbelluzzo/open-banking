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

    public function setHiringDateAttribute($hiring_date)
    {
        $this->attributes['hiring_date'] = Carbon::createFromFormat('d/m/Y', $hiring_date);
    }
}
