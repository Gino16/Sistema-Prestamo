<?php
$peticionAjax = true;
require_once "./../config/APP.php";


if () {
  require_once "./../controllers/userController.php";
  $userController = new UserController();
} else {
  session_start(['name' => 'SP']);
  session_unset();
  session_destroy();
  header("Location:" . SERVERURL . "login/");
  exit();
}
