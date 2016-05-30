<?php
require '../../../model/relatorios/projetos/projetos_tarefas.php';
$relatorios_projetos = new projetos_tarefas();
$id_projeto = $_POST['campo_select_projeto'];
$id_veiculo = $_POST['campo_select_veiculo'];
$id_tipo = $_POST['campo_select_tipo'];
$status = $_POST['campo_select_status'];
$id_ugb = $_POST['campo_select_ugb'];
$data_inicio = $_POST['data_inicio'];
$data_final = $_POST['data_final'];
if (empty($id_projeto) and empty($id_veiculo) and empty($id_funcionario) and empty($id_tipo) and empty($data_inicio) and empty($data_final) and empty($status) and empty($id_ugb)) {
    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Por Favor preencha algum campo!</p>";
} else {
    if (!empty($status)) {

        if ($status == "open" || $status == "concluido") { // status para os projetos abertos ou os projetos concluidos
            
            if (empty($id_veiculo) and empty($id_tipo) and empty($id_ugb) and ! empty($id_projeto)) { // tras todos os projetos executados em um periodo por nome
                if (empty($data_inicio) and empty($data_final)) {
                    $relatorios_projetos->setId_projeto($id_projeto);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->projetos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_projetos->setId_projeto($id_projeto);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setData_inicial($data_inicio);
                    $relatorios_projetos->setData_final($data_final);
                    $sql = $relatorios_projetos->projetosDatas($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            } else if (empty($id_projeto) and empty($id_tipo) and empty($id_ugb) and ! empty($id_veiculo)) { // tras todos os projetos executados em um periodo por veiculo 
                if (empty($data_inicio) and empty($data_final)) {
                    $relatorios_projetos->setId_veiculo($id_veiculo);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->veiculos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_projetos->setId_veiculo($id_veiculo);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setData_inicial($data_inicio);
                    $relatorios_projetos->setData_final($data_final);
                    $sql = $relatorios_projetos->veiculosDatas($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            } else if (empty($id_projeto) and empty($id_veiculo)and empty($id_ugb) and ! empty($id_tipo)) { // tras todos os projetos executados pelo tipo do veiculo
                if (empty($data_inicio) and empty($data_final)) {
                    $relatorios_projetos->setId_tipo_veiculo($id_tipo);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->tipoVeiculo($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_projetos->setId_tipo_veiculo($id_tipo);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setData_inicial($data_inicio);
                    $relatorios_projetos->setData_final($data_final);
                    $sql = $relatorios_projetos->tipoVeiculoDatas($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (empty($id_projeto) and empty($id_veiculo) and empty($id_tipo) and !empty($id_ugb)) { // tras todos os projetos executados por ugb
                if (empty($data_inicio) and empty($data_final)) {
                    $relatorios_projetos->setUgb($id_ugb);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->ugb($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_projetos->setUgb($id_ugb);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setData_inicial($data_inicio);
                    $relatorios_projetos->setData_final($data_final);
                    $sql = $relatorios_projetos->ugbDatas($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (!empty($id_projeto) and ! empty($id_veiculo) and empty($id_tipo) and empty($id_ugb)) { // tras todos os projetos realizados em um veiculo em especifico
                if (empty($data_inicio) and empty($data_final)) {
                    $relatorios_projetos->setId_projeto($id_projeto);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setId_veiculo($id_veiculo);
                    $sql = $relatorios_projetos->projetosVeiculos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else if (!empty($data_inicio) and ! empty($data_final)) {
                    $relatorios_projetos->setId_projeto($id_projeto);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setId_veiculo($id_veiculo);
                    $relatorios_projetos->setData_inicial($data_inicio);
                    $relatorios_projetos->setData_final($data_final);
                    $sql = $relatorios_projetos->projetosVeiculosDatas($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            } else if (!empty($id_projeto) and ! empty($id_tipo) and empty($id_veiculo) and empty($id_ugb)) { //tras todos os projetos realizados em um tipo de veiculo em especifico
                if (empty($data_inicio) and empty($data_final)) {
                    $relatorios_projetos->setId_projeto($id_projeto);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setId_tipo_veiculo($id_tipo);
                    $sql = $relatorios_projetos->projetoTipo($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_projetos->setId_projeto($id_projeto);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setId_tipo_veiculo($id_tipo);
                    $relatorios_projetos->setData_inicial($data_inicio);
                    $relatorios_projetos->setData_final($data_final);
                    $sql = $relatorios_projetos->projetoTipoDatas($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (!empty($id_veiculo) and ! empty($id_ugb) and empty($id_projeto) and empty($id_tipo)) { //tras todos os projetos realizados em um veiculo mas por UGB
                if (empty($data_inicio) and empty($data_final)) {
                    $relatorios_projetos->setId_veiculo($id_veiculo);
                    $relatorios_projetos->setUgb($id_ugb);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->ugbVeiculo($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_projetos->setId_veiculo($id_veiculo);
                    $relatorios_projetos->setUgb($id_ugb);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setData_inicial($data_inicio);
                    $relatorios_projetos->setData_final($data_final);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->ugbVeiculoDatas($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (!empty($id_tipo) and !empty($id_ugb) and empty($id_projeto) and empty($id_veiculo)) { //tras todos os projetos realizados em um Tipoveiculo mas por UGB
                if (empty($data_inicio) and empty($data_final)) {
                    $relatorios_projetos->setId_tipo_veiculo($id_tipo);
                    $relatorios_projetos->setUgb($id_ugb);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->ugbTipoVeiculo($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_projetos->setId_tipo_veiculo($id_tipo);
                    $relatorios_projetos->setUgb($id_ugb);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setData_inicial($data_inicio);
                    $relatorios_projetos->setData_final($data_final);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->ugbTipoVeiculoDatas($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (!empty($id_projeto) and !empty($id_ugb) and empty($id_tipo) and empty($id_veiculo)) { //tras todos os projetos realizados por nome em uma UGB
                if (empty($data_inicio) and empty($data_final)) {
                    $relatorios_projetos->setId_projeto($id_projeto);
                    $relatorios_projetos->setUgb($id_ugb);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->ugbProjeto($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_projetos->setId_projeto($id_projeto);
                    $relatorios_projetos->setUgb($id_ugb);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setData_inicial($data_inicio);
                    $relatorios_projetos->setData_final($data_final);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->ugbProjetoDatas($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (!empty($id_projeto) and ! empty($id_tipo) and ! empty($id_ugb) and empty($id_veiculo)) { //tras todos os projetos realizados em um tipo de veiculo em especifico com a ugb selecionada
                if (empty($data_inicio) and empty($data_final)) {
                   $relatorios_projetos->setId_projeto($id_projeto);
                   $relatorios_projetos->setId_tipo_veiculo($id_tipo);
                   $relatorios_projetos->setStatus_projeto($status);
                   $relatorios_projetos->setUgb($id_ugb);
                   $sql = $relatorios_projetos->projetoTipoVeiculoUgb($relatorios_projetos);
                   $relatorios_projetos->montaTabela($sql,$status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                   $relatorios_projetos->setId_projeto($id_projeto);
                   $relatorios_projetos->setData_inicial($data_inicio);
                   $relatorios_projetos->setData_final($data_final);
                   $relatorios_projetos->setId_tipo_veiculo($id_tipo);
                   $relatorios_projetos->setStatus_projeto($status);
                   $relatorios_projetos->setUgb($id_ugb);
                   $sql = $relatorios_projetos->projetoTipoVeiculoUgbDatas($relatorios_projetos);
                   $relatorios_projetos->montaTabela($sql,$status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (!empty($id_projeto) and ! empty($id_veiculo) and ! empty($id_ugb) and empty($id_tipo)) { //tras todos os projetos realizados em um  veiculo em especifico com a ugb selecionada
                if (empty($data_inicio) and empty($data_final)) {
                   $relatorios_projetos->setId_projeto($id_projeto);
                   $relatorios_projetos->setId_veiculo($id_veiculo);
                   $relatorios_projetos->setStatus_projeto($status);
                   $relatorios_projetos->setUgb($id_ugb);
                   $sql = $relatorios_projetos->projetoVeiculoUgb($relatorios_projetos);
                   $relatorios_projetos->montaTabela($sql,$status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                   $relatorios_projetos->setId_projeto($id_projeto);
                   $relatorios_projetos->setData_inicial($data_inicio);
                   $relatorios_projetos->setData_final($data_final);
                   $relatorios_projetos->setId_veiculo($id_veiculo);
                   $relatorios_projetos->setStatus_projeto($status);
                   $relatorios_projetos->setUgb($id_ugb);
                   $sql = $relatorios_projetos->projetoVeiculoUgbDatas($relatorios_projetos);
                   $relatorios_projetos->montaTabela($sql,$status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            } else {
                echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
            }
        } else { 

           //status dos projetos concluidos e abertos
            
            if (empty($id_veiculo) and empty($id_tipo) and empty($id_ugb) and ! empty($id_projeto)) { // tras todos os projetos executados em um periodo por nome
                if (empty($data_inicio) and empty($data_final)) {
                    $relatorios_projetos->setId_projeto($id_projeto);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->projetosStatusTodos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_projetos->setId_projeto($id_projeto);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setData_inicial($data_inicio);
                    $relatorios_projetos->setData_final($data_final);
                    $sql = $relatorios_projetos->projetosDatasStatusTodos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            } else if (empty($id_projeto) and empty($id_tipo) and empty($id_ugb) and ! empty($id_veiculo)) { // tras todos os projetos executados em um periodo por veiculo 
                if (empty($data_inicio) and empty($data_final)) {
                    $relatorios_projetos->setId_veiculo($id_veiculo);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->veiculosStatusTodos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_projetos->setId_veiculo($id_veiculo);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setData_inicial($data_inicio);
                    $relatorios_projetos->setData_final($data_final);
                    $sql = $relatorios_projetos->veiculosDatasStatusTodos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            } else if (empty($id_projeto) and empty($id_veiculo)and empty($id_ugb) and ! empty($id_tipo)) { // tras todos os projetos executados pelo tipo do veiculo
                if (empty($data_inicio) and empty($data_final)) {
                    $relatorios_projetos->setId_tipo_veiculo($id_tipo);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->tipoVeiculoStatusTodos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_projetos->setId_tipo_veiculo($id_tipo);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setData_inicial($data_inicio);
                    $relatorios_projetos->setData_final($data_final);
                    $sql = $relatorios_projetos->tipoVeiculoDatasStatusTodos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (empty($id_projeto) and empty($id_veiculo) and empty($id_tipo) and !empty($id_ugb)) { // tras todos os projetos executados por ugb
                if (empty($data_inicio) and empty($data_final)) {
                    $relatorios_projetos->setUgb($id_ugb);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->ugbStatusTodos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_projetos->setUgb($id_ugb);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setData_inicial($data_inicio);
                    $relatorios_projetos->setData_final($data_final);
                    $sql = $relatorios_projetos->ugbDatasStatusTodos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (!empty($id_projeto) and ! empty($id_veiculo) and empty($id_tipo) and empty($id_ugb)) { // tras todos os projetos realizados em um veiculo em especifico
                if (empty($data_inicio) and empty($data_final)) {
                    $relatorios_projetos->setId_projeto($id_projeto);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setId_veiculo($id_veiculo);
                    $sql = $relatorios_projetos->projetosVeiculosStatusTodos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else if (!empty($data_inicio) and ! empty($data_final)) {
                    $relatorios_projetos->setId_projeto($id_projeto);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setId_veiculo($id_veiculo);
                    $relatorios_projetos->setData_inicial($data_inicio);
                    $relatorios_projetos->setData_final($data_final);
                    $sql = $relatorios_projetos->projetosVeiculosDatasStatusTodos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            } else if (!empty($id_projeto) and ! empty($id_tipo) and empty($id_veiculo) and empty($id_ugb)) { //tras todos os projetos realizados em um tipo de veiculo em especifico
                if (empty($data_inicio) and empty($data_final)) {
                    $relatorios_projetos->setId_projeto($id_projeto);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setId_tipo_veiculo($id_tipo);
                    $sql = $relatorios_projetos->projetoTipoStatusTodos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_projetos->setId_projeto($id_projeto);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setId_tipo_veiculo($id_tipo);
                    $relatorios_projetos->setData_inicial($data_inicio);
                    $relatorios_projetos->setData_final($data_final);
                    $sql = $relatorios_projetos->projetoTipoDatasStatusTodos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (!empty($id_veiculo) and ! empty($id_ugb) and empty($id_projeto) and empty($id_tipo)) { //tras todos os projetos realizados em um veiculo mas por UGB
                if (empty($data_inicio) and empty($data_final)) {
                    $relatorios_projetos->setId_veiculo($id_veiculo);
                    $relatorios_projetos->setUgb($id_ugb);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->ugbVeiculoStatusTodos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_projetos->setId_veiculo($id_veiculo);
                    $relatorios_projetos->setUgb($id_ugb);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setData_inicial($data_inicio);
                    $relatorios_projetos->setData_final($data_final);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->ugbVeiculoDatasStatusTodos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (!empty($id_tipo) and !empty($id_ugb) and empty($id_projeto) and empty($id_veiculo)) { //tras todos os projetos realizados em um Tipoveiculo mas por UGB
                if (empty($data_inicio) and empty($data_final)) {
                    $relatorios_projetos->setId_tipo_veiculo($id_tipo);
                    $relatorios_projetos->setUgb($id_ugb);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->ugbTipoVeiculoStatusTodos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_projetos->setId_tipo_veiculo($id_tipo);
                    $relatorios_projetos->setUgb($id_ugb);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setData_inicial($data_inicio);
                    $relatorios_projetos->setData_final($data_final);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->ugbTipoVeiculoDatasStatusTodos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (!empty($id_projeto) and !empty($id_ugb) and empty($id_tipo) and empty($id_veiculo)) { //tras todos os projetos realizados por nome em uma UGB
                if (empty($data_inicio) and empty($data_final)) {
                    $relatorios_projetos->setId_projeto($id_projeto);
                    $relatorios_projetos->setUgb($id_ugb);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->ugbProjetoStatusTodos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_projetos->setId_projeto($id_projeto);
                    $relatorios_projetos->setUgb($id_ugb);
                    $relatorios_projetos->setStatus_projeto($status);
                    $relatorios_projetos->setData_inicial($data_inicio);
                    $relatorios_projetos->setData_final($data_final);
                    $relatorios_projetos->setStatus_projeto($status);
                    $sql = $relatorios_projetos->ugbProjetoDatasStatusTodos($relatorios_projetos);
                    $relatorios_projetos->montaTabela($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (!empty($id_projeto) and ! empty($id_tipo) and ! empty($id_ugb) and empty($id_veiculo)) { //tras todos os projetos realizados em um tipo de veiculo em especifico com a ugb selecionada
                if (empty($data_inicio) and empty($data_final)) {
                   $relatorios_projetos->setId_projeto($id_projeto);
                   $relatorios_projetos->setId_tipo_veiculo($id_tipo);
                   $relatorios_projetos->setStatus_projeto($status);
                   $relatorios_projetos->setUgb($id_ugb);
                   $sql = $relatorios_projetos->projetoTipoVeiculoUgbStatusTodos($relatorios_projetos);
                   $relatorios_projetos->montaTabela($sql,$status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                   $relatorios_projetos->setId_projeto($id_projeto);
                   $relatorios_projetos->setData_inicial($data_inicio);
                   $relatorios_projetos->setData_final($data_final);
                   $relatorios_projetos->setId_tipo_veiculo($id_tipo);
                   $relatorios_projetos->setStatus_projeto($status);
                   $relatorios_projetos->setUgb($id_ugb);
                   $sql = $relatorios_projetos->projetoTipoVeiculoUgbDatasStatusTodos($relatorios_projetos);
                   $relatorios_projetos->montaTabela($sql,$status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (!empty($id_projeto) and ! empty($id_veiculo) and ! empty($id_ugb) and empty($id_tipo)) { //tras todos os projetos realizados em um  veiculo em especifico com a ugb selecionada
                if (empty($data_inicio) and empty($data_final)) {
                   $relatorios_projetos->setId_projeto($id_projeto);
                   $relatorios_projetos->setId_veiculo($id_veiculo);
                   $relatorios_projetos->setStatus_projeto($status);
                   $relatorios_projetos->setUgb($id_ugb);
                   $sql = $relatorios_projetos->projetoVeiculoUgbStatusTodos($relatorios_projetos);
                   $relatorios_projetos->montaTabela($sql,$status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                   $relatorios_projetos->setId_projeto($id_projeto);
                   $relatorios_projetos->setData_inicial($data_inicio);
                   $relatorios_projetos->setData_final($data_final);
                   $relatorios_projetos->setId_veiculo($id_veiculo);
                   $relatorios_projetos->setStatus_projeto($status);
                   $relatorios_projetos->setUgb($id_ugb);
                   $sql = $relatorios_projetos->projetoVeiculoUgbDatasStatusTodos($relatorios_projetos);
                   $relatorios_projetos->montaTabela($sql,$status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            } else {
                echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
            }
            
            
            
            
            
            
            
        }
    } else {
        echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>E necessario o preenchimento do Campo STATUS!</p>";
    }
}
?>


