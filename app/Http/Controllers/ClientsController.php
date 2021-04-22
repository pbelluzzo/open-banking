<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clients;
use DateTime;

class ClientsController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'cpf' => 'required|cpf',
            'name' => 'required',
            'address' => 'required',
            'birthdate' => 'required'
        ]);

        Clients::create($data);

    }
}
