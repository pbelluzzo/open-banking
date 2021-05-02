<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Sharings extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'id' => $this->id,
                'clients_id' => $this->clients_id,
                'origin_institution_id' => $this->origin_institution_id,
                'destiny_institution_id' => $this->destiny_institution_id,
                'acceptance_date' => $this->acceptance_date,
                'xml_path' => $this->xml_path,
                'created_at' => $this->created_at->format('d/m/Y'),
                'updated_at' => $this->updated_at,
            ],
            'links' => [
                'self' => $this->path(),
            ]
        ];
    }
}
