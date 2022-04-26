<?php

//echo "test";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");

function validRequest()
{
  return (
    // make sure that the request type is POST
    $_SERVER['REQUEST_METHOD'] === 'POST'
    // make sure the required POST variables were included
    && isset($_POST['title'])
    && isset($_POST['message'])
  );
}

	//include('config.php');
	
$servername = "omranecoxvprosol.mysql.db";
$username = "omranecoxvprosol";
$password = "Prosol17";
$dbname = "omranecoxvprosol";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully"; return;
} catch (PDOException $e) {
  //echo "Connection failed: " . $e->getMessage();
  return;
}

$_POST = json_decode(file_get_contents("php://input"), true);

$sql = "SELECT nom, email FROM personnelanniv";
$result = $conn->query($sql);
//---------------------------------
// Set content-type header for sending HTML email 
$header = "MIME-Version: 1.0" . "\r\n";
$header .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// Additional headers 

$header .= 'From: <'. $_POST['expediteur'] .'>'."\n";
//print_r($_POST); exit();
//$stat = true;
// while ($row = $result->fetch()) {
//   $destination = $row["email"];
  $destination = 'amine-sefiat@hotmail.com';
  $subject = $_POST['title'];
  $sexe = "";
  // if ($row["sexe"] == 0) {
  //   $sexe = "Mr. ";
  // } else {
  //   $sexe = "Mme ";
  // }
  //$message = "<h4>Bonjour " . $row["name"] . "</h4>\n";
  $message = "<html>
  <head>
					<title></title>
					</head>
			<body>
			<h4>Bonjour amine</h4>\n";
  $message .= $_POST['message'] . "</body> </html>";
  

  if (validRequest()) {
    //$stat = $stat && mail($destination, $subject, $message, $header);
$stat = mail($destination, $subject, $message, $header);
//echo @$stat;
  // }
}//-----------------------------



$conn = null;
//$stat = true;
$data = [];
if ($stat) 
	$data['status'] = "success";
else $data['status'] = "failure";
echo json_encode($data);