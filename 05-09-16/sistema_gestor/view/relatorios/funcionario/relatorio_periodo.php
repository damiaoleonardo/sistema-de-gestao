<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/relatorios/funcionario/funcionario_periodo.css" type="text/css">
        <link rel="stylesheet" href="../style/modal/janela_modal.css" type="text/css" >
        <script src="../js/modal/janela_modal.js"></script>
        <script src="../js/relatorios/funcionarios/requisicao_formulario.js"></script> 
        <script src='../js/relatorios/projetos/data_inicio.js'></script>
        <script src='../js/relatorios/projetos/data_final.js'></script>
        <link rel="stylesheet" href="../style/relatorios/projetos/bootstrap-datepicker3.css"/>
        <script type="text/javascript" src="../js/relatorios/projetos/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="../js/relatorios/projetos/bootstrap-datepicker.min.js"></script>
        <script src="../js/relatorios/funcionarios/javascript_arquivos.js"></script>
        <script src="../js/relatorios/funcionarios/javascript_query.js"></script>
        <style type="text/css">
          #mostra {
                width: 700px;
                height: 500px;
                text-align: left;
            }
        </style>
    </head>
    <body>
        <div class="row_funcionario">
            <form class="form_relatorio_funcionario_periodo" action="" method="post">
                <div id="nome_funcionario" class="col-md-5 col-sm-5 col-xs-5">
                    <label id="label_fun">Funcionario</label> 
                    <select class="selectpicker"  name="campo_select_funcionario" name="campo_select_funcionario" >
                        <option value="0" selected="selected"></option>
                        <?php
                        $q_funcionario = "SELECT funcionarios.id_funcionario,funcionarios.sobrenome from funcionarios where 1";
                        $op_funcionario = mysql_query($q_funcionario);
                        while ($aux_funcionario = mysql_fetch_array($op_funcionario)) {
                            $nome_funcionario = $aux_funcionario['sobrenome'];
                            $id_funcionario = $aux_funcionario['id_funcionario'];
                            ?>
                            <option value="<?php echo $id_funcionario; ?>" style="color:black;"> <?php echo $nome_funcionario; ?></option>
                            <?php
                          }
                        ?>
                    </select>
                </div>
                <div id="periodo_datas" class="col-md-5 col-sm-5 col-xs-5">
                    <div id="data_inicio" class="col-sm-12 col-md-12 col-xs-12">
                        <label class="control-label col-sm-12 col-md-12 col-xs-12 requiredField" for="date" style="font-size:1em; color:white;">Data Inicio</label>
                        <div class="col-sm-9 col-md-9 col-xs-9">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input style="height: 24px;" class="form-control" id="date" name="data_inicio" placeholder="YYYY/MM/DD" type="text"/>
                            </div>
                        </div>

                    </div>
                    <div id="data_final" class="col-sm-12 col-md-12 col-xs-12">  
                        <label class="control-label col-sm-12 col-md-12 col-xs-12 requiredField" for="date" style="font-size:1em; color:white;">Data Final</label>
                        <div class="col-sm-9 col-md-9 col-xs-9" >
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input style="height: 24px;" class="form-control" id="date" name="data_final" placeholder="YYYY/MM/DD" type="text"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="button_relatorio_funci" class="col-md-2 col-sm-2 col-xs-2"><button style="background: #01669F; color:white;" type="submit" id="button_relatorio_periodo" class="btn btn-default">Pesquisar</button></div>
            </form>
        </div>
        <div  class="contans_funcionario_periodo">
            <div class="tabela_funcionario"></div>
        </div>
    </body>
</html>
