<?php

require ('../model/Connection.class.php');
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

$conexao_select = mysqli_connect("localhost", "root", "","sistema de gerenciamento"); 
mysqli_autocommit($conexao_select, FALSE);
$erro_select = 0;

if ($flag_iniciada == 0) {
    $flag_iniciado = "UPDATE projeto_executa SET hora_inicio = '$horainicio',data_inicio = '$data_hoje',quantidades_executores = 1,flag_iniciada = 1 where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $veiculo and projeto_executa.status != 'concluido'";
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
$query2 = "UPDATE tarefas_executa SET status = 'open',horas_inicio = '$horainicio',horas_inicio_tarefa='$horainicio',data_inicio= '$data_hoje' , quantidade_executores = 1 where tarefas_executa.id_tarefa = $id_tarefa and tarefas_executa.id_projeto = $id_projeto and tarefas_executa.id_veiculo= $veiculo and tarefas_executa.conclusao_projeto = 'nao concluido'";
$query3 = "INSERT INTO funcionario_executa (id_projeto_executa,id_projeto,id_veiculo,id_tarefa,id_funcionario,hora_inicial,data_tarefa,status_funcionario_tarefa,status_tarefa,flag_tarefa_aberta,flag_tarefa_relatorio) VALUES ('$id_projetos_executa_tarefa','$id_projeto','$veiculo','$id_tarefa','$id_funcionario','$horainicio','$data_hoje','ativo','open','1','0')"; 
if (!mysqli_query($conexao_select, $query1)) { $erro_select++; }
if (!mysqli_query($conexao_select, $query2)) { $erro_select++; }
if (!mysqli_query($conexao_select, $query3)) { $erro_select++; }
if ($erro_select == 0){
   mysqli_commit($conexao_select); echo "Tarefa Iniciada com sucesso!";
 } else {
   mysqli_rollback($conexao_select);
   echo "Nao foi possivel iniciar a tarefa";
} 











/*
$pdo = new PDO("mysql:host=localhost;dbname=nomeDoBanco", "root", "suaSenha");
if(!$pdo){
    die('Erro ao iniciar a conexão');
}
 
$pdo->beginTransaction();/* Inicia a transação 
$movimento = $pdo->query("INSERT INTO movimentos(idmovimento, data, valor, tipo, idconta) VALUES (1, '2011-12-08', 100, 'entrada', 1)");
 
if(!$movimento){
    die('Erro ao lancar movimento'); /*É disparado em caso de erro na inserção de movimento
}
 
$atualiza_saldo = $pdo->query("UPDATE conta SET saldo = saldo + 100 WHERE idconta = 1");
 
if(!$atualiza_saldo){
    $pdo->rollBack(); /* Desfaz a inserção na tabela de movimentos em caso de erro na query da tabela conta 
    die('Erro ao atualizar saldo');
}
 
$pdo->commit();  Se não houve erro nas querys, confirma os dados no banco 
echo 'Lançamento efetuado com sucesso!';/*



?>
