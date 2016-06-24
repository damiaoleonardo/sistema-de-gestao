<?php

$conexao_select_reabre = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
mysqli_autocommit($conexao_select_reabre, FALSE);
$erro_select_reabre = 0;

$id_projeto_executa_retorna_pausada = $_GET['id_projeto_executa'];
$id_tarefa_pausada_retorna_pausada = $_GET['id_tarefa'];
$id_projeto_pausado_retorna_pausada = $_GET['id_projeto'];
$id_veiculo_pausado_retorna_pausada = $_GET['id_veiculo'];
$id_funcionario_retorna_pausada = $_GET['id_funcionario'];
$data_hoje = date('Y-m-d');
$sql_reabre = "SELECT DATE_FORMAT(now(),'%H:%i:%s')";
$query_hora_reabre = mysqli_query($conexao_select_reabre, $sql_reabre);
if (!$query_hora_reabre) {
    $erro_select_reabre++;
}
$hora_inicio = mysqli_fetch_row($query_hora_reabre);
$horainicio = $hora_inicio[0];

$sql_data_tarefa = "select funcionario_executa.data_tarefa from funcionario_executa where funcionario_executa.id_projeto_executa = $id_projeto_executa_retorna_pausada and funcionario_executa.id_projeto = $id_projeto_pausado_retorna_pausada and funcionario_executa.id_veiculo = $id_veiculo_pausado_retorna_pausada and funcionario_executa.id_tarefa = $id_tarefa_pausada_retorna_pausada and funcionario_executa.id_funcionario = $id_funcionario_retorna_pausada and funcionario_executa.status_tarefa != 'concluida' and funcionario_executa.status_tarefa != 'open'";
$query_data_tarefa_reabre = mysqli_query($conexao_select_reabre, $sql_data_tarefa);
if (!$query_data_tarefa_reabre) {
    $erro_select_reabre++;
}
$data_tarefa = mysqli_fetch_row($query_data_tarefa_reabre);
$data_da_tarefa = $data_tarefa[0];

$sql_status_funci = "select funcionario_executa.id_funcionario from funcionario_executa where funcionario_executa.id_projeto_executa = $id_projeto_executa_retorna_pausada and funcionario_executa.id_projeto = $id_projeto_pausado_retorna_pausada and funcionario_executa.id_veiculo = $id_veiculo_pausado_retorna_pausada and funcionario_executa.id_tarefa = $id_tarefa_pausada_retorna_pausada and funcionario_executa.id_funcionario = $id_funcionario_retorna_pausada and funcionario_executa.status_tarefa != 'concluida' and funcionario_executa.status_tarefa != 'open'";
$query_id_funcionario_reabre = mysqli_query($conexao_select_reabre, $sql_status_funci);
if (!$query_id_funcionario_reabre) {
    $erro_select_reabre++;
}
$status_da_tarefa_func = mysqli_fetch_row($query_id_funcionario_reabre);
$id_do_status_do_funci = $status_da_tarefa_func[0];

$sql_nome_projeto = "select projeto.nome from projeto where projeto.id_projeto = $id_projeto_pausado_retorna_pausada";
$query_nome_projeto_reabre = mysqli_query($conexao_select_reabre, $sql_nome_projeto);
if (!$query_nome_projeto_reabre) {
    $erro_select_reabre++;
}
$nome_projeto = mysqli_fetch_row($query_nome_projeto_reabre);
$nome_do_projeto = $nome_projeto[0];

$sql_nome_veiculo = "select veiculos.nome_veiculo from veiculos where veiculos.id_veiculo = $id_veiculo_pausado_retorna_pausada";
$query_nome_veiculo_reabre = mysqli_query($conexao_select_reabre, $sql_nome_veiculo);
if (!$query_nome_veiculo_reabre) {
    $erro_select_reabre++;
}
$nome_veiculo = mysqli_fetch_row($query_nome_veiculo_reabre);
$nome_do_veiculo = $nome_veiculo[0];

$sql_nome_tarefa = "select tarefas.nome from tarefas where tarefas.id_tarefa = $id_tarefa_pausada_retorna_pausada";
$query_nome_tarefa_reabre = mysqli_query($conexao_select_reabre, $sql_nome_tarefa);
if (!$query_nome_tarefa_reabre) {
    $erro_select_reabre++;
}
$nome_tarefa = mysqli_fetch_row($query_nome_tarefa_reabre);
$nome_da_tarefa = $nome_tarefa[0];

$sql_nome_funcionario = "select funcionarios.sobrenome from funcionarios where funcionarios.id_funcionario = $id_funcionario_retorna_pausada";
$query_nome_sobrenome_reabre = mysqli_query($conexao_select_reabre, $sql_nome_funcionario);
if (!$query_nome_sobrenome_reabre) {
    $erro_select_reabre++;
}
$nome_funcionario = mysqli_fetch_row($query_nome_sobrenome_reabre);
$nome_do_funcionario = $nome_funcionario[0];

