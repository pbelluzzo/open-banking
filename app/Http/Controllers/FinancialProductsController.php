<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialProducts;
use App\Http\Resources\FinancialProducts as FinancialProductsResource;

class FinancialProductsController extends Controller
{
    public function index()
    {
        if ($this->requestUserIsClient()) {
            return response([], 403);
        };

        $products = FinancialProducts::where('financial_institutions_id', '=', request()->user()->entity->id)->get();

        return FinancialProductsResource::collection($products);
    }

    public function store()
    {
        $financial_product = FinancialProducts::create($this->validateData());

        return (new FinancialProductsResource($financial_product))
            ->response()
            ->setStatusCode(201);
    }

    public function show(FinancialProducts $financial_product)
    {
        if ($this->requestUserIsClient()) {
            return response([], 403);
        };
 
        return new FinancialProductsResource($financial_product);
    }

    public function update(FinancialProducts $financial_product)
    {
        $financial_product->update($this->validateData());

        return (new FinancialProductsResource($financial_product))
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(FinancialProducts $financial_product)
    {
        $financial_product->delete();
    }

    private function requestUserIsClient()
    {
        return get_class(request()->user()->entity) == 'App\Models\Clients';
    }

    private function validateData()
    {
        $data = request()->validate([
            'financial_institutions_id' => 'required',
            'description' => 'required',
            'minimum_value'=> 'required',
            'administration_fee' => 'required'
        ]);
        return $data;
    }
}
