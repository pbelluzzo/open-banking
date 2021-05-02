<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use App\Http\Resources\Accounts as AccountsResource;

class AccountsController extends Controller
{
    public function index() 
    {
        if ($this->requestUserIsClient()) {
            return response([], 403);
        };

        $accounts = Accounts::where('financial_institutions_id', '=', request()->user()->entity->id)->get();
        //$accounts = Accounts::whereHas('financial_institutions', function (Builder $query) {
        //    $query->where('financial_institutions_id.id', '=', request()->user()->entity->id);
        //})->get();

        return AccountsResource::collection($accounts);
    }

    public function store()
    {
        if ($this->requestUserIsClient()) {
            return response([], 403);
        };

        $account = Accounts::create($this->validateData());

        return (new AccountsResource($account))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Accounts $account)
    {
        return new AccountsResource($account);
    }

    public function update(Accounts $account)
    {
        $account->update($this->validateData());

        return (new AccountsResource($account))
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Accounts $account)
    {
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
}
