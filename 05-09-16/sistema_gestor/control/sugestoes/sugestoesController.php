<?php
require '../model/sugestoes/Sugestoes.php';
try {
    $sugestoes = new Sugestoes();
    $sugestoes->getSugestoes();
} catch (Exception $ex) {
    $ex->getMessage();
}
?>

