<?php
require ('../../model/Conexao/Connection.class.php');
$conexao = Connection::getInstance();
$id_tarefa_pausa = $_GET['id'];
$id_projeto_pausa = $_GET['id_projeto'];
$id_projeto_executa_pausa = $_GET['id_projeto_executa'];
$id_veiculo_pausa = $_GET['id_veiculo'];
$id_funcionario_pausa = $_GET['id_funcionario'];
$data_de_hoje = date('Y-m-d');
$sql = "SELECT DATE_FORMAT(now(),'%H:%i:%s')";
$result = mysql_query($sql);
$hora_inicio = mysql_fetch_row($result);
$horainicio = $hora_inicio[0];

$sql_get_quantidade_executores_tarefa = "select tarefas_executa.quantidade_executores from tarefas_executa where tarefas_executa.id_projeto = $id_projeto_pausa and tarefas_executa.id_veiculo = $id_veiculo_pausa and tarefas_executa.id_tarefa = $id_tarefa_pausa and tarefas_executa.conclusao_projeto = 'nao concluido'";
$aux_get_quantidade_executores = mysql_query($sql_get_quantidade_executores_tarefa);
$quantidades_executores_tarefa = mysql_fetch_row($aux_get_quantidade_executores);
$executores_da_tarefa = $quantidades_executores_tarefa[0];


$conexao_select = mysqli_connect("localhost", "root", "", "sistema de gerenciamento");
mysqli_autocommit($conexao_select, FALSE);
$erro_pause = 0;

if ($executores_da_tarefa == 1) {
    $atualiza_tarefas = "UPDATE tarefas_executa SET status = 'pause' where tarefas_executa.id_tarefa = $id_tarefa_pausa and tarefas_executa.id_projeto = $id_projeto_pausa and tarefas_executa.id_veiculo= $id_veiculo_pausa and tarefas_executa.conclusao_projeto = 'nao concluido'";

    if (!mysqli_query($conexao_select, $atualiza_tarefas)) {
        $erro_pause++;
    }
} else {
    $executores_da_tarefa -=1;
    $atualiza_tarefas_executa = "UPDATE tarefas_executa SET quantidade_executores = '$executores_da_tarefa' where tarefas_executa.id_tarefa = $id_tarefa_pausa and tarefas_executa.id_projeto = $id_projeto_pausa and tarefas_executa.id_veiculo= $id_veiculo_pausa and tarefas_executa.conclusao_projeto = 'nao concluido'";
    if (!mysqli_query($conexao_select, $atualiza_tarefas_executa)) {
        $erro_pause++;
    }
}

$atualiza_funcionario = "UPDATE funcionarios SET disponibilidade = 'inativo' where funcionarios.id_funcionario = $id_funcionario_pausa";
$atualiza_funcionario_executa = "UPDATE funcionario_executa SET hora_final = '$horainicio', status_funcionario_tarefa = 'nao ativo',status_tarefa= 'concluida',flag_tarefa_aberta = 0,flag_tarefa_relatorio = 0 where funcionario_executa.id_projeto=$id_projeto_pausa and funcionario_executa.id_veiculo= $id_veiculo_pausa and funcionario_executa.id_tarefa= $id_tarefa_pausa and funcionario_executa.id_funcionario= $id_funcionario_pausa and funcionario_executa.status_funcionario_tarefa = 'ativo' and funcionario_executa.status_tarefa != 'concluida'";
$insere_funcionario = "INSERT INTO funcionario_executa (id_projeto_executa,id_projeto,id_veiculo,id_tarefa,id_funcionario,data_tarefa,status_funcionario_tarefa,status_tarefa,flag_tarefa_aberta,flag_tarefa_relatorio) VALUES ('$id_projeto_executa_pausa','$id_projeto_pausa','$id_veiculo_pausa','$id_tarefa_pausa','$id_funcionario_pausa','$data_de_hoje',' nao ativo','pause','0','1')";

if (!mysqli_query($conexao_select, $atualiza_funcionario)) {
    $erro_pause++;
}
if (!mysqli_query($conexao_select, $atualiza_funcionario_executa)) {
    $erro_pause++;
}
if (!mysqli_query($conexao_select, $insere_funcionario)) {
    $erro_pause++;
}


if ($erro_pause == 0) {
    mysqli_commit($conexao_select);
    echo "Tarefa pausada com sucesso!";
} else {
    mysqli_rollback($conexao_select);
    echo "Nao foi possivel pausar a tarefa";
}
?>
