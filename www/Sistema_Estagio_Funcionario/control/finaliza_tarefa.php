<?php

require ('../model/Connection.class.php');
$conexao = Connection::getInstance();
session_start("dados_tarefas_finaliza");
$id_projetos_finaliza = $_SESSION['projeto'];
$id_tarefas_finaliza = $_SESSION['tarefa'];
$id_funcionarios_finaliza = $_SESSION['funcionario'];
$id_veiculos_finaliza = $_SESSION['veiculo'];
$login = $_SESSION['login'];
$texto = $_POST['texto'];
$data_atual = date('Y-m-d');
$sql = "SELECT DATE_FORMAT(now(),'%H:%i:%s')";
$result_hora = mysql_query($sql);
$hora_atual = mysql_fetch_row($result_hora);
$horaatual = $hora_atual[0];


$sql_get_quantidade_executores_tarefa_para_stop = "select tarefas_executa.quantidade_executores from tarefas_executa where tarefas_executa.id_projeto = $id_projetos_finaliza and tarefas_executa.id_veiculo = $id_veiculos_finaliza and tarefas_executa.id_tarefa = $id_tarefas_finaliza and tarefas_executa.conclusao_projeto = 'nao concluido'";
$aux_get_quantidade_executores_para_stop = mysql_query($sql_get_quantidade_executores_tarefa_para_stop);
$quantidades_executores_tarefa_para_stop = mysql_fetch_row($aux_get_quantidade_executores_para_stop);
$executores_da_tarefa_para_finaliza = $quantidades_executores_tarefa_para_stop[0];


$conexao_select = mysqli_connect("localhost", "root", "", "sistema de gerenciamento");
mysqli_autocommit($conexao_select, FALSE);
$erro_finaliza_manutencao = 0;

if ($executores_da_tarefa_para_finaliza == 1) {
    $atualiza_tarefas_executa = "UPDATE tarefas_executa SET status = 'concluida', horas_final = '$horaatual', data_final= '$data_atual',status_finalizado = 'funcionario' where tarefas_executa.id_projeto = $id_projetos_finaliza and tarefas_executa.id_veiculo= $id_veiculos_finaliza and tarefas_executa.id_tarefa = $id_tarefas_finaliza and tarefas_executa.conclusao_projeto = 'nao concluido' and tarefas_executa.tipo_tarefa = 'liberada'";
    if (!mysqli_query($conexao_select, $atualiza_tarefas_executa)) {
        $erro_finaliza_manutencao++;
    }
} else {
    $executores_da_tarefa_para_finaliza -=1;
    $atualiza_tarefa_executa = "UPDATE tarefas_executa SET quantidade_executores = '$executores_da_tarefa_para_finaliza' where tarefas_executa.id_projeto = $id_projetos_finaliza and tarefas_executa.id_veiculo= $id_veiculos_finaliza and tarefas_executa.id_tarefa = $id_tarefas_finaliza and tarefas_executa.conclusao_projeto = 'nao concluido' and tarefas_executa.tipo_tarefa = 'liberada'";
    if (!mysqli_query($conexao_select, $atualiza_tarefa_executa)) {
        $erro_finaliza_manutencao++;
    }
}

$atualiza_tarefas_executas = "UPDATE tarefas_executa SET descricao_da_tarefa= '$texto' where tarefas_executa.id_projeto = $id_projetos_finaliza and tarefas_executa.id_veiculo= $id_veiculos_finaliza and tarefas_executa.id_tarefa = $id_tarefas_finaliza and tarefas_executa.conclusao_projeto = 'nao concluido' and tarefas_executa.tipo_tarefa = 'liberada' ";
$atualiza_funcionario_disponibilidade = "UPDATE funcionarios SET disponibilidade = 'inativo' where funcionarios.id_funcionario = $id_funcionarios_finaliza";

$atualiza_tarefa_da_execucao = "UPDATE tarefas_executa SET status = 'concluida', horas_final = '$horaatual', data_final= '$data_atual',status_finalizado = 'funcionario' where tarefas_executa.id_projeto = $id_projetos_finaliza and tarefas_executa.id_veiculo= $id_veiculos_finaliza and tarefas_executa.id_tarefa = $id_tarefas_finaliza and tarefas_executa.conclusao_projeto = 'nao concluido' and tarefas_executa.tipo_tarefa = 'liberada'";

