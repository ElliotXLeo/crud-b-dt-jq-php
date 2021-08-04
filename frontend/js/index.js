let opcion = null;
let tablaPersona = null;

$(document).ready(() => {
  tablaPersona = $('#tablaPersona').DataTable({
    'columnDefs': [{
      'targets': -1,
      'data': null,
      'defaultContent': '<div class="btn-group">      <button class="btn btn-primary boton-editar btn-sm boton-letra">Editar</button>      <button class="btn btn-danger boton-eliminar btn-sm boton-letra">Eliminar</button>    </div>  </div>'
    }],
    'language': {
      'lengthMenu': 'Visualizar _MENU_ registros',
      'zeroRecords': 'No se encontraron registros',
      'info': 'Visualizar desde el registro _START_ al _END_ de un total de _TOTAL_ registros',
      'infoEmpty': 'No hay registros por visualizar',
      'infoFiltered': '(filtrado de un total de _MAX_ registros)',
      'sSearch': 'Buscar:',
      'oPaginate': {
        'sFirst': 'Primero',
        'sLast': 'Último',
        'sNext': 'Siguiente',
        'sPrevious': 'Anterior'
      },
      'sProcessing': 'Procesando'
    }
  });
});

$('#botonAgregarUsuario').click(() => {
  opcion = 1;
  $('#modalFormUsuario').trigger('reset');
  $('.modal-header').removeClass('bg-primary');
  $('.modal-header').addClass('bg-dark');
  $('.modal-title').text('Nuevo usuario');
  $('.modal-title').addClass('text-light');
  $('#modalBotonSubmit').text('Registrar');
  $('#modalCrud').modal("show");
});


$(document).on('click', '.boton-editar', function () {
  opcion = 2;
  $('#modalFormUsuario').trigger('reset');
  $('.modal-header').removeClass('bg-dark');
  $('.modal-header').addClass('bg-primary');
  $('.modal-title').text('Editar usuario');
  $('.modal-title').addClass('text-light');
  $('#modalBotonSubmit').text('Actualizar');
  $('#modalCrud').modal("show");
  const fila = $(this).closest('tr');
  const id = parseInt(fila.find('td:eq(0)').text());
  const usuario = fila.find('td:eq(1)').text();
  const celular = fila.find('td:eq(2)').text();
  const ubicacion = fila.find('td:eq(3)').text();
  if (false) {
    Swal.fire({
      title: '¿Quieres guardar los cambios?',
      showDenyButton: true,
      showCancelButton: true,
      confirmButtonText: `Guardar`,
      denyButtonText: `No guardar`,
      cancelButtonText: `Cancelar`
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        Swal.fire('¡Guardado!', '', 'success')
      } else if (result.isDenied) {
        Swal.fire('Los cambios no se guardaron', '', 'info')
      }
    });
  }
});

$(document).on('click', '.boton-eliminar', function () {
  opcion = 3;
  const fila = $(this).closest('tr');
  const id = parseInt(fila.find('td:eq(0)').text());
  console.log(id);
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
  });
  swalWithBootstrapButtons.fire({
    title: '¿Estás segur@?',
    text: '¡No podrás revertir esto!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: '¡Sí, bórralo!',
    cancelButtonText: '¡No, cancélalo!',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      // $.ajax({
      //   url: '../backend/base-de-datos/crud.php',
      //   type: 'POST',
      //   dataType: 'json',
      //   data: {
      //     opcion: opcion,
      //     id: id
      //   },
      //   success: (data) => {
      //     if (data != null) {
      //       tablaPersona.row(fila.parents('tr')).remove().draw();
      //       Swal.fire({
      //         icon: 'success',
      //         title: '¡Eliminado!'
      //       });
      //     } else {
      //       Swal.fire({
      //         icon: 'error',
      //         title: 'Error, contactarse con soporte.'
      //       });
      //     }
      //   }
      // });
      swalWithBootstrapButtons.fire(
        '¡Eliminad@!',
        'El usuario ha sido eliminad@.',
        'success'
      );
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      swalWithBootstrapButtons.fire(
        'Cancelad@',
        'El usuari@ está seguro :)',
        'error'
      );
    }
  });
});

$('#modalFormUsuario').submit((e) => {
  e.preventDefault();
  const usuario = $.trim($('#usuario').val());
  const clave = $.trim($('#clave').val());
  const celular = $.trim($('#celular').val());
  if (usuario == "" || clave == "" || celular == "") {
    Swal.fire({
      icon: 'warning',
      title: 'Debe completar los campos del registro.'
    });
    return false;
  } else {
    $.ajax({
      url: '../backend/base-de-datos/crud.php',
      type: 'POST',
      dataType: 'json',
      data: {
        usuario: usuario,
        clave: clave,
        celular: celular,
        opcion: opcion
      },
      success: (data) => {
        if (data != null) {
          const id = data[0].id;
          const usuario = data[0].usuario;
          const celular = data[0].celular;
          const ubicacion = data[0].ubicacion;
          const descripcion = data[0].descripcion;
          if (opcion == 1) {
            tablaPersona.row.add([id, usuario, celular, ubicacion, descripcion]).draw();
          } else if (opcion == 2) {
            tablaPersona.row(fila).data([id, usuario, celular, ubicacion, descripcion]).draw();
          }
          Swal.fire({
            icon: 'success',
            title: '¡Agregado!'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error, contactarse con soporte.'
          });
        }
      }
    });
    $('#modalCrud').modal("hide");
  }
});