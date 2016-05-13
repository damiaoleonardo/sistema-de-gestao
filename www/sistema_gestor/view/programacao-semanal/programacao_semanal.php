<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/programacao_semanal/programacao_semanal.css" type="text/css">
        <link rel="stylesheet" href="../style/bootstrap/bootstrap.css" type="text/css">
    </head>
    <body>
        <div class="row_programacao">
            <div class="col-md-12 col-sm-12 col-xs-12" id="header_programacao_semanal"><div id="titulo"><span>Programação Semanal</span></div></div>
            <contans>
                <div class="col-md-3 col-sm-3 col-xs-3" id="menu_selecao">
                    <div class="col-md-12 col-sm-12 col-xs-12" id="botoes_selecao">
                        <p class="navbar-btn"><a href="telaPrincipal.php?t=programacao-semanal&v=visualizacao-todos" class="btn btn-default">Visualização da Programação</a></p>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12" id="campos_pesquisa">
                        <label class="col-md-12 col-sm-12 col-xs-12" style="color:white;">Dia da Semana</label>
                        <form  method="post" action="telaPrincipal.php?t=programacao-semanal&v=edita-programacao">
                            <select class="selectpicker" name="dia_semana">
                                <option></option>
                                <option value="Segunda">Segunda</option>
                                <option value="Terca">Terça</option>
                                <option value="Quarta">Quarta</option>
                                <option value="Quinta">Quinta</option>
                                <option value="Sexta">Sexta</option>
                                <option value="Sabado">Sabado</option>
                                <option value="Domingo">Domingo</option>
                            </select> 
                            <button type="submit" class="btn btn-default" style="margin:15% 0% 0% 50%;">Pesquisar</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-9" id="tabela_visualizacao">
                    <?php
                    $pagina_programacao = $_REQUEST['v'];
                    if ($pagina_programacao == "visualizacao-todos") {
                        ?>
                    <div class="visualizacao_programacao">
                        <?php
                            require '../control/programacao_semanal/programacaovisualizacao_controller.php';
                        ?>
                    </div>
                    <?php 
                    } else if ($pagina_programacao == "edita-programacao") {
                        ?>
                        <div class="programacao_edit">
                            <?php
                            $dia_da_semana = $_POST['dia_semana'];
                            session_start("dia_semana");
                            $_SESSION['dia'] = $dia_da_semana;
                            require '../control/programacao_semanal/programacaosemanal_controller.php';
                            ?>

                        </div>
                        <?php
                    }
                    ?> 
                </div>
            </contans>
        </div>
    </body>
</html>
