<?php
include '../../model/veiculos/veiculos.php';
$placa_veiculo_atualiza = $_POST['letras_atualiza'] . "-" . $_POST['numeros_atualiza'];
$nome_veiculo_atualiza = $_POST['nome_atualiza'];
$tipo_veiculo_atualiza = $_POST['tipo_veiculo_atualiza'];
$veiculos_atualiza = new veiculos();
session_start("id_veiculo_edit");
$id_do_veiculo_atualiza = $_SESSION['id_veiculo'];

if (empty($nome_veiculo_atualiza) || empty($tipo_veiculo_atualiza)) {
    echo "<script>alert('Prencha todos os campos');</script>";
} else {
    try {
        $veiculos_atualiza->setId($id_do_veiculo_atualiza);
        $veiculos_atualiza->setPlaca($placa_veiculo_atualiza);
        $veiculos_atualiza->setNome($nome_veiculo_atualiza, 2);
        $veiculos_atualiza->setTipo($tipo_veiculo_atualiza);
        if ($veiculos_atualiza->AtualizaDados($veiculos_atualiza)) {
        echo "<script>alert('Veiculo alterado com sucesso');</script>";
        echo "<script>location.href='../view/telaPrincipal.php?t=veiculos'</script>";
        } else {
            echo "<script>alert('Ocorreu um erro na atualização do veiculo!');</script>";
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}
?>
