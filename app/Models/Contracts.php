<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contracts extends Model
{
    use HasFactory;
    
    protected $dates = ['hiring_date'];

    protected $dateFormat = 'Y-m-d';

    protected $guarded = [];

    public function setBirthdateAttribute($hiring_date)
    {
        $this->attributes['hiring_date'] = Carbon::createFromFormat('d/m/Y', $hiring_date);
    }
}
