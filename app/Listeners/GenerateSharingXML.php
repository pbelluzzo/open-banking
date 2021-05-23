<?php

namespace App\Listeners;

use App\Events\SharingConfirmed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use DOMDocument;
use App\Models\Accounts;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\FinancialProductsController;

class GenerateSharingXML
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SharingConfirmed  $event
     * @return void
     */
    public function handle(SharingConfirmed $event)
    {
        $client = $event->sharing->clients;
        $originInstitutionId = $event->sharing->origin_institution_id;

        $accounts = (new AccountsController)->getClientAccountInInstitution($client->id, $originInstitutionId);
        $contracts = (new ContractsController)->getIndexFromInstitution($client->id, $originInstitutionId);
        $products = (new FinancialProductsController)->getContractedProducts($client->id, $originInstitutionId);

        $xml = $this->generateDocument($client, $accounts, $products, $contracts);
        $xmlString = $xml->saveXML();

        $filename = ('client' . $client->id . 'sharing' . $event->sharing->id . '.xml');

        Storage::disk('local')->put($filename,$xmlString);
        
        $path = Storage::path($filename);

        $sharing = $event->sharing;
        $sharing->xml_path = $path;
        $sharing->save();
    }

    private function generateDocument($client, $accounts, $products, $contracts)
    {
        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;

        $sharingElement = $xml->createElement('compartilhamento');
        
        $clientElement = $xml->createElement('cliente');
        $sharingElement->appendChild($clientElement);
        $this->generateClientInfo($clientElement, $client, $xml);
        
        
        $accountsElement = $xml->createElement('contas');
        $sharingElement->appendChild($accountsElement);
        $this->generateAccountsInfo($accountsElement, $accounts, $xml);
        
        $productsElement = $xml->createElement('produtos');
        $sharingElement->appendChild($productsElement);
        $this->generateProductsInfo($productsElement, $products, $xml);
        
        $contractsElement = $xml->createElement('contratos');
        $sharingElement->appendChild($contractsElement);
        $this->generateContractsInfo($contractsElement, $contracts, $xml);
        
        $xml->appendChild($sharingElement);
   
        return $xml;
    }

    private function generateClientInfo($clientElement, $client, $xml)
    {
        $clientCpf = $xml->createElement('cpf', $client->cpf);
        $clientName = $xml->createElement('nome', $client->name);
        $clientAddress = $xml->createElement('endereco', $client->address);
        $clientBirthdate = $xml->createElement('dataNascimento', $client->birthdate);

        $clientElement->appendChild($clientCpf);
        $clientElement->appendChild($clientName);
        $clientElement->appendChild($clientAddress);
        $clientElement->appendChild($clientBirthdate);
    }

    private function generateAccountsInfo($accountsElement, $accounts, $xml)
    {
        foreach ($accounts as $account){
            $singleAccountElement = $xml->createElement('conta');

            $accountId = $xml->createAttribute('identificador');
            $accountId->value = $account->id;
            
            $singleAccountElement->appendChild($accountId);
            $accountsElement->appendChild($singleAccountElement);
        }
    }

    private function generateProductsInfo($productsElement, $products, $xml)
    {
        foreach ($products as $product){
            $singleProductElement = $xml->createElement('produto');

            $productId = $xml->createAttribute('identificador');
            $productId->value = $product->id;
            
            $singleProductElement->appendChild($productId);
            $productsElement->appendChild($singleProductElement);
        }
    }

    private function generateContractsInfo($contractsElement, $contracts, $xml)
    {
        foreach ($contracts as $contract){
            $singleContractElement = $xml->createElement('contrato');

            $contractId = $xml->createAttribute('identificador');
            $contractId->value = $contract->id;
            
            $singleContractElement->appendChild($contractId);
            $contractsElement->appendChild($singleContractElement);
        }
    }
}
