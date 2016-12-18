<?php
  include_once('../config.php');
  conectarBaseDatos();
  if (isset($_GET['index'])) {
    $_GET['index']=mysql_real_escape_string($_GET['index']);
    $query="DELETE FROM `tarjetasUsuario` WHERE idTarjeta = ".$_GET['index']." AND idUsuario = ".$_GET['idUsuario']."";
    mysql_query($query) or die("Consulta fallida: " . mysql_error());
  }
  header("location: ../Usuario/Perfil.php");
?>
