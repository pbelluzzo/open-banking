<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialInstitutions;

class FinancialInstitutionsController extends Controller
{
    public function store()
    {
        FinancialInstitutions::create($this->validateData());
    }

    public function show(FinancialInstitutions $financial_institution)
    {
        return $financial_institution;
    }

    public function update(FinancialInstitutions $financial_institution)
    {
        $financial_institution->update($this->validateData());
    }

    public function destroy(FinancialInstitutions $financial_institution)
    {
        $financial_institution->delete();
    }

    private function validateData()
    {
        $data = request()->validate([
            'cnpj' => 'required|cnpj',
            'company_name' => 'required',
            'fantasy_name' => 'required',
            'bank_code' => 'required|unique:financial_institutions'
        ]);
        return $data;
    }
}
