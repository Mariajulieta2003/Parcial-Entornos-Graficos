<?php
// Iniciar sesión
session_start();

// Verificar que haya sesión activa, sino redirigir al login
if (!isset($_SESSION['id_usuario'])) {
  header('Location: login.php');
  exit;
}
// Realizar consulta SQL para mostrar todos los productos en una tabla HTML
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die('Error de conexión: ' . $conn->connect_error);
}

// Consulta para obtener los productos
$sql = "SELECT id, nombre, precio FROM productos";
$resultado = $conn->query($sql);

// Incluir boton/link para cerrar sesion
echo "<br><a href='cerrar_sesion.php'>Cerrar sesión</a>";

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title> Listado de Productos</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h2> Lista de productos</h2>

  <?php if ($resultado && $resultado->num_rows > 0): ?>

    <table border="1" cellpadding="8" cellspacing="0">
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Precio</th>
      </tr>
      <?php while ($fila = $resultado->fetch_assoc()): ?>
        <tr>
          <td><?php echo htmlspecialchars($fila['id']); ?></td>
          <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
          <td><?php echo htmlspecialchars($fila['precio']); ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php else: ?>

    <p>No hay productos disponibles.</p>
  <?php endif; ?>

  <a href="cerrar_sesion.php">Cerrar sesión</a>
</body>
</html>