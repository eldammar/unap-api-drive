<?php

use Google\Client;
use Google\Service\Drive;
putenv('GOOGLE_APPLICATION_CREDENTIALS=trusty-server-413107-3dd846db03b3.json');

function uploadWithConversion()
{
    try {
        $client = new Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(Drive::DRIVE);

        $driveService = new Drive($client);
        $carpetaDestinoId = '1lvyYS0TuymcPphqSPTW3ZRRQhK6DV1gW';
        $fileMetadata = new Drive\DriveFile(array(
            'name' => 'My Report',
            'parents' => array($carpetaDestinoId),
            'mimeType' => 'application/vnd.google-apps.spreadsheet'
        ));

        $content = file_get_contents('files/MarketingDirecto.csv');
        $file = $driveService->files->create($fileMetadata, array(
            'data' => $content,
            'mimeType' => 'text/csv',
            'uploadType' => 'multipart',
            'fields' => 'id'));

        printf("Id del archivo: %s\n", $file->id);
        printf("Carpeta: %s\n", 'https://drive.google.com/drive/folders/' . $carpetaDestinoId);
        printf("Archivo: %s\n", 'https://drive.google.com/open?id=' . $file->id);

        return $file->id;
    } catch(Exception $e) {
        echo "Error Message: ".$e;
    }
}

require_once 'api-google/vendor/autoload.php';
uploadWithConversion();

