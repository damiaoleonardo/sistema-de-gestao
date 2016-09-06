<?php
include '../../../model/sugestoes/Sugestoes.php';
try {
    $id_sugestao = $_GET['id_sugestao'];
    $sugestoes_descartada = new Sugestoes();
    $sugestoes_descartada->setSugestaoDescartada($id_sugestao);
    echo "Sugestao descartada com sucesso!";
  } catch (Exception $ex) {
    $ex->getMessage();
}
?>

