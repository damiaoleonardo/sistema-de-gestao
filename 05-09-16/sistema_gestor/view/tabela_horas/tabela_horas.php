<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/tabela_horas/tabela_horas.css" type="text/css">
        <link rel="stylesheet" href="../style/tabela_horas/bootstrap-datepicker3.css"/>
        <link rel="stylesheet" href="../style/bootstrap/class_table.css" type="text/css">
        <script src='../js/tabela_horas/data_inicio.js'></script>
        <script src='../js/tabela_horas/data_final.js'></script>
        <script src='../js/tabela_horas/requisicao.js'></script>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/tabela_horas/bootstrap-datepicker.min.js"></script>    
</head>
    <body>
        <div class="recebe_resposta"></div>
        <form class="form_relatorio_tabela_horas" action="" method="post">
            <header class="row_relatorio_tabela_horas">
                <div id="primeiro_campo" class="col-sm-5 col-md-5 col-xs-5">
                    <div id="tabela_horas" class="col-sm-12 col-md-12 col-xs-12">
                        <label class="label">Funcionario</label>
                         <select class="selectpicker"  name="campo_select_funcionario" >
                            <option value="0" selected="selected"></option>
                            <?php
                            $conexao_select_funcionario = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
                            $conexao_select_funcionario->set_charset("utf8");
                            $q_funcionario = "SELECT funcionarios.id_funcionario,funcionarios.sobrenome from funcionarios where funcionarios.tipo != 'Administrador'";
                            $query_funcionarios = mysqli_query($conexao_select_funcionario, $q_funcionario);
                            while ($row = $query_funcionarios->fetch_assoc()) {
                                $login = $row['id_funcionario'];
                                $nome_funcionario = $row['sobrenome'];
                                ?>
                                <option value="<?php echo $login; ?>" style="color:black;"> <?php echo $nome_funcionario; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div id="terceiro_campo" class="col-sm-5 col-md-5 col-xs-5">
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
                <div id="campo_button" class="col-sm-2 col-md-2 col-xs-2"><button type="submit"  class="btn btn-default">Pesquisar tabela</button></div>
            </header>
        </form>
        <div class="recebe_tabela_horas"><div class="conteudo_dinamico"></div></div>
    </body>
</html>