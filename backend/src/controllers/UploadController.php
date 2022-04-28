<?php


include($_SERVER['DOCUMENT_ROOT'] . '/monasaba/backend/headers.php');
include($_SERVER['DOCUMENT_ROOT'] . '/monasaba/backend/src/helpers.php');

// include($_SERVER['DOCUMENT_ROOT'] . '/backend/headers.php');
// include($_SERVER['DOCUMENT_ROOT'] . '/backend/src/helpers.php');

class UploadController
{

  function validUploadRequest()
  {
    return (
      // make sure that the request type is POST
      $_SERVER['REQUEST_METHOD'] === 'POST'
      // make sure the required POST variables were included
      && isset($_POST['file'])
    );
  }

  function uploadFile()
  {
    
    // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {

      // Testons si l'extension est autorisée
      $fileInfo = pathinfo($_FILES['file']['name']);
      $extension = $fileInfo['extension'];
      $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
      if (in_array($extension, $allowedExtensions)) {
        $img = '/monasaba/backend/public/upload/' . uniqid() . basename($_FILES['file']['name']); 
        // $img = '/backend/public/upload/' . uniqid() . basename($_FILES['file']['name']); 
        move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $img);

        // echo json_encode(['imgURL' => "http://" . $_SERVER['HTTP_HOST'] . $img]);
        echo json_encode(['imgURL' => "https://" . $_SERVER['HTTP_HOST'] . $img]);
      }

      
    }
  }
}

$_POST = Helpers::getPost();

$controller = new UploadController();

$controller->uploadFile();
