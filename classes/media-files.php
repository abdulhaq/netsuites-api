<?php

require_once '../vendor/autoload.php';

use NetSuite\Classes\AddRequest;
use NetSuite\Classes\GetRequest;
use NetSuite\Classes\RecordRef;
use NetSuite\Classes\File;
use NetSuite\NetSuiteService;

class MediaFiles
{
    public function getMedia()
    {
        require '../config.php';
        $service = new NetSuiteService($config);
        $internalId = "64129";

        $request2 = new GetRequest();
        $request2->baseRef = new RecordRef();
        $request2->baseRef->internalId = $internalId;
        $request2->baseRef->type = "file";
        $response = $service->get($request2);

        print_r($response);
    }

    public function uploadMedia()
    {
        require '../config.php';
        $service = new NetSuiteService($config);

        $imgPath = 'image.jpg'; //specify the file path
        $imgContents = file_get_contents($imgPath); //get the contents of the file
        $file = new File();
        $file->folder = new RecordRef();
        $file->folder->internalId = "-15";
        $file->name = 'test6.png';
        $file->isOnline = true;
        // $file->attachFrom = '_computer';
        $file->content = $imgContents;

        $addRequest = new AddRequest();
        $addRequest->record = $file;
        $addResponse = $service->add($addRequest);

        if (!$addResponse->writeResponse->status->isSuccess) {
            echo "ADD FILE ERROR";
        } else {
            echo "ADD FILE SUCCESS, id " . $addResponse->writeResponse->baseRef->internalId;
        }
    }
}