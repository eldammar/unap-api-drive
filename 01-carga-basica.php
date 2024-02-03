<?php

use Google\Client;
use Google\Service\Drive;
putenv('GOOGLE_APPLICATION_CREDENTIALS=trusty-server-413107-3dd846db03b3.json');

function uploadBasic()
{
    try {
        $client = new Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(Drive::DRIVE);

        $driveService = new Drive($client);
        $carpetaDestinoId = '1lvyYS0TuymcPphqSPTW3ZRRQhK6DV1gW';
        $fileMetadata = new Drive\DriveFile(array(
            'name' => 'photo.jpg',
            'parents' => array($carpetaDestinoId)
        ));

        $content = file_get_contents('files/photo.jpg');
        $file = $driveService->files->create($fileMetadata, array(
            'data' => $content,
            'mimeType' => 'image/jpeg',
            'uploadType' => 'multipart',
            'fields' => 'id'));

        printf("ID del archivo: %s\n", $file->id);
        printf("Carpeta: %s\n", 'https://drive.google.com/drive/folders/' . $carpetaDestinoId);
        printf("Archivo: %s\n", 'https://drive.google.com/open?id=' . $file->id);

        return $file->id;

    } catch(Exception $e) {
        echo "Error Message: ".$e;
    }
}
//[END drive_upload_basic]
require_once 'api-google/vendor/autoload.php';
uploadBasic();

