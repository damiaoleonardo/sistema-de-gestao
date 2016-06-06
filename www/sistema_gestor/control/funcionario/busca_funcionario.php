<?php
include '../../model/funcionario/funcionario.php';
$parametro = isset($_POST['pesquisaCliente']) ? $_POST['pesquisaCliente'] : null;
$funcionario = new funcionario();
$funcionario->getFuncionario($parametro);
?>

