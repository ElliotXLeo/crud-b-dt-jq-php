$(document).ready(() => {
  $('#tablaPersona').DataTable({
    'columnDefs': [{
      'targets': -1,
      'data': null,
      'defaultContent': '<div class="text-center">      <div class="btn-group">        <button class="btn btn-primary btnEditar btn-sm boton-letra">Editar</button>        <button class="btn btn-danger btnEditar btn-sm boton-letra">Eliminar</button>      </div>    </div>'
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

  $('#botonAgregarUsuario').click(() => {
    $('#formRegistroUsuario').trigger('reset');
    $('.modal-header').addClass('bg-dark bg-gradient');
    $('.modal-title').text('Nuevo usuario');
    $('.modal-title').addClass('text-light');

    $('#modalCrud').modal("show");
  });

  $('#formRegistroUsuario').submit((e) => {
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
        datatype: 'json',
        data: {
          usuario: usuario,
          clave: clave,
          celular: celular
        },
        success: (data) => {
          if (data != 'null') {
            const datos = JSON.parse(data);
            usuario = datos[0].id;
            usuario = datos[0].usuario;
            clave = datos[0].celular;
            celular = datos[0].ubicación;
            celular = datos[0].descripcion;
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
});
