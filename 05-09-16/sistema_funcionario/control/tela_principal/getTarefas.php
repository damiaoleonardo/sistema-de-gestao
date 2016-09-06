<?php

require '../model/tela_principal/getInformacoes.php';

try {
    $exibe_tarefas = new getInformacoes();
    $exibe_tarefas->setId_projeto($id_do_projeto);
    $exibe_tarefas->setId_veiculo($id_do_veiculo);
    $exibe_tarefas->setId_projeto_executa($id_do_projeto_executa);
    $exibe_tarefas->setId_funcionario($id_funcionario);
    $exibe_tarefas->setStatus_funcionario($status_disponibilidade);
    $exibe_tarefas->exibeTarefas($exibe_tarefas);
} catch (Exception $ex) {
    $ex->getMessage();
}
?>

