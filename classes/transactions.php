<?php

require_once '../vendor/autoload.php';

use NetSuite\Classes\AddRequest;
use NetSuite\Classes\CashSale;
use NetSuite\Classes\CashSaleItem;
use NetSuite\Classes\CashSaleItemList;
use NetSuite\Classes\RecordRef;
use NetSuite\Classes\SearchEnumMultiSelectField;
use NetSuite\Classes\SearchRequest;
use NetSuite\Classes\TransactionSearchBasic;
use NetSuite\NetSuiteService;

class Transactions
{
    function getTransaction()
    {
        require '../config.php';
        $service = new NetSuiteService($config);

        // Retrieve customer deposits (customize your search criteria)
        $search = new TransactionSearchBasic();
        $search->type = new SearchEnumMultiSelectField();
        $search->type->searchValue = ["_customerDeposit"];

        $request = new SearchRequest();
        $request->searchRecord = $search;

        $searchResponse = $service->search($request);

        if ($searchResponse->searchResult->status->isSuccess) {
            $customerDeposits = $searchResponse->searchResult->recordList->record;

            foreach ($customerDeposits as $customerDeposit) {
                // Process each customer deposit
                echo "ID: {$customerDeposit->internalId}, Transaction ID: {$customerDeposit->tranId}\n";
            }
        } else {
            // Handle search errors
            $errors = $searchResponse->searchResult->status->statusDetail;
            foreach ($errors as $error) {
                echo "Search Error: {$error->message}\n";
            }
        }
    }

    function createTransaction()
    {
        require '../config.php';
        $service = new NetSuiteService($config);
        // Prepare the data for the sales order
        $cashSale = new CashSale();

        // Set the customer for the cash sale (replace with the actual customer internal ID)
        $customerRef = new RecordRef();
        $customerRef->internalId = 20998;
        $cashSale->entity = $customerRef;

        // Set the location for the cash sale (replace with the actual location internal ID)
        $locationRef = new RecordRef();
        $locationRef->internalId = 1;
        $cashSale->location = $locationRef;

        // Create an array to hold multiple items
        $items = [];
        // Add items to the cash sale (replace with the actual item internal ID and quantity)
        $itemRef = new RecordRef();
        $itemRef->internalId = 300;
        $cashSaleItem = new CashSaleItem();
        $cashSaleItem->item = $itemRef;
        $cashSaleItem->quantity = 2;
        $items[] = $cashSaleItem;

        // second item
        $itemRef = new RecordRef();
        $itemRef->internalId = 13163;
        $cashSaleItem = new CashSaleItem();
        $cashSaleItem->item = $itemRef;
        $cashSaleItem->rate = 15;
        $cashSaleItem->quantity = 2;

        $items[] = $cashSaleItem;

        $cashSale->itemList = new CashSaleItemList();
        $cashSale->itemList->item = $items;
        // $cashSale->total = 100.00;
        $cashSale->taxTotal = 10.00;
        $cashSale->externalId = 123453;

        $request = new AddRequest();
        $request->record = $cashSale;

        // Create the cash sale
        try {
            $response = $service->add($request);
            $cashSaleInternalId = $response->writeResponse->baseRef->internalId;
            echo "Cash Sale created with ID: " . $cashSaleInternalId;
        } catch (Exception $e) {
            echo "Error creating cash sale: " . $e->getMessage();
        }
    }
}