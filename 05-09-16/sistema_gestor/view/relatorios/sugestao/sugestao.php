<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/relatorios/sugestao/sugestao.css" type="text/css">
        <link rel="stylesheet" href="../style/relatorios/sugestao/bootstrap-datepicker3.css"/>
        <link rel="stylesheet" href="../style/bootstrap/class_table.css" type="text/css">
        <script src='../js/relatorios/sugestao/data_inicio.js'></script>
        <script src='../js/relatorios/sugestao/data_final.js'></script>
        <script src='../js/relatorios/sugestao/requisicao.js'></script>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/relatorios/sugestao/acoes_sugestao.js"></script>
        <script type="text/javascript" src="../js/relatorios/sugestao/bootstrap-datepicker.min.js"></script>    
</head>
    <body>
        <div class="recebe_resposta"></div>
        <form class="form_relatorio_sugestao" action="" method="post">
            <header class="row_relatorio_sugestao">
                <div id="primeiro_campo" class="col-sm-5 col-md-5 col-xs-5">
                    <div id="sugestao" class="col-sm-12 col-md-12 col-xs-12">
                        <label class="label">Funcionario</label>
                         <select class="selectpicker"  name="campo_select_funcionario" >
                            <option value="0" selected="selected"></option>
                            <?php
                            $conexao_select_funcionario = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
                            $conexao_select_funcionario->set_charset("utf8");
                            $q_funcionario = "SELECT funcionarios.login,funcionarios.sobrenome from funcionarios where funcionarios.tipo != 'Administrador'";
                            $query_funcionarios = mysqli_query($conexao_select_funcionario, $q_funcionario);
                            while ($row = $query_funcionarios->fetch_assoc()) {
                                $login = $row['login'];
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
                <div id="campo_button" class="col-sm-2 col-md-2 col-xs-2"><button type="submit"  class="btn btn-default">Pesquisar Sugestão</button></div>
            </header>
        </form>
        <div class="recebe_sugestao">
            <table id="descricao_sugestao"  class='table table-hover'>
                <tr>
                    <td style="width: 10%;">Sugestor</td>
                    <td style="width: 10%;">Nome</td>
                    <td style="width: 10%;">Data enviada</td>
                    <td style="width: 10%;">Data Vista</td>
                    <td style="width: 20%;">Como é hoje</td>
                    <td style="width: 2%;"><img src="../img/camera.png"></td>
                    <td style="width: 20%;">Como deve ser</td>
                    <td style="width: 2%;"><img src="../img/camera.png"></td>
                    <td style="width: 8%;"></td>
                    <td style="width: 8%;"></td>
                </tr>
            </table>
            <div class="conteudo_dinamico"></div>
        </div>
    </body>
</html>