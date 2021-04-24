<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contracts;

class ContractsController extends Controller
{
    public function store()
    {
        Contracts::create($this->validateData());
    }

    private function validateData()
    {
        $data = request()->validate([
            'account_id' => 'required',
            'product_id' => 'required',
            'ammount_invested' => 'required',
            'hiring_date' => 'required',
        ]);
        return $data;
    }
}
