<?php

require '../model/tela_principal/getInformacoes.php';
try {
    $exibe_projeto = new getInformacoes();
    $exibe_projeto->exibeProjetos($id_funcionario);
} catch (Exception $ex) {
    $ex->getMessage();
}
?>