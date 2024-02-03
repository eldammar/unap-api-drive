<?php

use Google\Client;
use Google\Service\Drive;

putenv('GOOGLE_APPLICATION_CREDENTIALS=trusty-server-413107-3dd846db03b3.json');

function listFiles()
{
    try {
        $client = new Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(Drive::DRIVE);

        $driveService = new Drive($client);

        // Set the folder ID to retrieve files from
        $folderId = '1lvyYS0TuymcPphqSPTW3ZRRQhK6DV1gW';

        $params = array(
            'q' => "'{$folderId}' in parents", // Retrieve files only from the specified folder
            'fields' => 'files(id, name, fileExtension)',
        );

        $files = $driveService->files->listFiles($params)->getFiles();

        foreach ($files as $file) {
            printf("File ID: %s\n", $file->getId());
            printf("File Name: %s\n", $file->getName());
            printf("File Extension: %s\n", $file->getFileExtension());
            echo "------------------------\n";
        }

    } catch (Exception $e) {
        echo "Error Message: ".$e;
    }
}

require_once 'api-google/vendor/autoload.php';
listFiles();
