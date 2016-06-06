<?php
require ('../../model/Conexao/Connection.class.php');
$conexao = Connection::getInstance();
$id_tarefa_varios_executores = $_GET['id'];
$id_projeto_varios_executores = $_GET['id_projeto'];
$veiculo_varios_executores = $_GET['veiculo'];
$id_funcionario_varios_executores = $_GET['id_funcionario'];
$dataatual = date('Y-m-d');
$sql = "SELECT DATE_FORMAT(now(),'%H:%i:%s')";
$result = mysql_query($sql);
$hora_inicio = mysql_fetch_row($result);
$horainicio = $hora_inicio[0];
$sql_id_projeto_executa_tarefa_abre = "select tarefas_executa.id_projeto_executa from tarefas_executa where tarefas_executa.id_projeto = $id_projeto_varios_executores and tarefas_executa.id_veiculo = $veiculo_varios_executores and tarefas_executa.conclusao_projeto ='nao concluido'";
$result_id_projeto_executa_tarefa_abre = mysql_query($sql_id_projeto_executa_tarefa_abre);
$id_projeto_executa_tarefa_abre = mysql_fetch_row($result_id_projeto_executa_tarefa_abre);
$id_projetos_executa_tarefa_abre = $id_projeto_executa_tarefa_abre[0];
$sql_status_funcio = "select funcionario_executa.id_funcionario from funcionario_executa where funcionario_executa.id_projeto = $id_projeto_varios_executores and funcionario_executa.id_veiculo = $veiculo_varios_executores and funcionario_executa.id_tarefa = $id_tarefa_varios_executores and funcionario_executa.id_funcionario = $id_funcionario_varios_executores and funcionario_executa.status_tarefa != 'concluida' and funcionario_executa.status_tarefa != 'open'";
$result_funcio = mysql_query($sql_status_funcio);
$status_da_tarefa_funcio = mysql_fetch_row($result_funcio);
$id_do_status_do_funcio = $status_da_tarefa_funcio[0];


$sql_nome_projeto = "select projeto.nome from projeto where projeto.id_projeto = $id_projeto_varios_executores";
$result_nome_projeto = mysql_query($sql_nome_projeto);
$nome_projeto = mysql_fetch_row($result_nome_projeto);
$nome_do_projeto = $nome_projeto[0];

$sql_nome_veiculo = "select veiculos.nome_veiculo from veiculos where veiculos.id_veiculo = $veiculo_varios_executores";
$result_nome_veiculo  = mysql_query($sql_nome_veiculo);
$nome_veiculo  = mysql_fetch_row($result_nome_veiculo);
$nome_do_veiculo  = $nome_veiculo[0];
$sql_nome_tarefa = "select tarefas.nome from tarefas where tarefas.id_tarefa = $id_tarefa_varios_executores";
$result_nome_tarefa  = mysql_query($sql_nome_tarefa);
$nome_tarefa  = mysql_fetch_row($result_nome_tarefa);
$nome_da_tarefa  = $nome_tarefa[0];
$sql_nome_funcionario = "select funcionarios.sobrenome from funcionarios where funcionarios.id_funcionario = $id_funcionario_varios_executores";
$result_nome_funcionario = mysql_query($sql_nome_funcionario);
$nome_funcionario = mysql_fetch_row($result_nome_funcionario);
$nome_do_funcionario = $nome_funcionario[0];
$conexao_select = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
mysqli_autocommit($conexao_select, FALSE);
$erro_reabre = 0;


