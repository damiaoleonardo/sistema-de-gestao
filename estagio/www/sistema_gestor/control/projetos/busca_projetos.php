<?php
include '../../model/projetos/projetos.php';
$busca_projeto = isset($_POST['pesquisaCliente']) ? $_POST['pesquisaCliente'] : null;
$projetos = new projetos();
$projetos->getProjetos($busca_projeto);
?>
