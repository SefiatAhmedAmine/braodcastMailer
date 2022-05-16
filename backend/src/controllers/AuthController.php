<?php

include(__DIR__ . '/../../headers.php');
require_once(__DIR__ . '/../helpers.php');
require_once(__DIR__ . '/../DAO/UserDAO.php');


class AuthController
{
  /**
   * validate the calling request 
   * allowed request methods : POST
   *
   * @return bool
   */
  function validLogoutRequest()
  {
    return (
      // make sure that the request type is POST
      $_SERVER['REQUEST_METHOD'] === 'POST'
      // make sure the required POST variables were included
      && isset($_POST['user_id'])
      && isset($_POST['user'])
    );
  }

  /**
   * check user credentials and start a session for user if they are correct
   *
   * @param [type] $data
   * @return void
   */
  public function AuthUser($data)
  {
    $userDAO = new UserDAO();
    $user = $userDAO->getUserWithEmail($data["email"]);
    if ($user && $user[$userDAO->getPasswordCol()] == $data['password']) {
     
      echo json_encode([
        'status' => true, 'user' => $data['email'],
        'user_id' => md5($data['email'])
      ]);
    }
    else echo json_encode(['status' => false, 'message' => 'Echec de deconnexion']);
  }


  public function logoutUser()
  {
    if ($this->validLogoutRequest()) {
      // session_destroy();
      echo json_encode([
        'status' => true,
        'message' => 'Deconnexion avec succes'
      ]);
    }
    else echo json_encode(['status' => false, 'message' => 'Echec de deconnexion']);

  }


  public function registerUser($data)
  {
    $userDAO = new UserDAO();
    if ($userDAO->store($data)) {
      echo json_encode(['status' => true, 'message' => 'Inscription avec succes!']);
      return;
    }
    echo json_encode(['status' => false, 'message' => 'Echec d\'inscription']);
  }
}

// get the sent post data
$_POST = Helpers::getPost();

$controller = new AuthController();

if (isset($_POST['action'])) {
  switch ($_POST['action']) {
    case 'register':
      $controller->registerUser($_POST);
      break;
    case 'login':
      $controller->AuthUser($_POST);
      break;
    case 'logout':
      $controller->logoutUser();
      break;
  }
}
