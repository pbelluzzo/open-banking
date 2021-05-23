<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Sharings;
use App\Events\SharingConfirmed;
use App\Http\Resources\Sharings as SharingsResource;


class SharingsController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Sharings::class);

        $sharings = $this->getIndex();

        return SharingsResource::collection($sharings);
    }

    public function store()
    {
        $this->authorize('create', Sharings::class);

        $sharing = Sharings::create($this->validateData());

        return (new SharingsResource($sharing))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Sharings $sharing)
    {
        $this->authorize('view', $sharing);    

        return new SharingsResource($sharing);
    }

    public function update(Sharings $sharing)
    {
        $this->authorize('update', $sharing);

        $updatedSharing = request()->validate([
            'acceptance_date' => 'required'
        ]);

        SharingConfirmed::dispatch($sharing);

        $sharing->update($updatedSharing);
        
        return (new SharingsResource($sharing))
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Sharings $sharing)
    {
        $this->authorize('delete',$sharing);

        $sharing->delete();
    }

    public function download(Sharings $sharing)
    {
        preg_match('([^/]+$)',$sharing->xml_path, $fileName);
        $sharingFile = Storage::get($fileName[0]);
        return $sharingFile;
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

    private function getIndex() {
        if(requestUserIsClient()){
            return Sharings::where('sharings.clients_id', '=', request()->user()->entity->id)->get();
        }
        return Sharings::where('sharings.destiny_institution_id', '=', request()->user()->entity->id)->get();
    }

}
