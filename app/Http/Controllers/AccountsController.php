<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;

class AccountsController extends Controller
{
    public function store()
    {
        Accounts::create($this->validateData());
    }

    public function show(Accounts $account)
    {
        return $account;
    }

    public function update(Accounts $account)
    {
        $account->update($this->validateData());
    }

    public function destroy(Accounts $account)
    {
        $account->delete();
    }

    private function validateData()
    {
        $data = request()->validate([
            'client_id' => 'required',
            'institution_id' => 'required',
            'balance'=> 'required'
        ]);
        return $data;
    }
}
