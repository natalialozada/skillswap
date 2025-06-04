async function makeFetchFormRequest(method, url, data) {
  const formData = new FormData();

  // Verificar si el parámetro `data` es un formulario HTML
  if (data instanceof HTMLFormElement) {
      new FormData(data).forEach((value, key) => {
          formData.append(key, value);
      });
  } else {
      // Asumir que `data` es un objeto
      for (const key in data) {
          if (data.hasOwnProperty(key)) {
              formData.append(key, data[key]);
          }
      }
  }

  try {
      const response = await fetch(url, {
          method: method,
          body: formData,
      });

      console.log("Estado de la respuesta HTTP:", response.status);
      console.log("Encabezados de la respuesta:", response.headers);

      // Verificar si la respuesta es válida
      if (!response.ok) {
          const errorText = await response.text();
          console.error("Error en la respuesta del servidor:", errorText);
          throw new Error(`Error en la respuesta HTTP: ${response.status} ${response.statusText}`);
      }

      // Leer y procesar el cuerpo como JSON
      const responseBody = await response.text(); // Leer el cuerpo como texto primero
      try {
          const jsonData = JSON.parse(responseBody); // Intentar parsear como JSON
          console.log("Respuesta JSON recibida:", jsonData);
          return jsonData;
      } catch (jsonParseError) {
          console.error("Error al parsear JSON:", jsonParseError);
          console.error("Contenido bruto de la respuesta:", responseBody);
          throw new Error("La respuesta no contiene JSON válido.");
      }
  } catch (error) {
      console.error("Error capturado durante la petición:", error.message);
      throw error;
  }
}

//Formulario Registro ----------------------------------------------------------------------------------------------------------------------------------------

document.addEventListener("DOMContentLoaded", function () {
  //alert("hola");
  const formRegistro = document.getElementById("form-registro");

  if (formRegistro) {
      const botonRegistro = document.getElementById("boton-registro");
      const controller1 = "controllers/registro-controller.php";
      const resultadoRegistro = document.getElementById("resultadoRegistro");
      formRegistro.addEventListener("submit", function (event) {
          event.preventDefault();
          botonRegistro.disabled = true;
          makeFetchFormRequest('POST', controller1, formRegistro)
              .then(response => {
                  if (response.status === "success") {
                      resultadoRegistro.textContent = response.message;
                      formRegistro.reset();
                  }
                  else {
                      resultadoRegistro.textContent = response.message || 'Error desconocido.';
                  }
              })
              .catch(error => {
                  console.error("Error en la inserción:", error.message);
                  resultadoRegistro.textContent = 'No se pudo realizar la inserción';
              })
              .finally(() => {
                  botonRegistro.disabled = false;
              });
      });
  }

  //Formulario Iniciar -----------------------------------------------------------------------------------------------------------------------------------

  const formInicia = document.getElementById("form-login");

  if (formInicia) {
      const botonInicio = document.getElementById("boton-inicio");
      const controller1 = "controllers/login-controller.php";
      const resultadoInicia = document.getElementById("resultadoInicia");


      formInicia.addEventListener("submit", function (event) {
          
          event.preventDefault();
          botonInicio.disabled = true;
          makeFetchFormRequest('POST', controller1, formInicia)
              .then(response => {
                  if (response.status === "success") {
                      resultadoInicia.textContent = response.message;
                      formInicia.reset();
                      window.location.href = "principal.php";
                  }
                  else {
                      resultadoInicia.textContent = response.message || 'Error desconocido.';
                  }
              })
              .catch(error => {
                  console.error("Error en la inserción:", error.message);
                  resultadoInicia.textContent = 'No se pudo realizar la inserción';
              })
              .finally(() => {
                  botonInicio.disabled = false;
              });
      });
  }

});

/*Guardar perfil creado */
const form = document.getElementById("form-perfil");

  if (form) {
    form.addEventListener("submit", async function (e) {
      e.preventDefault();

      const formData = new FormData(form);

      try {
        const response = await fetch("controllers/guardar-perfil-controller.php", {
          method: "POST",
          body: formData
        });

        const result = await response.json();

        if (result.status === "success") {
          alert("Perfil guardado con éxito");
          location.reload();
        } else {
          alert("Error: " + result.message);
        }
      } catch (err) {
        console.error("Error al enviar el formulario:", err);
        alert("Hubo un error de red");
      }
    });
  }

  const inputFile = document.getElementById("foto_perfil");
  const preview = document.querySelector(".foto-perfil-preview");

  if (inputFile && preview) {
    inputFile.addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
  }

  const formEditar = document.getElementById("form-editar-perfil");

if (formEditar) {
  formEditar.addEventListener("submit", async function (e) {
    e.preventDefault();
    const formData = new FormData(formEditar);

    try {
      const res = await fetch("controllers/editar-perfil-controller.php", {
        method: "POST",
        body: formData,
      });

      const result = await res.json();
      if (result.status === "success") {
        alert("Perfil actualizado correctamente");
        window.location.href = "mi-perfil.php";
      } else {
        alert("Error: " + result.message);
      }
    } catch (err) {
      console.error("Error de red:", err);
      alert("Error de red");
    }
  });

  const preview = document.getElementById("preview-img");
  const inputFile = document.getElementById("foto_perfil");

  if (inputFile && preview) {
    inputFile.addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
  }
}
/*botón conectar principal*/ 
document.addEventListener('DOMContentLoaded', () => {
  const botonesConectar = document.querySelectorAll('.btn-conectar');

  botonesConectar.forEach(btn => {
    btn.addEventListener('click', async (e) => {
      e.preventDefault();

      const idDestino = btn.dataset.id;

      try {
        const response = await fetch("controllers/enviar-solicitud-controller.php", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `id_destino=${encodeURIComponent(idDestino)}`
        });

        const data = await response.json();

        if (data.status === 'success') {
          alert("✅ Solicitud enviada con éxito.");
        } else {
          alert("⚠️ " + data.message);
        }
      } catch (error) {
        alert("Error en la red. Intenta de nuevo.");
        console.error(error);
      }
    });
  });
});

document.addEventListener("DOMContentLoaded", () => {
  fetch("controllers/notificaciones-controller.php")
    .then(res => res.json())
    .then(data => {
      if (data.status === "success" && data.count > 0) {
        const contador = document.getElementById("contador-notis");
        contador.textContent = data.count;
        contador.style.display = "inline-block";
      }
    })
    .catch(err => console.error("Error al obtener notificaciones:", err));
});

document.addEventListener("DOMContentLoaded", () => {
  const btns = document.querySelectorAll(".tab-btn");
  const tabs = document.querySelectorAll(".tab-content");

  btns.forEach(btn => {
    btn.addEventListener("click", () => {
      btns.forEach(b => b.classList.remove("active"));
      tabs.forEach(tab => tab.classList.remove("active"));

      btn.classList.add("active");
      document.getElementById(btn.dataset.tab).classList.add("active");
    });
  });

 
  const campana = document.getElementById("campana-icono");
  if (campana) {
    campana.addEventListener("click", () => {
      window.location.href = "notificaciones.php";
    });
  }
});
