document.addEventListener("DOMContentLoaded",  async function() {
    const formulario = document.getElementById("miFormulario");
  
     formulario.addEventListener("submit", async function(event) {
      event.preventDefault(); 
      
      
        const nombre = document.getElementById("nombre_elemento").value;
        const descripcion = document.getElementById("descripcion_elemento").value;
          const nserie = document.getElementById("numero_serie").value;
          const estado = document.getElementById('estado').value;
          const prioridad_alta = document.getElementById('prioridad_alta').value;
          const prioridad_media = document.getElementById('prioridad_media').value;
          const prioridad_baja = document.getElementById('prioridad_baja').value;
          const formData = {
            nombre: nombre,
            descripcion: descripcion,
            nserie: nserie,
            estado: estado,
            prioridad: prioridad_alta ? prioridad_alta : prioridad_media? prioridad_media : prioridad_baja 
       
        
      };

      const confirmacion = await Swal.fire({
        title: '¿Enviar datos?',
        text: '¿Estás seguro de que deseas enviar estos datos?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, enviar',
        cancelButtonText: 'Cancelar'
      });
      if (confirmacion.isConfirmed) {
      try {
        const response = await fetch('http://localhost/html%20treball/Practica-SEVIDOR-HTML/WS/baseDatos/createElement2.php' , {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(formData),
        });
      
        const responseData = await response.json(); 
      
        if (!response.ok) {
          throw new Error("Error al enviar los datos: " + responseData.message); 
        }
      
        console.log("Datos enviados correctamente", responseData);
      } catch (error) {
        console.error("Error:", error);
      }
    }
    });
  });