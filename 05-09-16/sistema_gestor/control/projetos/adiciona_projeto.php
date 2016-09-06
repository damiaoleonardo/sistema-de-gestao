<?php
include '../../model/projetos/projetos.php';
$projeto = new Projetos();
$nome_projeto = $_POST['nome_projeto'];
$ugb = $_POST['ugb'];
$descricao = $_POST['descricao'];
$checkbox = $_POST['id_tarefa'];

if (empty($nome_projeto) || empty($descricao) || empty($ugb) || empty($checkbox)) {
    echo "<script>alert('Prencha todos os campos');</script>";
} else {
    try {
        $projeto->setNome_projeto($nome_projeto, 1);
        $projeto->setUgb($ugb);
        $projeto->setDescricao($descricao);
        $projeto->setTarefas($checkbox);
        if ($projeto->Addprojeto($projeto)) {
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