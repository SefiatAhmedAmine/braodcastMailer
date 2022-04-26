<?php

$uploadDIR = "";

class Helpers
{

  /**
   * decode json formated data sent from HTTP POST
   *
   * @return mixed
   */
  static function getPost()
  {
    return json_decode(file_get_contents("php://input"), true);
  }
}
