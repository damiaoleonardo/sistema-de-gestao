<?php

include '../../model/projetos/projetos.php';
$projeto_atualiza = new Projetos();
$nome_projeto_atualiza = $_POST['nome_projeto_atualiza'];
$ugb_atualiza = $_POST['ugb_atualiza'];
$descricao_atualiza = $_POST['descricao_atualiza'];
$checkbox_atualiza = $_POST['id_tarefa_atualiza'];
session_start("dados_projeto");
$id_projeto_atualiza = $_SESSION['id_do_projeto'];

if (empty($nome_projeto_atualiza) || empty($descricao_atualiza) || empty($ugb_atualiza) || empty($checkbox_atualiza) || empty($id_projeto_atualiza)){
    echo "<script>alert('Prencha todos os campos');</script>";
} else {
    try {
        $projeto_atualiza->setId_projeto($id_projeto_atualiza);
        $projeto_atualiza->setNome_projeto($nome_projeto_atualiza, 2);
        $projeto_atualiza->setUgb($ugb_atualiza);
        $projeto_atualiza->setDescricao($descricao_atualiza);
        $projeto_atualiza->setTarefas($checkbox_atualiza);
        if ($projeto_atualiza->Atualizar_projeto($projeto_atualiza)) {
            echo "<script>alert('Projeto salvo com sucesso');</script>";
            echo "<script>location.href='../view/telaPrincipal.php?t=projetos'</script>";
         } else {
            echo "<script>alert('Ocorreu um erro!');</script>";
       }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}
?>