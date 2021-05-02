<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Contracts extends JsonResource
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
                'accounts_id' => $this->accounts_id,
                'financial_products_id' => $this->financial_products_id,
                'amount_invested' => $this->amount_invested,
                'administration_fee' => $this->administration_fee,
                'hiring_date' => $this->hiring_date,
                'finished' => $this->finished,
                'created_at' => $this->created_at->format('d/m/Y'),
                'updated_at' => $this->updated_at,
            ],
            'links' => [
                'self' => $this->path(),
            ]
        ];
    }
}
