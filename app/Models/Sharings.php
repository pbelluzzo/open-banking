<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Sharings extends Model
{
    use HasFactory;

    protected $dates = ['acceptance_date'];

    protected $dateFormat = 'Y-m-d';

    protected $guarded = [];

    protected $casts = [
        'client_id' => 'integer',
        'origin_institution_id' => 'integer',
        'destiny_institution_id' => 'integer'
    ];

    public function setAcceptanceDateAttribute($acceptance_date)
    {
        if($acceptance_date == '') 
        {
            $this->attributes['acceptance_date'] = $acceptance_date;
            return;
        }
        $this->attributes['acceptance_date'] = Carbon::createFromFormat('d/m/Y', $acceptance_date);
    }
}
