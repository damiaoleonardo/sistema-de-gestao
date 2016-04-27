<?php

require ('../../../model/relatorios/funcionario/funcionario_periodo.php');
require ('../../../model/relatorios/mensagens/Mensagens.php');
$funcionario = new funcionario_periodo();
$mensagem = new Mensagens();
$id_funcionario = $_POST['campo_select_funcionario'];
$data_inicio = $_POST['select_dataI'];
$data_final = $_POST['select_dataF'];

if (empty($id_funcionario)) {
    echo $print_retorno = $mensagem->MensagemCampoVazio();
} else {
    if (empty($data_inicio)) {
        echo $print_retorno = $mensagem->MensagemCampoVazio();
    } else if (empty($data_final)) {
        try {
            $funcionario->setId_funcionario($id_funcionario);
            $funcionario->setData_inicio($data_inicio);
            $funcionario->MontaTabelaInformacaoDia($funcionario);
        } catch (Exception $ex) {
            echo $ex->getMessage(); 
        }
    } else {
        try {
            $funcionario->setId_funcionario($id_funcionario);
            $funcionario->setData_inicio($data_inicio);
            $funcionario->setData_final($data_final);
            $funcionario->MontaTabelaInformacaoPeriodo($funcionario);
        } catch (Exception $ex) {
            echo $ex->getMessage(); 
        }
    }
}
?>
