<?php
session_start("dia_semana");
$dia_semanal = $_SESSION['dia'];
include '../model/programacao_semanal/programacaoSemanal.php';
$dia_semana = new programacaoSemanal();
$dia_semana->setDia_semana($dia_semanal);
$dia_semana->montaDia($dia_semana);
?>

