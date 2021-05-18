<?php
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$error = false;
$config = include 'config.php';

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  if (isset($_POST['asignatura'])) {
    $consultaSQL = "SELECT * FROM notas WHERE asignatura LIKE '%" . $_POST['asignatura'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM notas";
  }

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $notas = $sentencia->fetchAll();

} catch(PDOException $error) {
  $error= $error->getMessage();
}

$titulo = isset($_POST['asignatura']) ? 'Lista de notas (' . $_POST['asignatura'] . ')' : 'Lista de notas';
?>

<?php include "templates/header.php"; ?>

<?php
if ($error) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $error ?>
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
      <a href="crearnotas.php"  class="btn btn-primary mt-4">Crear nota</a>
      <hr>
      <form method="post" class="form-inline">
        <div class="form-group mr-3">
          <input type="text" id="asignatura" name="asignatura" placeholder="Buscar por asignatura" class="form-control">
        </div>
        <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
        <button type="submit" name="submit" class="btn btn-primary">Ver resultados</button>
        <hr>
        <div class="form-group">
          <a class="btn btn-primary" href="index.php">Regresar alumno</a>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-3"><?= $titulo ?></h2>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Asignatura</th>
            <th>Notas</th>
            <th>Observaciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($notas && $sentencia->rowCount() > 0) {
            foreach ($notas as $fila) {
              ?>
              <tr>
                <td><?php echo escapar($fila["id"]); ?></td>
                <td><?php echo escapar($fila["asignatura"]); ?></td>
                <td><?php echo escapar($fila["nota"]); ?></td>
                <td><?php echo escapar($fila["observaciones"]); ?></td>
                <td>
                  <a href="<?= 'borrarnotas.php?id=' . escapar($fila["id"]) ?>">🗑️Borrar</a>
                  <a href="<?= 'editarnotas.php?id=' . escapar($fila["id"]) ?>">✏️Editar</a>
                </td>
              </tr>
              <?php
            }
          }
          ?>
        <tbody>
      </table>
    </div>
  </div>
</div>

<?php include "templates/footer.php"; ?>
