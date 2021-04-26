<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sharings;

class SharingsController extends Controller
{
    public function store()
    {
        Sharings::create($this->validateData());
    }

    public function show(Sharings $sharing)
    {
        return $sharing;
    }

    public function update(Sharings $sharing)
    {
        $sharing->update($this->validateData());
    }

    public function destroy(Sharings $sharing)
    {
        $sharing->delete();
    }

    private function validateData()
    {
        $data = request()->validate([
            'client_id' => 'required',
            'origin_institution_id' => 'required',
            'destiny_institution_id'=> 'required',
            'acceptance_date' => 'nullable',
            'xml_path' => 'nullable',
        ]);
        return $data;
    }
}
