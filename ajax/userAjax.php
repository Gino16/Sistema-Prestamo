<?php
$peticionAjax = true;
require_once "./../config/APP.php";


if (isset($_POST['usuario_dni_save'])) {
  require_once "./../controllers/userController.php";
  $userController = new UserController();

  if (isset($_POST['usuario_dni_save'])) {
    echo $userController->addUserController();
  }
} else {
  session_start(['name' => 'SP']);
  session_unset();
  session_destroy();
  header("Location:" . SERVERURL . "login/");
  exit();
}
