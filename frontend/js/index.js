'use strict';

let opcion = null;
let tablaPersona = null;
let fila = null;
let id = null;
let http = null;
let endpoint = '../backend/models/crud.php';

$(document).ready(() => {
  const consultarRegistros = async () => {
    try {
      const res = await axios({
        method: 'GET',
        url: endpoint,
      });
      const data = res.data;
      const tbody = document.getElementById('tbody');
      data.map((elemento) => {
        tbody.innerHTML += `
          <tr>
            <td>${elemento.id}</td>
            <td>${elemento.usuario}</td>
            <td>${elemento.descripcion}</td>
            <td>
            </td>
          </tr>
        `;
      });
      tablaPersona = $('#tablaPersona').DataTable({
        'columnDefs': [{
          'targets': -1,
          'data': null,
          'defaultContent': '<div class="btn-group">      <button class="btn btn-success boton-editar btn-sm boton-letra">Editar</button>      <button class="btn btn-danger boton-eliminar btn-sm boton-letra">Eliminar</button>    </div>  </div>'
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
    } catch (error) {
      Swal.fire({
        position: 'center',
        title: '¡Ha ocurrido un error! Contactar con soporte.',
        text: error,
        icon: 'warning',
        confirmButtonText: 'Aceptar',
        showClass: {
          popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp'
        }
      });
    }
  }
  consultarRegistros();

  $('#botonAgregarUsuario').click(() => {
    opcion = 1;
    $('#modalFormUsuario').trigger('reset');
    $('.modal-header').removeClass('bg-success');
    $('.modal-header').addClass('bg-primary');
    $('.modal-title').text('Nuevo usuario');
    $('#modalBotonSubmit').text('Registrar');
    $('#modalCrud').modal("show");
    $('#clave').prop("disabled", false);
  });

  $(document).on('click', '.boton-editar', function () {
    opcion = 3;
    $('#modalFormUsuario').trigger('reset');
    $('.modal-header').removeClass('bg-primary');
    $('.modal-header').addClass('bg-success');
    $('.modal-title').text('Editar usuario');
    $('#modalBotonSubmit').text('Actualizar');
    $('#modalCrud').modal("show");
    fila = $(this).closest('tr');
    id = parseInt(fila.find('td:eq(0)').text());
    const usuario = fila.find('td:eq(1)').text();
    $('#usuario').val(usuario);
    $('#clave').val('********');
    $('#clave').prop("disabled", true);
  });

  $(document).on('click', '.boton-eliminar', function () {
    const fila = $(this);
    id = parseInt(fila.closest('tr').find('td:eq(0)').text());
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
        const eliminarRegistro = async () => {
          try {
            const res = await axios({
              method: 'DELETE',
              url: endpoint,
              data: {
                id: id
              }
            });
            const data = res.data;
            if (data != null) {
              tablaPersona.row(fila.parents('tr')).remove().draw();
              swalWithBootstrapButtons.fire(
                '¡Eliminad@!',
                'El usuario ha sido eliminad@.',
                'success'
              );
            }
          } catch (error) {
            Swal.fire({
              position: 'center',
              title: '¡Ha ocurrido un error! Contactar con soporte.',
              text: error,
              icon: 'warning',
              confirmButtonText: 'Aceptar',
              showClass: {
                popup: 'animate__animated animate__fadeInDown'
              },
              hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
              }
            });
          }
        }
        eliminarRegistro();
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
    if (usuario == "" || clave == "") {
      Swal.fire({
        icon: 'warning',
        title: 'Debe completar los campos del registro.'
      });
      return false;
    } else if (opcion == 1) {
      http = 'POST';
      consultaAjax(0, usuario, clave, http);
    } else if (opcion == 3) {
      http = 'PUT';
      Swal.fire({
        title: '¿Quieres guardar los cambios?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: `Guardar`,
        denyButtonText: `No guardar`,
        cancelButtonText: `Cancelar`
      }).then((result) => {
        if (result.isConfirmed) {
          consultaAjax(id, usuario, clave, http);
          Swal.fire('¡Guardado!', '', 'success');
        } else if (result.isDenied) {
          Swal.fire('No se guardaron los cambios.', '', 'info');
        }
      });
    }
    $('#modalCrud').modal("hide");
  });

  const consultaAjax = (id, usuario, clave, http) => {
    if (opcion == 1) {
      $.ajax({
        url: endpoint,
        type: http,
        dataType: 'json',
        data: {
          id: id,
          usuario: usuario,
          clave: clave
        },
        success: (data) => {
          if (data != null) {
            const id = data[0].id;
            const usuario = data[0].usuario;
            const descripcion = data[0].descripcion;
            tablaPersona.row.add([id, usuario, descripcion]).draw();
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
    } else if (opcion == 3) {
      const actualizarRegistro = async () => {
        try {
          const res = await axios({
            method: http,
            url: endpoint,
            data: {
              "id": id,
              "usuario": usuario
            }
          });
          const data = res.data;
          if (data != null) {
            const id = data[0].id;
            const usuario = data[0].usuario;
            const descripcion = data[0].descripcion;
            tablaPersona.row(fila).data([id, usuario, descripcion]).draw();
          }
        } catch (error) {
          Swal.fire({
            position: 'center',
            title: '¡Ha ocurrido un error! Contactar con soporte.',
            text: error,
            icon: 'warning',
            confirmButtonText: 'Aceptar',
            showClass: {
              popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
              popup: 'animate__animated animate__fadeOutUp'
            }
          });
        }
      }
      actualizarRegistro();
    }
  }
});