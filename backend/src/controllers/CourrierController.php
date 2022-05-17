<?php

session_start();

include(__DIR__ . '/../../headers.php');
require_once(__DIR__ .  '/../DAO/DB.php');
require_once(__DIR__ . '/../DAO/PersonnelDAO.php');
require_once(__DIR__ . '/../DAO/LogsDAO.php');
require_once(__DIR__ . '/../helpers.php');

class CourrierController
{
  /**
   * validate the calling request before starting to send emails
   * allowed request methods : POST
   *
   * @return bool
   */
  function validSendMessageRequest()
  {
    return (
      // make sure that the request type is POST
      $_SERVER['REQUEST_METHOD'] === 'POST'
      // make sure the required POST variables were included
      && isset($_POST['title'])
      && isset($_POST['message'])
      && isset($_POST['expediteur'])
    );
  }

  function validUser()
  {
    return (isset($_POST['user_id'])
      && isset($_POST['user'])
      && md5($_POST['user']) == $_POST['user_id'] 
    );
  }

  function sendMail($to, $subject, $message)
  {
    // Set content-type header for sending HTML email 
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    // Additional headers 
    $headers .= 'From: <' . strip_tags($_POST['expediteur']) . '>' . "\n";

    if (mail($to, $subject, $message, $headers)) {
      $log = new LogsDAO();
      $log->store([
        'expeditor' => $_POST['user'],
        'subject' => $subject,
        'send_at' => date("Y-m-d h:i:sa")
      ]);
      return true;
    }
    return false;
  }

  /**
   * Send message to all users
   * HTTP method : POST
   *
   * @return void
   */
  public function sendMessageToUsers()
  {
    $state = false;
    $message = "un erreur est survenue lors de l'execution de la requete";
    if ($this->validSendMessageRequest() && $this->validUser() ) {
      $personnelDAO = new PersonnelDAO();
      $users = $personnelDAO->all();

      $state = false;
      foreach ($users as $row) {
        $sexe = $row[$personnelDAO->getSexeCol()] == 0 ? "Mr" : "Mme";
        $destination = $row[$personnelDAO->getEmailCol()];
        $subject = strip_tags($_POST['title']);
        $message = "<h4>Bonjour ".$sexe." ".$row[$personnelDAO->getLastnameCol()]."</h4>\n";
        $message .= strip_tags($_POST['message']);

        $state = $state || $this->sendMail($destination, $subject, $message);
      }
    }
    echo json_encode(['status' => $state, 'message' => $_SESSION]);

  }

  /**
   * Send message to amine-sefiat@hotmail.com to test mailing
   * HTTP method : POST
   *
   * @return void
   */
  public function sendMessageToTest()
  {
    if ($this->validSendMessageRequest() && $this->validUser()) {

      $destination = "amine.sefiat@gmail.com";
      $subject = $_POST['title'];
      $message = "<h4>Bonjour Mr SEFIAT</h4>\n";
      $message .= $_POST['message'];

      $state = $this->sendMail($destination, $subject, $message);

    }
    echo json_encode(['status' => $state, 'message' => $message]);
  }
}

$controller = new CourrierController();

// get the sent post data
$_POST = Helpers::getPost();
$controller->sendMessageToUsers();
