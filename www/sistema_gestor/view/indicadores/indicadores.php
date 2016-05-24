<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/indicadores/indicadores.css" type="text/css">
        <link rel="stylesheet" href="../style/indicadores/bootstrap-datepicker3.css" type="text/css">
        <script src="../js/indicador_semanal/bootstrap-datepicker.min.js"></script>
        <script src="../js/indicador_semanal/data_final.js"></script>
        <script src="../js/indicador_semanal/data_inicio.js"></script>
    </head>
    <body>
        <div class="atividades_semanal">
            <div id="header" class="col-md-12 col-sm-12 col-xs-12">
            </div>
            <div id="conteudo_veiculos" class="col-md-12 col-sm-12 col-xs-12">  
                <div id="veiculos_selecao" class="col-md-4 col-sm-4 col-xs-4">
                    <form method="post" action="telaPrincipal.php?t=atividade-semanal&g=indicador-semanal" class="form_indicador_semanal">
                        <div id="semana" class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-6" >
                                <label class="label">Semana</label>
                                <select class="selectpicker"  name="campo_select_semana">
                                    <option value="0" selected="selected"></option>
                                    <?php
                                    $semana = 1;
                                    while ($semana < 53) {
                                        ?>
                                        <option value="<?php echo $semana; ?>" style="color:black;"><?php echo "Semana " . $semana; ?></option>
                                        <?php
                                        $semana ++;
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6" >
                                <label class="label">Meta</label>
                                <select class="selectpicker"  name="campo_select_meta">
                                    <option value="0" selected="selected"></option>
                                    <?php
                                    $meta = 80;
                                    while ($meta <= 100) {
                                        ?>
                                        <option value="<?php echo $meta; ?>" style="color:black;"><?php echo $meta; ?></option>
                                        <?php
                                        $meta ++;
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div id="periodo" class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <label class="control-label col-sm-12 col-md-12 col-xs-12 requiredField" for="date" style="font-size:1.1em;">Inicio</label>
                                <div class="col-sm-12 col-md-12 col-xs-12">
                                    <div class="input-group">
                                        <input style="height: 30px;  width: 100px;" class="form-control" id="date" name="data_inicio" placeholder="YYYY/MM/DD" type="text"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <label class="control-label col-sm-12 col-md-12 col-xs-12 requiredField" for="date" style="font-size:1.1em;">Final</label>
                                <div class="col-sm-12 col-md-12 col-xs-12" >
                                    <div class="input-group">
                                        <input style="height: 30px; width: 100px;" class="form-control" id="date" name="data_final" placeholder="YYYY/MM/DD" type="text"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="veiculos" class="col-md-12 col-sm-12 col-xs-12">
                            <div class="cabecalho" style="background:#01669F;">
                                <table class='table table-hover'>
                                    <tr style="color:white;">
                                        <td>Veiculo</td>
                                        <td>Seleção</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="veiculos_list">
                                <table class='table table-hover'>
                                    <?php
                                    $q_veiculos = "SELECT veiculos.id_veiculo,veiculos.nome_veiculo from veiculos where id_tipo = 1";
                                    $op_veiculos = mysql_query($q_veiculos);
                                    while ($aux_veiculo = mysql_fetch_array($op_veiculos)) {
                                        $nome_veiculo = $aux_veiculo['nome_veiculo'];
                                        $id_veiculo = $aux_veiculo['id_veiculo'];
                                        ?>
                                        <tr>
                                            <td><?php echo $nome_veiculo ?></td>
                                            <td><input type="checkbox" name="veiculo[]" value="<?php echo $id_veiculo ?> "></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </table>
                            </div>
                            <div class="botao_confirma">
                                <button type="submit" class="btn btn-default" style="margin-top:4%; background: #1b6d85; color:white; float: right;">Gerar Indicador</button>
                            </div>

                        </div>
                    </form>
                </div>
                <div id="grafico_nota" class="col-md-8 col-sm-8 col-xs-8">
                    <?php
                    $page = $_REQUEST['g'];
                    if ($page == 'indicador-semanal') {
                        session_start("indicador_semanal)");
                        $_SESSION['campo_select_meta'] =  $meta_semana = $_POST['campo_select_meta'];
                        $_SESSION['campo_select_semana'] =    $semana_inserida = $_POST['campo_select_semana'];
                        $_SESSION['data_inicio'] =  $periodo_inicial = $_POST['data_inicio'];
                        $_SESSION['data_final'] =  $periodo_final = $_POST['data_final'];
                        $_SESSION['veiculos'] = $veiculos = $_POST['veiculo'];
                        require '../control/indicador_semanal/indicador_semanal.php';
                        ?>
                        <div style="width: 100%;margin-top:7%; overflow: scroll;">  
                            <img id="imagem" src= "../view/indicadores/gera_grafico_indicadorsemanal.php" alt = "" title = ""/>
                        </div>

    <?php
}
?>
                </div>
            </div>
        </div>
    </body>
</html>
