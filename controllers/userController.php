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
    $dni = MainModel::cleanString($_POST['usuario_dni_save']);
    $nombre = MainModel::cleanString($_POST['usuario_nombre']);
    $apellido = MainModel::cleanString($_POST['usuario_apellido']);
    $telefono = MainModel::cleanString($_POST['usuario_telefono']);
    $direccion = MainModel::cleanString($_POST['usuario_direccion']);
    $email = MainModel::cleanString($_POST['usuario_email']);
    $usuario = MainModel::cleanString($_POST['usuario_usuario']);
    $clave1 = MainModel::cleanString($_POST['usuario_clave_1']);
    $clave2 = MainModel::cleanString($_POST['usuario_clave_2']);
    $privilegio = MainModel::cleanString($_POST['usuario_privilegio']);

    // Validaciones campos vacios
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

    // Validaciones integridad de datos
    if (!MainModel::verifyData("[0-9-]{8,20}", $dni)) {
      $alert = [
        "Alert" => "simple",
        "Title" => "Ocurrio un error inesperado",
        "Text" => "El DNI debe contener entre 8 y 20 caracteres y solo numeros",
        "Type" => "error"
      ];
      echo json_encode($alert);
      exit();
    }

    if (!MainModel::verifyData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $nombre)) {
      $alert = [
        "Alert" => "simple",
        "Title" => "Ocurrio un error inesperado",
        "Text" => "El nombre debe contener entre 1 y 35 caracteres",
        "Type" => "error"
      ];
      echo json_encode($alert);
      exit();
    }

    if (!MainModel::verifyData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $apellido)) {
      $alert = [
        "Alert" => "simple",
        "Title" => "Ocurrio un error inesperado",
        "Text" => "El apellido debe contener entre 1 y 35 caracteres",
        "Type" => "error"
      ];
      echo json_encode($alert);
      exit();
    }

    if ($telefono != "") {
      if (!MainModel::verifyData("[0-9()+]{8,20}", $telefono)) {
        $alert = [
          "Alert" => "simple",
          "Title" => "Ocurrio un error inesperado",
          "Text" => "El telefono debe contener entre 8 y 20 caracteres y solo numeros",
          "Type" => "error"
        ];
        echo json_encode($alert);
        exit();
      }
    }

    if ($direccion != "") {
      if (!MainModel::verifyData("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}", $direccion)) {
        $alert = [
          "Alert" => "simple",
          "Title" => "Ocurrio un error inesperado",
          "Text" => "La direccion debe contener entre 1 y 190 caracteres",
          "Type" => "error"
        ];
        echo json_encode($alert);
        exit();
      }
    }

    if (!MainModel::verifyData("[a-zA-Z0-9]{1,35}", $usuario)) {
      $alert = [
        "Alert" => "simple",
        "Title" => "Ocurrio un error inesperado",
        "Text" => "El usuario debe contener entre 1 y 35 caracteres",
        "Type" => "error"
      ];
      echo json_encode($alert);
      exit();
    }

    if ($email != "") {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $alert = [
          "Alert" => "simple",
          "Title" => "Ocurrio un error inesperado",
          "Text" => "El email no es valido",
          "Type" => "error"
        ];
        echo json_encode($alert);
        exit();
      } else {
        $emailExists = MainModel::executeSimpleQuery("SELECT usuario_email FROM usuario WHERE usuario_email = '$email'");
        if ($emailExists->rowCount() > 0) {
          $alert = [
            "Alert" => "simple",
            "Title" => "Ocurrio un error inesperado",
            "Text" => "El email ya esta registrado",
            "Type" => "error"
          ];
          echo json_encode($alert);
          exit();
        }
      }
    }

    if (!MainModel::verifyData("[a-zA-Z0-9$@.-]{7,100}", $clave1) || !MainModel::verifyData("[a-zA-Z0-9$@.-]{7,100}", $clave2)) {
      $alert = [
        "Alert" => "simple",
        "Title" => "Ocurrio un error inesperado",
        "Text" => "La clave debe contener entre 7 y 100 caracteres y letras o @, $, ., -",
        "Type" => "error"
      ];
      echo json_encode($alert);
      exit();
    }



    // Comprobar dni existe
    $dniExists = MainModel::executeSimpleQuery("SELECT usuario_dni FROM usuario WHERE usuario_dni = '$dni'");

    if ($dniExists->rowCount() > 0) {
      $alert = [
        "Alert" => "simple",
        "Title" => "Ocurrio un error inesperado",
        "Text" => "El DNI ya existe en el sistema",
        "Type" => "error"
      ];
      echo json_encode($alert);
      exit();
    }

    // Comprobar usuario existe
    $usuarioExists = MainModel::executeSimpleQuery("SELECT usuario_usuario FROM usuario WHERE usuario_usuario = '$usuario'");

    if ($usuarioExists->rowCount() > 0) {
      $alert = [
        "Alert" => "simple",
        "Title" => "Ocurrio un error inesperado",
        "Text" => "El usuario ya existe en el sistema",
        "Type" => "error"
      ];
      echo json_encode($alert);
      exit();
    }

    if ($clave1 != $clave2) {
      $alert = [
        "Alert" => "simple",
        "Title" => "Ocurrio un error inesperado",
        "Text" => "Las claves no coinciden",
        "Type" => "error"
      ];
      echo json_encode($alert);
      exit();
    } else {
      $password = MainModel::encryptPassword($clave1);
    }

    if ($privilegio < 1 || $privilegio > 3) {
      $alert = [
        "Alert" => "simple",
        "Title" => "Ocurrio un error inesperado",
        "Text" => "El privilegio no es valido",
        "Type" => "error"
      ];
      echo json_encode($alert);
      exit();
    }

    $dataUser = [
      "DNI" => $dni,
      "NOMBRE" => $nombre,
      "APELLIDO" => $apellido,
      "TELEFONO" => $telefono,
      "DIRECCION" => $direccion,
      "EMAIL" => $email,
      "USUARIO" => $usuario,
      "CLAVE" => $password,
      "ESTADO" => "Activo",
      "PRIVILEGIO" => $privilegio
    ];
    $userCreated = UserModel::addUserModel($dataUser);

    if ($userCreated->rowCount() == 1) {
      $alert = [
        "Alert" => "success",
        "Title" => "Usuario registrado con exito",
        "Text" => "El usuario se registro con exito",
        "Type" => "success"
      ];
    } else {
      $alert = [
        "Alert" => "simple",
        "Title" => "Ocurrio un error inesperado",
        "Text" => "El usuario no se pudo registrar",
        "Type" => "error"
      ];
    }
    echo json_encode($alert);
  }
}
