<?php

require '../../../model/relatorios/projetos/projetos_tarefas.php';
$relatorios_projetos = new projetos_tarefas();
$id_projeto = $_POST['campo_select_projeto'];
$id_veiculo = $_POST['campo_select_veiculo'];
$id_tipo = $_POST['campo_select_tipo'];
$data_inicio = $_POST['data_inicio'];
$data_final = $_POST['data_final'];

if(empty($id_projeto) and empty($id_veiculo) and empty($id_funcionario) and empty($id_tipo) and empty($data_inicio) and empty($data_final)){
    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Por Favor preencha algum campo!</p>";
}else{
    if(empty($id_veiculo ) and empty($id_tipo)){ // tras todos os projetos executados em um periodo por nome
        if(empty($data_inicio) and empty($data_final)){
           $relatorios_projetos->setId_projeto($id_projeto);
           $sql = $relatorios_projetos->projetos($relatorios_projetos);
           $relatorios_projetos->montaTabela($sql);
        }else if(!empty($data_inicio)and !empty($data_final)) {
           $relatorios_projetos->setId_projeto($id_projeto);
           $relatorios_projetos->setData_inicial($data_inicio);
           $relatorios_projetos->setData_final($data_final);
           $sql = $relatorios_projetos->projetosDatas($relatorios_projetos);
           $relatorios_projetos->montaTabela($sql);
        }else{
             echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
        }
    }else if(empty($id_projeto ) and empty($id_tipo)){ // tras todos os projetos executados em um periodo por veiculo
        if(empty($data_inicio) and empty($data_final)){
           $relatorios_projetos->setId_veiculo($id_veiculo);
           $sql = $relatorios_projetos->veiculos($relatorios_projetos);
           $relatorios_projetos->montaTabela($sql);
        }else if(!empty($data_inicio)and !empty($data_final)) {
           $relatorios_projetos->setId_veiculo($id_veiculo);
           $relatorios_projetos->setData_inicial($data_inicio);
           $relatorios_projetos->setData_final($data_final);
           $sql = $relatorios_projetos->veiculosDatas($relatorios_projetos);
           $relatorios_projetos->montaTabela($sql);
        }else{
             echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
        }
    }else if(empty($id_projeto ) and empty($id_veiculo)){ // tras todos os projetos executados em um periodo pelo tipo do veiculo
        if(empty($data_inicio) and empty($data_final)){
           $relatorios_projetos->setId_tipo_veiculo($id_tipo);
           $sql = $relatorios_projetos->tipoVeiculo($relatorios_projetos);
           $relatorios_projetos->montaTabela($sql);
        }else if(!empty($data_inicio)and !empty($data_final)) {
           $relatorios_projetos->setId_tipo_veiculo($id_tipo);
           $relatorios_projetos->setData_inicial($data_inicio);
           $relatorios_projetos->setData_final($data_final);
           $sql = $relatorios_projetos->tipoVeiculoDatas($relatorios_projetos);
           $relatorios_projetos->montaTabela($sql);
        }else{
             echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
        }
    } else if(!empty($id_projeto ) and !empty($id_veiculo)){ // tras todos os projetos realizados em um veiculo em especifico
        
        if(empty($data_inicio) and empty($data_final)){
           $relatorios_projetos->setId_projeto($id_projeto);
           $relatorios_projetos->setId_veiculo($id_veiculo);
           $sql = $relatorios_projetos->projetosVeiculos($relatorios_projetos);
           $relatorios_projetos->montaTabela($sql);
        }else if(!empty($data_inicio)and !empty($data_final)) {
           $relatorios_projetos->setId_projeto($id_projeto);
           $relatorios_projetos->setId_veiculo($id_veiculo);
           $relatorios_projetos->setData_inicial($data_inicio);
           $relatorios_projetos->setData_final($data_final);
           $sql = $relatorios_projetos->projetosVeiculosDatas($relatorios_projetos);
           $relatorios_projetos->montaTabela($sql);
        }else{
             echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
        }
        
    } else if(!empty($id_projeto ) and !empty($id_tipo)){ //tras todos os projetos realizados em um tipo de veiculo em especifico
        
        if(empty($data_inicio) and empty($data_final)){
           $relatorios_projetos->setId_projeto($id_projeto);
           $relatorios_projetos->setId_tipo_veiculo($id_tipo);
           $sql = $relatorios_projetos->projetoTipo($relatorios_projetos);
           $relatorios_projetos->montaTabela($sql);
        }else if(!empty($data_inicio)and !empty($data_final)) {
           $relatorios_projetos->setId_projeto($id_projeto);
           $relatorios_projetos->setId_tipo_veiculo($id_tipo);
           $relatorios_projetos->setData_inicial($data_inicio);
           $relatorios_projetos->setData_final($data_final);
           $sql = $relatorios_projetos->projetoTipoDatas($relatorios_projetos);
           $relatorios_projetos->montaTabela($sql);
        }else{
             echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
        }
        
    }else {
       echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
    }   
}

?>


