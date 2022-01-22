<?php
$peticionAjax = true;
require_once "../config/APP.php";

if (isset($_POST['token']) && isset($_POST['usuario'])) {
  require_once "../controllers/loginController.php";
  $loginController = new LoginController();
  echo $loginController->logoutController();
} else {
  session_start(['name' => 'SP']);
  session_unset();
  session_destroy();
  header("Location:" . SERVERURL . "login/");
  exit();
}
