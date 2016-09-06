<?php
require '../../model/controle-manutencao/ControleManutencao.php';
$parametro = isset($_POST['pesquisaCliente']) ? $_POST['pesquisaCliente'] : null;
$controle = new ControleManutencao();
$controle->buscaAtividades($parametro);
?>
