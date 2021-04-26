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

    public function show(Contracts $contract)
    {
        return $contract;
    }

    public function update(Contracts $contract)
    {
        $contract->update($this->validateData());
    }

    public function destroy(Contracts $contract)
    {
        $contract->delete();
    }

    private function validateData()
    {
        $data = request()->validate([
            'account_id' => 'required',
            'product_id' => 'required',
            'amount_invested' => 'required',
            'administration_fee' => 'required',
            'hiring_date' => 'required',
            'finished' => 'required|nullable'
        ]);
        return $data;
    }
}
