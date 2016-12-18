<?php
  if (isset($_SESSION['message'])) {
    if (isset($_SESSION['idUsuario'])) {?>
  <section class="contenedorPrincipal">
<?php
    }else{ ?>
      <section class="contenedorIngresarCuenta">
  <?php }?>
    <article>
      <div class="header">
      </div>
      <div>
        <div id="mensajeError" class="errorTipo<?php echo $_SESSION['tipoError']?>">
          <?php echo $_SESSION['message'] ?>.</div>
          <?php unset($_SESSION['message']);
                unset($_SESSION['tipoError']);
          ?>
      </div>
    </article>
  </section>
<?php } ?>
