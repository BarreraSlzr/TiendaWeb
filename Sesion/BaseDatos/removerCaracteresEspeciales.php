<?php
  function removerCaracteresEspeciales ($variableSucia){
    $variableSucia = mysql_real_escape_string($variableSucia);
    $variableSucia = trim($variableSucia);
    $variableSucia = strip_tags($variableSucia);
    $variableSucia = htmlspecialchars($variableSucia);
    return $variableSucia;
  }
?>
