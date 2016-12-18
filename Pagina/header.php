<?php
require_once(ROOT_PATH.'Productos/tools/carritoDefault.php');
$carrito = new Carrito();
  if (isset($_POST['idProductoAgregar'])){
  	extract($_POST);
  	if ($cantidadArticulos<0) {
  		$cantidadArticulos=1;
  	}
  	$buscarProductos = mysql_query("SELECT * FROM Productos
  		WHERE idProducto=".$idProductoAgregar." LIMIT 1")
  			or die("Consulta fallida: " . mysql_error());
  	$productosEncontrados=mysql_fetch_array($buscarProductos);
  	if($cantidadArticulos <= $productosEncontrados['cantidad']){
  		$carrito->add($productosEncontrados, $cantidadArticulos);
  	}else {
  		$_SESSION['message']="Cantidad no disponible en Stock";
  		$_SESSION['tipoError']="Fallo";
  	}
    header('Tienda.php');
  }
?>
<header id="header">

  <a id="tituloHeader" href="/Tienda_Web/Tienda.php">
      <span class="tituloPagina">Internet Friends</span>
      <span class="descripcionPagina">DESIGN | FASHION | MERCHANDISE</span>
  </a>

  <nav>
    <div id="saludoUsuario">
      <ul>
        <li><h4>
            <?php
            if (isset($_SESSION['nombreUsuario'])) {
              ?>
              Bienvenido/a <a href="/Tienda_Web/Usuario/Perfil.php"><?php echo $_SESSION['nombreUsuario'];  ?>.</a>
                      <?php
            } else {
              ?>
              Hola,<a href="/Tienda_Web/IniciarSesion.php"> inicia sesion </a>para finalizar tus compras.<?php
            }?>
          </h4></li>
      </ul>
    </div>
    <?php
    if (isset($_SESSION['nombreUsuario'])) {
      ?>

    <?php
    } ?>

    <ul>
      <lu>
      <?php
      if (isset($_SESSION['nombreUsuario'])) {
        ?><a href="/Tienda_Web/Sesion/logout.php">Salir
      <?php
      } else {
        ?>
          <a href="/Tienda_Web/IniciarSesion.php">Ingresar
        <?php
      }?>
      </a></lu>
      <li><a href="/Tienda_Web/Tienda.php">Tienda</a></li>
      <li><a href="/Tienda_Web/Tienda/Carrito.php">Carrito <?php if(isset($carrito)){ echo "(".$carrito->articulos_total().")"; }?></a></li>
    </ul>
  </nav>
</header>
