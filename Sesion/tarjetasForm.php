<section id="contenedorPrincipal" class="contenedorIngresarCuenta">
  <?php if (isset($_SESSION['idinfoUsuario'])) {
  $tarjetasEncontradas = mysql_query("SELECT * FROM tarjetasUsuario WHERE idUsuario=".$_SESSION['idUsuario']."")
    or die("Consulta fallida: " . mysql_error());?>
  <div id="cuentaTitulos"><h2>Tarjetas Asociadas</h2></div>
  <?php
  if (mysql_num_rows($tarjetasEncontradas)!=0) {?>
    <div class="contenedorDatos">
      <table>
        <tr>
          <td>
            <article><h5 style="margin:0;">
              Tipo de tarjeta:
            </h5>
            </article>
          </td>
          <td>
            <article><h5 style="margin:0;">
              Numero de Tarjeta:
            </h5>
            </article>
          </td>
          <td>
            <article><h5 style="margin:0;">
                Vigencia:
              </h5>
            </article>
          </td>
          <td>
            <article><h5 style="margin:0;">
              <div id="divForm">
              </h5>
              </div>
            </article>
          </td>
        </tr>
        <?php
        $tarjetasEncontradas = mysql_query("SELECT * FROM tarjetasUsuario WHERE idUsuario=".$_SESSION['idUsuario']."")
          or die("Consulta fallida: " . mysql_error());
        while ($tarjetas=mysql_fetch_array($tarjetasEncontradas)){?>
          <tr>
            <td id="datosTarjetas">
            <?php echo  $tipoTarjeta = ($tarjetas['tipoTarjeta'] == 1)? "Debito" : "Credito";?>
            </td>
            <td id="datosTarjetas">
            <?php echo $tarjetas['numeroTarjeta'];?>
            </td>
            <td id="datosTarjetas">
              <?php echo $tarjetas['mesVigencia']." / ".$tarjetas['anoVigencia'];?>
            </td>
            <td id="datosTarjetas">
              <div><a href ="../Sesion/eliminarTarjeta.php?index=<?php echo $tarjetas['idTarjeta']?>&idUsuario=<?php echo $_SESSION['idUsuario']?>" onclick="return confirm ('¿Esta seguro que desea borrar esta tarjeta de Debito?')"><button> Eliminar </button></a><div>
            </td>
          </tr><?php }?>
        </table>
      </div><?php
    } ?>
  <form method="post" action="/Tienda_Web/Usuario/Perfil.php" class="cajaForm">
    <div id="cuentaTitulos"><h3 style="margin:.5em;">Agregar Tarjeta</h3></div>
    <div class="contenedorDatos">
      <article class="datos">
        <div class="nombreDatos">
          Tipo tarjeta:
        </div>
        <select required class="textArea" name="tipoTarjetaUsuario">
          <option value="">Elegir</option>
          <option value="1">Debito</option>
          <option value="2">Credito</option>
        </select>
      </article>
      <article class="datos">
        <div class="nombreDatos">
          Numero de tarjeta:
        </div>
          <input  required type="number" name="tarjetaUsuario" min="0" class="textArea" value="<?php echo $_POST['tarjetaUsuario']?>">
          <?php if (isset($tarjetaError)){?><span id="mensajeError">
            <?php echo $tarjetaError;?></span><?php }?>
      </article>
      <article class="datos" style="max-width: 5em;">
        <div class="nombreDatos">
          CV:
        </div>
          <input required type="number" name="seguridadTarjetaUsuario" min="100" max="999" class="textArea" value="<?php echo $_POST['seguridadTarjetaUsuario']?>">
          <?php if (isset($seguridadTarjetaError)){?><span id="mensajeError">
            <?php echo $seguridadTarjetaError;?></span><?php }?>
      </article>
      <article class="datos">
        <div class="nombreDatos">
          Vigencia:
        </div>
        <input required type="number" name="mesTarjetaUsuario" class="textArea" min="1" max="12" step="1" style="max-width: 3em;" value="<?php echo $_POST['mesTarjetaUsuario']?>"> /
        <input required type="number" name="anoTarjetaUsuario" class="textArea" min="16" max="99" step="1" style="max-width: 3em;" value="<?php echo $_POST['anoTarjetaUsuario']?>">
      </article>
    </div>
    <?php }else {
      ?>
      <div style="text-align: center;">Para agregar tarjetas es necesario completar tu informacion</div>
      <?php
    }?>
    <div class="contenedorDatos">
      <input type="submit" name="completarInformacion" value="Agregar otra tarjeta" class="botonForm" id="completar">
    </div>
  </form>
</section>
