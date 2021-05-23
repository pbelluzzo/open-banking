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
        $this->authorize('viewAny', Clients::class);
        
        $clients = Clients::whereHas('accounts', function (Builder $query) {
            $query->where('accounts.financial_institutions_id', '=', request()->user()->entity->id);
        })->get();

        return ClientsResource::collection($clients);
    }

    public function store()
    {
        $this->authorize('create', Clients::class);

        if ($this->clientExists($this->validateData()['cpf'])){

            $client = Clients::where('cpf', '=', $this->validateData()['cpf'])->first();

            return (new ClientsResource($client))
                ->response()
                ->setStatusCode(201);
        };

        $client = Clients::create($this->validateData());

        return (new ClientsResource($client))
            ->response()
            ->setStatusCode(201);
    }
    
    public function show(Clients $client)
    {
        $this->authorize('view', $client);

        return new ClientsResource($client);
    }
    
    public function update(Clients $client)
    {
        $this->authorize('update', $client);

        $client->update($this->validateData());

        return (new ClientsResource($client))
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Clients $client)
    {
        $this->authorize('delete', $client);

        $client->delete();

        return response([], 204);
    }

    private function requestUserIsClient()
    {
        return get_class(request()->user()->entity) == 'App\Models\Clients';
    }

    private function clientExists($cpf)
    {
        $client = Clients::where('cpf', '=', $this->validateData()['cpf'])->firstOrFail();

        if ($client == null) {
            return false;
        }

        return true;
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
