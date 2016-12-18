<?php
if ($_GET['modificar']) {
  extract($_GET);
  include_once('../config.php');
  conectarBaseDatos();
  $datosEncontrados=mysql_query("DELETE infoUsuario FROM infoUsuario WHERE idInfoUsuario=".$modificar." AND idInfoUsuario=".$_SESSION['idUsuario']."")
  or die (mysql_error());
  header("Location: ../Usuario/Perfil.php");
}
?>
