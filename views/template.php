<!DOCTYPE html>
<html lang="es">

<head>
  <title><?= COMPANY ?></title>
  <?php include "./views/inc/Link.php"; ?>


</head>

<body>
  <?php
  $peticionAjax = false;
  require_once "./controllers/viewController.php";
  $viewController = new ViewController();
  $views = $viewController->getViewController();
  if ($views == "login" || $views == "404") {
    require_once "./views/contents/" . $views . "-view.php";
  } else {
    session_start(['name' => 'SP']);
  ?>
    <!-- Main container -->
    <main class="full-box main-container">
      <!-- Nav Lateral -->
      <?php include "./views/inc/NavLateral.php"; ?>

      <!-- Page content -->
      <section class="full-box page-content">
        <?php
        include "./views/inc/NavBar.php";
        include $views;
        ?>


      </section>
    </main>
  <?php }
  include "./views/inc/Script.php"; ?>
</body>

</html>