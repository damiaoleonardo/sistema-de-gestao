<?php

require ('../../model/Conexao/Connection.class.php');
$conexao = Connection::getInstance();
$id_projeto_stop = $_GET['id_projeto'];
$id_veiculo_stop = $_GET['id_veiculo'];
$id_tarefa_stop = $_GET['id_tarefa'];
$id_funcionario_stop = $_GET['id_funcionario'];
$data_atual = date('Y-m-d');
$sql = "SELECT DATE_FORMAT(now(),'%H:%i:%s')";
$result_hora = mysql_query($sql);
$hora_atual = mysql_fetch_row($result_hora);
$horaatual = $hora_atual[0];
$flag_projeto_finalizado = 0;

$sql_get_quantidade_executores_tarefa_para_stop = "select tarefas_executa.quantidade_executores from tarefas_executa where tarefas_executa.id_projeto = $id_projeto_stop and tarefas_executa.id_veiculo = $id_veiculo_stop and tarefas_executa.id_tarefa = $id_tarefa_stop and tarefas_executa.conclusao_projeto = 'nao concluido'";
$aux_get_quantidade_executores_para_stop = mysql_query($sql_get_quantidade_executores_tarefa_para_stop);
$quantidades_executores_tarefa_para_stop = mysql_fetch_row($aux_get_quantidade_executores_para_stop);
$executores_da_tarefa_para_stop = $quantidades_executores_tarefa_para_stop[0];
$conexao_select = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
mysqli_autocommit($conexao_select, FALSE);
$erro_finaliza = 0;

if ($executores_da_tarefa_para_stop == 1) {
    $atualiza_tarefa = "UPDATE tarefas_executa SET status = 'concluida', horas_final = '$horaatual', data_final= '$data_atual',status_finalizado = 'funcionario' where tarefas_executa.id_projeto = $id_projeto_stop and tarefas_executa.id_veiculo= $id_veiculo_stop and tarefas_executa.id_tarefa = $id_tarefa_stop and tarefas_executa.conclusao_projeto = 'nao concluido'";
    if (!mysqli_query($conexao_select, $atualiza_tarefa)) {
        $erro_finaliza++;
    }

    $sql_status_do_projeto = "select tarefas_executa.status from tarefas_executa where tarefas_executa.id_projeto = $id_projeto_stop and tarefas_executa.id_veiculo= $id_veiculo_stop and tarefas_executa.status != 'concluida'";
    $result_flag_atividades = mysql_query($sql_status_do_projeto);
    if (mysql_num_rows($result_flag_atividades) == 1) {
        $flag_projeto_finalizado = 1;
    }
} else {
    $executores_da_tarefa_para_stop -=1;
    $atualiza_a_tarefa = "UPDATE tarefas_executa SET quantidade_executores = '$executores_da_tarefa_para_stop' where tarefas_executa.id_projeto = $id_projeto_stop and tarefas_executa.id_veiculo= $id_veiculo_stop and tarefas_executa.id_tarefa = $id_tarefa_stop and tarefas_executa.conclusao_projeto = 'nao concluido'";
    if (!mysqli_query($conexao_select, $atualiza_a_tarefa)) {
        $erro_finaliza++;
    }
}

$atualiza_disponibilidade_funcionario = "UPDATE funcionarios SET disponibilidade = 'inativo' where funcionarios.id_funcionario = $id_funcionario_stop";
if (!mysqli_query($conexao_select, $atualiza_disponibilidade_funcionario)) {
    $erro_finaliza++;
}
$atualiza_o_funcionario = "UPDATE funcionario_executa SET hora_final ='$horaatual',status_funcionario_tarefa = 'nao ativo',status_tarefa = 'pause',flag_tarefa_aberta = 0,flag_tarefa_relatorio = 0 where funcionario_executa.id_projeto = $id_projeto_stop and funcionario_executa.id_veiculo = $id_veiculo_stop and funcionario_executa.id_tarefa = $id_tarefa_stop and funcionario_executa.id_funcionario= $id_funcionario_stop and funcionario_executa.status_tarefa != 'concluida'";

if (!mysqli_query($conexao_select, $atualiza_o_funcionario)) {
    $erro_finaliza++;
}

if ($flag_projeto_finalizado == 1) {
    $atualiza_projeto = "UPDATE projeto_executa SET status ='concluido',horas_final = '$horaatual',data_final = '$data_atual' where projeto_executa.id_projeto = $id_projeto_stop and projeto_executa.id_veiculo = $id_veiculo_stop and projeto_executa.status != 'concluido'";
    $atualiza_as_tarefas = "UPDATE tarefas_executa SET status = 'concluida' where tarefas_executa.id_projeto = $id_projeto_stop and tarefas_executa.id_veiculo= $id_veiculo_stop and tarefas_executa.status != 'concluida'";
    $atualiza_status_tarefas = "UPDATE tarefas_executa SET conclusao_projeto = 'concluido' where tarefas_executa.id_projeto = $id_projeto_stop and tarefas_executa.id_veiculo= $id_veiculo_stop";
    $atualiza_status_tarefas_executa = "UPDATE tarefas_executa SET status_finalizado = 'gestor' where tarefas_executa.status_finalizado != 'funcionario'";
    $atualiza_funcionario_executa = "UPDATE funcionario_executa SET status_tarefa = 'concluida' where funcionario_executa.id_projeto = $id_projeto_stop and funcionario_executa.id_veiculo = $id_veiculo_stop and funcionario_executa.status_tarefa != 'concluida'";
    $atualiza_tarefas_executa_status = "UPDATE tarefas_executa SET status = 'concluida', horas_final = '$horaatual', data_final= '$data_atual',status_finalizado = 'funcionario' where tarefas_executa.id_projeto = $id_projeto_stop and tarefas_executa.id_veiculo= $id_veiculo_stop and tarefas_executa.id_tarefa = $id_tarefa_stop and tarefas_executa.conclusao_projeto = 'nao concluido'";

    if (!mysqli_query($conexao_select, $atualiza_projeto)) {
        $erro_finaliza++;
    }
    if (!mysqli_query($conexao_select, $atualiza_as_tarefas)) {
        $erro_finaliza++;
    }
    if (!mysqli_query($conexao_select, $atualiza_status_tarefas)) {
        $erro_finaliza++;
    }
    if (!mysqli_query($conexao_select, $atualiza_status_tarefas_executa)) {
        $erro_finaliza++;
    }
    if (!mysqli_query($conexao_select, $atualiza_funcionario_executa)) {
        $erro_finaliza++;
    }
    if (!mysqli_query($conexao_select, $atualiza_tarefas_executa_status)) {
        $erro_finaliza++;
    }
}

if ($erro_finaliza == 0) {
    mysqli_commit($conexao_select);
} else {
    mysqli_rollback($conexao_select);
}

?>


