<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialProducts;

class FinancialProductsController extends Controller
{
    public function store()
    {
        FinancialProducts::create($this->validateData());
    }

    public function show(FinancialProducts $financial_product)
    {
        return $financial_product;
    }

    public function update(FinancialProducts $financial_product)
    {
        $financial_product->update($this->validateData());
    }

    public function destroy(FinancialProducts $financial_product)
    {
        $financial_product->delete();
    }

    private function validateData()
    {
        $data = request()->validate([
            'institution_id' => 'required',
            'description' => 'required',
            'minimum_value'=> 'required',
            'administration_fee' => 'required'
        ]);
        return $data;
    }
}
