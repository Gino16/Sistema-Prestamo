const formulariosAjax = document.querySelectorAll(".FormularioAjax");

function sendFormAjax(e) {
  e.preventDefault();

  let formData = new FormData(this);
  let method = this.getAttribute("method");
  let action = this.getAttribute("action");
  let type = this.getAttribute("data-form");

  let headers = new Headers();

  let config = {
    method: method,
    headers: headers,
    mode: "cors",
    cache: "no-cache",
    body: formData,
  };

  let alertText;

  if (type === "save") {
    alertText = "Los datos quedarán guardados en el sistema";
  } else if (type === "delete") {
    alertText = "Los datos serán eliminados del sistema";
  } else if (type === "update") {
    alertText = "Los datos serán actualizados en el sistema";
  } else if (type === "search") {
    alertText = "Los datos serán buscados en el sistema";
  } else if (type === "loans") {
    alertText = "Desea remover los datos seleccionados?";
  } else {
    alertText = "Quieres realizar esta operación?";
  }

  Swal.fire({
    title: "¿Estás seguro?",
    text: alertText,
    type: "question",
    showCancelButton: true,
    cancelButtonColor: "#d33",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "Aceptar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.value) {
      fetch(action, config)
        .then((response) => response.json())
        .then((response) => {
          return alertsAjax(response);
        });
    }
  });
}

formulariosAjax.forEach(formulario => {
  formulario.addEventListener("submit", sendFormAjax);
});

function alertsAjax(alert) {
  if (alert.Alert === "simple") {
    Swal.fire({
      title: alert.Title,
      text: alert.Text,
      type: alert.Type,
      confirmButtonText: "Aceptar"
    });
  } else if (alert.Alert === "reload") {
    Swal.fire({
      title: alert.Title,
      text: alert.Text,
      type: alert.Type,
      confirmButtonText: "Aceptar",
    }).then(result => {
      if (result.value) {
        location.reload();
      }
    });
  } else if (alert.Alert === "clean") {
    Swal.fire({
      title: alert.Title,
      text: alert.Text,
      type: alert.Type,
      confirmButtonText: "Aceptar",
    }).then(result => {
      if (result.value) {
        document.querySelectorAll(".FormularioAjax").reset();
      }
    });
  } else if (alert.Alert === "redirect") {
    Swal.fire({
      title: alert.Title,
      text: alert.Text,
      type: alert.Type,
      confirmButtonText: "Aceptar",
    }).then(result => {
      if (result.value) {
        window.location.href = alert.Url;
      }
    });
  }
}