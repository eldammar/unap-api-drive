<?php

use Google\Client;
use Google\Service\Drive;

putenv('GOOGLE_APPLICATION_CREDENTIALS=trusty-server-413107-3dd846db03b3.json');

function downloadFile()
{
    try {
        $client = new Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(Drive::DRIVE);

        $driveService = new Drive($client);

        // Get File Id from user input
        $realFileId = readline("Enter File Id: ");
        $fileId = $realFileId;

        // Check if the file is a Google Docs file (non-binary)
        $file = $driveService->files->get($fileId);
        if ($file->mimeType == 'application/vnd.google-apps.document') {
            // Export Google Docs file
            echo "Exporting Google Docs file..." . PHP_EOL;
            $response = $driveService->files->export($fileId, 'text/plain', array('alt' => 'media'));
        } else {
            // Download binary file
            echo "Downloading binary file..." . PHP_EOL;
            $response = $driveService->files->get($fileId, array('alt' => 'media'));
        }

        // Specify the destination folder
        $destinationFolder = 'descargas/';

        // Ensure the destination folder exists, create it if not
        if (!file_exists($destinationFolder)) {
            mkdir($destinationFolder, 0755, true);
        }

        // Specify the file path in the destination folder
        $filePath = $destinationFolder . $file->name;

        // Save the content to the file
        file_put_contents($filePath, $response->getBody()->getContents());

        echo "File downloaded to: " . $filePath . PHP_EOL;

    } catch (Exception $e) {
        echo "Error Message: " . $e;
    }
}

// [END drive_download_basic]
require_once 'api-google/vendor/autoload.php';
downloadFile();
