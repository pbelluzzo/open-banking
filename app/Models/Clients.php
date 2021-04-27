<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Clients extends Model
{
    use HasFactory;

    protected $dates = ['birthdate'];

    protected $dateFormat = 'Y-m-d';

    protected $guarded = [];

    public function setBirthdateAttribute($birthdate)
    {
        $this->attributes['birthdate'] = Carbon::createFromFormat('d/m/Y', $birthdate);
    }

    public function user()
    {
        return $this->morphOne(User::class, 'entity');
    }

}
