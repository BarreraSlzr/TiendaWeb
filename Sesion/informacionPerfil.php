<?php
$error=false;

if (isset($_SESSION['idUsuario'])) {
  conectarBaseDatos();
  //Comienza POST para subir datos a BD
  if (isset($_POST['completarInformacion'])){

    if (isset($_SESSION['idinfoUsuario'])) {
      //POST para agregar tarjeta

      if (strlen($_POST['tarjetaUsuario'])!=16) {
        $error=true;
        $tarjetaError="Numero de tarjeta incorrecto";
      }
      $resultado = mysql_query("SELECT * FROM tarjetasUsuario WHERE numeroTarjeta=".$_POST['tarjetaUsuario']." AND idUsuario=".$_SESSION['idUsuario']."")
           or die("Consulta fallida: " . mysql_error());
    	if( mysql_num_rows($resultado) !=0){
       	$error = true;
       	$tarjetaError = "Ya has agregado esta tarjeta";
    	}

      //Subir informacion sin errores a BD
      if (!$error){
        $resultadoQuery = mysql_query("INSERT INTO tarjetasUsuario(idUsuario,tipoTarjeta,numeroTarjeta,numeroSeguridadTarjeta,mesVigencia,anoVigencia)
        VALUES(".$_SESSION['idUsuario'].",".$_POST['tipoTarjetaUsuario'].",".$_POST['tarjetaUsuario'].", ".$_POST['seguridadTarjetaUsuario'].",".$_POST['mesTarjetaUsuario'].",".$_POST['anoTarjetaUsuario'].")")
        or die("Consulta fallida: " . mysql_error());
        $_SESSION['message']="Has agregado una nueva tarjeta correctamente";
        $_SESSION['tipoError']="Exito";
        unset($_POST);
      }else {

      $_SESSION['message']="Error al agregar una nueva tarjeta";
      $_SESSION['tipoError']="Fallo";
      }
    }//Termina agregar tarjeta
    else {
      //POST para Informacion de Usuario

      ///Limpiar datos para enviar a BD
      $idUsuario = removerCaracteresEspeciales($_SESSION['idUsuario']);
      $direccionUsuario = removerCaracteresEspeciales($_POST['direccion']);
      $codigoPostalUsuario = removerCaracteresEspeciales($_POST['codigoPostal']);
      $telefonoUsuario = removerCaracteresEspeciales($_POST['telefono']);
      $municipioUsuario = removerCaracteresEspeciales($_POST['municipio']);
      $estadoUsuario = removerCaracteresEspeciales($_POST['estado']);
      $paisUsuario = removerCaracteresEspeciales($_POST['pais']);

      $patternTelefono = "/^\+(?:\(([[:digit:]]){2,3}\))(?:(\s[[:digit:]]){0,1})(?:(\s)[[:digit:]][[:digit:]]){1}(?:(\s)([[:digit:]]){4}){2}$/";
      if (preg_match($patternTelefono, $telefonoUsuario)!=1) {
        $error=true;
        $telefonoError="Escribe correctamente tu telefono.</br>Ejemplo: +(LADA) 9 99 9999 9999";
      }
      if(!$error){//Subir informacion sin errores a BD
        $resultadoQuery = mysql_query("INSERT INTO infoUsuario(idinfoUsuario,direccion,municipio,estado,pais,codigoPostal,telefono)
          VALUES('$idUsuario', '$direccionUsuario','$municipioUsuario','$estadoUsuario','$paisUsuario','$codigoPostalUsuario','$telefonoUsuario')")
          or die("Consulta fallida: " . mysql_error());
        $_SESSION['direccionUsuario']=$direccionUsuario;
        $_SESSION['codigoPostalUsuario']=$codigoPostalUsuario;
        $_SESSION['telefonoUsuario']=$telefonoUsuario;
        $_SESSION['municipioUsuario']=$municipioUsuario;
        $_SESSION['estadoUsuario']=$estadoUsuario;
        $_SESSION['paisUsuario']=$paisUsuario;

        $_SESSION['message']="Has completado tu informacion correctamente";
        $_SESSION['tipoError']="Exito";
      }
    }
  }//Termina POST
}else {
  $_SESSION['message']="Es necesario inciar sesion para ingresar a tu perfil";
  $_SESSION['tipoError']="Fallo";
  header("Location: /Tienda_Web/IniciarSesion.php");
}
//<!-- Mensaje de error --->
include ( ROOT_PATH.'Pagina/mensajeError.php');
?>
<section id="contenedorPrincipal" class="contenedorIngresarCuenta">
  <div id="cuentaTitulos"><h2>Mi Cuenta</h2></div>
  <section id="contenedorPrincipal" class="contenedorIngresarCuenta">
    <div id="cuentaTitulos"><h2>Datos Generales</h2></div>
    <div class="contenedorDatos">
      <article class="datos">
        <div id="divForm">
          Nombre:
        </div>
        <div id="divForm">
          <?php
          if (isset($_SESSION['nombreUsuario'])!="") {
            echo $_SESSION['nombreUsuario'];
          }
          ?>
        </div>
      </article>
      <article class="datos">
        <div id="divForm">
          Apellidos:
        </div>
        <div id="divForm">
          <?php
          if (isset($_SESSION['apellidosUsuario'])!="") {
          echo $_SESSION['apellidosUsuario'];
          }
          ?>
        </div>
      </article>
    </div>
    <div class="contenedorDatos">

      <article class="datos">
        <div id="divForm">
          Correo Electronico:
        </div>
        <div id="divForm">
          <?php
          if (isset($_SESSION['emailUsuario'])!="") {
          echo $_SESSION['emailUsuario'];
          }
          ?>
        </div>
      </article>
    </div>
  </section>
  <?php
    include(ROOT_PATH.'Sesion/datosContactoForm.php');
    include(ROOT_PATH.'Sesion/tarjetasForm.php');
  ?>
