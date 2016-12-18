<?php
  $error=false;

  if(isset($_POST['registrarUsuario'])){

    conectarBaseDatos();

    //Limpiar variables de caracteres especiales
    $nombre = removerCaracteresEspeciales($_POST['nombre']);
    $apellidos = removerCaracteresEspeciales($_POST['apellidos']);
    $email = removerCaracteresEspeciales($_POST['email']);
    $password = removerCaracteresEspeciales($_POST['password']);
    $password2 = removerCaracteresEspeciales($_POST['password2']);

    // Validacion de nombre
    if (!preg_match("/^[a-zA-Z ]+$/",$nombre)) {
     	$error = true;
     	$nombreError = "No se admiten nombres con caracteres especiales. Intentalo de nuevo.";
    }
   if (!preg_match("/^[a-zA-Z ]+$/",$apellidos)) {
     	$error = true;
     	$apellidosError = "No se admiten apellidos con caracteres especiales. Intentalo de nuevo.";
    }

    // Validacion de email
    if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
     	$error = true;
     	$emailError = "Ingresa un correo valido. 'ejemplo@empresa.com.'";
    } else {
     // checa si email ya existe o no
     $resultado = mysql_query("SELECT email FROM Usuario WHERE email='$email'")
          or die("Consulta fallida: " . mysql_error());

     	if( mysql_num_rows($resultado) !=0){
      	$error = true;
      	$emailError = "Este correo ya a sido utilizado.";
     	}
    }
    // Validacion de contraseña
    if(strlen($password) < 6) {
     	$error = true;
     	$passwordError = "La contraseña debe ser mayor a 6 caracteres.";
  	} else if($password != $password2) {
  		$error = true;
  		$password2Error = "Las contraseñas no coinciden.";
  	}

    // Si no hay error continuar con el registro
    if( !$error ) {

  	  // Encripacion de password usando SHA256();
  	  $password = hash('sha256', $password);

      $resultadoQuery = mysql_query("INSERT INTO Usuario(nombre,apellidos,email,password) VALUES('$nombre', '$apellidos','$email','$password')");

      if ($resultadoQuery){
      	$_SESSION['tipoError'] = "Exito";
      	$_SESSION['message'] = $_SESSION['nombreUsuario'].", te haz registrado exitosamente";
        $_SESSION['nombreUsuario']=$nombre;
        $_SESSION['apellidosUsuario']=$apellidos;
        $_SESSION['emailUsuario']=$email;
        header("Location: /Tienda_Web/IniciarSesion.php");
     	} else {
      	$_SESSION['tipoError'] = "Fallo";
      	$_SESSION['message'] = "No fue posible la creacion de su cuenta. Intentelo de nuevo";
      }
    }else {
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
      <!-- Formulario de registro -->
      <form method="post" action="/Tienda_Web/Registrarme.php" class="cajaForm">
        <table>
          <th colspan="2">
            <div id="divForm">
              <h1>Registrar nueva cuenta</h1>
            </div>
          </th>
          <tr>
            <td class="nombreDatos">
              <div id="divForm">
                Nombre:
              </div>
            </td>
          </tr>
          <tr>
            <?php if (isset($nombreError)){?><td><span id="mensajeError">* <?php echo $nombreError;?></span></td><?php }?>
          </tr>
          <tr>
            <td>
              <div id="divForm">
                <input required type="text" maxlength="20" name="nombre" class="textArea" autofocus <?php if (isset($nombreError)){ } else { if (isset( $nombre )) { ?> value=" <?php echo $nombre ?>"<?php } } ?>>
              </div>
            </td>
          </tr>
          <tr>
            <td class="nombreDatos">
              <div id="divForm">
                Apellidos:
              </div>
            </td>
          </tr>
          <tr>
            <?php if (isset($apellidosError)){?><td><span id="mensajeError">* <?php echo $apellidosError;?></span></td><?php }?>
          </tr>
          <tr>
            <td>
              <div id="divForm">
                <input required type="text" maxlength="100" name="apellidos" class="textArea" <?php if (isset($apellidosError)){}else{if (isset($apellidos)){?> value="<?php echo $apellidos ?>" <?php }} ?>>
              </div>
            </td>
          </tr>
          <tr>
            <td class="nombreDatos">
              <div id="divForm">
                Correo Electronico:
              </div>
            </td>
          </tr>
          <tr>
            <?php if (isset($emailError)){?><td><span id="mensajeError">* <?php echo $emailError;?></span></td><?php }?>
          </tr>
          <tr>
            <td>
              <div id="divForm">
                <input required type="email" maxlength="128" name="email" placeholder="ejemplo@empresa.com.mx" class="textArea" <?php if (isset($emailError)){}else{if (isset($email)){?> value="<?php echo $email  ?>" <?php }} ?>>
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
                <input required type="password" maxlength="32" name="password" placeholder="La contraseña debe ser mayor a 6 caracteres." class="textArea">
              </div>
            </td>
          </tr>
          <tr>
            <td class="nombreDatos">
              <div id="divForm">
                Confirma Contraseña:
              </div>
            </td>
          </tr>
          <tr>
            <?php if (isset($password2Error)){?><td><span id="mensajeError">* <?php echo $password2Error;?></span></td><?php }?>
          </tr>
          <tr>
            <td>
              <div id="divForm">
                <input required type="password" maxlength="32" name="password2" class="textArea">
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div id="divForm">
                <input type="submit" name="registrarUsuario" value="Crear cuenta" class="botonForm">
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
              ¿Ya tienes cuenta?
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div id="divForm">
              <a href="/Tienda_Web/IniciarSesion.php" style="width: 100%; padding: 0 1em 0 0;">
                <input type="submit" name="registrarUsuario" value="Iniciar Sesion" class="botonForm"></a>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </article>
</section>
