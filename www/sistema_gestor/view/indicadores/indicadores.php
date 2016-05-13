<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/indicadores/indicadores.css" type="text/css">
    </head>
    <body>
        <div class="atividades_semanal">
            <div id="header" class="col-md-12 col-sm-12 col-xs-12">

            </div>
            <div id="conteudo_veiculos" class="col-md-12 col-sm-12 col-xs-12">
                <div id="veiculos_selecao" class="col-md-4 col-sm-4 col-xs-4">
                    <div id="semana" class="col-md-12 col-sm-12 col-xs-12">
                        <label class="label">Semana</label>
                        <select class="selectpicker"  name="campo_select_veiculo">
                            <option value="0" selected="selected" ></option>
                            <?php
                            $semana = 1;
                            while ($semana < 53) {
                                ?>
                                <option value="<?php echo $semana; ?>" style="color:black;"> <?php echo "Semana  " . $semana; ?></option>
                                <?php
                                $semana ++;
                            }
                            ?>
                        </select>
                    </div>
                    <div id="veiculos" class="col-md-12 col-sm-12 col-xs-12">
                        <div class="cabecalho" style="background:#01669F; ">
                            <table class='table table-hover'>
                            <tr style="color:white;">
                                <td>Veiculo</td>
                                <td>Seleção</td>
                            </tr>
                            </table>
                        </div>
                        <form method="post" action="">
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
                        </form>
                    </div>
                </div>
                <div id="grafico_nota" class="col-md-8 col-sm-8 col-xs-8"></div>
            </div>
        </div>
    </body>
</html>
