<?php
include 'api-google/vendor/autoload.php';

putenv('GOOGLE_APPLICATION_CREDENTIALS=trusty-server-413107-3dd846db03b3.json');

$client = new Google_Client();

$client->useApplicationDefaultCredentials();

$client->SetScopes(['https://www.googleapis.com/auth/drive.file']);

try {
    $service = new Google_Service_Drive($client);
    $file_path = "files/photo.jpg";

    $file = new Google_Service_Drive_DriveFile();
    $file->setName($file_path);

    $file->setParents(array("1lvyYS0TuymcPphqSPTW3ZRRQhK6DV1gW"));
    $file->setDescription("Archivo cargado desde PHP");
    $file->setMimeType("image/jpg");

    $resultado = $service->files->create(
        $file,
        array(
            'data' => file_get_contents($file_path),
            'mimeType' => "image/jpg",
            'uploadType' => 'media'
        )
    );
    echo '<a href="https://drive.google.com/open?id=' . $resultado->id . '" target="_blank">' .$resultado->name.'</a>';

} catch (Google_Service_Exception $gs) {
    $mensaje = json_decode($gs->getMessage());
    echo $mensaje->error->message;
} catch (Exception $e) {
    echo $e->getMessage();
}
