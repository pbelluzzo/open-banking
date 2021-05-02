<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Clients;
use App\Http\Resources\Clients as ClientsResource;

use DateTime;

class ClientsController extends Controller
{
    public function index()
    {  
        if ($this->requestUserIsClient()) {
            return response([], 403);
        };
        
        $clients = Clients::whereHas('accounts', function (Builder $query) {
            $query->where('accounts.financial_institutions_id', '=', request()->user()->entity->id);
        })->get();

        return ClientsResource::collection($clients);
    }

    public function store()
    {
        $client = Clients::create($this->validateData());

        return (new ClientsResource($client))
            ->response()
            ->setStatusCode(201);
    }
    
    public function show(Clients $client)
    {
        if ($this->requestUserIsClient()) {
           return response([], 403);
        };

        return new ClientsResource($client);
    }
    
    public function update(Clients $client)
    {
        $client->update($this->validateData());

        return (new ClientsResource($client))
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Clients $client)
    {
        $client->delete();

        return response([], 204);
    }

    private function requestUserIsClient()
    {
        return get_class(request()->user()->entity) == 'App\Models\Clients';
    }

    private function validateData()
    {
        return request()->validate([
            'cpf' => 'required|cpf',
            'name' => 'required',
            'address' => 'required',
            'birthdate' => 'required|date_format:d/m/Y'
        ]);
    }
}
