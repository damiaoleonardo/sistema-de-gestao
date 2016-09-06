<?php
    require '../../model/controle-manutencao/ControleManutencao.php';
    $controle = new ControleManutencao();
    $id_veiculo = $_POST['veiculo'];
    $controle->tabelaVeiculoControle_inspecao($id_veiculo);
?>
