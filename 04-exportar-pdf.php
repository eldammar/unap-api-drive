<?php

use Google\Client;
use Google\Service\Drive;

putenv('GOOGLE_APPLICATION_CREDENTIALS=trusty-server-413107-3dd846db03b3.json');

function exportPdf()
{
    try {
        $client = new Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(Drive::DRIVE);

        $driveService = new Drive($client);
        $realFileId = readline("Enter File Id: ");
        $fileId = $realFileId;

        $response = $driveService->files->export($fileId, 'application/pdf', array(
            'alt' => 'media'));

        $content = $response->getBody()->getContents();

        // Guardar el contenido del PDF en un archivo en la carpeta "Descargas"
        $pdfFilePath = 'Descargas/' . $realFileId . '.pdf';
        file_put_contents($pdfFilePath, $content);

        echo "PDF guardado en: " . $pdfFilePath;

    } catch (Exception $e) {
        echo "Error Message: " . $e;
    }
}

//[END drive_export_pdf]
require_once 'api-google/vendor/autoload.php';
exportPdf();
