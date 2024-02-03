<?php

use Google\Client;
use Google\Service\Drive;

putenv('GOOGLE_APPLICATION_CREDENTIALS=trusty-server-413107-3dd846db03b3.json');

function createGoogleDoc($folderId)
{
    try {
        $client = new Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(Drive::DRIVE);
        $driveService = new Drive($client);

        // Nombre del documento de Google Docs
        $documentName = 'Nuevo-Documento';

        $fileMetadata = new Drive\DriveFile(array(
            'name' => $documentName,
            'mimeType' => 'application/vnd.google-apps.document',
            'parents' => array($folderId)
        ));

        $file = $driveService->files->create($fileMetadata, array(
            'fields' => 'id'
        ));

        printf("Documento de Google Docs '%s' creado con ID: %s\n", $documentName, $file->id);

        return $file->id;

    } catch (Exception $e) {
        echo "Mensaje de error: " . $e;
    }
}

require_once 'api-google/vendor/autoload.php';

$folderId = '16gqFzyfpjwYKRhgEr0XFgYU2uKMQLSQx';

createGoogleDoc($folderId);