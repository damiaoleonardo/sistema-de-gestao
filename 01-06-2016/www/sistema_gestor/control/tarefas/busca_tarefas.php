<?php
include '../../model/tarefas/tarefa.php';
$busca = isset($_POST['pesquisaCliente']) ? $_POST['pesquisaCliente'] : null;
$tarefa = new Tarefa();
$tarefa->getTarefas($busca);
?>
