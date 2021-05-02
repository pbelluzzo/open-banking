<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FinancialInstitutions extends JsonResource
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
                'cnpj' => $this->cnpj,
                'company_name' => $this->company_name,
                'fantasy_name' => $this->fantasy_name,
                'bank_code' => $this->bank_code,
                'logo_path' => $this->logo_path,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'links' => [
                'self' => $this->path(),
            ]
            ];
    }
}
