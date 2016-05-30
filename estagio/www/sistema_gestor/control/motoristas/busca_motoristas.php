<?php
include '../../model/motorista/motorista.php';
$parametro = isset($_POST['pesquisaCliente']) ? $_POST['pesquisaCliente'] : null;
$motorista = new motorista();
$motorista->getMotorista($parametro);
?>
