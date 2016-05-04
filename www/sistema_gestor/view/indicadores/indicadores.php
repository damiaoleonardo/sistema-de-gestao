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
                        <table class='table table-hover'>
                            <tr>
                                <td>Veiculo</td>
                                <td>Seleção</td>
                            </tr>
                            <?php
                            $q_veiculos = "SELECT veiculos.id_veiculo,veiculos.nome_veiculo from veiculos where 1";
                            $op_veiculos = mysql_query($q_veiculos);
                            while ($aux_veiculo = mysql_fetch_array($op_veiculos)) {
                                $nome_veiculo = $aux_veiculo['nome_veiculo'];
                                $id_veiculo = $aux_veiculo['id_veiculo'];
                                ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
                <div id="grafico_nota" class="col-md-8 col-sm-8 col-xs-8"></div>
            </div>
        </div>
    </body>
</html>
