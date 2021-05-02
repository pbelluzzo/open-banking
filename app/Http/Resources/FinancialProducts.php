<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FinancialProducts extends JsonResource
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
                'financial_institutions_id' => $this->financial_institutions_id,
                'description' => $this->description,
                'minimum_value' => $this->minimum_value,
                'administration_fee' => $this->administration_fee,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'links' => [
                'self' => $this->path(),
            ]
        ];
    }
}
