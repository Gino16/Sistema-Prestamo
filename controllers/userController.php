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
    # code...
  }
}
