<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD B DT jQ PHP I</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="./css/index.css">
  <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
</head>

<body class="body">

  <?php
  // Read
  require_once "../backend/models/conexion.php";
  $conexion = new Conexion();
  $conectar = $conexion->Conectar();

  $consulta = "SELECT usu.id, usu.usuario, usu.celular, usu.ubicacion, rol.descripcion FROM usuario usu INNER JOIN rol rol ON usu.idRol = rol.id;";

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
    <h3 class="text-center text-light py-2">
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
          <button type="button" name="button" class="btn btn-primary col-12 fw-bold" id="botonAgregarUsuario" data-bs-toggle="modal" data-bs-target="#modalCrud">Agregar usuario</button>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablaPersona">
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

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalCrud" tabindex="-1" aria-labelledby="modalCrudLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-primary bg-gradient text-light">
            <h5 class="modal-title" id="modalCrudLabel">Modal title</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="modalFormUsuario" class="form">
            <div class="modal-body">
              <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <!-- <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuario" required> -->
                <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
              </div>
              <div class="mb-3">
                <label for="clave" class="form-label">Clave</label>
                <!-- <input type="password" name="clave" id="clave" class="form-control" placeholder="Clave" required> -->
                <input type="password" name="clave" id="clave" class="form-control" placeholder="Clave">
              </div>
              <div class="mb-3">
                <label for="celular" class="form-label">Celular</label>
                <!-- <input type="number" name="celular" id="celular" class="form-control" placeholder="Celular" required> -->
                <!-- <input type="number" name="celular" id="celular" class="form-control" placeholder="Celular" min="900000000" max="999999999" title="Ingresar un número de 9 dígitos."> -->
                <input type="text" name="celular" id="celular" class="form-control" placeholder="Celular" pattern="9[0-9]{8}" maxlength="9" title="Ingresar un número válido de 9 dígitos.">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary" id="modalBotonSubmit"></button>
            </div>
        </div>
      </div>
    </div>

  </main>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="./js/index.js"></script>
</body>

</html>