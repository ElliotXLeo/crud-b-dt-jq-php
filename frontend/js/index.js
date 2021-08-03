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
    $('.modal-title').text('Nueva persona');
    $('.modal-title').addClass('text-light');
    $('#modalCrud').modal("show");
  });


});
