<?php
require_once('../config.php');
conectarBaseDatos();
if (isset($_POST['eliminarCarrito'])) {
  extract($_POST);
  require_once(ROOT_PATH.'Productos/tools/carritoDefault.php');
  $carrito = new Carrito();
  $carrito->remove_producto($idUnicaProducto);
}
$compraConfirmada=False;
$tipoPago="";
$pagoHecho= false;

if (isset($_GET['otraOpcion'])) {
  $compraConfirmada=true;
}
if (isset($_POST['realizarPago'])) {
  $compraConfirmada=true;
  $pagoHecho=true;
}
if (isset($_POST['confirmarCompra'])) {
  $compraConfirmada=true;
  require_once(ROOT_PATH.'Productos/tools/carritoDefault.php');
  $carrito = new Carrito();
  $articulos_total['carrito'] =$_SESSION['carrito']["articulos_total"];
  $precio_total['carrito'] =$_SESSION['carrito']["precio_total"];
  unset($_SESSION['carrito']["articulos_total"]);
  unset($_SESSION['carrito']["precio_total"]);
  foreach($_SESSION["carrito"] as $producto)
  {
    extract($producto);
    $carrito->cambiarCantidad($producto, $_POST['cantidadProducto'.$idProducto.'']);
  }
}
if (isset($_POST['tipoPagoTrans']) && $_POST['tipoPagoTrans']!= null ) {
  $tipoPago = 1;
  $compraConfirmada = true;
}
if (isset($_POST['tipoPagoTarj']) && $_POST['tipoPagoTarj']!= null) {
  $tipoPago = 2;
  $compraConfirmada = true;
}
if (isset($_POST['tipoPagoPay']) && $_POST['tipoPagoPay']!= null) {
  $tipoPago = 3;
  $compraConfirmada = true;
}
?>
<script type="text/javascript">
function calculo(cantidad,precio,inputtext){
  // Calculo del subtotal
  total = precio*cantidad;
  inputtext.value=total;
}
function elegirTarjeta(elegidatipoTarjeta,elegidanumeroTarjeta,elegidanumeroSeguridadTarjeta,elegidamesVigencia,elegidaanoVigencia,tipoTarjeta,numTarjeta,cvTarjeta,mesTarjeta,anoTarjeta){
  document.getElementById('numTarjeta').setAttribute( "value", elegidanumeroTarjeta);
  document.getElementById('cvTarjeta').setAttribute( "value", elegidanumeroSeguridadTarjeta);
  document.getElementById('mesTarjeta').setAttribute( "value", elegidamesVigencia);
  document.getElementById('anoTarjeta').setAttribute( "value", elegidaanoVigencia);

}
</script>
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
    <?php include( '../Pagina/header.php' );
    //<!-- Mensaje de error --->
    include ( '../Pagina/mensajeError.php' );

    echo "<ul class='contenedorCarrito'>
    <form class= action='/Tienda_Web/Tienda/Carrito.php' method='post'>";
    if ($compraConfirmada == true && $pagoHecho == false) {?>
        <li>
          <div style="margin: 1em auto; display: block">
          <?php if (isset($tipoPago) AND $tipoPago==null){ ?>
              <div class="contenedorProductoCarro" style="flex-flow: wrap">
                <div class="subcontenedores">
                  <strong>Seleccione una opcion de pago</strong>
                </div>
                <div class="subcontenedores">
                  <input class="btnTipoPago" type="submit" name="tipoPagoTrans" value="Transeferencia Bancaria">
                  <input class="btnTipoPago" type="submit" name="tipoPagoTarj" value="Tarjeta">
                  <input class="btnTipoPago" style="background: rgb(30, 144, 255);" type="submit" name="tipoPagoPay" value="PayPal">
                </div>
              </div>
            <?php } else {
            if (isset($_SESSION['idinfoUsuario'])) {?>
              <div class="contenedorProductoCarro" style="flex-flow: column">
                    <strong>Domicilios asociados a su cuenta</strong>
                <div>
                  <div class="subcontenedores">
                    <div class="inputsSubContenedores">
                      <b><sub>Direccion de Usuario</sub></b>
                      <div>
                        <?php  echo $_SESSION['direccionUsuario'] ?>
                      </div>
                    </div>
                    <div class="inputsSubContenedores">
                      <b><sub>Codigo Postal</sub></b>
                      <div>
                        <?php echo $_SESSION['codigoPostalUsuario'] ?>
                      </div>
                    </div>
                    <div class="inputsSubContenedores">
                      <b><sub>Municipio</sub></b>
                      <div>
                        <?php echo $_SESSION['municipioUsuario'] ?>
                      </div>
                    </div>
                    <div class="inputsSubContenedores">
                      <b><sub>Estado</sub></b>
                      <div>
                        <?php echo $_SESSION['estadoUsuario'] ?>
                      </div>
                    </div>
                    <div class="inputsSubContenedores">
                      <b><sub>Estado</sub></b>
                      <div>
                        <?php echo $_SESSION['paisUsuario'] ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
                <?php
              }
              switch ($tipoPago) {
                case '1':?>
                <div class="contenedorProductoCarro" style="flex-flow: wrap">
                  <div class="subcontenedores">
                    <strong>Transferencia Bancaria</strong>
                  </div>
                  <div class="subcontenedores">
                    <div class="inputsSubContenedores">
                      <b><sub>Institucion Bancaria</sub></b>
                      <div>
                        <input class="inpuEscritura" type="text" name="InstitucionBancaria" value="">
                      </div>
                    </div>
                    <div class="inputsSubContenedores">
                      <b><sub>Nº de Transferencia</sub></b>
                      <div>
                        <input class="inpuEscritura" required type="number" name="InstitucionBancaria" value="">
                      </div>
                    </div>
                    <div class="inputsSubContenedores">
                      <b><sub>Nº de Cuenta</sub></b>
                      <div>
                        <input class="inpuEscritura" required type="number" name="InstitucionBancaria" value="">
                      </div>
                    </div>
                    <div class="inputsSubContenedores">
                      <b><sub>Nombre de cuentahabiente</sub></b>
                      <div>
                        <input class="inpuEscritura" required type="text" name="InstitucionBancaria" value="">
                      </div>
                    </div>
                </div>
                <div class="subcontenedores" style="min-width: 80%;">
                  <a href="?otraOpcion=true">
                    <input class="btnTipoPago" style="background: rgb(255, 63, 48); margin: .5em auto" type="button" name="otraOpcion" value="Elegir otra opcion de pago">
                  </a>
                  <input class="btnTipoPago" type="submit" name="tipoPago" value="Pagar">
                </div>
                <?php break;
                case '2':
                if (isset($_SESSION['idUsuario'])) {
                $tarjetasCreditoEncontradas = mysql_query("SELECT * FROM tarjetasUsuario WHERE idUsuario=".$_SESSION['idUsuario']."")
                  or die("Consulta fallida: " . mysql_error());
                if (mysql_num_rows($tarjetasCreditoEncontradas)!=0) {
                  while ($tarjetas=mysql_fetch_array($tarjetasCreditoEncontradas)){
                    extract($tarjetas);?>
                  <div class="contenedorProductoCarro" style="flex-flow: column">
                        <strong>Tarjetas asociadas a tu cuenta</strong>
                    <div>
                      <div class="subcontenedores">
                        <div class="inputsSubContenedores">
                          <b><sub>Tipo de Tarjeta</sub></b>
                          <div>
                            <?php  echo $tipoTarjeta= ($tipoTarjeta == 1) ? "Debito" : "Credito" ; ?>
                          </div>
                        </div>
                        <div class="inputsSubContenedores">
                          <b><sub>Nº de Tarjeta</sub></b>
                          <div>
                            <?php echo $numeroTarjeta ?>
                          </div>
                        </div>
                        <div class="inputsSubContenedores">
                          <b><sub>Vigencia</sub></b>
                          <div style="min-width: 6em;">
                            <?php echo $mesVigencia ?>/<?php echo $anoVigencia ?>
                          </div>
                        </div>
                        <!--
                        <div class="inputsSubContenedores">
                          <input style="min-width: 17em; margin: 1em 1.5em auto;" name="tipoPago" value="Elegir" type="button"
                            onClick="elegirTarjeta(<?php echo "".$tipoTarjeta.",".$numeroTarjeta.",".$numeroSeguridadTarjeta.",".$mesVigencia.",".$anoVigencia.",tipoTarjeta,numTarjeta,cvTarjeta,mesTarjeta,anoTarjeta"?>)">
                        </div>
                       --->
                      </div>
                    </div>
                  </div>
                  <?php }
                  }
                }?>
                <div class="contenedorProductoCarro" style="flex-flow: column">
                    <strong>Pagar mediante Tarjeta</strong>
                    <div class="subcontenedores">
                      <div class="inputsSubContenedores">
                        <b><sub>Tipo de Tarjeta</sub></b>
                        <div>
                          <select required id="tipoTarjeta" class="inpuEscritura" name="tipoTarjetaUsuario">
                            <option value="">Elegir</option>
                            <option value="Debito">Debito</option>
                            <option value="Credito">Credito</option>
                          </select>
                        </div>
                      </div>
                      <div class="inputsSubContenedores">
                        <b><sub>Nº de Tarjeta</sub></b>
                        <div>
                          <input  required id="numTarjeta" type="number" name="tarjetaUsuario" min="0" class="inpuEscritura" value="<?php if(isset($_POST['tarjetaUsuario'])) echo $_POST['tarjetaUsuario'];?>">
                          <?php if (isset($tarjetaError)){?><span id="mensajeError">
                            <?php echo $tarjetaError;?></span><?php }?>
                        </div>
                      </div>
                      <div class="inputsSubContenedores">
                        <b><sub>CV</sub></b>
                        <div>
                          <input required id="cvTarjeta" type="number" name="seguridadTarjetaUsuario" min="100" max="999" class="inpuEscritura"
                            value="<?php if(isset($_POST['seguridadTarjetaUsuario'])) echo $_POST['seguridadTarjetaUsuario'];?>">
                          <?php if (isset($seguridadTarjetaError)){?><span id="mensajeError">
                            <?php echo $seguridadTarjetaError;?></span><?php }?>
                        </div>
                      </div>
                      <div class="inputsSubContenedores">
                        <b><sub>Vigencia</sub></b>
                        <div style="min-width: 6em;">
                          <input required id="mesTarjeta" type="number" name="mesTarjetaUsuario" class="inpuEscritura" min="1" max="12" step="1" style="max-width: 3em;"
                            value="<?php if(isset($_POST['mesTarjetaUsuario'])) echo $_POST['mesTarjetaUsuario'];?>">/
                          <input required id="anoTarjeta" type="number" name="anoTarjetaUsuario" class="inpuEscritura" min="16" max="99" step="1" style="max-width: 3em;"
                            value="<?php if(isset($_POST['anoTarjetaUsuario'])) echo $_POST['anoTarjetaUsuario'];?>">
                        </div>
                      </div>
                    </div>
                    <div class="subcontenedores" style="min-width: 80%;">
                      <a href="?otraOpcion=true"><input class="btnTipoPago" style="background: rgb(255, 63, 48); margin: .5em auto" type="button" name="otraOpcion" value="Elegir otra opcion de pago"></a>
                      <input class="btnTipoPago" type="submit" name="tipoPago" value="Pagar">
                    </div>
                <?php break;
                case '3':?>
                <div class="contenedorProductoCarro" style="flex-flow: column">
                      <strong>Pagar mediante PayPal</strong>
                      <div class="subcontenedores">
                        <div class="inputsSubContenedores">
                          <b><sub>Numero de seguridad</sub></b>
                          <input min="1000000000" max="999999999999" class="inpuEscritura" type="number" name="seguridadPaypal" value="">
                        </div>
                      </div>
                      <div class="subcontenedores" style="min-width: 80%;">
                        <a href="?otraOpcion=true"><input class="btnTipoPago" style="background: rgb(255, 63, 48); margin: .5em auto" type="button" name="otraOpcion" value="Elegir otra opcion de pago"></a>
                        <input class="btnTipoPago" type="submit" name="realizarPago" value="Pagar">
                      </div>
                <?php break;
              }
            }; ?>

            <div class="contenedorProductoCarro" style="flex-flow: wrap; padding: 0 3em; margin: .1em auto">
              <div class="subcontenedores">
                <div style="margin: 1em 1em">
                  <b><sub>Cantidad de Productos<b><sub>
                  <div><?php echo $carrito->articulos_total() ?></div>
                </div>
                <div style="margin: 1em 1em">
                  <b><sub>Total a pagar<b><sub>
                  <div><small>$ <?php echo $carrito->precio_total() ?></small></div>
                </div>
              </div>
            </div>
          </div>
        </li>
    <?php }elseif ($pagoHecho==true){?>
      <li>
        <div style="margin: 1em auto; display: block">
          <a href="/Tienda_Web/Tienda.php" style="text-decoration: none; ">
            <div class="contenedorProductoCarro"
              style="background: rgba(25,200,70,1); color: white;font-weight: 900;
              border: 0.1em solid rgba(0,0,0,.2);">
              <div style="text-align: center; margin: 0 auto;">
                ¡Pago Realizado!</br><h3>Continua navegando</h3>
              </div>
            </div>
          </a>
        </div>
      </li>

    <?php }
      if (is_numeric($carrito->articulos_total()) && $carrito->articulos_total()>0) {
    		$articulos_total['carrito'] =$_SESSION['carrito']["articulos_total"];
    		$precio_total['carrito'] =$_SESSION['carrito']["precio_total"];
    		unset($_SESSION['carrito']["articulos_total"]);
    		unset($_SESSION['carrito']["precio_total"]);
        foreach($_SESSION["carrito"] as $producto)
      	{
          extract($producto);
          $queryProducto = mysql_query("SELECT * FROM Productos WHERE idProducto=".$idProducto."");
          $infoProductoBodega = mysql_fetch_array($queryProducto);?>
          <li class='listadoProductos'>
          <div class="contenedorProductoCarro" <?php if ($compraConfirmada == true){
              ?> style="margin: -.2em auto; max-width: 35em; box-shadow: none;" <? } ?> >
            <div class="imgProductoCarrito" style="background-image:url('http://localhost/Tienda_Web/Productos/imagenesProducto/<?php echo $idProducto?>.jpg');">
              <div class="carritoImagenHover" style="background-image:url('http://localhost/Tienda_Web/Productos/imagenesProducto/<?php echo $idProducto?>_alt.jpg');">
                <img style="opacity: 0;" src="http://localhost/Tienda_Web/Productos/imagenesProducto/<?php echo $idProducto?>.jpg" alt="">
              </div>
            </div>
              <div class="infoProductoCarrito">
                <a href="/Tienda_Web/Tienda/Producto.php?id=<?php echo $idProducto ?>" class="descripcionProductoCarrito">
                  <div>
                    <strong> <?php echo $nombre."</br>" ?>
                    </strong>
                    <?php echo $categoriaNombre."</br>" ?>
                    <?php echo nl2br($descripcion)."</br>" ?>
                  </div>
                </a>
              <div>
                <div class="infoCompraProductoCarrito">
                  <div class="cantidadProductoCarrito">
                    <strong>Cantidad</strong>
                    <div>
                      <input required type="number" name="cantidadProducto<?php echo $idProducto?>" value="<?php echo $cantidad ?>"
                      onChange="calculo(this.value,precioProducto<?php echo $idProducto?>.value, total<?php echo $idProducto?>);"
                      <?php if ($compraConfirmada == true){
                        echo "disabled class='inputMuestraInfo'>";
                      }else{?>
                      min="1" max="<?php echo $infoProductoBodega['cantidad'] ?>"
                      id="cantidadProducto<?php echo $idProducto ?>"
                      class="inpuEscritura">
                    </div>
                    <?php if ($infoProductoBodega['cantidad']>1){ ?>
                      <sub style="color: green; font-size: .5em;">Stock disponible:</sub>
                    <?php }else { ?>
                      <sub style="color: red; font-size: .5em;">Stock no disponible:</sub>
                    <?php }
                     echo "</br>".$infoProductoBodega['cantidad'];
                    } ?>
                  </div>
                  <div class="precioProductoCarrito">
                    <strong>Precio</strong>
                    <div class=""><small>$</small>
                      <input disabled type="text" value="<?php echo $precio ?>"
                      id="precioProducto<?php echo $idProducto ?>"
                      class="inputMuestraInfo">
                    </div>
                  </div>
                </div>

                <div>
                    <sub><b>Precio Total</b></sub>
                    <div><small>$</small>
                      <input disabled type="text" value="<?php echo $total ?>"
                      id="total<?php echo $idProducto ?>"
                      class="inputMuestraInfo">
                    </div>
                    <?php if ($compraConfirmada == false){?>
                    <div>
                      <input hidden type="text" name="idUnicaProducto" value="<?php echo $unique_id?>">
                      <input class="removerCarritoButton" type="submit" name="eliminarCarrito" value="Quitar Articulo">
                    </div>
                  <?php } ?>
                  </div>
                </div>
              </article>
            </div>
        </div>
    </li><?php
  }?>
    <?php if ($compraConfirmada == False){?>
    <li >
      <div style="margin: -2em auto; display: flex">
          <input class="botonCompra" type="submit" name="confirmarCompra" value="Confirmar compra">
      </div>
    </li>
    <?php } ?>
  </form>
      <?php
  $_SESSION['carrito']["articulos_total"]= $articulos_total['carrito'];
  $_SESSION['carrito']["precio_total"]= $precio_total['carrito'];
}else {
  ?>
  <li>
    <div style="margin: 1em auto; display: block">
      <a href="/Tienda_Web/Tienda.php" style="text-decoration: none; ">
        <div class="contenedorProductoCarro"
          style="background: rgb(255, 63, 48); color: white;font-weight: 900;
          border: 0.1em solid rgba(0,0,0,.2);">
          <div style="text-align: center; margin: 0 auto;">
            ¡Aun no haz agregado ningun producto al carrito!</br>
            </br>
            <h3>Continua navegando ;)</h3>
          </div>
        </div>
      </a>
    </div>
  </li><?php
  }
  if ($pagoHecho == true){
    unset($_SESSION['carrito']["articulos_total"]);
    unset($_SESSION['carrito']["precio_total"]);
    foreach($_SESSION['carrito'] as $producto)
    {
      extract($producto);
      mysql_query("UPDATE Productos SET cantidad = cantidad - $cantidad WHERE idProducto=".$idProducto."")
        or die("Consulta fallida: " . mysql_error());
    }
    $carrito->destroy();
  }
  echo "</ul>";?>
  </div>
  <footer id="footer">
		<p>&copy; 2016 <a style="text-decoration:none" href="#">Internet Friends</a></p>
	</footer>
</body>
</html>
