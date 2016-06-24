<?php

$conexao_select_reabre_tarefa = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
mysqli_autocommit($conexao_select_reabre_tarefa, FALSE);
$erro_abre_tarefa = 0;

$id_tarefa_varios_executores = $_GET['id_tarefa'];
$id_projeto_executa_varios_executores = $_GET['id_projeto_executa'];
$id_projeto_varios_executores = $_GET['id_projeto'];
$veiculo_varios_executores = $_GET['id_veiculo'];
$id_funcionario_varios_executores = $_GET['id_funcionario'];
$dataatual = date('Y-m-d');
$sql_reabre_tarefa = "SELECT DATE_FORMAT(now(),'%H:%i:%s')";
$query_hora_reabre_tarefa = mysqli_query($conexao_select_reabre_tarefa, $sql_reabre_tarefa);
if (!$query_hora_reabre_tarefa) {
    $erro_abre_tarefa++;
}
$hora_inicio = mysqli_fetch_row($query_hora_reabre_tarefa);
$horainicio = $hora_inicio[0];

$sql_nome_projeto = "select projeto.nome from projeto where projeto.id_projeto = $id_projeto_varios_executores";
$query_projeto_reabre_tarefa = mysqli_query($conexao_select_reabre_tarefa, $sql_nome_projeto);
if (!$query_projeto_reabre_tarefa) {
    $erro_abre_tarefa++;
}
$nome_projeto = mysqli_fetch_row($query_projeto_reabre_tarefa);
$nome_do_projeto = $nome_projeto[0];

$sql_nome_veiculo = "select veiculos.nome_veiculo from veiculos where veiculos.id_veiculo = $veiculo_varios_executores";
$query_veiculo_reabre_tarefa = mysqli_query($conexao_select_reabre_tarefa, $sql_nome_veiculo);
if (!$query_veiculo_reabre_tarefa) {
    $erro_abre_tarefa++;
}
$nome_veiculo = mysqli_fetch_row($query_veiculo_reabre_tarefa);
$nome_do_veiculo = $nome_veiculo[0];

$sql_nome_tarefa = "select tarefas.nome from tarefas where tarefas.id_tarefa = $id_tarefa_varios_executores";
$query_tarefa_reabre_tarefa = mysqli_query($conexao_select_reabre_tarefa, $sql_nome_tarefa);
if (!$query_tarefa_reabre_tarefa) {
    $erro_abre_tarefa++;
}
$nome_tarefa = mysqli_fetch_row($query_tarefa_reabre_tarefa);
$nome_da_tarefa = $nome_tarefa[0];

$sql_nome_funcionario = "select funcionarios.sobrenome from funcionarios where funcionarios.id_funcionario = $id_funcionario_varios_executores";
$query_funcionario_reabre_tarefa = mysqli_query($conexao_select_reabre_tarefa, $sql_nome_funcionario);
if (!$query_funcionario_reabre_tarefa) {
    $erro_abre_tarefa++;
}
$nome_funcionario = mysqli_fetch_row($query_funcionario_reabre_tarefa);
$nome_do_funcionario = $nome_funcionario[0];


$sql_data_tarefa_abre = "select funcionario_executa.data_tarefa from funcionario_executa where funcionario_executa.id_projeto_executa = $id_projeto_executa_varios_executores and funcionario_executa.id_projeto = $id_projeto_varios_executores and funcionario_executa.id_veiculo = $veiculo_varios_executores and funcionario_executa.id_tarefa = $id_tarefa_varios_executores and funcionario_executa.id_funcionario = $id_funcionario_varios_executores and funcionario_executa.status_tarefa != 'concluida' and funcionario_executa.status_tarefa != 'open'";
$query_data_tarefa_abre = mysqli_query($conexao_select_reabre_tarefa, $sql_data_tarefa_abre);
if (!$query_data_tarefa_abre) {
    $erro_abre_tarefa++;
}
$data_tarefa_abre = mysqli_fetch_row($query_data_tarefa_abre);
$data_da_tarefa_abre = $data_tarefa_abre[0];


$sql_status_funcionario = "select funcionario_executa.id_funcionario from funcionario_executa where funcionario_executa.id_projeto_executa = $id_projeto_executa_varios_executores and funcionario_executa.id_projeto = $id_projeto_varios_executores and funcionario_executa.id_veiculo = $veiculo_varios_executores and funcionario_executa.id_tarefa = $id_tarefa_varios_executores and funcionario_executa.id_funcionario = $id_funcionario_varios_executores and funcionario_executa.status_tarefa != 'concluida' and funcionario_executa.status_tarefa != 'open'";
$query_id_funcionario_abre = mysqli_query($conexao_select_reabre_tarefa, $sql_status_funcionario);
if (!$query_id_funcionario_abre) {
    $erro_abre_tarefa++;
}
$status_da_tarefa_funcionario = mysqli_fetch_row($query_id_funcionario_abre);
$id_do_status_do_funcionario = $status_da_tarefa_funcionario[0];


