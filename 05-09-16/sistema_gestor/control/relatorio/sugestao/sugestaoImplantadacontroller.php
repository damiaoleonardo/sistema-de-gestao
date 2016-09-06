<?php
include '../../../model/sugestoes/Sugestoes.php';
try {
    $id_sugestao = $_GET['id_sugestao'];
    $sugestoes_implantada = new Sugestoes();
    $sugestoes_implantada->setSugestaoImplantada($id_sugestao);
    echo "Sugestao Implantada com sucesso!";
} catch (Exception $ex) {
    $ex->getMessage();
}
?>

