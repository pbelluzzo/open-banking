<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Contracts;
use App\Http\Resources\Contracts as ContractsResource;

class ContractsController extends Controller
{
    public function index()
    {
        $contracts = Contracts::whereHas('accounts', function (Builder $query) {
            $query->where('accounts.financial_institutions_id', '=', request()->user()->entity->id);
        })->get();

        return ContractsResource::collection($contracts);
    }

    public function store()
    {
        $contract = Contracts::create($this->validateData());

        return (new ContractsResource($contract))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Contracts $contract)
    {
        return new ContractsResource($contract);
    }

    public function update(Contracts $contract)
    {
        $contract->update($this->validateData());

        return (new ContractsResource($contract))
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Contracts $contract)
    {
        $contract->delete();
    }

    private function validateData()
    {
        $data = request()->validate([
            'accounts_id' => 'required',
            'financial_products_id' => 'required',
            'amount_invested' => 'required',
            'administration_fee' => 'required',
            'hiring_date' => 'nullable',
            'finished' => 'required|nullable'
        ]);
        return $data;
    }
}
