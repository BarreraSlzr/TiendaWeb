<?php
include_once('../config.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <title>Internet friends - Tienda en Linea</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="/Tienda_Web/style.css">
</head>
<body>
	<div class="pagina">
		<!-- Comienza Header -->
		<?php
    include ( ROOT_PATH.'Pagina/header.php');
    include ( ROOT_PATH.'Sesion/informacionPerfil.php')
    ?>
	</div>

  <!-- Footer -->
  <footer id="footer">
    <p>&copy; 2016 <a style="text-decoration:none" href="#">Internet Friends</a></p>
  </footer>
</body>
</html>
