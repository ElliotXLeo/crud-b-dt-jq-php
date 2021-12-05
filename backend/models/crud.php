<?php
require_once "./conexion.php";
$conexion = new Conexion();
$conectar = $conexion->Conectar();

if (isset($_POST["opcion"]) && !empty($_POST["opcion"])) {
  $opcion = $_POST["opcion"];
  // Create (Crear)
  if ($opcion == 1) {
    if (isset($_POST["usuario"]) && isset($_POST["clave"]) && isset($_POST["celular"])) {
      if (!empty($_POST["usuario"]) && !empty($_POST["clave"]) && !empty($_POST["celular"])) {
        try {
          // Agregar
          $usuario = $_POST["usuario"];
          $clave = md5($_POST["clave"]);
          $celular = $_POST["celular"];
          $consulta = "INSERT INTO `usuario` (`id`, `usuario`, `clave`, `celular`, `ubicacion`, `idRol`) VALUES (NULL, '$usuario', '$clave', '$celular', '@-12.0671257,-77.0358376,21z', '2');";
          $resultado = $conectar->prepare($consulta);
          $resultado->execute();

          // Seleccionar último agregado
          $consulta = "SELECT usu.id, usu.usuario, usu.celular, usu.ubicacion, rol.descripcion FROM usuario usu INNER JOIN rol rol ON usu.idRol = rol.id ORDER BY usu.id DESC LIMIT 1;";
          $resultado = $conectar->prepare($consulta);
          $resultado->execute();
        } catch (Exception $e) {
          // die("Error: " . $e->getMessage());
          $data = null;
        }
      }
    }
    // Update
  } elseif ($opcion == 2) {
    if (isset($_POST["id"]) && isset($_POST["usuario"]) && isset($_POST["clave"]) && isset($_POST["celular"])) {
      if (!empty($_POST["id"]) && !empty($_POST["usuario"]) && !empty($_POST["clave"]) && !empty($_POST["celular"])) {
        try {
          // Actualizar
          $id = $_POST["id"];
          $usuario = $_POST["usuario"];
          $clave = md5($_POST["clave"]);
          $celular = $_POST["celular"];
          // $consulta = "UPDATE `usuario` SET `usuario` = '$usuario', `clave` = '$clave', `celular` = '$celular' WHERE `usuario`.`id` = $id;";
          $consulta = "UPDATE `usuario` SET `usuario` = '$usuario', `celular` = '$celular' WHERE `usuario`.`id` = $id;";
          $resultado = $conectar->prepare($consulta);
          $resultado->execute();

          // Seleccionar el registro actualizado
          $consulta = "SELECT usu.id, usu.usuario, usu.celular, usu.ubicacion, rol.descripcion FROM usuario usu INNER JOIN rol rol ON usu.idRol = rol.id WHERE usu.id = $id;";
          $resultado = $conectar->prepare($consulta);
          $resultado->execute();
        } catch (Exception $e) {
          // die("Error: " . $e->getMessage());
          $data = null;
        }
      }
    }
    // Delete
  } elseif ($opcion == 3) {
    if (isset($_POST["id"]) && !empty($_POST["id"])) {
      // Eliminar
      try {
        $id = $_POST["id"];
        $consulta = "DELETE FROM `usuario` WHERE `usuario`.`id` = $id;";
        $resultado = $conectar->prepare($consulta);
        $resultado->execute();
      } catch (Exception $e) {
        // die("Error: " . $e->getMessage());
        $data = null;
      }
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
