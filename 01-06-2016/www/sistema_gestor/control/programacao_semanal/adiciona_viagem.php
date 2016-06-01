<?php
$motoristaA = $_POST['motoristaA'];
$motoristaB = $_POST['motoristaB'];
$veiculo = $_POST['veiculo'];
$rota = $_POST['rota'];
include '../../model/programacao_semanal/programacaoSemanal.php';
$adiciona_viagem = new programacaoSemanal();
if(empty($motoristaA) && empty($motoristaB)){
    echo "<script>alert('Motorista nao selecionado')</script>";
}else{
try {
   $adiciona_viagem->setMotoristaA($motoristaA);
   $adiciona_viagem->setMotoristaB($motoristaB);
   $adiciona_viagem->setRota($rota);
   $adiciona_viagem->setVeiculo($veiculo);
   $adiciona_viagem->adicionaViagem($adiciona_viagem);
} catch (Exception $ex) {
    $ex->getMessage();
}
}
?>
