<?php
if ($peticionAjax) {
  include "./../config/SERVER.php";
} else {
  include "./config/SERVER.php";
}
class MainModel
{
  protected static function connect()
  {
    $conn = new PDO(SGBD, USER, PASSWORD);
    return $conn;
  }

  protected static function executeSimpleQuery($query)
  {
    $sql = self::connect()->prepare($query);
    $sql->execute();
    return $sql;
  }

  public function encryption($string)
  {
    $output = false;
    $key = hash('sha256', SECRET_KEY);
    $iv = substr(hash('sha256', SECRET_IV), 0, 16);
    $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
    $output = base64_encode($output);
    return $output;
  }

  protected static function decryption($string)
  {
    $key = hash('sha256', SECRET_KEY);
    $iv = substr(hash('sha256', SECRET_IV), 0, 16);
    $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
    return $output;
  }

  public function encryptPassword($password)
  {
    $output = false;
    $output = password_hash($password, PASSWORD_BCRYPT);
    return $output;
  }

  public function verifyPassword($password, $hash)
  {
    $output = false;
    $output = password_verify($password, $hash);
    return $output;
  }

  // limpiar cadenas de inyeccion sql y scripts
  protected static function cleanString($string)
  {
    $string = trim($string);
    $string = stripslashes($string);
    $string = str_ireplace("<script>", "", $string);
    $string = str_ireplace("</script>", "", $string);
    $string = str_ireplace("<script src", "", $string);
    $string = str_ireplace("<script type=", "", $string);
    $string = str_ireplace("SELECT * FROM", "", $string);
    $string = str_ireplace("DELETE FROM", "", $string);
    $string = str_ireplace("INSERT INTO", "", $string);
    $string = str_ireplace("DROP TABLE", "", $string);
    $string = str_ireplace("DROP DATABASE", "", $string);
    $string = str_ireplace("TRUNCATE TABLE", "", $string);
    $string = str_ireplace("SHOW TABLES", "", $string);
    $string = str_ireplace("SHOW DATABASES", "", $string);
    $string = str_ireplace("<?php", "", $string);
    $string = str_ireplace("?>", "", $string);
    $string = str_ireplace("--", "", $string);
    $string = str_ireplace(">", "", $string);
    $string = str_ireplace("<", "", $string);
    $string = str_ireplace("[", "", $string);
    $string = str_ireplace("]", "", $string);
    $string = str_ireplace("^", "", $string);
    $string = str_ireplace("==", "", $string);
    $string = str_ireplace(";", "", $string);
    $string = str_ireplace("::", "", $string);
    $string = str_ireplace("'", "", $string);
    $string = str_ireplace("\"", "", $string);
    $string = str_ireplace("\\", "", $string);
    $string = str_ireplace("/", "", $string);
    $string = stripslashes($string);
    $string = trim($string);
    return $string;
  }

  protected static function generateRandomCode($letter, $length, $number)
  {
    for ($i = 0; $i < $length; $i++) {
      $random = rand(0, 9);
      $letter .= $random;
    }
    return $letter . "-" . $number;
  }

  protected static function verifyData($filter, $string)
  {
    if (preg_match("/^" . $filter . "$/", $string)) {
      return true;
    } else {
      return false;
    }
  }

  // protected static function verifyDate($date){
  //   $date = str_replace('/', '-', $date);
  //   $date = date('Y-m-d', strtotime($date));
  //   return $date;

  // }

  // Funcion generica para generar paginacion de tablas
  protected static function tablePaginator($page, $nPages, $url, $buttons)
  {
    $table = '<ul class="justify-content-center pagination">';

    if ($page == 1) {
      $table .= '<li class="page-item disabled"><a class="page-link"><i class="fas fa-angle-double-left"></i></a></li>';
    } else {
      $table .= '
      <li class="page-item"><a class="page-link" href="' . $url . '1/"><i class="fas fa-angle-double-left"></i></a></li>
      <li class="page-item"><a class="page-link" href="' . $url . ($page - 1) . '/">Anterior</a></li>
      ';
    }

    $count = 0;

    for ($i = 1; $i <= $nPages; $i++) {
      if ($count >= $buttons) {
        break;
      }

      if ($page == $i) {
        $table .= '<li class="page-item active"><a class="page-link active" href="' . $url . $i . '/">' . $i . '</a></li>';
      } else {
        $table .= '<li class="page-item"><a class="page-link" href="' . $url . $i . '/">' . $i . '</a></li>';
      }

      $count++;
    }

    if ($page == $nPages) {
      $table .= '<li class="page-item disabled"><a class="page-link"> <i class="fas fa-angle-double-right"></i></a></li>';
    } else {
      $table .= '
        <li class="page-item"><a class="page-link" href="' . $url . ($page + 1) . '/">Siguiente</a></li>
        <li class="page-item"><a class="page-link" href="' . $url . $nPages . '/"><i class="fas fa-angle-double-right"></i></a></li>
        ';
    }

    $table .= '</ul>';
    return $table;
  }
}
