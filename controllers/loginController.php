<?php
if ($peticionAjax) {
  require_once "../models/loginModel.php";
} else {
  require_once "./models/loginModel.php";
}

class LoginController extends LoginModel
{
  public function loginController()
  {
    $user = MainModel::cleanString($_POST['usuario']);
    $password = MainModel::cleanString($_POST['clave']);

    if ($user == "" || $password == "") {
      echo '
        <script>
        Swal.fire({
          type: "error",
          title: "¡Debe ingresar usuario y contraseña!",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        }).then(function(result){
          if(result.value){
            window.location = "' . SERVERURL . 'login/";
          }
        });
        </script>
      ';
      exit();
    }

    if (!MainModel::verifyData("[a-zA-Z0-9]{1,35}", $user)) {
      echo '
        <script>
        Swal.fire({
          type: "error",
          title: "¡El usuario no puede contener caracteres especiales!",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        }).then(function(result){
          if(result.value){
            window.location = "' . SERVERURL . 'login/";
          }
        });
        </script>
      ';
      exit();
    }

    if (!MainModel::verifyData("[a-zA-Z0-9$@.-]{7,100}", $password)) {
      echo '
        <script>
        Swal.fire({
          type: "error",
          title: "¡La contraseña no puede contener caracteres especiales!",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        }).then(function(result){
          if(result.value){
            window.location = "' . SERVERURL . 'login/";
          }
        });
        </script>
      ';
      exit();
    }

    $data = [
      "USUARIO" => $user,
    ];

    $userData = LoginModel::loginModel($data);

    if ($userData->rowCount() == 1) {
      $row = $userData->fetch();
      echo "ACA LLEGA EN LOGIN";
      if (MainModel::verifyPassword($password, $row["usuario_clave"])) {
        session_start(["name" => "SP"]);
        $_SESSION["id"] = $row["usuario_id"];
        $_SESSION["nombre"] = $row["usuario_nombre"];
        $_SESSION["apellido"] = $row["usuario_apellido"];
        $_SESSION["usuario"] = $row["usuario_usuario"];
        $_SESSION["privilegio"] = $row["usuario_privilegio"];
        $_SESSION["token"] = md5(uniqid(mt_rand(), true));
        return header("Location:" . SERVERURL . "home/");
      } else {
        echo '
          <script>
          Swal.fire({
            type: "error",
            title: "!El usuario o contraseña son incorrectas!",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
          }).then(function(result){
            if(result.value){
              window.location = "' . SERVERURL . 'login/";
            }
          });
          </script>
        ';
        exit();
      }
    } else {
      echo '
        <script>
        Swal.fire({
          type: "error",
          title: "!El usuario o contraseña son incorrectas!",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        }).then(function(result){
          if(result.value){
            window.location = "' . SERVERURL . 'login/";
          }
        });
        </script>
      ';
      exit();
    }
  }

  public function forceLogoutController(){
    session_unset();
    session_destroy();
    if( headers_sent()){
      echo '<script>
      window.location.href="' . SERVERURL . 'login/";
      </script>';
    } else {
      header("Location:" . SERVERURL . "login/");
    }
  }

  public function logoutController()
  {
    session_start(["name" => "SP"]);
    $token = MainModel::decryption($_POST['token']);
    $usuario = MainModel::decryption($_POST['usuario']);

    if($token == $_SESSION['token'] && $usuario == $_SESSION['usuario']){
      session_unset();
      session_destroy();
      $alert = [
        "Alert" => "redirect",
        "Title" => "¡Sesión cerrada!",
        "Text" => "¡Hasta pronto!",
        "Icon" => "success",
        "URL" => SERVERURL . "login/"
      ];
    } else {
      $alert = [
        "Alert" => "info",
        "Title" => "¡No se pudo cerrar sesión!",
        "Text" => "¡Intenta nuevamente!",
        "Icon" => "error",
      ];
    }
    echo json_encode($alert);
  }
}
