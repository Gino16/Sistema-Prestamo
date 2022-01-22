<?php
$peticionAjax = true;
require_once "../config/APP.php";

if (condition) {
  # code...
} else {
  session_start(['name' => 'SP']);
  session_unset();
  session_destroy();
  header("Location:" . SERVERURL . "login/");
  exit();
}
