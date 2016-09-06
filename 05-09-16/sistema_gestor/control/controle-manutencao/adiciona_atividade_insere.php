<?php
include '../../model/controle-manutencao/ControleManutencao.php';
$controle = new ControleManutencao();
session_start("identificador_veiculo");
$id_do_veiculo = $_SESSION['id_veiculo'];
echo $id_atividade_insere = $_POST['adiciona_atividade_controle'];
if (empty($id_atividade_insere)){
    echo "<script>alert('Por favor preencha o campo da atividade!');</script>";
} else {
    try {
        if ($controle->addAtividade_controle($id_do_veiculo, $id_atividade_insere)) {
            echo "<script>alert('Atividade salva com sucesso');</script>";
            echo "<script>location.href='telaPrincipal.php?t=controle-manutencao-preventiva&flag_atividade=1'</script>";
        } else {
            echo "<script>alert('Ocorreu algum problema ao inserir a atividade ao controle');</script>";
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}
?>