if ($id_do_status_do_funcionario == $id_funcionario_varios_executores) {
   
    if ($data_da_tarefa_abre == $dataatual) {
        $atualiza_funcionario_abre = "UPDATE funcionario_executa SET hora_inicial = '$horainicio', status_funcionario_tarefa = 'ativo',status_tarefa = 'open',flag_tarefa_aberta = 1,flag_tarefa_relatorio = 0 where funcionario_executa.id_projeto_executa = $id_projeto_executa_varios_executores and funcionario_executa.id_projeto=$id_projeto_varios_executores and funcionario_executa.id_veiculo= $veiculo_varios_executores and funcionario_executa.id_tarefa= $id_tarefa_varios_executores and funcionario_executa.id_funcionario=$id_funcionario_varios_executores and funcionario_executa.status_tarefa != 'concluida' and funcionario_executa.flag_tarefa_relatorio = 1";
        if (!mysqli_query($conexao_select_reabre_tarefa, $atualiza_funcionario_abre)) {
            $erro_abre_tarefa++;
        }
    } else {
        $insert_funcionario_executa = "INSERT INTO funcionario_executa (id_projeto_executa,id_projeto,id_veiculo,id_tarefa,id_funcionario,nome_do_projeto,nome_do_veiculo,nome_da_tarefa,nome_do_funcionario,hora_inicial,data_tarefa,status_funcionario_tarefa,status_tarefa,flag_tarefa_aberta,flag_tarefa_relatorio) VALUES ('$id_projeto_executa_varios_executores','$id_projeto_varios_executores','$veiculo_varios_executores','$id_tarefa_varios_executores','$id_funcionario_varios_executores','$nome_do_projeto','$nome_do_veiculo','$nome_da_tarefa','$nome_do_funcionario','$horainicio','$dataatual','ativo','open','1','0')";
        if (!mysqli_query($conexao_select_reabre_tarefa, $insert_funcionario_executa)) {
            $erro_abre_tarefa++;
        }
        $delete_funcionario_executa_existente = "delete from funcionario_executa where funcionario_executa.id_projeto_executa = $id_projeto_executa_varios_executores and funcionario_executa.id_projeto=$id_projeto_varios_executores and funcionario_executa.id_veiculo= $veiculo_varios_executores and funcionario_executa.id_tarefa= $id_tarefa_varios_executores and funcionario_executa.id_funcionario=$id_funcionario_varios_executores and funcionario_executa.status_tarefa != 'concluida' and funcionario_executa.data_tarefa = '$data_da_tarefa' ";
        if (!mysqli_query($conexao_select_reabre_tarefa, $delete_funcionario_executa_existente)) {
            $erro_abre_tarefa++;
        }
    }
} else {
    $insere_funcionario_executa = "INSERT INTO funcionario_executa (id_projeto_executa,id_projeto,id_veiculo,id_tarefa,id_funcionario,nome_do_projeto,nome_do_veiculo,nome_da_tarefa,nome_do_funcionario,hora_inicial,data_tarefa,status_funcionario_tarefa,status_tarefa,flag_tarefa_aberta,flag_tarefa_relatorio) VALUES ('$id_projeto_executa_varios_executores','$id_projeto_varios_executores','$veiculo_varios_executores','$id_tarefa_varios_executores','$id_funcionario_varios_executores','$nome_do_projeto','$nome_do_veiculo','$nome_da_tarefa','$nome_do_funcionario','$horainicio','$dataatual','ativo','open','1','0')";
    if (!mysqli_query($conexao_select_reabre_tarefa, $insere_funcionario_executa)) {
        $erro_abre_tarefa++;
    }
}



/*
$insere_funcionario_executa = "INSERT INTO funcionario_executa (id_projeto_executa,id_projeto,id_veiculo,id_tarefa,id_funcionario,nome_do_projeto,nome_do_veiculo,nome_da_tarefa,nome_do_funcionario,hora_inicial,data_tarefa,status_funcionario_tarefa,status_tarefa,flag_tarefa_aberta,flag_tarefa_relatorio) VALUES ('$id_projeto_executa_varios_executores','$id_projeto_varios_executores','$veiculo_varios_executores','$id_tarefa_varios_executores','$id_funcionario_varios_executores','$nome_do_projeto','$nome_do_veiculo','$nome_da_tarefa','$nome_do_funcionario','$horainicio','$dataatual','ativo','open','1','0')";
if (!mysqli_query($conexao_select_reabre_tarefa, $insere_funcionario_executa)) {
    $erro_abre_tarefa++;
}
*/


$atualiza_funcionario_disponibilidade = "UPDATE funcionarios SET disponibilidade = 'ativo' where funcionarios.id_funcionario = $id_funcionario_varios_executores";
if (!mysqli_query($conexao_select_reabre_tarefa, $atualiza_funcionario_disponibilidade)) {
    $erro_abre_tarefa++;
}

if ($erro_abre_tarefa == 0) {
    mysqli_commit($conexao_select_reabre_tarefa);
} else {
    mysqli_rollback($conexao_select_reabre_tarefa);
}
?>

