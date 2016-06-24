<?php
include '../../model/tarefas/tarefa.php';
  $tarefa = new Tarefa();
  $nome_tarefa = $_POST['nome_tarefa'];
  $duracao_hora = $_POST['duracao'];
  $certificador = $_POST['id_funcionario'];
  $descricao = $_POST['descricao'];
  if (empty($nome_tarefa) || empty($duracao_hora) || empty($certificador) || empty($descricao)) {
    echo "<script>alert('Prencha todos os campos');</script>";
} else {
    try {
        $tarefa->setNome($nome_tarefa,1);
        $tarefa->setDuracao($duracao_hora);
        $tarefa->setCertificador($certificador);
        $tarefa->setDescricao($descricao);
       if($tarefa->addTarefa($tarefa)){
          echo "<script>alert('Tarefa salva com sucesso');</script>";
          echo "<script>location.href='../view/telaprincipal.php?t=/tarefas'</script>";
       }else{
           echo "<script>alert('Ocorreu algum problema');</script>"; 
       }
     } catch (Exception $ex) {
        echo $ex->getMessage(); 
    }
}
  
?>
