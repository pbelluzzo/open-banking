<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
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

    public function getContractedProducts($clientId, $institutionId)
    {
        $contractedProducts = 
        DB::table('financial_products')
        ->join('contracts', 'financial_products.id', '=', 'contracts.financial_products_id')
        ->join('accounts', 'contracts.accounts_id', '=', 'accounts.id')
        ->select('financial_products.*')
        ->where('accounts.clients_id','=',$clientId)
        ->where('financial_products.financial_institutions_id', '=', $institutionId)
        ->get();

        return $contractedProducts;
    }

    private function requestUserIsClient()
    {
        return get_class(request()->user()->entity) == 'App\Models\Clients';
    }

    private function validateData()
    {
        $data = request()->validate([
            'financial_institutions_id' => 'required',
            'description' => 'required|unique:financial_products,description',
            'minimum_value'=> 'required|min:1|unique:financial_products,minimum_value',
            'administration_fee' => 'required|min:0|max:100,unique:financial_products,administration_fee'
        ]);
        return $data;
    }
}