if ($id_do_status_do_funcio == $id_funcionario_varios_executores) {
    $atualiza_funcionario_executa = "UPDATE funcionario_executa SET hora_inicial = '$horainicio', status_funcionario_tarefa = 'ativo',status_tarefa = 'open',flag_tarefa_aberta = 1,flag_tarefa_relatorio = 0 where funcionario_executa.id_projeto=$id_projeto_varios_executores and funcionario_executa.id_veiculo= $veiculo_varios_executores and funcionario_executa.id_tarefa= $id_tarefa_varios_executores and funcionario_executa.id_funcionario=$id_funcionario_varios_executores and funcionario_executa.status_tarefa != 'concluida'";
    if (!mysqli_query($conexao_select, $atualiza_funcionario_executa)) {
        $erro_reabre++;
    }
} else {
   $insere_funcionario_executa = "INSERT INTO funcionario_executa (id_projeto_executa,id_projeto,id_veiculo,id_tarefa,id_funcionario,nome_do_projeto,nome_do_veiculo,nome_da_tarefa,nome_do_funcionario,hora_inicial,data_tarefa,status_funcionario_tarefa,status_tarefa,flag_tarefa_aberta,flag_tarefa_relatorio) VALUES ('$id_projetos_executa_tarefa_abre','$id_projeto_varios_executores','$veiculo_varios_executores','$id_tarefa_varios_executores','$id_funcionario_varios_executores','$nome_do_projeto','$nome_do_veiculo','$nome_da_tarefa','$nome_do_funcionario','$horainicio','$dataatual','ativo','open','1','0')";
    if (!mysqli_query($conexao_select, $insere_funcionario_executa)) {
        $erro_reabre++;
    }
}

$sql_quantidade_executores_tarefa = "select tarefas_executa.quantidade_executores from tarefas_executa where tarefas_executa.id_projeto = $id_projeto_varios_executores and tarefas_executa.id_veiculo = $veiculo_varios_executores and tarefas_executa.id_tarefa = $id_tarefa_varios_executores and tarefas_executa.conclusao_projeto = 'nao concluido'";
$result_executores = mysql_query($sql_quantidade_executores_tarefa);
$quantidade_executores_da_tarefa = mysql_fetch_row($result_executores);
$executores_tarefa = $quantidade_executores_da_tarefa[0];

$executores_tarefa +=1;
$atualiza_tarefas_executa = "UPDATE tarefas_executa SET quantidade_executores = '$executores_tarefa' where tarefas_executa.id_projeto = $id_projeto_varios_executores and tarefas_executa.id_veiculo= $veiculo_varios_executores and tarefas_executa.id_tarefa = $id_tarefa_varios_executores and tarefas_executa.conclusao_projeto = 'nao concluido'";
if (!mysqli_query($conexao_select, $atualiza_tarefas_executa)) {
        $erro_reabre++;
    }
$executores_tarefa = 0;
$sql_quantidade_executores_projeto = "select tarefas_executa.quantidade_executores from tarefas_executa where tarefas_executa.id_projeto = $id_projeto_varios_executores and tarefas_executa.id_veiculo = $veiculo_varios_executores and tarefas_executa.id_tarefa = $id_tarefa_varios_executores and tarefas_executa.conclusao_projeto = 'nao concluido'";
$result_executores_projeto = mysql_query($sql_quantidade_executores_projeto);
$quantidade_executores_do_projeto = mysql_fetch_row($result_executores_projeto);
$executores_projeto = $quantidade_executores_do_projeto[0];

$executores_projeto +=1;

$atualiza_projeto_executa = "UPDATE projeto_executa SET quantidades_executores = '$executores_projeto' where projeto_executa.id_projeto = $id_projeto_varios_executores and projeto_executa.id_veiculo = $veiculo_varios_executores and projeto_executa.status != 'concluido'";
$atualiza_funcionario_disponibilidade = "UPDATE funcionarios SET disponibilidade = 'ativo' where funcionarios.id_funcionario = $id_funcionario_varios_executores";


if (!mysqli_query($conexao_select, $atualiza_projeto_executa)) {
        $erro_reabre++;
    }
if (!mysqli_query($conexao_select, $atualiza_funcionario_disponibilidade)) {
        $erro_reabre++;
    }

$executores_projeto = 0;

if ($erro_reabre == 0){
   mysqli_commit($conexao_select); 
    echo "Tarefa iniciada com sucesso!";
 } else {
    mysqli_rollback($conexao_select);
      echo "Nao foi possivel iniciar a tarefa";
} 
?>