$atualiza_funcionario_executa = "UPDATE funcionario_executa SET hora_final = '$horaatual', status_funcionario_tarefa = 'nao ativo',status_tarefa = 'concluida',flag_tarefa_aberta = 0,flag_tarefa_relatorio = 0 where funcionario_executa.id_projeto = $id_projetos_finaliza and funcionario_executa.id_veiculo = $id_veiculos_finaliza and funcionario_executa.id_tarefa = $id_tarefas_finaliza and funcionario_executa.id_funcionario= $id_funcionarios_finaliza and funcionario_executa.status_tarefa != 'concluida'";



if (!mysqli_query($conexao_select, $atualiza_tarefas_executas)) {
    $erro_finaliza_manutencao++;
}
if (!mysqli_query($conexao_select, $atualiza_funcionario_disponibilidade)) {
    $erro_finaliza_manutencao++;
}
if (!mysqli_query($conexao_select, $atualiza_tarefa_da_execucao)) {
    $erro_finaliza_manutencao++;
}
if (!mysqli_query($conexao_select, $atualiza_funcionario_executa)) {
    $erro_finaliza_manutencao++;
}


$cont_tarefas_finaliza = 0;
$sql_status_do_projeto = "select tarefas_executa.status from tarefas_executa where tarefas_executa.id_projeto = $id_projetos_finaliza and tarefas_executa.id_veiculo= $id_veiculo_stop and tarefas_executa.status != 'concluida'";
$result = mysql_query($sql_status_do_projeto);
while ($aux_result = mysql_fetch_array($result)) {
    $cont_tarefas_finaliza ++;
}

if ($cont_tarefas_finaliza == 0) {
    $update_projeto_executa = "UPDATE projeto_executa SET status = 'concluido',horas_final = '$horaatual',data_final = '$data_atual' where projeto_executa.id_projeto = $id_projetos_finaliza and projeto_executa.id_veiculo = $id_veiculos_finaliza and projeto_executa.status != 'concluido'";
    $update_tarefa_executa = "UPDATE tarefas_executa SET status = 'concluida' where tarefas_executa.id_projeto = $id_projetos_finaliza and tarefas_executa.id_veiculo= $id_veiculos_finaliza and tarefas_executa.status != 'concluida'";
    $update_tarefas_executa = "UPDATE tarefas_executa SET conclusao_projeto = 'concluido' where tarefas_executa.id_projeto = $id_projetos_finaliza and tarefas_executa.id_veiculo= $id_veiculos_finaliza";
    $update_atividade_executa = "UPDATE tarefas_executa SET status_finalizado = 'gestor' where tarefas_executa.status_finalizado != 'funcionario'";
    $update_funcionario_executa = "UPDATE funcionario_executa SET status_tarefa = 'concluida' where funcionario_executa.id_projeto = $id_projetos_finaliza and funcionario_executa.id_veiculo = $id_veiculos_finaliza and funcionario_executa.status_tarefa != 'concluida'";
    $update_tarefas_executas = "UPDATE tarefas_executa SET status = 'concluida', horas_final = '$horaatual', data_final= '$data_atual',status_finalizado = 'funcionario' where tarefas_executa.id_projeto = $id_projetos_finaliza and tarefas_executa.id_veiculo= $id_veiculos_finaliza and tarefas_executa.id_tarefa = $id_tarefas_finaliza and tarefas_executa.conclusao_projeto = 'nao concluido'";

    if (!mysqli_query($conexao_select, $update_projeto_executa)) {
        $erro_finaliza_manutencao++;
    }
    if (!mysqli_query($conexao_select, $update_tarefa_executa)) {
        $erro_finaliza_manutencao++;
    }
    if (!mysqli_query($conexao_select, $update_tarefas_executa)) {
        $erro_finaliza_manutencao++;
    }
    if (!mysqli_query($conexao_select, $update_atividade_executa)) {
        $erro_finaliza_manutencao++;
    }
    if (!mysqli_query($conexao_select, $update_funcionario_executa)) {
        $erro_finaliza_manutencao++;
    }
    if (!mysqli_query($conexao_select, $update_tarefas_executas)) {
        $erro_finaliza_manutencao++;
    }
}

if ($erro_finaliza_manutencao == 0){
    mysqli_commit($conexao_select); 
    echo "Tarefa Iniciada com sucesso!";
 } else {
    mysqli_rollback($conexao_select);
    echo "Nao foi possivel iniciar a tarefa";
} 

echo "<script>location.href='../view/tela_principal.php?t=visualiza_tarefas&login=$login&id=$id_projetos_finaliza&veiculo=$id_veiculos_finaliza'</script>";
?>
