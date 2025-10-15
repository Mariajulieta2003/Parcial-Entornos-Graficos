<?php
// Inicio de la sesion
session_start();

// Formulario con campos username y password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

// Conexión a la base de datos
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die('Error de conexión: ' . $conn->connect_error);
}
// Validar credenciales contra la tabla usuarios mediante consulta SQL
$stmt = $conn->prepare('SELECT id, password FROM usuarios WHERE username = ?');
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->store_result();

// Verifica si existe el usuario en la base de datos
if ($stmt->num_rows === 1) {
  $stmt->bind_result($id_usuario, $hash_password);
  $stmt->fetch();
  
// Guardar id del usuario en variable de sesión
if (password_verify($password, $hash_password)) {
    $_SESSION['id_usuario'] = $id_usuario;

    // Guardar cookie con el nombre del usuario por 7 días
    setcookie('ultimo_usuario', $username, time() + (7 * 24 * 60 * 60), "/");
    // Redirigir a la página de productos
    header('Location: productos.php');
    exit;
  } else {
    $error = "Contraseña incorrecta.";
  }
  } else {
  $error = "Usuario no encontrado.";
  }
// Precompletar el username si existe cookie
$username_cookie = isset($_COOKIE['ultimo_usuario']) ? $_COOKIE['ultimo_usuario'] : '';
$stmt->close();
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title> Login </title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <h2> Iniciar sesión </h2>
  <form method="post" action="">
    <label for="username">Usuario:</label>
    <input type="text" name="username" id="username" required>
    
    <label for="password">Contraseña:</label>
    <input type="password" name="password" id="password" required>
    
    <button type="submit">Ingresar</button>
  </form>
</body>
</html>

