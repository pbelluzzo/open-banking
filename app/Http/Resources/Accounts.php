<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Accounts extends JsonResource
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
                'financial_institutions_id' => $this->financial_institutions_id,
                'balance' => $this->balance,
                'created_at' => $this->created_at->format('d/m/Y'),
                'updated_at' => $this->updated_at,
                'ended_in' => $this->ended_in,
            ],
            'links' => [
                'self' => $this->path(),
            ]
        ];
    }
}
