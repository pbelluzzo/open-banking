<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use App\Http\Resources\Accounts as AccountsResource;

class AccountsController extends Controller
{
    public function index() 
    {
        $this->authorize('viewAny', Accounts::class);

        $accounts = $this->getAccountsIndex( request()->user()->entity->id);

        return AccountsResource::collection($accounts);
    }

    public function store()
    {
        $this->authorize('create', Accounts::class);

        $account = Accounts::create($this->validateData());

        return (new AccountsResource($account))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Accounts $account)
    {
        $this->authorize('view', $account);

        return new AccountsResource($account);
    }

    public function update(Accounts $account)
    {
        $this->authorize('update', $account);

        $account->update($this->validateData());

        return (new AccountsResource($account))
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Accounts $account)
    {
        $this->authorize('delete', $account);

        $account->delete();
    }

    private function validateData()
    {
        $data = request()->validate([
            'clients_id' => 'required',
            'financial_institutions_id' => 'required',
            'balance'=> 'required|min:0',
            'ended_in' => 'nullable'
        ]);
        return $data;
    }

    private function requestUserIsClient()
    {
        return get_class(request()->user()->entity) == 'App\Models\Clients';
    }

    private function requestUserIsInstitution()
    {
        return request()->user()->entity_type == 'App\Models\FinancialInstitutions';
    }

    private function getAccountsIndex($entity_id)
    {
        if ($this->requestUserIsInstitution()){ 
            $accounts = Accounts::where('financial_institutions_id', '=', $entity_id)->get();
            return $accounts;
        }
        $accounts = Accounts::where('clients_id', '=', $entity_id)->get();
        return $accounts;
    }
}
