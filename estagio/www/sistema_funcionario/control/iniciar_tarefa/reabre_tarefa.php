<?php
require ('../../model/Conexao/Connection.class.php');
$conexao = Connection::getInstance(); 
$id_tarefa_pausada = $_GET['id'];
$id_projeto_pausado = $_GET['id_projeto'];
$veiculo_pausado = $_GET['veiculo'];
$id_funcionario = $_GET['id_funcionario'];
$data_hoje = date('Y-m-d');
$sql = "SELECT DATE_FORMAT(now(),'%H:%i:%s')";
$result = mysql_query($sql);
$hora_inicio = mysql_fetch_row($result);
$horainicio = $hora_inicio[0];
$sql_id_projeto_executas_tarefa = "select tarefas_executa.id_projeto_executa from tarefas_executa where tarefas_executa.id_projeto = $id_projeto_pausado and tarefas_executa.id_veiculo = $veiculo_pausado and tarefas_executa.conclusao_projeto ='nao concluido'";
$result_id_projeto_executas_tarefa = mysql_query($sql_id_projeto_executas_tarefa);
$id_projeto_executas_tarefa = mysql_fetch_row($result_id_projeto_executas_tarefa);
$id_projetos_executas_tarefa = $id_projeto_executas_tarefa[0];
$sql_data_tarefa = "select funcionario_executa.data_tarefa from funcionario_executa where funcionario_executa.id_projeto = $id_projeto_pausado and funcionario_executa.id_veiculo = $veiculo_pausado and funcionario_executa.id_tarefa = $id_tarefa_pausada and funcionario_executa.id_funcionario = $id_funcionario and funcionario_executa.status_tarefa != 'concluida' and funcionario_executa.status_tarefa != 'open'";
$result_data_tarefa = mysql_query($sql_data_tarefa);
$data_tarefa = mysql_fetch_row($result_data_tarefa);
$data_da_tarefa = $data_tarefa[0];
$sql_status_funci = "select funcionario_executa.id_funcionario from funcionario_executa where funcionario_executa.id_projeto = $id_projeto_pausado and funcionario_executa.id_veiculo = $veiculo_pausado and funcionario_executa.id_tarefa = $id_tarefa_pausada and funcionario_executa.id_funcionario = $id_funcionario and funcionario_executa.status_tarefa != 'concluida' and funcionario_executa.status_tarefa != 'open'";
$result_funci = mysql_query($sql_status_funci);
$status_da_tarefa_func = mysql_fetch_row($result_funci);
$id_do_status_do_funci = $status_da_tarefa_func[0];

$sql_nome_projeto = "select projeto.nome from projeto where projeto.id_projeto = $id_projeto_pausado";
$result_nome_projeto = mysql_query($sql_nome_projeto);
$nome_projeto = mysql_fetch_row($result_nome_projeto);
$nome_do_projeto = $nome_projeto[0];

$sql_nome_veiculo = "select veiculos.nome_veiculo from veiculos where veiculos.id_veiculo = $veiculo_pausado";
$result_nome_veiculo  = mysql_query($sql_nome_veiculo);
$nome_veiculo  = mysql_fetch_row($result_nome_veiculo);
$nome_do_veiculo  = $nome_veiculo[0];
$sql_nome_tarefa = "select tarefas.nome from tarefas where tarefas.id_tarefa = $id_tarefa_pausada";
$result_nome_tarefa  = mysql_query($sql_nome_tarefa);
$nome_tarefa  = mysql_fetch_row($result_nome_tarefa);
$nome_da_tarefa  = $nome_tarefa[0];
$sql_nome_funcionario = "select funcionarios.sobrenome from funcionarios where funcionarios.id_funcionario = $id_funcionario";
$result_nome_funcionario = mysql_query($sql_nome_funcionario);
$nome_funcionario = mysql_fetch_row($result_nome_funcionario);
$nome_do_funcionario = $nome_funcionario[0];

$conexao_select = mysqli_connect("localhost", "root", "","sistema_de_gestao"); 
mysqli_autocommit($conexao_select, FALSE);
$erro_select = 0;

