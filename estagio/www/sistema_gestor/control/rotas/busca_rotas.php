<?php
include '../../model/rotas/rotas.php';
$parametro = isset($_POST['pesquisaCliente']) ? $_POST['pesquisaCliente'] : null;
$rotas = new rotas();
$rotas->getRotas($parametro);
?>
