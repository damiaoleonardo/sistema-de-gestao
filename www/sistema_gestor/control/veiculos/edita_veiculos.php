<?php
include '../../model/veiculos/veiculos.php';
$placa_veiculo = $_POST['letras'] . "-" . $_POST['numeros'];
$nome_veiculo = $_POST['nome'];
$tipo_veiculo = $_POST['tipo_veiculo'];
$veiculos = new veiculos();
session_start("id_veiculo_edit");
 $id_do_veiculo = $_SESSION['id_veiculo'];
if (empty($nome_veiculo) || empty($tipo_veiculo)) {
    echo "<script>alert('Prencha todos os campos');</script>";
} else {
    try {
        $veiculos->setPlaca($placa_veiculo);
        $veiculos->setNome($nome_veiculo, 2);
        $veiculos->setTipo($tipo_veiculo);
        $veiculos->setId($id_do_veiculo);
        $veiculos->AtualizaDados($veiculos);
        echo "<script>alert('Veiculo alterado com sucesso');</script>";
        echo "<script>location.href='../view/telaPrincipal.php?t=veiculos'</script>";
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}
?>
