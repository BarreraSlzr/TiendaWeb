
<?php
require_once('../config.php');
conectarBaseDatos();
if (isset($_GET['id'])) {
  $queryProducto=mysql_query("SELECT * FROM Productos WHERE idProducto=".$_GET['id']." LIMIT 1")
      or die("Consulta fallida: " . mysql_error());
?>

	<!DOCTYPE html>
	<html lang="es">
	<head>
	  <title>Internet friends - Tienda en Linea</title>
	  <meta charset="UTF-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	  <meta http-equiv="X-UA-Compatible" content="ie=edge">
	  <title>Document</title>
	  <link rel="stylesheet" href="../style.css">
	</head>
	<body>
		<div class="pagina">
			<!-- Comienza Header -->
			<?php include ( ROOT_PATH.'Pagina/header.php') ?>
			<!-- Mensaje de error --->
			<?php include ( ROOT_PATH.'Pagina/mensajeError.php') ?>
			<div class="contenedorDeProductos">
		  <?php mostrarProductos($queryProducto);?>
			</div>
		</div>
	  <footer id="footer">
			<p>&copy; 2016 <a style="text-decoration:none" href="#">Internet Friends</a></p>
		</footer>
	</body>
	</html>
<?php }else {
  $_SESSION['message']="Poducto buscado no se encuetra";
  $_SESSION['message']="Fallo";
  header("/Tienda_Web/Tienda.php");
}
  ?>
