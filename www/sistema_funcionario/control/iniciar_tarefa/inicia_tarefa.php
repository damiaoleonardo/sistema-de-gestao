<?php

$conexao_select_inicia = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
mysqli_autocommit($conexao_select_inicia, FALSE);
$erro_select_inicia = 0;

// recebe todos os parametros mandados via javascript para assim garantir a unicidade do atributo
$id_tarefa_inicia = $_GET['id_tarefa'];
$id_projeto_executa_inicia = $_GET['id_projeto_executa'];
$id_projeto_inicia = $_GET['id_projeto'];
$id_veiculo_inicia = $_GET['id_veiculo'];
$id_funcionario_inicia = $_GET['id_funcionario'];
$data_hoje = date('Y-m-d');
$sql_hora = "SELECT DATE_FORMAT(now(),'%H:%i:%s')";
$query_hora = mysqli_query($conexao_select_inicia, $sql_hora);
 if (!$query_hora) {
   $erro_select_inicia++;
   }
$hora_inicio = mysqli_fetch_row($query_hora);
$horainicio = $hora_inicio[0];

// seleção do nome do projeto,veiculo,tarefa e funcionario

$sql_nome_projeto = "select projeto.nome from projeto where projeto.id_projeto = $id_projeto_inicia";
$query_nome_projeto = mysqli_query($conexao_select_inicia, $sql_nome_projeto);
 if (!$query_nome_projeto) {
   $erro_select_inicia++;
   }
$nome_projeto = mysqli_fetch_row($query_nome_projeto);
$nome_do_projeto = $nome_projeto[0];

$sql_nome_veiculo = "select veiculos.nome_veiculo from veiculos where veiculos.id_veiculo = $id_veiculo_inicia";
$query_nome_veiculo = mysqli_query($conexao_select_inicia, $sql_nome_veiculo);
 if (!$query_nome_veiculo) {
   $erro_select_inicia++;
   }
$nome_veiculo = mysqli_fetch_row($query_nome_veiculo);
$nome_do_veiculo = $nome_veiculo[0];


$sql_nome_tarefa = "select tarefas.nome from tarefas where tarefas.id_tarefa = $id_tarefa_inicia";
$query_nome_tarefa = mysqli_query($conexao_select_inicia, $sql_nome_tarefa);
 if (!$query_nome_tarefa) {
   $erro_select_inicia++;
   }
$nome_tarefa = mysqli_fetch_row($query_nome_tarefa);
$nome_da_tarefa = $nome_tarefa[0];

$sql_nome_funcionario = "select funcionarios.sobrenome from funcionarios where funcionarios.id_funcionario = $id_funcionario_inicia";
$query_nome_funcionario = mysqli_query($conexao_select_inicia, $sql_nome_funcionario);
 if (!$query_nome_funcionario) {
   $erro_select_inicia++;
   }
$nome_funcionario = mysqli_fetch_row($query_nome_funcionario);
$nome_do_funcionario = $nome_funcionario[0];

// verifica se o projeto ja foi iniciado por algum funcionario

$sql_projeto_iniciado = "select projeto_executa.flag_iniciada from projeto_executa where projeto_executa.id_projeto_executa = $id_projeto_executa_inicia and projeto_executa.id_projeto = $id_projeto_inicia and projeto_executa.id_veiculo = $id_veiculo_inicia and projeto_executa.status !='concluido'";
$query_flag_iniciada = mysqli_query($conexao_select_inicia, $sql_projeto_iniciado);
 if (!$query_flag_iniciada) {
   $erro_select_inicia++;
   }
$flag_inicia_projeto = mysqli_fetch_row($query_flag_iniciada);
$flag_iniciada = $flag_inicia_projeto[0];



if ($flag_iniciada == 0) {
    $flag_iniciado = "UPDATE projeto_executa SET hora_inicio = '$horainicio',data_inicio = '$data_hoje',id_funcionario= $id_funcionario_inicia,flag_iniciada = 1 where projeto_executa.id_projeto_executa = $id_projeto_executa_inicia and projeto_executa.id_projeto = $id_projeto_inicia and projeto_executa.id_veiculo = $id_veiculo_inicia and projeto_executa.status != 'concluido'";
    if (!mysqli_query($conexao_select_inicia, $flag_iniciado)) {
        $erro_select_inicia++;
    }
}

$query_atualiza_status_funcionario = "UPDATE funcionarios SET disponibilidade = 'ativo' where funcionarios.id_funcionario = $id_funcionario_inicia";
if (!mysqli_query($conexao_select_inicia, $query_atualiza_status_funcionario)) {
    $erro_select_inicia++;
}
$query_atualiza_status_tarefa = "UPDATE tarefas_executa SET status = 'open',horas_inicio = '$horainicio',horas_inicio_tarefa='$horainicio',data_inicio= '$data_hoje' ,id_funcionario= '$id_funcionario_inicia' where tarefas_executa.id_tarefa = $id_tarefa_inicia and tarefas_executa.id_projeto = $id_projeto_inicia and tarefas_executa.id_veiculo= $id_veiculo_inicia and tarefas_executa.conclusao_projeto = 'nao concluido'";
if (!mysqli_query($conexao_select_inicia, $query_atualiza_status_tarefa)) {
    $erro_select_inicia++;
}
$query_atualiza_funcionario_executa_tarefa = "INSERT INTO funcionario_executa (id_projeto_executa,id_projeto,id_veiculo,id_tarefa,id_funcionario,nome_do_projeto,nome_do_veiculo,nome_da_tarefa,nome_do_funcionario,hora_inicial,data_tarefa,status_funcionario_tarefa,status_tarefa,flag_tarefa_aberta,flag_tarefa_relatorio) VALUES ('$id_projeto_executa_inicia','$id_projeto_inicia','$id_veiculo_inicia','$id_tarefa_inicia','$id_funcionario_inicia','$nome_do_projeto','$nome_do_veiculo','$nome_da_tarefa','$nome_do_funcionario','$horainicio','$data_hoje','ativo','open','1','0')";
if (!mysqli_query($conexao_select_inicia, $query_atualiza_funcionario_executa_tarefa)) {
    $erro_select_inicia++;
}

if ($erro_select_inicia == 0) {
    mysqli_commit($conexao_select_inicia);
} else {
    mysqli_rollback($conexao_select_inicia);
} 


?>
