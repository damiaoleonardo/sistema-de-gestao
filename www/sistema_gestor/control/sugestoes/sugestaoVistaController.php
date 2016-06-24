<?php
include '../../model/sugestoes/Sugestoes.php';
try {
    $id_sugestao = $_GET['id_sugestao'];
    $sugestoes_lida = new Sugestoes();
    $sugestoes_lida->setSugestaoVista($id_sugestao);
    echo "Sugestao lida";
} catch (Exception $ex) {
    $ex->getMessage();
}
?>

