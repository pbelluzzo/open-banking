<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sharings;
use App\Http\Resources\Sharings as SharingsResource;


class SharingsController extends Controller
{
    public function index()
    {
        $sharings = Sharings::where('sharings.destiny_institution_id', '=', request()->user()->entity->id)->get();

        return SharingsResource::collection($sharings);
    }

    public function store()
    {
        $sharing = Sharings::create($this->validateData());

        return (new SharingsResource($sharing))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Sharings $sharing)
    {
        return new SharingsResource($sharing);
    }

    public function update(Sharings $sharing)
    {
        $sharing->update($this->validateData());

        return (new SharingsResource($sharing))
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Sharings $sharing)
    {
        $sharing->delete();
    }

    private function validateData()
    {
        $data = request()->validate([
            'clients_id' => 'required',
            'origin_institution_id' => 'required',
            'destiny_institution_id'=> 'required',
            'acceptance_date' => 'nullable',
            'xml_path' => 'nullable',
        ]);
        return $data;
    }
}
