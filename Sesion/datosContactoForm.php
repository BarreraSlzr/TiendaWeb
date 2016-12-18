<section id="contenedorPrincipal" class="contenedorIngresarCuenta">
    <div class="contenedorDatos">
    <article class="datos"><h2>Datos de Contacto</h2></article>
    <?php $datosContactoEncontrados = mysql_query("SELECT * FROM infoUsuario WHERE idinfoUsuario=".$_SESSION['idUsuario']."")
      or die("Consulta fallida: " . mysql_error());

          //Descarga datos asociados a la cuenta
          $datos=mysql_fetch_array($datosContactoEncontrados);
          $_SESSION['idinfoUsuario']=$datos['idinfoUsuario'];
          $_SESSION['direccionUsuario']=$datos['direccion'];
          $_SESSION['codigoPostalUsuario']=$datos['codigoPostal'];
          $_SESSION['telefonoUsuario']=$datos['telefono'];
          $_SESSION['municipioUsuario']=$datos['municipio'];
          $_SESSION['estadoUsuario']=$datos['estado'];
          $_SESSION['paisUsuario']=$datos['pais'];
    if (mysql_num_rows($datosContactoEncontrados)>0){ ?>
      <article id="editarBoton">
        <a href ="../Sesion/modificarDatos.php?modificar=<?php echo $_SESSION['idinfoUsuario']?>" onclick="return confirm ('¿Seguro que deseas modificar tus datos de contacto?')"><button> Modificar </button></a>
      </article>
      </div>

    <?php }else {
        ?>
      </div>
      <form method="post" action="/Tienda_Web/Usuario/Perfil.php" class="cajaForm">
        <?php } ?>
        <div class="contenedorDatos">
          <article class="datos">
            <div id="divForm">
              Direccion:
            </div>
            <div id="divForm">
              <?php
              if (isset($_SESSION['direccionUsuario'])!="") {
              echo $_SESSION['direccionUsuario'];
              }else {
                ?>
                <input required type="text" name="direccion" class="textArea" value="<?php if(isset($_POST['direccion'])) echo $_POST['direccion']?>">
                <?
              }
              ?>
            </div>
            <?php if (isset($direccionError)){?><div id="divForm"><span id="mensajeError"><?php echo $direccionError;?></span></div><?php }?>
          </article>
          <article class="datos">
            <div id="divForm">
              Codigo Postal:
            </div>
            <div id="divForm">
              <?php
              if (isset($_SESSION['codigoPostalUsuario'])!="") {
              echo $_SESSION['codigoPostalUsuario'];
              }else {
                ?>
                <input required type="number" min="10000" max="99999" name="codigoPostal" class="textArea" value="<?php if(isset($_POST['codigoPostal'])) echo $_POST['codigoPostal']?>">
                <?
              }
              ?>
            </div>
            <?php if (isset($codigoPostalError)){?><div id="divForm"><span id="mensajeError"><?php echo $codigoPostalError;?></span></div><?php }?>
          </article>
          <article class="datos">
            <div id="divForm">
              Telefono:
            </div>
            <div id="divForm">
              <?php
              if (isset($_SESSION['telefonoUsuario'])!="") {
              echo $_SESSION['telefonoUsuario'];
              }else {
                $patternTelefono = "/^\+(?:\(([[:digit:]]){2,3}\))(?:(\s[[:digit:]]){0,1})(?:(\s)[[:digit:]][[:digit:]]){1}(?:(\s)([[:digit:]]){4}){2}$/";
              ?>
                <input required type='tel' pattern='<?php echo $patternTelefono?>'
                  title='Formato de telefono valido: "+(LADA) 9 99 9999 9999"' name="telefono" class="textArea" value="<?php if(isset($_POST['telefono'])) echo $_POST['telefono']?>">
                <? } ?>
            </div>
            <?php if (isset($telefonoError)){?><div id="divForm"><span id="mensajeError"><?php echo $telefonoError;?></span></div><?php }?>
          </article>
        </div>
        <div class="contenedorDatos">
          <article class="datos">
            <div id="divForm">
              Municipio:
            </div>
            <div id="divForm">
              <?php
              if (isset($_SESSION['municipioUsuario'])!="") {
              echo $_SESSION['municipioUsuario'];
              }else {
                ?>
                <input required type="text" name="municipio" class="textArea" value="<?php if(isset($_POST['municipio'])) echo $_POST['municipio']?>">
                <?
              }
              ?>
            </div>
            <?php if (isset($municipioError)){?><div id="divForm"><span id="mensajeError"><?php echo $municipioError;?></span></div><?php }?>
          </article>
          <article class="datos">
            <div id="divForm">
              Estado:
            </div>
            <div id="divForm">
              <?php
              if (isset($_SESSION['estadoUsuario'])!="") {
              echo $_SESSION['estadoUsuario'];
              }else {
                ?>
                <input required type="text" name="estado" class="textArea" value="<?php if(isset($_POST['estado'])) echo $_POST['estado']?>">
                <?
              }
              ?>
            </div>
            <?php if (isset($estadoError)){?><div id="divForm"><span id="mensajeError"><?php echo $estadoError;?></span></div><?php }?>
          </article>
          <article class="datos">
            <div id="divForm">
              Pais:
            </div>
            <div id="divForm">
              <?php
              if (isset($_SESSION['paisUsuario'])!="") {
              echo $_SESSION['paisUsuario'];
              }else {
                ?>
                <input required type="text" name="pais" class="textArea" value="<?php if(isset($_POST['pais'])) echo $_POST['pais']?>">
                <?
              }
              ?>
            </div>
            <?php if (isset($paisError)){?><span id="mensajeError"><?php echo $paisError;?></span><?php }?>
          </article>
        </div>
        <?php if (isset($_SESSION['telefonoUsuario'])){}else{?>
        <div class="contenedorDatos">
          <input type="submit" name="completarInformacion" value="Completar informacion" class="botonForm" id="completar">
        </div>
        <?php }?>
      </form>
</section>
