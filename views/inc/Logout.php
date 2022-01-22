<script>
  let btnSalir = document.querySelector("#btnSalir");

  btnSalir.addEventListener("click", function(e) {
    e.preventDefault();
    Swal.fire({
      title: "¿Deseas cerrar sesión?",
      text: "¡Esta por salir del sistema!",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "¡Si, cerrar sesión!",
      cancelButtonText: "¡No, cancelar!"
    }).then((result) => {
      if (result.value) {
        let url = "<?= SERVERURL ?>ajax/loginAjax.php";
        let token = "<?= $loginController->encryption($_SESSION['token']) ?>";
        let usuario = "<?= $loginController->encryption($_SESSION['usuario']) ?>";

        let data = new FormData();

        data.append("token", token);
        data.append("usuario", usuario);

        fetch(url, {
            method: 'POST',
            body: data
          }).then(response => response.json())
          .then(response => {
            alertsAjax(response)
          });
      }
    });
  });
</script>