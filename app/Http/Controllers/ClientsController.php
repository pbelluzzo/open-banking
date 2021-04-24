<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clients;
use DateTime;

class ClientsController extends Controller
{
    public function store()
    {
        Clients::create($this->validateData());
    }
    
    public function show(Clients $client)
    {
        return $client;
    }
    
    public function update(Clients $client)
    {
        $client->update($this->validateData());
    }

    public function destroy(Clients $client)
    {
        $client->delete();
    }

    private function validateData()
    {
        return request()->validate([
            'cpf' => 'required|cpf',
            'name' => 'required',
            'address' => 'required',
            'birthdate' => 'required'
        ]);
    }
}
