<?php
$conexao_select_finaliza = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
mysqli_autocommit($conexao_select_finaliza, FALSE);
$erro_finaliza_tarefa = 0;

$id_projeto_stop = $_GET['id_projeto'];
$id_veiculo_stop = $_GET['id_veiculo'];
$id_tarefa_stop = $_GET['id_tarefa'];
$id_projeto_executa_stop = $_GET['id_projeto_executa'];
$id_funcionario_stop = $_GET['id_funcionario'];
$data_atual = date('Y-m-d');
$sql_finaliza = "SELECT DATE_FORMAT(now(),'%H:%i:%s')";
$query_hora_finaliza = mysqli_query($conexao_select_finaliza, $sql_finaliza);
if (!$query_hora_finaliza) {
    $erro_finaliza_tarefa++;
 }
$hora_atual = mysqli_fetch_row($query_hora_finaliza);
$horaatual = $hora_atual[0];

$sql_quantidade_executores_finaliza = "SELECT funcionario_executa.id_funcionario FROM funcionario_executa WHERE funcionario_executa.status_funcionario_tarefa = 'ativo' and funcionario_executa.id_projeto_executa = $id_projeto_executa_stop and funcionario_executa.id_projeto = $id_projeto_stop and funcionario_executa.id_veiculo = $id_veiculo_stop and funcionario_executa.id_tarefa = $id_tarefa_stop";
$query_id_funcionario_finaliza = mysqli_query($conexao_select_finaliza, $sql_quantidade_executores_finaliza);
if (!$query_id_funcionario_finaliza) {
    $erro_finaliza_tarefa++;
}
$quantidades_executores_finaliza = mysqli_num_rows($query_id_funcionario_finaliza);

$sql_quantidade_executores_finaliza_projeto = "select tarefas_executa.id_tarefa from tarefas_executa where tarefas_executa.id_projeto_executa = $id_projeto_executa_stop and tarefas_executa.id_projeto = $id_projeto_stop and tarefas_executa.id_veiculo = $id_veiculo_stop and tarefas_executa.status != 'concluida' ";
$query_id_tarefa_finaliza = mysqli_query($conexao_select_finaliza, $sql_quantidade_executores_finaliza_projeto);
if (!$query_id_tarefa_finaliza) {
    $erro_finaliza_tarefa++;
}
$quantidades_executores_finaliza_projeto = mysqli_num_rows($query_id_tarefa_finaliza);
    if ($quantidades_executores_finaliza == 1) {
        $atualiza_tarefa = "UPDATE tarefas_executa SET status = 'concluida', horas_final = '$horaatual', data_final= '$data_atual',status_finalizado = 'funcionario' where tarefas_executa.id_projeto_executa = $id_projeto_executa_stop and tarefas_executa.id_projeto = $id_projeto_stop and tarefas_executa.id_veiculo= $id_veiculo_stop and tarefas_executa.id_tarefa = $id_tarefa_stop and tarefas_executa.conclusao_projeto = 'nao concluido'";
        if (!mysqli_query($conexao_select_finaliza, $atualiza_tarefa)) {
            $erro_finaliza_tarefa++;
        }
    }

    $atualiza_disponibilidade_funcionario = "UPDATE funcionarios SET disponibilidade = 'inativo' where funcionarios.id_funcionario = $id_funcionario_stop";
    if (!mysqli_query($conexao_select_finaliza, $atualiza_disponibilidade_funcionario)) {
        $erro_finaliza_tarefa++;
    }

    $atualiza_o_funcionario = "UPDATE funcionario_executa SET hora_final ='$horaatual',status_funcionario_tarefa ='nao ativo',status_tarefa = 'concluida',flag_tarefa_aberta = 0,flag_tarefa_relatorio = 0 where funcionario_executa.id_projeto_executa = $id_projeto_executa_stop and funcionario_executa.id_projeto = $id_projeto_stop and funcionario_executa.id_veiculo = $id_veiculo_stop and funcionario_executa.id_tarefa = $id_tarefa_stop and funcionario_executa.id_funcionario= $id_funcionario_stop and funcionario_executa.status_tarefa != 'concluida'";
    if (!mysqli_query($conexao_select_finaliza, $atualiza_o_funcionario)) {
        $erro_finaliza_tarefa++;
    }

    if ($quantidades_executores_finaliza_projeto == 1 && $quantidades_executores_finaliza == 1) {
        $atualiza_projeto = "UPDATE projeto_executa SET status ='concluido',horas_final = '$horaatual',data_final = '$data_atual' where projeto_executa.id_projeto_executa = $id_projeto_executa_stop and projeto_executa.id_projeto = $id_projeto_stop and projeto_executa.id_veiculo = $id_veiculo_stop and projeto_executa.status != 'concluido'";
        $atualiza_as_tarefas = "UPDATE tarefas_executa SET status = 'concluida' where tarefas_executa.id_projeto_executa = $id_projeto_executa_stop and tarefas_executa.id_projeto = $id_projeto_stop and tarefas_executa.id_veiculo= $id_veiculo_stop and tarefas_executa.status != 'concluida'";
        $atualiza_status_tarefas = "UPDATE tarefas_executa SET conclusao_projeto = 'concluido' where tarefas_executa.id_projeto_executa = $id_projeto_executa_stop and tarefas_executa.id_projeto = $id_projeto_stop and tarefas_executa.id_veiculo= $id_veiculo_stop";
        $atualiza_status_tarefas_executa = "UPDATE tarefas_executa SET status_finalizado = 'gestor' where tarefas_executa.status_finalizado != 'funcionario'";
        $atualiza_funcionario_executa = "UPDATE funcionario_executa SET status_tarefa = 'concluida' where funcionario_executa.id_projeto_executa = $id_projeto_executa_stop and funcionario_executa.id_projeto = $id_projeto_stop and funcionario_executa.id_veiculo = $id_veiculo_stop and funcionario_executa.status_tarefa != 'concluida'";
        $atualiza_tarefas_executa_status = "UPDATE tarefas_executa SET status = 'concluida', horas_final = '$horaatual', data_final= '$data_atual',status_finalizado = 'funcionario' where tarefas_executa.id_projeto_executa = $id_projeto_executa_stop and tarefas_executa.id_projeto = $id_projeto_stop and tarefas_executa.id_veiculo= $id_veiculo_stop and tarefas_executa.id_tarefa = $id_tarefa_stop and tarefas_executa.conclusao_projeto = 'nao concluido'";

        if (!mysqli_query($conexao_select_finaliza, $atualiza_projeto)) {
            $erro_finaliza_tarefa++;
        }
        if (!mysqli_query($conexao_select_finaliza, $atualiza_as_tarefas)) {
            $erro_finaliza_tarefa++;
        }
        if (!mysqli_query($conexao_select_finaliza, $atualiza_status_tarefas)) {
            $erro_finaliza_tarefa++;
        }
        if (!mysqli_query($conexao_select_finaliza, $atualiza_status_tarefas_executa)) {
            $erro_finaliza_tarefa++;
        }
        if (!mysqli_query($conexao_select_finaliza, $atualiza_funcionario_executa)) {
            $erro_finaliza_tarefa++;
        }
        if (!mysqli_query($conexao_select_finaliza, $atualiza_tarefas_executa_status)) {
            $erro_finaliza_tarefa++;
        }
    }

    if ($erro_finaliza_tarefa == 0) {
        mysqli_commit($conexao_select_finaliza);
    } else {
        mysqli_rollback($conexao_select_finaliza);
    }

?>


