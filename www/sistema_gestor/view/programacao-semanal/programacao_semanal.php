<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/programacao_semanal/programacao_semanal.css" type="text/css">
        <link rel="stylesheet" href="../style/bootstrap/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="../style/programacao_semanal/modal_viagem.css" type="text/css">
        <script src="../js/viagens/modal_viagens.js"></script>
        <script src="../js/jquery.js"></script>
        <script src="../js/viagens/adicionar_viagem.js"></script>
    </head>
    <body>
        <div id="retorno_delete"></div>
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
                                <option value="1">Segunda</option>
                                <option value="2">Terça</option>
                                <option value="3">Quarta</option>
                                <option value="4">Quinta</option>
                                <option value="5">Sexta</option>
                                <option value="6">Sabado</option>
                                <option value="7">Domingo</option>
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
                            if (isset($_GET['dia_semana']) and isset($_GET['id_motoristaA']) and isset($_GET['id_motoristaB']) and isset($_GET['id_rota']) and isset($_GET['id_veiculo']) ) {
                                $dia_semanas = $_GET['dia_semana'];
                                $id_motoristaA = $_GET['id_motoristaA'];
                                $id_motoristaB = $_GET['id_motoristaB'];
                                $id_rota = $_GET['id_rota'];
                                $id_veiculo = $_GET['id_veiculo'];
                                $sql = "delete from programacao_semanal where programacao_semanal.id_diasemana = $dia_semanas and programacao_semanal.id_motoristaA = $id_motoristaA "
                                        . "and programacao_semanal.id_motoristaB = $id_motoristaB and programacao_semanal.id_rota = $id_rota and programacao_semanal.id_veiculo = $id_veiculo";
                                mysql_query($sql);
                                session_start("dia_semana");
                                $_SESSION['dia'] = $dia_semanas;
                                require '../control/programacao_semanal/programacaosemanal_controller.php';
                            } else {
                                $dia_da_semana = $_POST['dia_semana'];
                                session_start("dia_semana");
                                $_SESSION['dia'] = $dia_da_semana;
                                require '../control/programacao_semanal/programacaosemanal_controller.php';
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?> 
                </div>
            </contans>
        </div>
        <div  id="viagem" class="modalDialog">
            <div id="viagens">
                <a id="btnClose" href="#" title="Close" class="close" onclick="fecha_modal('viagem')" >X</a>
                <div class="recebe_resposta"></div>
                <form class="form_rotas" method="post" action="">
                    <div class="col-md-12 col-sm-12 col-xs-12" id="header"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12" id="contans">
                        <div class="col-md-3 col-sm-3 col-xs-3">

                            <label>Motorista A</label>
                            <select class="selectpicker" id="campos" name="motoristaA">
                                <option></option>
                                <?php
                                $sql_motorista = "select motoristas.id_motorista, motoristas.nome_motorista from motoristas where 1 ";
                                $result_motorista = mysql_query($sql_motorista);
                                while ($aux_motorista = mysql_fetch_array($result_motorista)) {
                                    $id_motorista = $aux_motorista['id_motorista'];
                                    $nome_motorista = $aux_motorista['nome_motorista'];
                                    ?>
                                    <option value="<?php echo $id_motorista ?>"><?php echo $nome_motorista ?></option>
                                    <?php
                                }
                                ?>
                            </select> 
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3">

                            <label>Motorista B</label>
                            <select class="selectpicker" id="campos" name="motoristaB">
                                <option></option>
                                <?php
                                $sql_motorista = "select motoristas.id_motorista, motoristas.nome_motorista from motoristas where 1 ";
                                $result_motorista = mysql_query($sql_motorista);
                                while ($aux_motorista = mysql_fetch_array($result_motorista)) {
                                    $id_motorista = $aux_motorista['id_motorista'];
                                    $nome_motorista = $aux_motorista['nome_motorista'];
                                    ?>
                                    <option value="<?php echo $id_motorista ?>"><?php echo $nome_motorista ?></option>
                                    <?php
                                }
                                ?>
                            </select> 
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <label>Veiculo</label>
                            <select class="selectpicker" id="campos" name="veiculo">
                                <option></option>
                                <?php
                                $sql_veiculo = "select veiculos.id_veiculo,veiculos.nome_veiculo from veiculos where id_tipo = 1 or id_tipo =2 or id_tipo = 5";
                                $result_veiculo = mysql_query($sql_veiculo);
                                while ($aux_veiculo = mysql_fetch_array($result_veiculo)) {
                                    $id_veiculo = $aux_veiculo['id_veiculo'];
                                    $nome_veiculo = $aux_veiculo['nome_veiculo'];
                                    ?>
                                    <option value="<?php echo $id_veiculo ?>"><?php echo $nome_veiculo ?></option>
                                    <?php
                                }
                                ?>
                            </select> 
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <label>Rota</label>
                            <select class="selectpicker" id="campos" name="rota">
                                <option></option>
                                <?php
                                $sql_rota = "select rotas.id_rota,rotas.nome_rota from rotas where 1 ";
                                $result_rota = mysql_query($sql_rota);
                                while ($aux_rota = mysql_fetch_array($result_rota)) {
                                    $id_rota = $aux_rota['id_rota'];
                                    $nome_rota = $aux_rota['nome_rota'];
                                    ?>
                                    <option value="<?php echo $id_rota ?>"><?php echo $nome_rota ?></option>
                                    <?php
                                }
                                ?>
                            </select> 
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <button type="submit" class="btn btn-default" style="margin-top:15%; background: #01669F; color:white;">Salvar</button> 
                        </div>
                    </div>   
                </form>
            </div>
        </div>
        <div  id="editeviagem" class="modalDialog">
            <div id="editeviagens">
                <a id="btnClose" href="#" title="Close" class="close" onclick="fecha_modal('editeviagem')">X</a>
                <div id="recebe_resposta"></div>
                <form class="form_rotassss" method="post" action="">
                    <div class="col-md-12 col-sm-12 col-xs-12" id="header"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12" id="contans">
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <label>Motorista</label>
                            <select class="selectpicker" id="motorista" name="motorista">
                                <option value="<?php ?>"><?php ?></option>
                                <?php
                                $sql_motorista = "select motoristas.id_motorista, motoristas.nome_motorista from motoristas where 1 ";
                                $result_motorista = mysql_query($sql_motorista);
                                while ($aux_motorista = mysql_fetch_array($result_motorista)) {
                                    $id_motorista = $aux_motorista['id_motorista'];
                                    $nome_motorista = $aux_motorista['nome_motorista'];
                                    ?>
                                    <option value="<?php echo $id_motorista ?>"><?php echo $nome_motorista ?></option>
                                    <?php
                                }
                                ?>
                            </select> 
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <label>Veiculo</label>
                            <select class="selectpicker" id="motorista" name="veiculo">
                                <option></option>
                                <?php
                                $sql_veiculo = "select veiculos.id_veiculo,veiculos.nome_veiculo from veiculos where id_tipo = 1";
                                $result_veiculo = mysql_query($sql_veiculo);
                                while ($aux_veiculo = mysql_fetch_array($result_veiculo)) {
                                    $id_veiculo = $aux_veiculo['id_veiculo'];
                                    $nome_veiculo = $aux_veiculo['nome_veiculo'];
                                    ?>
                                    <option value="<?php echo $id_veiculo ?>"><?php echo $nome_veiculo ?></option>
                                    <?php
                                }
                                ?>
                            </select> 
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <label>Rota</label>
                            <select class="selectpicker" id="motorista" name="rota">
                                <option></option>
                                <?php
                                $sql_rota = "select rotas.id_rota,rotas.nome_rota from rotas where 1 ";
                                $result_rota = mysql_query($sql_rota);
                                while ($aux_rota = mysql_fetch_array($result_rota)) {
                                    $id_rota = $aux_rota['id_rota'];
                                    $nome_rota = $aux_rota['nome_rota'];
                                    ?>
                                    <option value="<?php echo $id_rota ?>"><?php echo $nome_rota ?></option>
                                    <?php
                                }
                                ?>
                            </select> 
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <button type="submit" class="btn btn-default" style="margin-top:15%; background: #01669F; color:white;">Salvar</button> 
                        </div>
                    </div>   
                </form>
            </div>
        </div>
    </body>
</html>
