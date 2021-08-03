<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD B DT jQ PHP I</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="./css/index.css">
</head>

<body class="body">

  <?php
  require_once "../backend/base-de-datos/conexion.php";
  $conexion = new Conexion();
  $conectar = $conexion->Conectar();

  $consulta = "SELECT usu.id, usu.usuario, usu.celular, usu.ubicacion, rol.descripcion FROM usuario usu INNER JOIN rol rol ON usu.idRol = rol.id;";
  // $consulta = "SELECT usu.id, usu.usuario, usu.celular, usu.ubicacion, rol.descripcion FROM usuario usu INNER JOIN rol rol ON usu.idRol = rol.id WHERE usu.id=4;";

  $resultado = $conectar->prepare($consulta);
  $resultado->execute();

  if ($resultado->rowCount() >= 1) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
  } else {
    $data = null;
  }
  $conectar = null;
  ?>
  <header class="header">
    <h3 class="text-center text-light">
      <span class="badge rounded-pill bg-light text-dark">CRUD</span>
      <span class="badge rounded-pill bg-danger">B</span>
      <span class="badge rounded-pill bg-primary">DataTables</span>
      <span class="badge rounded-pill bg-warning text-dark">jQuery</span>
      <span class="badge rounded-pill bg-secondary">PHP</span>
      <span class="badge rounded-pill bg-success">I</span>
    </h3>
  </header>

  <main class="main">

    <div class="container">
      <div class="row">
        <div class="col-lg-12 my-4">
          <button type="button" name="button" class="btn btn-dark col-12 boton-letra" id="botonAgregarUsuario" data-bs-toggle="modal">Agregar usuario</button>
        </div>
      </div>
    </div>


    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="table-responsive">
            <table class="table table-striped table-dark table-hover" id="tablaPersona">
              <thead class="text-center">
                <tr>
                  <th>Id</th>
                  <th>Usuario</th>
                  <th>Celular</th>
                  <th>Ubicación</th>
                  <th>Rol</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (!is_null($data)) {
                  foreach ($data as $d) {
                    echo '
                      <tr>
                        <td>' . $d['id'] . '</td>
                        <td>' . $d['usuario'] . '</td>
                        <td>' . $d['celular'] . '</td>
                        <td>' . $d['ubicacion'] . '</td>
                        <td>' . $d['descripcion'] . '</td>
                        <td>
                          
                        </td>
                      </tr>
                    ';
                  }
                }
                ?>
                <!-- <div class="text-center">
                  <div class="btn-group">
                    <button class="btn btn-primary btnEditar btn-sm boton-letra">Editar</button>
                    <button class="btn btn-danger btnEditar btn-sm boton-letra">Eliminar</button>
                  </div>
                </div> -->

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalCrud" tabindex="-1" aria-labelledby="modalCrudLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalCrudLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="" method="post" id="formRegistroUsuario" class="form">
              <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuario" required>
              </div>
              <div class="mb-3">
                <label for="clave" class="form-label">Clave</label>
                <input type="password" name="clave" id="clave" class="form-control" placeholder="Clave" required>
              </div>
              <div class="mb-3">
                <label for="celular" class="form-label">Celular</label>
                <input type="number" name="celular" id="celular" class="form-control" placeholder="Celular" required>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-dark">Registrar</button>
          </div>
        </div>
      </div>
    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="./js/index.js"></script>
</body>

</html>