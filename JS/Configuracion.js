document.addEventListener("DOMContentLoaded", function () {
  const tablaElementos = document.getElementById("tablaBody");

  function agregarElementosATabla(data) {
    tablaElementos.innerHTML = "";

    if (Array.isArray(data)) {
      data.forEach((valor) => {
        if (typeof valor === "object" && valor !== null) {
          const fila = document.createElement("tr");

          for (const clave in valor) {
            const celda = document.createElement("td");
            celda.textContent = valor[clave];
            fila.appendChild(celda);
          }

          const celdaEliminar = document.createElement("td");
          const botonEliminar = document.createElement("input");
          botonEliminar.type = "button";
          botonEliminar.value = "X";
          botonEliminar.addEventListener("click", async function () {
            const confirmacion = await Swal.fire({
              title: '¿Estás seguro de querer eliminar este elemento?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Sí, eliminar',
              cancelButtonText: 'Cancelar'
            });
            if (confirmacion.isConfirmed) {
              
            const filaAEliminar = this.closest("tr");
            const idAEliminar = filaAEliminar.querySelector("td:first-child").textContent; 
          
            try {
              const response = await fetch('http://localhost/html%20treball/Practica-SEVIDOR-HTML/WS/baseDatos/deleteElement.php' + '?id=' + idAEliminar, {
                method: 'DELETE',
              });
          
          
             
              const newData = {
                id: Number(document.getElementById("id").value),
                nombre: document.getElementById("nombre").value,
                descripcion: document.getElementById("descripcion").value,
                nserie: document.getElementById("numSerie").value,
                estado: document.getElementById("estado").value,
                prioridad: document.getElementById("prioridad").value
              };
          
              const modifyResponse = await fetch('http://localhost/html%20treball/Practica-SEVIDOR-HTML/WS/baseDatos/modifyElement.php' + '?id=' + id, {
                method: 'PUT',
                headers: {
                  'Content-Type': 'application/json'
                },
                body: JSON.stringify(newData)
              });
          
              if (!modifyResponse.ok) {
                throw new Error('Error al intentar modificar el elemento.');
              }
          
              
              const updatedData = await cargarElementos();
              agregarElementosATabla(updatedData.data);
            } catch (error) {
              console.error('Error:', error);
            }
           
          }
          });
          
          celdaEliminar.appendChild(botonEliminar);
          fila.appendChild(celdaEliminar);

          const celdaEditar = document.createElement("td");
          const botonEditar = document.createElement("input");
          botonEditar.type = "button";
          botonEditar.value = "Editar";

          botonEditar.addEventListener("click", async function () {
            const filaAEditar = this.closest("tr");
           await editarFila(filaAEditar);
          });
          celdaEditar.appendChild(botonEditar);
          fila.appendChild(celdaEditar);

          tablaElementos.appendChild(fila);
        } else {
          console.error("La estructura de los datos no es la esperada.");
        }
      });
    } else {
      console.error("La estructura de 'data' no es la esperada.");
    }
  }

  async function cargarElementos() {
    try {
      const response = await fetch(
        "http://localhost/html%20treball/Practica-SEVIDOR-HTML/WS/baseDatos/getElement.php"
      );

      if (!response.ok) {
        throw new Error("Error al cargar los elementos.");
      }

      const data = await response.json();
      console.log(data);
      agregarElementosATabla(data.data);
    } catch (error) {
      console.error("Error:", error);
    }
  }

  cargarElementos();


  async function editarFila(fila) {
    const celdas = fila.querySelectorAll("td");
    const id = celdas[0].textContent;
    const nombre = celdas[1].textContent;
    const descripcion = celdas[2].textContent;
    const numSerie = celdas[3].textContent;
    const estado = celdas[4].textContent;
    const prioridad = celdas[5].textContent;
    
    document.getElementById("id").value = id;
    document.getElementById("nombre").value = nombre;
    document.getElementById("descripcion").value = descripcion;
    document.getElementById("numSerie").value = numSerie;
    document.getElementById("estado").value = estado;
    document.getElementById("prioridad").value = prioridad;
    const confirmacion = await Swal.fire({
      title: '¿Editar elemento?',
      text: '¿Estás seguro de que deseas editar este elemento?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí, editar',
      cancelButtonText: 'Cancelar'
    });
    if (confirmacion.isConfirmed) {
    document.getElementById("guardarBtn").onclick = async function () {
      const confirmacionGuardar = await Swal.fire({
        title: '¿Guardar cambios?',
        text: '¿Estás seguro de que deseas guardar los cambios?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, guardar',
        cancelButtonText: 'Cancelar'
      });
      if (confirmacionGuardar.isConfirmed) {
          const newData = {
            id: Number(document.getElementById("id").value),
            nombre: document.getElementById("nombre").value,
            descripcion: document.getElementById("descripcion").value,
            nserie: document.getElementById("numSerie").value,
            estado: document.getElementById("estado").value,
            prioridad: document.getElementById("prioridad").value
          };
          const response = await fetch('http://localhost/html%20treball/Practica-SEVIDOR-HTML/WS/baseDatos/modifyElement.php'+'?id='+ id, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json'
              
            },
            body: JSON.stringify(newData)
          });
          if (!response.ok) {
            throw new Error('Error al intentar modificar el elemento.');
          }
    if(response.ok){
       const updatedData = await cargarElementos();
       agregarElementosATabla(updatedData.data);
    }
    
       
        document.getElementById("id").value = "";
        document.getElementById("nombre").value = "";
        document.getElementById("descripcion").value = "";
        document.getElementById("numSerie").value = "";
        document.getElementById("estado").value = "";
        document.getElementById("prioridad").value = "";
      };
    }
    }
    }

const inputFiltrar = document.getElementById("filtrar");
function filtrarTabla() {
  const filtro = inputFiltrar.value.toLowerCase();
  const filas = tablaElementos.querySelectorAll("tr");

  filas.forEach((fila) => {
    const celdas = fila.querySelectorAll("td");
    const nombre = celdas[0].textContent.toLowerCase();
    const descripcion = celdas[1].textContent.toLowerCase();
    if (filtro.length >= 3) {
      if (nombre.includes(filtro) || descripcion.includes(filtro)) {
        fila.classList.remove("oculto");
        fila.classList.add("color");
      } else {
        fila.classList.add("oculto");
        fila.classList.remove("color");
      }
    } else if (filtro.length === 0) {
      fila.classList.remove("oculto", "color");
    }
  });
}

inputFiltrar.addEventListener("input", filtrarTabla);
});