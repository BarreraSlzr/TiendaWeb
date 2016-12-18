<?php
function mostrarProductos($query){
  echo "<ul class='contenedorFlex'>";
  $numeroProductos = mysql_num_rows($query);
  while ( $producto = mysql_fetch_array($query) ){
    extract($producto);
    if($numeroProductos == 1){ ?>
      <li class="listadoProductos">
      <div style="font-size: xx-large;font-weight: bolder;text-align: left;background: linear-gradient(to left, rgba(127, 212, 237, 0.52) 0%,#8ced7f 40%);">
        <article style="width: 14em; padding: 1em 1em;color: #FFF;"><?php echo nl2br($descripcion) ?></article></div>

        <div style="margin: .5em 0; font-size: large;font-weight: bolder;text-align: left;background: linear-gradient(to left, rgba(127, 212, 237, 0.52) 0%,#8ced7f 40%);">
          <a href="/Tienda_Web/Tienda.php" style="text-decoration: none"><article style="width: 14em; padding: 1em 1em;color: #FFF;">Regresar a la Tienda</article></a></div>
      </li>
    <?php } ?>
    <li class="listadoProductos">
      <div class="contenedorProducto"
      style="background-image:url('http://localhost/Tienda_Web/Productos/imagenesProducto/<?php echo $idProducto.".jpg"?>');
        <?php if($numeroProductos == 1){ ?>
          width: 30em; height: 100%; margin: 0% !important;
         <?php } ?> ">
        <div class="infoProducto"
        <?php if($numeroProductos == 1){ ?>
        style=" width: 30em; height: 40em;"
         <?php } ?>>
          <div class="descripcionProducto">
          <article class="descripcionProducto">
            <a style="text-decoration: none; color: white" href="/Tienda_Web/Tienda/Producto.php?id=<?php echo $idProducto ?>">
              <?php echo $nombre ?>
              </br>
              <strong><?php echo $categoriaNombre?></strong>
            </a>
            </br>
              <?php echo $precio ?>
          </article>
        </div>
          <div class="botonCarrito">
            <form class="agregarCarrito" action="/Tienda_Web/Tienda.php" method="post">
              <?php if ($cantidad>=1){ ?>
                <select required class="cantidadProducto" name="cantidadArticulos">
                  <option value=''>Cant.</option>
                  <?php for ($i=1; $i <= $cantidad ; $i) {
                    echo "<option value='".$i."'>".$i."</option>";
                    ((($i/10)>= 1)? $i+=5 : $i++);
                  }?>
                </select>
                <input name="idProductoAgregar" value="<?php echo $idProducto ?>" style="display: none;">
                <input type="submit" value="Agregar a carrito" name="agregarArticulo" class="botonCarrito"></a>
            <?php }else{ ?>
              <input disabled style="color: black; margin: 1em auto" type="submit" value="Producto Agotado" name="agregarArticulo" class="botonCarrito"></a>
            <?php } ?>
            </form>

          </div>
        </div>
        <img class="inspectorImagen" src="http://localhost/Tienda_Web/Productos/imagenesProducto/<?php echo $idProducto?>_alt.jpg" alt="">
      </div>
    </li>
    <?php
  }
  echo "</ul>";
}
?>
