<?php
require_once "./mainModel.php";

class UserModel extends MainModel
{
  protected static function addUserModel($data)
  {
    $sql = MainModel::connect()->prepare("INSERT INTO usuario 
    (usuario_dni, usuario_nombre, usuario_apellido, usuario_telefono, usuario_direccion, usuario_email, usuario_usuario, usuario_clave, usuario_estado, usuario_privilegio)
    VALUES (:DNI, :NOMBRE, :APELLIDO, :TELEFONO, :DIRECCION, :EMAIL, :USUARIO, :CLAVE, :ESTADO, :PRIVILEGIO);");

    $sql->bindParam(":DNI", $data["DNI"]);
    $sql->bindParam(":NOMBRE", $data["NOMBRE"]);
    $sql->bindParam(":APELLIDO", $data["APELLIDO"]);
    $sql->bindParam(":TELEFONO", $data["TELEFONO"]);
    $sql->bindParam(":DIRECCION", $data["DIRECCION"]);
    $sql->bindParam(":EMAIL", $data["EMAIL"]);
    $sql->bindParam(":USUARIO", $data["USUARIO"]);
    $sql->bindParam(":CLAVE", $data["CLAVE"]);
    $sql->bindParam(":ESTADO", $data["ESTADO"]);
    $sql->bindParam(":PRIVILEGIO", $data["PRIVILEGIO"]);
    $sql->execute();
    return $sql;
  }
}
