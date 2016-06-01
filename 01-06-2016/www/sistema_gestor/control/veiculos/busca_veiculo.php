<?php
include '../../model/veiculos/veiculos.php';
$parametro = isset($_POST['pesquisaCliente']) ? $_POST['pesquisaCliente'] : null;
$veiculos = new veiculos();
$veiculos->getVeiculos($parametro);
?>
