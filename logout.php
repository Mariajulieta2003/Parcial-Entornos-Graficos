<?php
//Destruir la sesion activa y redirigir al login

session_start();
session_destroy();
header("Location: login.php");
exit();

?>