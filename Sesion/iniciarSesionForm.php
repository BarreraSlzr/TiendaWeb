<?php
  $error=false;
  if(isset($_POST['iniciarSesion'])){
    conectarBaseDatos();
    //Limpiar variables de caracteres especiales
    $email = removerCaracteresEspeciales($_POST['email']);
    $password = removerCaracteresEspeciales($_POST['password']);

    // Validacion de email
    if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
     	$error = true;
     	$emailError = "Ingresa un correo valido. 'ejemplo@empresa.com.'";
    } else {
     // checa si email ya existe o no
     $resultadoQuery = mysql_query("SELECT email FROM Usuario WHERE email = '$email'")
          or die("Consulta fallida: " . mysql_error());

     	if( mysql_num_rows($resultadoQuery) == 0 ){
      	$error = true;
        $emailError="_________________";
      	$_SESSION['message'] = "El correo electronico que ingresaste no concide con ninguna cuenta</br>
          <a href='/Tienda_Web/Registrarme.php' style='
          text-decoration: none; color: cornflowerblue;'>Registrate para crear un cuenta</a>";
      	$_SESSION['tipoError'] = "Fallo";
     	}
    }
    // Validacion de contraseña
    if (empty($password)){
     	$error = true;
     	$passwordError = "Porfavor, ingresa una contraseña.";
    } else if(strlen($password) < 6) {
     	$error = true;
     	$passwordError = "La contraseña debe ser mayor a 6 caracteres.";
  	}
    if (!$error){
      $password = hash('sha256', $password);

      $resultadoQuery = mysql_query("SELECT * FROM Usuario WHERE email = '$email' AND password = '$password'")
           or die("Consulta fallida: " . mysql_error());

      if ( mysql_num_rows($resultadoQuery) == 0 ) {
        $error=true;
        $_SESSION['tipoError'] = "Fallo";
        $_SESSION['message'] = "Contraseña incorrecta. Vuelva a intentarlo";
      } elseif ( mysql_num_rows($resultadoQuery)!= 1 ) {
        $error=true;
        $_SESSION['tipoError'] = "Fallo";
        $_SESSION['message'] = "Tenemos problema con la base de datos (Al parecer hay dos cuentas iguales)";
      } elseif ( mysql_num_rows($resultadoQuery) == 1 ) {
        $datos=mysql_fetch_array($resultadoQuery);
        $_SESSION['idUsuario'] = $datos['idUsuario'];
        $_SESSION['nombreUsuario'] = $datos['nombre'];
        $_SESSION['apellidosUsuario'] = $datos['apellidos'];
        $_SESSION['emailUsuario']= $datos['email'];
        $_SESSION['tipoError'] = "Exito";
        $_SESSION['message'] = $_SESSION['nombreUsuario'].", haz ingresado exitosamente";
        header("Location: /Tienda_Web/Usuario/Perfil.php");
      } else {
        $_SESSION['tipoError'] = "Fallo";
        $_SESSION['message'] = "No fue posible iniciar sesion. Intentelo de nuevo";
      }
    } else {
      $_SESSION['tipoError'] = "Fallo";
      $_SESSION['message'] = "Favor de ingresar los datos faltantes";
    }
  }

//<!-- Mensaje de error --->
include ( ROOT_PATH.'Pagina/mensajeError.php');
?>

<section class="contenedorIngresarCuenta">
  <article>
    <div>
      <form method="post" action="/Tienda_Web/IniciarSesion.php" class="cajaForm">
        <table>
          <th colspan="2">
            <div id="divForm">
              <h1>Ingresa a tu cuenta</h1>
            </div>
          </th>
          <tr>
            <td class="nombreDatos">
              <div id="divForm">
                Correo Electronico:
              </div>
            </td>
          </tr>
          <tr>
            <?php if (isset($emailError)){?><td><span id="mensajeError"><?php echo $emailError;?></span></td><?php }?>
          </tr>
          <tr>
            <td>
              <div id="divForm">
                <input required type="email" maxlength="128" name="email" placeholder="ejemplo@empresa.com.mx" class="textArea" <?php if (isset($emailError)){ } else { if (isset($email)){?> value="<?php echo $email  ?>" <?php } }?>>
              </div>
            </td>
          </tr>
          <tr>
            <td class="nombreDatos">
              <div id="divForm">
                Contraseña:
              </div>
            </td>
          </tr>
          <tr>
            <?php if (isset($passwordError)){?><td><span id="mensajeError">* <?php echo $passwordError;?></span></td><?php }?>
          </tr>
          <tr>
            <td>
              <div id="divForm">
                <input required type="password" maxlength="32" name="password" placeholder="Debe contener minimo 6 caracteres" class="textArea">
              </div>
            </td>
          </tr>
          <tr>
          <tr>
            <td>
              <div id="divForm">
                <input type="submit" name="iniciarSesion" value="Inciar Sesion" class="botonForm">
              </div>
            </td>
          </tr>
        </table>
      </form>
    </div>
  </article>
</section>

<section class="contenedorIngresarCuenta">
  <article>
    <div>
      <!-- Opcion para inciar sesion -->
      <table>
      <tr>
        <td class="nombreDatos">
          <div id="divForm" style="display: block; text-align: center;">
            ¿Aun no tienes cuenta?
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div id="divForm">
            <a href="Registrarme.php" style="width: 100%; padding: 0 1em 0 0;">
              <input  type="submit" name="registrarUsuario" value="Registrarme" class="botonForm"></a>
          </div>
        </td>
      </tr>
      </table>

    </div>
  </article>
</section>
