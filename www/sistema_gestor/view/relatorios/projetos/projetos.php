<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/relatorios/projetos/projetos.css" type="text/css">
        <link rel="stylesheet" href="../style/bootstrap/class_table.css" type="text/css">
        <script src='../js/relatorios/gera_relatorio.js'></script>
        <script src='../js/data_inicio.js'></script>
        <script src='../js/data_final.js'></script>
        <script src='../js/relatorios/projetos/requisicao.js'></script>
        <script type="text/javascript" src="relatorios/projetos/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="relatorios/projetos/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="relatorios/projetos/bootstrap-datepicker3.css"/>
</head>
    <body>
        <div class="recebe_resposta"></div>
        <form class="form_relatorio_projeto" action="" method="post">
            <header class="row_relatorio_projeto">
                <div id="primeiro_campo" class="col-sm-4 col-md-4 col-xs-4">
                    <div id="projeto" class="col-sm-12 col-md-12 col-xs-12">
                        <label class="label">Projeto</label>
                        <select class="selectpicker"  name="campo_select_projeto" >
                            <option value="0" selected="selected" ></option>
                            <?php
                            $q_op = "SELECT projeto.id_projeto,projeto.nome from projeto where 1";
                            $op = mysql_query($q_op);
                            while ($aux_projeto = mysql_fetch_array($op)) {
                                $nome_projeto = $aux_projeto['nome'];
                                $id_projeto = $aux_projeto['id_projeto'];
                                ?>
                                <option value="<?php echo $id_projeto; ?>" style="color:black;"> <?php echo $nome_projeto; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div id="veiculo" class="col-sm-12 col-md-12 col-xs-12">
                        <label class="label">Veiculo</label>
                        <select class="selectpicker"  name="campo_select_veiculo" >
                            <option value="0" selected="selected" ></option>
                            <?php
                            $q_veiculos = "SELECT veiculos.id_veiculo,veiculos.nome_veiculo from veiculos where 1";
                            $op_veiculos = mysql_query($q_veiculos);
                            while ($aux_veiculo = mysql_fetch_array($op_veiculos)) {
                                $nome_veiculo = $aux_veiculo['nome_veiculo'];
                                $id_veiculo = $aux_veiculo['id_veiculo'];
                                ?>
                                <option value="<?php echo $id_veiculo; ?>" style="color:black;"> <?php echo $nome_veiculo; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div id="segundo_campo" class="col-sm-3 col-md-3 col-xs-3">
                    <div id="tipoveiculo" class="col-sm-12 col-md-12 col-xs-12">
                        <label class="label">Tipo Veiculo</label>
                        <select class="selectpicker"  name="campo_select_tipo" >
                            <option value="0" selected="selected" ></option>
                            <?php
                            $q_tipo = "SELECT tipo_veiculo.id_tipo,tipo_veiculo.tipo from tipo_veiculo where 1";
                            $op_tipos = mysql_query($q_tipo);
                            while ($aux_tipo = mysql_fetch_array($op_tipos)) {
                                $tipo = $aux_tipo['tipo'];
                                $id_tipo = $aux_tipo['id_tipo'];
                                ?>
                                <option value="<?php echo $id_tipo; ?>" style="color:black;"> <?php echo $tipo; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div id="terceiro_campo" class="col-sm-3 col-md-3 col-xs-3" >
                    <div id="data_inicio" class="col-sm-12 col-md-12 col-xs-12">
                         <label class="control-label col-sm-12 col-md-12 col-xs-12 requiredField" for="date" style="font-size:1em; color:white;">Data Inicio</label>
                                            <div class="col-sm-12 col-md-12 col-xs-12" >
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                    <input style="height: 24px;" class="form-control" id="date" name="data_inicio" placeholder="YYYY/MM/DD" type="text"/>
                                                </div>
                                            </div>
                        
                    </div>
                    <div id="data_final" class="col-sm-12 col-md-12 col-xs-12">  
                            <label class="control-label col-sm-12 col-md-12 col-xs-12 requiredField" for="date" style="font-size:1em; color:white;">Data Final</label>
                                            <div class="col-sm-12 col-md-12 col-xs-12" >
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                    <input style="height: 24px;" class="form-control" id="date" name="data_final" placeholder="YYYY/MM/DD" type="text"/>
                                                </div>
                                            </div>
                                        </div>
                    </div>
                <div id="campo_button" class="col-sm-2 col-md-2 col-xs-2"><button type="submit"  class="btn btn-default">Pesquisar</button></div>
            </header>
        </form>
    </body>
</html>