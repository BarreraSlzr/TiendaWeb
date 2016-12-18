<?php
require_once(dirname(__FILE__).'/config.php');
conectarBaseDatos();
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
			<!-- Mensaje de error --->
			<?php include ( ROOT_PATH.'Pagina/mensajeError.php') ?>
			<div class="contenedorDeProductos">
			  <?php    $buscarTodosLosProductos = mysql_query("SELECT * FROM Productos")
			      or die("Consulta fallida: " . mysql_error());
			      mostrarProductos($buscarTodosLosProductos);
			  ?>
			</div>
		</div>
	  <footer id="footer">
			<p>&copy; 2016 <a style="text-decoration:none" href="#">Internet Friends</a></p>
		</footer>
	</body>
	</html>
