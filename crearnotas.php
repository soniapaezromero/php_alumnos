<?php

include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'La nota ' . escapar($_POST['asignatura']) . ' ha sido agregada con éxito'
  ];

  $config = include 'config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $calificacion = [
      "asignatura"   => $_POST['asignatura'],
      "nota" => $_POST['nota'],
      "observaciones"    => $_POST['observaciones'],
    ];

    $consultaSQL = "INSERT INTO notas (asignatura, nota, observaciones)";
    $consultaSQL .= "values (:" . implode(", :", array_keys($calificacion)) . ")";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($calificacion);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}
?>

<?php include 'templates/header.php'; ?>

<?php
if (isset($resultado)) {
  ?>
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-4">Crea una nota</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="asignatura">Asignatura</label>
          <input type="text" name="asignatura" id="asignatura" class="form-control">
        </div>
        <div class="form-group">
          <label for="nota">Nota</label>
          <input type="text" name="nota" id="nota" class="form-control">
        </div>
        <div class="form-group">
          <label for="observaciones">Observaciones</label>
          <input type="text" name="observaciones" id="observaciones" class="form-control">
        </div>
        <div class="form-group">
          <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href="indexnotas.php">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'templates/footer.php'; ?>
