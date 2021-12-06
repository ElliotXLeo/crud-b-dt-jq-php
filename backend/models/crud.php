<?php
require_once "./conexion.php";
$conexion = new Conexion();
$conectar = $conexion->Conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Create
  if (isset($_POST["usuario"]) && isset($_POST["clave"])) {
    if (!empty($_POST["usuario"]) && !empty($_POST["clave"])) {
      try {
        // Agregar
        $usuario = $_POST["usuario"];
        $clave = md5($_POST["clave"]);
        $consulta = "INSERT INTO `usuarios` (`id`, `usuario`, `clave`, `id_rol`) VALUES (NULL, '$usuario', '$clave', '2');";
        $resultado = $conectar->prepare($consulta);
        $resultado->execute();

        // Seleccionar último agregado
        $consulta = "SELECT usu.id, usu.usuario, rol.descripcion FROM usuarios usu INNER JOIN roles rol ON usu.id_rol = rol.id ORDER BY usu.id DESC LIMIT 1;";
        $resultado = $conectar->prepare($consulta);
        $resultado->execute();
      } catch (Exception $e) {
        // die("Error: " . $e->getMessage());
        $data = null;
      }
    }
  }
  // Read
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
  try {
    // Leer
    $consulta = "SELECT usu.id, usu.usuario, rol.descripcion FROM usuarios usu INNER JOIN roles rol ON usu.id_rol = rol.id;";
    $resultado = $conectar->prepare($consulta);
    $resultado->execute();
  } catch (Exception $e) {
    // die("Error: " . $e->getMessage());
    $data = null;
  }
  // Update
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
  $data = json_decode(file_get_contents('php://input'));
  if (isset($data->id) && isset($data->usuario)) {
    if (!empty($data->id) && !empty($data->usuario)) {
      try {
        // Actualizar
        $id = $data->id;
        $usuario = $data->usuario;
        $consulta = "UPDATE `usuarios` SET `usuario` = '$usuario' WHERE `usuarios`.`id` = $id;";
        $resultado = $conectar->prepare($consulta);
        $resultado->execute();

        // Seleccionar el registro actualizado
        $consulta = "SELECT usu.id, usu.usuario, rol.descripcion FROM usuarios usu INNER JOIN roles rol ON usu.id_rol = rol.id WHERE usu.id = $id;";
        $resultado = $conectar->prepare($consulta);
        $resultado->execute();
      } catch (Exception $e) {
        // die("Error: " . $e->getMessage());
        $data = null;
      }
    }
  }
  // Delete
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
  $data = json_decode(file_get_contents('php://input'));
  if (isset($data->id) && !empty($data->id)) {
    // Eliminar
    try {
      $id = $data->id;
      $consulta = "DELETE FROM `usuarios` WHERE `usuarios`.`id` = $id;";
      $resultado = $conectar->prepare($consulta);
      $resultado->execute();
    } catch (Exception $e) {
      // die("Error: " . $e->getMessage());
      $data = null;
    }
  }
}

// Validar que se realizó de forma correcta la consulta
if (isset($resultado)) {
  if ($resultado->rowCount() >= 1) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
  } else {
    $data = null;
  }
} else {
  $data = null;
}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conectar = null;
