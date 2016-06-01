<?php
require ('../../model/Conexao/Connection.class.php');
$conexao = Connection::getInstance();
$id_tarefa = $_GET['id'];
$id_projeto = $_GET['id_projeto'];
$veiculo = $_GET['veiculo'];
$id_funcionario = $_GET['id_funcionario'];
$data_hoje = date('Y-m-d');
$sql = "SELECT DATE_FORMAT(now(),'%H:%i:%s')";
$result = mysql_query($sql);
$hora_inicio = mysql_fetch_row($result);
$horainicio = $hora_inicio[0];
$sql_nome_projeto = "select projeto.nome from projeto where projeto.id_projeto = $id_projeto";
$result_nome_projeto = mysql_query($sql_nome_projeto);
$nome_projeto = mysql_fetch_row($result_nome_projeto);
$nome_do_projeto = $nome_projeto[0];

$sql_nome_veiculo = "select veiculos.nome_veiculo from veiculos where veiculos.id_veiculo = $veiculo";
$result_nome_veiculo  = mysql_query($sql_nome_veiculo);
$nome_veiculo  = mysql_fetch_row($result_nome_veiculo);
$nome_do_veiculo  = $nome_veiculo[0];
$sql_nome_tarefa = "select tarefas.nome from tarefas where tarefas.id_tarefa = $id_tarefa";
$result_nome_tarefa  = mysql_query($sql_nome_tarefa);
$nome_tarefa  = mysql_fetch_row($result_nome_tarefa);
$nome_da_tarefa  = $nome_tarefa[0];
$sql_nome_funcionario = "select funcionarios.sobrenome from funcionarios where funcionarios.id_funcionario = $id_funcionario";
$result_nome_funcionario = mysql_query($sql_nome_funcionario);
$nome_funcionario = mysql_fetch_row($result_nome_funcionario);
$nome_do_funcionario = $nome_funcionario[0];
$sql_id_projeto_executa_tarefa = "select tarefas_executa.id_projeto_executa from tarefas_executa where tarefas_executa.id_projeto = $id_projeto and tarefas_executa.id_veiculo = $veiculo and tarefas_executa.conclusao_projeto ='nao concluido'";
$result_id_projeto_executa_tarefa = mysql_query($sql_id_projeto_executa_tarefa);
$id_projeto_executa_tarefa = mysql_fetch_row($result_id_projeto_executa_tarefa);
$id_projetos_executa_tarefa = $id_projeto_executa_tarefa[0];
$sql_projeto_iniciado = "select projeto_executa.flag_iniciada,projeto_executa.quantidades_executores from projeto_executa where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $veiculo and projeto_executa.status !='concluido'";
$result_projeto =  mysql_query($sql_projeto_iniciado);
while ($aux_projeto_iniciado = mysql_fetch_array($result_projeto)) {
    $flag_iniciada = $aux_projeto_iniciado['flag_iniciada'];
    $quantidade_executores = $aux_projeto_iniciado['quantidades_executores'];
}
$conexao_select = mysqli_connect("localhost", "root", "","sistema_de_gestao"); 
mysqli_autocommit($conexao_select, FALSE);
$erro_select = 0;

if ($flag_iniciada == 0) {
    $flag_iniciado = "UPDATE projeto_executa SET hora_inicio = '$horainicio',data_inicio = '$data_hoje',quantidades_executores = 1,id_funcionario= '$id_funcionario',flag_iniciada = 1 where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $veiculo and projeto_executa.status != 'concluido'";
  if (!mysqli_query($conexao_select, $flag_iniciado)){
      $erro_select++;
  }  
} else {
    $quantidade_executores +=1;
    $flag_ja_iniciado = "UPDATE projeto_executa SET quantidades_executores = '$quantidade_executores' where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $veiculo and projeto_executa.status != 'concluido'";
    if (!mysqli_query($conexao_select, $flag_ja_iniciado)){  
        $erro_select++; 
        }      
   }

$query1 = "UPDATE funcionarios SET disponibilidade = 'ativo' where funcionarios.id_funcionario = $id_funcionario";
$query2 = "UPDATE tarefas_executa SET status = 'open',horas_inicio = '$horainicio',horas_inicio_tarefa='$horainicio',data_inicio= '$data_hoje' ,id_funcionario= '$id_funcionario', quantidade_executores = 1 where tarefas_executa.id_tarefa = $id_tarefa and tarefas_executa.id_projeto = $id_projeto and tarefas_executa.id_veiculo= $veiculo and tarefas_executa.conclusao_projeto = 'nao concluido'";
$query3 = "INSERT INTO funcionario_executa (id_projeto_executa,id_projeto,id_veiculo,id_tarefa,id_funcionario,nome_do_projeto,nome_do_veiculo,nome_da_tarefa,nome_do_funcionario,hora_inicial,data_tarefa,status_funcionario_tarefa,status_tarefa,flag_tarefa_aberta,flag_tarefa_relatorio) VALUES ('$id_projetos_executa_tarefa','$id_projeto','$veiculo','$id_tarefa','$id_funcionario','$nome_do_projeto','$nome_do_veiculo','$nome_da_tarefa','$nome_do_funcionario','$horainicio','$data_hoje','ativo','open','1','0')"; 
if (!mysqli_query($conexao_select, $query1)) { $erro_select++; }
if (!mysqli_query($conexao_select, $query2)) { $erro_select++; }
if (!mysqli_query($conexao_select, $query3)) { $erro_select++; }
if ($erro_select == 0){
   mysqli_commit($conexao_select); echo "Tarefa Iniciada com sucesso!";
 } else {
   mysqli_rollback($conexao_select);
   echo "Nao foi possivel iniciar a tarefa";
} 


