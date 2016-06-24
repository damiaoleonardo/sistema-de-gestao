<?php

include('../../model/sugestao/sugestao.php');
$nome_da_sugestao = $_POST['nome_da_sugestao'];
$como_e_hoje = $_POST['como_e_hoje'];
$como_deve_ser = $_POST['como_deve_ser'];
session_start("id_funcionario");
$id_do_func = $_SESSION['id_do_funcionario'];


if (empty($nome_da_sugestao) || empty($como_e_hoje) || empty($como_deve_ser)) {
    echo "<script>alert('Por Favor preencha todos os campos necessarios!')</script>";
} else {
    try {
        $sugestao = new sugestao();
        $sugestao->setNome_da_sugestao($nome_da_sugestao);
        $sugestao->setComo_e_hoje($como_e_hoje);
        $sugestao->setComo_deve_ser($como_deve_ser);
        $sugestao->setId_funcionario($id_do_func);
        $sugestao->addSugestao($sugestao);
        echo "<script>alert('Sugestão enviada com sucesso!')</script>";
        echo "<script>location.href='telaPrincipal.php?t=visualiza_projeto'</script>";
    } catch (Exception $ex) {
        $ex->getMessage();
    }
}
?>
