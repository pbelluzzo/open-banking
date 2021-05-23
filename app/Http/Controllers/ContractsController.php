<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Contracts;
use App\Events\ContractAccepted;
use App\Http\Resources\Contracts as ContractsResource;

class ContractsController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Contracts::class);

        $contracts = $this->getIndex(request()->user()->entity->id);

        return ContractsResource::collection($contracts);
    }

    public function store()
    {
        $this->authorize('create', Contracts::class);

        $contract = Contracts::create($this->validateData());

        return (new ContractsResource($contract))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Contracts $contract)
    {
        $this->authorize('view', $contract);

        return new ContractsResource($contract);
    }

    public function update(Contracts $contract)
    {
        $this->authorize('update', $contract);
        
        $updatedContract = $this->validateData();

        if($updatedContract['hiring_date'] != null){
            if ($contract->accounts->balance < $updatedContract['amount_invested']){
                return response(['errors' => 'Saldo Insuficiente'], 400);
            }
            try {
                ContractAccepted::dispatch($contract);
            } catch (Exception $exception) {
                echo ($exception);
            }
        }

        $contract->update($updatedContract);

        return (new ContractsResource($contract))
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Contracts $contract)
    {
        $this->authorize('delete', $contract);

        $contract->delete();
    }

    private function getIndex($entity_id)
    {
        if ($this->requestUserIsClient()){
            $contracts = Contracts::whereHas('accounts', function (Builder $query) use ($entity_id){
                $query->where('accounts.clients_id', '=', $entity_id);
            })->get();

            return $contracts;
        }

        $contracts = Contracts::whereHas('accounts', function (Builder $query) use ($entity_id){
            $query->where('accounts.financial_institutions_id', '=', $entity_id);
        })->get();

        return $contracts;
    }

    public function getIndexFromInstitution($entity_id, $institution_Id)
    {
        $contracts = Contracts::whereHas('accounts', function (Builder $query) use ($entity_id, $institution_Id){
            $query->where('accounts.clients_id', '=', $entity_id)
            ->where('accounts.financial_institutions_id', '=', $institution_Id);
            })->get();

        return $contracts;
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

    private function requestUserIsClient()
    {
        return get_class(request()->user()->entity) == 'App\Models\Clients';
    }
}
