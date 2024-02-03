<?php

use Google\Client;
use Google\Service\Drive;

putenv('GOOGLE_APPLICATION_CREDENTIALS=trusty-server-413107-3dd846db03b3.json');

require_once 'api-google/vendor/autoload.php';

function createFolder()
{
    try {
        $client = new Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(Drive::DRIVE);

        $driveService = new Drive($client);

        // Specify the parent folder (unap-test) ID
        $parentFolderId = '1lvyYS0TuymcPphqSPTW3ZRRQhK6DV1gW'; // Reemplace con el ID real de la carpeta

        // Solicitar el nombre de la carpeta desde la consola
        echo "Ingrese el nombre de la carpeta: ";
        $folderName = trim(fgets(STDIN));

        $fileMetadata = new Drive\DriveFile(array(
            'name' => $folderName,
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents' => array($parentFolderId)
        ));

        $file = $driveService->files->create($fileMetadata, array(
            'fields' => 'id'
        ));

        printf("Carpeta '%s' creada con ID: %s\n", $folderName, $file->id);

        return $file->id;

    } catch (Exception $e) {
        echo "Mensaje de error: " . $e;
    }
}

createFolder();