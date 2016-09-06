<?php
include '../../model/controle-manutencao/ControleManutencao.php';
$controle = new ControleManutencao();
$id_projeto_update = $_POST['projeto_update'];
$tipo_atividade_update = $_POST['campo_select_tipo_update'];

if (empty($id_projeto_update) || empty($tipo_atividade_update)) {
    echo "<script>alert('Prencha todos os campos');</script>";
} else {
    try {
        if ($controle->updateAtividade($id_projeto_update, $tipo_atividade_update)) {
            echo "<script>alert('Atividade alterada com sucesso');</script>";
            echo "<script>location.href='telaPrincipal.php?t=atividades-controle'</script>";
        } else {
            echo "<script>alert('Ocorreu algum problema ao inserir a atividade');</script>";
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}
?>
