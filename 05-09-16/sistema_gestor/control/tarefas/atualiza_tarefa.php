<?php

include '../../model/tarefas/tarefa.php';
$tarefa_atualiza = new Tarefa();
$nome_tarefa_atualiza = $_POST['nome_tarefa_atualiza'];
$duracao_hora_atualiza = $_POST['duracao_atualiza'];
$certificador_atualiza = $_POST['id_funcionario_atualiza'];
$descricao_atualiza = $_POST['descricao_atualiza'];
session_start("dados_tarefa");
$id_da_tarefa_atualiza = $_SESSION['id_da_tarefa'];

if (empty($nome_tarefa_atualiza) || empty($duracao_hora_atualiza) || empty($certificador_atualiza) || empty($descricao_atualiza) || empty($id_da_tarefa_atualiza)) {
    echo "<script>alert('Prencha todos os campos');</script>";
} else {
    try {
        $tarefa_atualiza->setId_tarefa($id_da_tarefa_atualiza);
        $tarefa_atualiza->setNome($nome_tarefa_atualiza, 2);
        $tarefa_atualiza->setDuracao($duracao_hora_atualiza);
        $tarefa_atualiza->setCertificador($certificador_atualiza);
        $tarefa_atualiza->setDescricao($descricao_atualiza);
        if ($tarefa_atualiza->atualizaTarefa($tarefa_atualiza)) {
            echo "<script>alert('Tarefa salva com sucesso');</script>";
            echo "<script>location.href='../view/telaPrincipal.php?t=tarefas'</script>";
        } else {
            echo "<script>alert('Ocorreu algum problema ao inserir a tarefa');</script>";
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}
?>
