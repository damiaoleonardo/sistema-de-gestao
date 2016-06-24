<?php

//conexao via mysqli com o banco de dados
$conexao_select_pause = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
mysqli_autocommit($conexao_select_pause, FALSE);
$erro_pause = 0;

//recebe parametros do javascript

$id_tarefa_pausa = $_GET['id_tarefa'];
$id_projeto_pausa = $_GET['id_projeto'];
$id_projeto_executa_pausa = $_GET['id_projeto_executa'];
$id_veiculo_pausa = $_GET['id_veiculo'];
$id_funcionario_pausa = $_GET['id_funcionario'];
$data_de_hoje = date('Y-m-d');
$sql_hora_pausa = "SELECT DATE_FORMAT(now(),'%H:%i:%s')";
$query_hora_pausa = mysqli_query($conexao_select_pause, $sql_hora_pausa);
 if (!$query_hora_pausa) {
   $erro_pause++;
 }
$hora_inicio = mysqli_fetch_row($query_hora_pausa);
$horainicio = $hora_inicio[0];

//recebe o nome do projeto,veiculo,tarefa e funcionario

$sql_nome_projeto = "select projeto.nome from projeto where projeto.id_projeto = $id_projeto_pausa";
$query_nome_projeto_pausa = mysqli_query($conexao_select_pause, $sql_nome_projeto);
 if (!$query_nome_projeto_pausa) {
   $erro_pause++;
 }
$nome_projeto = mysqli_fetch_row($query_nome_projeto_pausa);
$nome_do_projeto = $nome_projeto[0];

$sql_nome_veiculo = "select veiculos.nome_veiculo from veiculos where veiculos.id_veiculo = $id_veiculo_pausa";
$query_nome_veiculo_pausa = mysqli_query($conexao_select_pause, $sql_nome_veiculo);
 if (!$query_nome_veiculo_pausa) {
   $erro_pause++;
 }
$nome_veiculo = mysqli_fetch_row($query_nome_veiculo_pausa);
$nome_do_veiculo = $nome_veiculo[0];

$sql_nome_tarefa = "select tarefas.nome from tarefas where tarefas.id_tarefa = $id_tarefa_pausa";
$query_nome_tarefa_pausa = mysqli_query($conexao_select_pause, $sql_nome_tarefa);
 if (!$query_nome_tarefa_pausa) {
   $erro_pause++;
 }
$nome_tarefa = mysqli_fetch_row($query_nome_tarefa_pausa);
$nome_da_tarefa = $nome_tarefa[0];

$sql_nome_funcionario = "select funcionarios.sobrenome from funcionarios where funcionarios.id_funcionario = $id_funcionario_pausa";
$query_nome_funcionario_pausa = mysqli_query($conexao_select_pause, $sql_nome_funcionario);
 if (!$query_nome_funcionario_pausa) {
   $erro_pause++;
 }
$nome_funcionario = mysqli_fetch_row($query_nome_funcionario_pausa);
$nome_do_funcionario = $nome_funcionario[0];

$sql_quntidade_executores = "SELECT funcionario_executa.id_funcionario FROM funcionario_executa WHERE funcionario_executa.status_funcionario_tarefa = 'ativo' and funcionario_executa.id_projeto_executa = $id_projeto_executa_pausa and funcionario_executa.id_projeto = $id_projeto_pausa and funcionario_executa.id_veiculo = $id_veiculo_pausa and funcionario_executa.id_tarefa = $id_tarefa_pausa";
$query_executores_pausa = mysqli_query($conexao_select_pause, $sql_quntidade_executores);
 if (!$query_executores_pausa) {
   $erro_pause++;
 }
$quantidades_executores = mysqli_num_rows($query_executores_pausa);
if ($quantidades_executores == 1) {
    $atualiza_tarefas = "UPDATE tarefas_executa SET status = 'pause' where tarefas_executa.id_tarefa = $id_tarefa_pausa and tarefas_executa.id_projeto = $id_projeto_pausa and tarefas_executa.id_veiculo= $id_veiculo_pausa and tarefas_executa.conclusao_projeto = 'nao concluido'";
    if (!mysqli_query($conexao_select_pause, $atualiza_tarefas)) {
        $erro_pause++;
    }
}

$atualiza_funcionario = "UPDATE funcionarios SET disponibilidade = 'inativo' where funcionarios.id_funcionario = $id_funcionario_pausa";

if (!mysqli_query($conexao_select_pause, $atualiza_funcionario)) {
    $erro_pause++;
}
$atualiza_funcionario_executa = "UPDATE funcionario_executa SET hora_final = '$horainicio', status_funcionario_tarefa = 'nao ativo',status_tarefa= 'concluida',flag_tarefa_aberta = 0,flag_tarefa_relatorio = 0 where funcionario_executa.id_projeto=$id_projeto_pausa and funcionario_executa.id_veiculo= $id_veiculo_pausa and funcionario_executa.id_tarefa= $id_tarefa_pausa and funcionario_executa.id_funcionario= $id_funcionario_pausa and funcionario_executa.status_funcionario_tarefa = 'ativo' and funcionario_executa.status_tarefa != 'concluida'";

if (!mysqli_query($conexao_select_pause, $atualiza_funcionario_executa)) {
    $erro_pause++;
}
$insere_funcionario = "INSERT INTO funcionario_executa (id_projeto_executa,id_projeto,id_veiculo,id_tarefa,id_funcionario,nome_do_projeto,nome_do_veiculo,nome_da_tarefa,nome_do_funcionario,data_tarefa,status_funcionario_tarefa,status_tarefa,flag_tarefa_aberta,flag_tarefa_relatorio) VALUES ('$id_projeto_executa_pausa','$id_projeto_pausa','$id_veiculo_pausa','$id_tarefa_pausa','$id_funcionario_pausa','$nome_do_projeto','$nome_do_veiculo','$nome_da_tarefa','$nome_do_funcionario','$data_de_hoje',' nao ativo','pause','0','1')";

if (!mysqli_query($conexao_select_pause, $insere_funcionario)) {
    $erro_pause++;
}

if ($erro_pause == 0) {
    mysqli_commit($conexao_select_pause);
} else {
    mysqli_rollback($conexao_select_pause);
}

?>
