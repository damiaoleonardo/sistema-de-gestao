<?php

require '../model/tela_principal/getInformacoes.php';
$id_projeto_executa = $_GET['id_projeto'];
$id_projeto = $_GET['id'];
$id_veiculo = $_GET['veiculo'];
$exibe_tarefas = new getInformacoes();
$exibe_tarefas->setId_projeto($id_projeto);
$exibe_tarefas->setId_veiculo($id_veiculo);
$exibe_tarefas->setId_projeto_executa($id_projeto_executa);    
$exibe_tarefas->setId_funcionario($id_funcionario);
$exibe_tarefas->setStatus_funcionario($status_disponibilidade);
$exibe_tarefas->exibeTarefas($exibe_tarefas);
?>

