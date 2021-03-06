<?php

include($_SERVER['DOCUMENT_ROOT'] . '/monasaba/backend/headers.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/monasaba/backend/src/DAO/DB.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/monasaba/backend/src/DAO/UserDAO.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/monasaba/backend/src/helpers.php');

// include($_SERVER['DOCUMENT_ROOT'] . '/backend/headers.php');
// require_once($_SERVER['DOCUMENT_ROOT'] . '/backend/src/DAO/DB.php');
// require_once($_SERVER['DOCUMENT_ROOT'] . '/backend/src/DAO/UserDAO.php');
// require_once($_SERVER['DOCUMENT_ROOT'] . '/backend/src/helpers.php');

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

  /**
   * Send message to all users
   * HTTP method : POST
   *
   * @return void
   */
  public function sendMessageToUsers()
  {
    if ($this->validSendMessageRequest()) {
      $userDAO = new UserDAO();
      $users = $userDAO->all();

      // Set content-type header for sending HTML email 
      $header = "MIME-Version: 1.0" . "\r\n";
      $header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
      // Additional headers 
      $header .= 'From: <' . strip_tags($_POST['expediteur']) . '>' . "\n";

      $state = false;
      foreach ($users as $row) {
        $destination = $row[$userDAO->getEmail()];
        $subject = strip_tags($_POST['title']);
        $message = "<h4>Bonjour " . $row[$userDAO->getName()] . "</h4>\n";
        $message .= strip_tags($_POST['message']);

        $state = $state || mail($destination, $subject, $message, $header);
      }
	  echo json_encode(['status' => $state, 'message' => $message]);
    }
  }

  /**
   * Send message to amine-sefiat@hotmail.com and m.elmoutassim@alomrane.gov.ma to test mailing
   * HTTP method : POST
   *
   * @return void
   */
  public function sendMessageToTest()
  {

    if ($this->validSendMessageRequest()) {

	$header = "From: <" . strip_tags($_POST['expediteur']) . ">\n";
	
	
	//$header .= "Reply-To: <" . strip_tags($_POST['expediteur']) . '>' . "\r\n";
	//$header .= "Return-Path: <" . strip_tags($_POST['expediteur']) . '>' . "\r\n";
	
      // Set content-type header for sending HTML email 
      $header .= "MIME-Version: 1.0" . "\r\n";
      $header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
      // Additional headers 
      
  
      $destination = "r.mouati@alomrane.gov.ma";
      $subject = $_POST['title'];
      $message = "<html><body>
	  <h4>Bonjour ELMOUTASSIM BILLAH</h4>\n";
      $message .= $_POST['message'];
	  $message .= "</body> </html>";

      $state = mail($destination, $subject, $message, $header);

      $destination2 = "amine.sefiat@gmail.com";
      $subject2 = $_POST['title'];
      $message = "<html><body>
		<h4>Bonjour SEFIAT</h4>\n";
      $message2 .= $_POST['message'];
	  $message2 .= "</body> </html>";


      $state = mail($destination2, $subject2, $message2, $header);

    }
    echo json_encode(['status' => $state, 'message' => $message]);
  }
}

$controller = new CourrierController();

// get the sent post data
$_POST = Helpers::getPost();

// testing call
$controller->sendMessageToTest();

// production call
// $controller->sendMessageToUsers();

