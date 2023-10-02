<?php

require_once '../vendor/autoload.php';

use NetSuite\Classes\AddRequest;
use NetSuite\Classes\CustomFieldList;
use NetSuite\Classes\CustomRecord;
use NetSuite\Classes\CustomRecordRef;
use NetSuite\Classes\GetRequest;
use NetSuite\Classes\RecordRef;
use NetSuite\Classes\StringCustomFieldRef;
use NetSuite\Classes\UpdateRequest;
use NetSuite\NetSuiteService;

class CustomRecords
{
    function getCustomRecord()
    {
        require '../config.php';
        $service = new NetSuiteService($config);

        $internalId = "1731";
        $request = new GetRequest();
        $request->baseRef = new CustomRecordRef();
        $request->baseRef->typeId = '51'; // Custom Record List Id
        $request->baseRef->internalId = $internalId;
        $existingRecord = $service->get($request);

        print_r($existingRecord);
    }

    function createCustomRecord()
    {
        require '../config.php';
        $service = new NetSuiteService($config);

        //Post Body
        $customFieldList[0] = new StringCustomFieldRef();
        $customFieldList[0]->internalId = "322";
        $customFieldList[0]->value = "Test from PHP toolkit";

        //Post Title
        $customFieldList[1] = new StringCustomFieldRef();
        $customFieldList[1]->internalId = "321";
        $customFieldList[1]->value = "API testing";


        $basicCustomRecord = new CustomRecord();
        $basicCustomRecord->name = "API test 2";
        $basicCustomRecord->recType = new RecordRef();
        $basicCustomRecord->recType->internalId = "51"; //Record Type's internal ID (Setup > Customization > Record Types > Basic Record Type (Internal ID=14)
        $basicCustomRecord->customFieldList = new CustomFieldList();

        $basicCustomRecord->customFieldList->customField = $customFieldList;

        $addRequest = new AddRequest();
        $addRequest->record = $basicCustomRecord;
        $addResponse = $service->add($addRequest);

        if (!$addResponse->writeResponse->status->isSuccess) {
            echo "ADD ERROR";
        } else {
            echo "ADD SUCCESS, id " . $addResponse->writeResponse->baseRef->internalId;
        }
    }

    function updateCustomRecord()
    {
        require '../config.php';
        $service = new NetSuiteService($config);

        //Post Body
        $customFieldList[0] = new StringCustomFieldRef();
        $customFieldList[0]->scriptId = "custrecord_sc_blog_post_pt_content";
        $customFieldList[0]->value = 'New great body';

        //Post Title
        $customFieldList[1] = new StringCustomFieldRef();
        $customFieldList[1]->scriptId = "custrecord_sc_blog_post_pt_subheading";
        $customFieldList[1]->value = 'New Great Title';


        // Create the custom record with updated fields
        $customRecord = new CustomRecord();
        $customRecord->recType = new RecordRef();
        $customRecord->recType->internalId = '51';
        $customRecord->internalId = '2227';
        $customRecord->customFieldList = $customFieldList;

        // Create the UpdateRequest and set the record to update
        $updateRequest = new UpdateRequest();
        $updateRequest->record = $customRecord;

        // Send the update request to NetSuite
        $updateResponse = $service->update($updateRequest);
        print_r($updateResponse);
    }
}
