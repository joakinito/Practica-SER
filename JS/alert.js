import Swal from 'sweetalert2';
Swal.fire({
  title: '¡Hola!',
  text: 'Este es un mensaje con SweetAlert2',
  icon: 'success',
  confirmButtonText: 'Aceptar'
}).then((result) => {
  if (result.isConfirmed) {
  }
});