<?php

require_once '../vendor/autoload.php';

use NetSuite\NetSuiteService;

class Customers
{
    function getCustomer()
    {
        require '../config.php';

        $service = new NetSuiteService($config);

        $request = new GetRequest();
        $request->baseRef = new RecordRef();
        $request->baseRef->internalId = "1731"; // NetSuite Id of Customer
        $request->baseRef->type = "customer";

        $getResponse = $service->get($request);

        print_r($getResponse);
    }

    function createCustomer()
    {
        require '../config.php';
        $service = new NetSuiteService($config);

        $customer = new Customer();
        $customer->firstName = 'first name';
        $customer->lastName = 'last name';
        $customer->companyName = 'company';
        $customer->phone = 'phone';
        $customer->email = 'email';
        // ... add all of your fields, then create the request

        // Customer Address Array
        $address = new Address();
        $address->addr1 = 'address_1';
        $address->addr2 = 'address_1';
        $address->city = 'city';
        $address->state = 'state';
        $address->zip = 'zip';

        // Address Book Array
        $address_book = new CustomerAddressbook();
        $address_book->defaultShipping = false;
        $address_book->defaultBilling = false;
        $address_book->isResidential = true;
        $address_book->addressbookAddress = $address;

        // Address Book List Array
        $address_book_list = new CustomerAddressbookList();
        $address_book_list->addressbook = $address_book;
        $address_book_list->replaceAll = false;

        $customer->addressbookList = $address_book_list;
        $customer->externalId = ''; // id for reference

        $request = new AddRequest();
        $request->record = $customer;

        $addResponse = $service->add($request);

        if (!$addResponse->writeResponse->status->isSuccess) {
            echo "ADD ERROR";
        } else {
            $ns_id = $addResponse->writeResponse->baseRef->internalId;
            echo "ADD SUCCESS, id " . $ns_id;
        }
    }

    public static function updateCustomer()
    {
        // Build the Customer object
        $customer = new Customer();
        $customer->internalId = ''; // id of customer to update
        $customer->companyName = '';
        $customer->firstName = '';
        $customer->lastName = '';
        $customer->email = '';
        // ... set other customer properties

        // Customer Address Array
        $address = new Address();
        $address->addr1 = '';
        $address->addr2 = '';
        $address->city = '';
        $address->state = '';
        $address->zip = '';

        // Address Book Array
        $address_book = new CustomerAddressbook();
        $address_book->defaultShipping = false;
        $address_book->defaultBilling = false;
        $address_book->isResidential = true;
        $address_book->addressbookAddress = $address;

        // Address Book List Array
        $address_book_list = new CustomerAddressbookList();
        $address_book_list->addressbook = $address_book;
        $address_book_list->replaceAll = false;

        $customer->externalId = '';

        // Update the customer using the Netsuite service
        require '../config.php';
        $service = new NetSuiteService($config);

        $request = new UpdateRequest();
        $request->record = $customer;
        $result = $service->update($request);

        // Handle the result and return a response
        if ($result->writeResponse->status->isSuccess) {
            echo 'Customer updated';
        } else {
            echo 'Error Occured';
        }
    }
}

$obj = new Customers();
$obj->getCustomer();
