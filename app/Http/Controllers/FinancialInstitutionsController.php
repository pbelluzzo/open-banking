<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialInstitutions;
use App\Http\Resources\FinancialInstitutions as FinancialInstitutionsResource;

class FinancialInstitutionsController extends Controller
{
    public function index() 
    {
        $financial_institutions = FinancialInstitutions::where('financial_institutions.id', '<>', request()->user()->entity->id)->get();

        return FinancialInstitutionsResource::collection($financial_institutions);
    }

    public function store()
    {
        FinancialInstitutions::create($this->validateData());

        return (new FinancialInstitutionsResource($financial_institution))
            ->response()
            ->setStatusCode(201);
    }

    public function show(FinancialInstitutions $financial_institution)
    {
        return new FinancialInstitutionsResource($financial_institution);
    }

    public function update(FinancialInstitutions $financial_institution)
    {
        $financial_institution->update($this->validateData());

        return (new FinancialInstitutionsResource($financial_institution))
            ->response()
            ->setStatusCode(200);
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
