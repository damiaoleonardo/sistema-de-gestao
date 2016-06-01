<?php
session_start();
$meta_semanal = $_SESSION['campo_select_meta'];
$semana_num = $_SESSION['campo_select_semana'];
$periodo_inicio = $_SESSION['data_inicio'];
$periodo_final = $_SESSION['data_final'];
$veiculo = $_SESSION['veiculos'];
include '../model/indicador_semanal/indicadorSemanal.php';
$indicador_semanal = new indicadorSemanal();
try {
    $indicador_semanal->setmeta($meta_semanal);
    $indicador_semanal->setSemana($semana_num);
    $indicador_semanal->setInicio($periodo_inicio);
    $indicador_semanal->setFinal($periodo_final);
    $indicador_semanal->setVeiculos($veiculo);
    $indicador_semanal->porcentagemAtingida($indicador_semanal);    
} catch (Exception $ex) {
    $ex->getMessage();
}
?>

