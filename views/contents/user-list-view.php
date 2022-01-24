<?php if ($_SESSION['privilegio'] != 1) {
  echo $loginController->forceLogoutController();
  exit();
} ?>
<!-- Page header -->
<div class="full-box page-header">
  <h3 class="text-left">
    <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS
  </h3>
  <p class="text-justify">
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
  </p>
</div>

<div class="container-fluid">
  <ul class="full-box list-unstyled page-nav-tabs">
    <li>
      <a href="<?= SERVERURL ?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
    </li>
    <li>
      <a class="active" href="<?= SERVERURL ?>user-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
    </li>
    <li>
      <a href="<?= SERVERURL ?>user-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
    </li>
  </ul>
</div>

<!-- Content -->
<div class="container-fluid">
  <div class="table-responsive">
    <table class="table table-dark table-sm">
      <thead>
        <tr class="text-center roboto-medium">
          <th>#</th>
          <th>DNI</th>
          <th>NOMBRE</th>
          <th>TELÉFONO</th>
          <th>USUARIO</th>
          <th>EMAIL</th>
          <th>ACTUALIZAR</th>
          <th>ELIMINAR</th>
        </tr>
      </thead>
      <tbody>
        <?php
        require_once "./controllers/userController.php";
        $userController = new UserController();
        echo $userController->userPaginatorController($pagina[1], 15, $_SESSION['privilegio'], $_SESSION['id'], $pagina[0], "");
        ?>
  </div>

</div>