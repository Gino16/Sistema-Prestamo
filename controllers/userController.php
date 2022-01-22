<?php
if ($peticionAjax) {
  require_once "./../models/userModel.php";
} else {
  require_once "./models/userModel.php";
}
class UserController extends UserModel
{
  public function addUserController()
  {
    $dni = MainModel::cleanString($_POST['usuario_dni']);
    $nombre = MainModel::cleanString($_POST['usuario_nombre']);
    $apellido = MainModel::cleanString($_POST['usuario_apellido']);
    $telefono = MainModel::cleanString($_POST['usuario_telefono']);
    $direccion = MainModel::cleanString($_POST['usuario_direccion']);
    $email = MainModel::cleanString($_POST['usuario_email']);
    $usuario = MainModel::cleanString($_POST['usuario_usuario']);
    $clave1 = MainModel::cleanString($_POST['usuario_clave_1']);
    $clave2 = MainModel::cleanString($_POST['usuario_clave_2']);
    $privilegio = MainModel::cleanString($_POST['usuario_privilegio']);

    // Validaciones
    if ($dni == "" || $nombre == "" || $apellido == "" || $email == "" || $usuario == "" || $clave1 == "" || $clave2 == "" || $privilegio == "") {
      $alert = [
        "Alert" => "simple",
        "Title" => "Ocurrio un error inesperado",
        "Text" => "Todos los campos son obligatorios",
        "Type" => "error"
      ];
      echo json_encode($alert);
      exit();
    }
  }
}