if ($id_do_status_do_funci == $id_funcionario) {
    if ($data_da_tarefa == $data_hoje) {

        $atualiza_funcionario = "UPDATE funcionario_executa SET hora_inicial = '$horainicio', status_funcionario_tarefa = 'ativo',status_tarefa = 'open',flag_tarefa_aberta = 1,flag_tarefa_relatorio = 0 where funcionario_executa.id_projeto=$id_projeto_pausado and funcionario_executa.id_veiculo= $veiculo_pausado and funcionario_executa.id_tarefa= $id_tarefa_pausada and funcionario_executa.id_funcionario=$id_funcionario and funcionario_executa.status_tarefa != 'concluida' and funcionario_executa.flag_tarefa_relatorio = 1";
        if (!mysqli_query($conexao_select, $atualiza_funcionario)) {
            $erro_select++;
        }
    } else {
        $insert_funcionario = "INSERT INTO funcionario_executa (id_projeto_executa,id_projeto,id_veiculo,id_tarefa,id_funcionario,nome_do_projeto,nome_do_veiculo,nome_da_tarefa,nome_do_funcionario,hora_inicial,data_tarefa,status_funcionario_tarefa,status_tarefa,flag_tarefa_aberta,flag_tarefa_relatorio) VALUES ('$id_projetos_executas_tarefa','$id_projeto_pausado','$veiculo_pausado','$id_tarefa_pausada','$id_funcionario','$nome_do_projeto','$nome_do_veiculo','$nome_da_tarefa','$nome_do_funcionario','$horainicio','$data_hoje','ativo','open','1','0')";
        if (!mysqli_query($conexao_select, $insert_funcionario)) {
            $erro_select++;
        }
        $delete_funcionario = "delete from funcionario_executa where funcionario_executa.id_projeto=$id_projeto_pausado and funcionario_executa.id_veiculo= $veiculo_pausado and funcionario_executa.id_tarefa= $id_tarefa_pausada and funcionario_executa.id_funcionario=$id_funcionario and funcionario_executa.status_tarefa != 'concluida' and funcionario_executa.data_tarefa = '$data_da_tarefa' ";
        if (!mysqli_query($conexao_select, $delete_funcionario)) {
            $erro_select++;
        }
    }
} else {
  
    $insere_funcionario = "INSERT INTO funcionario_executa (id_projeto_executa,id_projeto,id_veiculo,id_tarefa,id_funcionario,nome_do_projeto,nome_do_veiculo,nome_da_tarefa,nome_do_funcionario,hora_inicial,data_tarefa,status_funcionario_tarefa,status_tarefa,flag_tarefa_aberta,flag_tarefa_relatorio ) VALUES ('$id_projetos_executas_tarefa','$id_projeto_pausado','$veiculo_pausado','$id_tarefa_pausada','$id_funcionario','$nome_do_projeto','$nome_do_veiculo','$nome_da_tarefa','$nome_do_funcionario','$horainicio','$data_hoje','ativo','open','1','0')";
    if (!mysqli_query($conexao_select, $insere_funcionario)) {
        $erro_select++;
    }
}






$query1 = "UPDATE funcionarios SET disponibilidade = 'ativo' where funcionarios.id_funcionario = $id_funcionario";
$query2 = "UPDATE tarefas_executa SET status = 'open',horas_inicio = '$horainicio' where tarefas_executa.id_tarefa = $id_tarefa_pausada and tarefas_executa.id_projeto = $id_projeto_pausado and tarefas_executa.id_veiculo= $veiculo_pausado and tarefas_executa.conclusao_projeto = 'nao concluido'";

if (!mysqli_query($conexao_select, $query1)) {$erro_select++; }
if (!mysqli_query($conexao_select, $query2)) { $erro_select++; }

if ($erro_select == 0){
   mysqli_commit($conexao_select); 
    echo "Tarefa retornada com sucesso!";
 } else {
    mysqli_rollback($conexao_select);
      echo "Nao foi possivel retornar a tarefa";
} 
?>