<?php
require_once "mainModel.php";
class LoginModel extends MainModel
{
  protected static function loginModel($data){
    $sql = MainModel::connect()->prepare("SELECT * FROM usuario WHERE usuario_usuario = :usuario AND usuario_estado = 'Activo'");
    $sql->bindParam(":usuario", $data['USUARIO']);
    $sql->execute();
    return $sql;
  }
}
