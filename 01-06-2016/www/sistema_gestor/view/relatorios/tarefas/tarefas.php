<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style/relatorios/tarefas/tarefas.css" type="text/css">
        <link rel="stylesheet" href="../style/bootstrap/class_table.css" type="text/css">
        <script src='../js/relatorios/gera_relatorio.js'></script>
        <title></title>
    </head>
    <body>
        <form class="form_relatorio_projeto" action="" method="post">
            <header class="row_relatorio_projeto">
                <div id="primeiro_campo" class="col-sm-4 col-md-4 col-xs-4">
                    <div id="projeto" class="col-sm-12 col-md-12 col-xs-12">
                        <label class="label">Tarefa</label>
                            <select class="selectpicker"  name="campo_select_projeto" >
                                    <option value="0" selected="selected"></option>
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
                                      <option value="0" selected="selected"></option>
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

                    <div id="funcionario" class="col-sm-12 col-md-12 col-xs-12">
                        <label class="label">Funcionario</label>
                       <select class="selectpicker"  name="campo_select_funcionario" >
                                      <option value="0" selected="selected"></option>
                                    <?php
                                    $q_funcionario= "SELECT funcionarios.id_funcionario,funcionarios.sobrenome from funcionarios where 1";
                                    $op_funcionario= mysql_query($q_funcionario);
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
                    <div id="tipoveiculo" class="col-sm-12 col-md-12 col-xs-12">
                        <label class="label">Tipo Veiculo</label>
                        <select class="selectpicker"  name="campo_select_tipo" >
                                      <option value="0" selected="selected"></option>
                                    <?php
                                    $q_tipo = "SELECT tipo_veiculo.id_tipo,tipo_veiculo.tipo from tipo_veiculo where 1";
                                    $op_tipos= mysql_query($q_tipo);
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
                <div id="terceiro_campo" class="col-sm-3 col-md-3 col-xs-3">
                    <div id="data_inicio" class="col-sm-12 col-md-12 col-xs-12">
                        <label class="label">Data Inicio</label>
                        <select class="selectpicker">
                            <option></option>
                            <option>Data Inicio</option>
                            <option>Ketchup</option>
                            <option>Relish</option>
                        </select>
                    </div>
                    <div id="data_final" class="col-sm-12 col-md-12 col-xs-12">
                        <label class="label">Data Final</label>
                        <select class="selectpicker">
                            <option></option>
                            <option>Data Final</option>
                            <option>Ketchup</option>
                            <option>Relish</option>
                        </select>
                    </div>
                </div>
                <div id="campo_button" class="col-sm-2 col-md-2 col-xs-2"><button type="submit"  class="btn btn-default">Pesquisar</button></div>
            </header>
        </form>
        <div class="row_conteudo-controle-manutencao"></div>
    </body>
</html>
