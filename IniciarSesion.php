<?php

include_once(dirname(__FILE__).'/config.php');
if (isset($_SESSION['idUsuario']) != "") {
	$_SESSION['message'] = "Ya haz iniciado sesion";
	$_SESSION['tipoError'] = "Exito";
	header("Location: /Tienda_Web/Tienda.php");
}

$error=false;
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <title>Internet friends - Tienda en Linea</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="pagina">
		<!-- Comienza Header -->
		<?php include ( ROOT_PATH.'Pagina/header.php') ?>
		<!-- Formulario de registro -->
		<?php include(ROOT_PATH.'Sesion/iniciarSesionForm.php') ?>
	</div>
	<footer id="footer">
		<p>&copy; 2016 <a style="text-decoration:none" href="#">Internet Friends</a></p>
	</footer>
</body>
</html>