if ($id_do_status_do_funci == $id_funcionario_retorna_pausada) {
    
    if ($data_da_tarefa == $data_hoje) {
        $atualiza_funcionario = "UPDATE funcionario_executa SET hora_inicial = '$horainicio', status_funcionario_tarefa = 'ativo',status_tarefa = 'open',flag_tarefa_aberta = 1,flag_tarefa_relatorio = 0 where funcionario_executa.id_projeto_executa = $id_projeto_executa_retorna_pausada and funcionario_executa.id_projeto=$id_projeto_pausado_retorna_pausada and funcionario_executa.id_veiculo= $id_veiculo_pausado_retorna_pausada and funcionario_executa.id_tarefa= $id_tarefa_pausada_retorna_pausada and funcionario_executa.id_funcionario=$id_funcionario_retorna_pausada and funcionario_executa.status_tarefa != 'concluida' and funcionario_executa.flag_tarefa_relatorio = 1";
        if (!mysqli_query($conexao_select_reabre, $atualiza_funcionario)) {
            $erro_select_reabre++;
        }
    } else {
        $insert_funcionario = "INSERT INTO funcionario_executa (id_projeto_executa,id_projeto,id_veiculo,id_tarefa,id_funcionario,nome_do_projeto,nome_do_veiculo,nome_da_tarefa,nome_do_funcionario,hora_inicial,data_tarefa,status_funcionario_tarefa,status_tarefa,flag_tarefa_aberta,flag_tarefa_relatorio) VALUES ('$id_projeto_executa_retorna_pausada','$id_projeto_pausado_retorna_pausada','$id_veiculo_pausado_retorna_pausada','$id_tarefa_pausada_retorna_pausada','$id_funcionario_retorna_pausada','$nome_do_projeto','$nome_do_veiculo','$nome_da_tarefa','$nome_do_funcionario','$horainicio','$data_hoje','ativo','open','1','0')";
        if (!mysqli_query($conexao_select_reabre, $insert_funcionario)) {
            $erro_select_reabre++;
        }
        $delete_funcionario = "delete from funcionario_executa where funcionario_executa.id_projeto_executa = $id_projeto_executa_retorna_pausada and funcionario_executa.id_projeto=$id_projeto_pausado_retorna_pausada and funcionario_executa.id_veiculo= $id_veiculo_pausado_retorna_pausada and funcionario_executa.id_tarefa= $id_tarefa_pausada_retorna_pausada and funcionario_executa.id_funcionario=$id_funcionario_retorna_pausada and funcionario_executa.status_tarefa != 'concluida' and funcionario_executa.data_tarefa = '$data_da_tarefa' ";
        if (!mysqli_query($conexao_select_reabre, $delete_funcionario)) {
            $erro_select_reabre++;
        }
    }
} else {
    $insere_funcionario = "INSERT INTO funcionario_executa (id_projeto_executa,id_projeto,id_veiculo,id_tarefa,id_funcionario,nome_do_projeto,nome_do_veiculo,nome_da_tarefa,nome_do_funcionario,hora_inicial,data_tarefa,status_funcionario_tarefa,status_tarefa,flag_tarefa_aberta,flag_tarefa_relatorio ) VALUES ('$id_projeto_executa_retorna_pausada','$id_projeto_pausado_retorna_pausada','$id_veiculo_pausado_retorna_pausada','$id_tarefa_pausada_retorna_pausada','$id_funcionario_retorna_pausada','$nome_do_projeto','$nome_do_veiculo','$nome_da_tarefa','$nome_do_funcionario','$horainicio','$data_hoje','ativo','open','1','0')";
    if (!mysqli_query($conexao_select_reabre, $insere_funcionario)) {
        $erro_select_reabre++;
    }
}

$query_atualiza_status_funcionario = "UPDATE funcionarios SET disponibilidade = 'ativo' where funcionarios.id_funcionario = $id_funcionario_retorna_pausada";
if (!mysqli_query($conexao_select_reabre, $query_atualiza_status_funcionario)) {
    $erro_select_reabre++;
}

$query_atualiza_tarefas_status = "UPDATE tarefas_executa SET status = 'open',horas_inicio = '$horainicio' where tarefas_executa.id_projeto_executa= $id_projeto_executa_retorna_pausada and tarefas_executa.id_tarefa = $id_tarefa_pausada_retorna_pausada and tarefas_executa.id_projeto = $id_projeto_pausado_retorna_pausada and tarefas_executa.id_veiculo= $id_veiculo_pausado_retorna_pausada and tarefas_executa.conclusao_projeto = 'nao concluido'";

if (!mysqli_query($conexao_select_reabre, $query_atualiza_tarefas_status)) {
    $erro_select_reabre++;
}

if ($erro_select_reabre == 0) {
    mysqli_commit($conexao_select_reabre);
} else {
    mysqli_rollback($conexao_select_reabre);
}
?>