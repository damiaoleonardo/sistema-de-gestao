<?php
include '../../model/veiculos/veiculos.php';
$placa_veiculo = $_POST['letras'] . "-" . $_POST['numeros'];
$nome_veiculo = $_POST['nome'];
$tipo_veiculo = $_POST['tipo'];
$veiculos = new veiculos();

if (empty($nome_veiculo) || empty($tipo_veiculo)) {
    echo "<script>alert('Prencha todos os campos');</script>";
} else {
    try {
        $veiculos->setPlaca($placa_veiculo);
        $veiculos->setNome($nome_veiculo, 1);
        $veiculos->setTipo($tipo_veiculo);
        if ($veiculos->AddVeiculos($veiculos)) {
             echo "<script>alert('Veiculo salvo com sucesso');</script>";
             echo "<script>location.href='../view/telaPrincipal.php?t=veiculos'</script>";
        } else {
            echo "<script>alert('Ocorreu um erro ao inserir o veiculo!');</script>";
        }
        
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}
?>
