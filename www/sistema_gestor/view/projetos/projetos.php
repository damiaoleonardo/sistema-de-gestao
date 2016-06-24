<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/projetos/projetos.css" type="text/css">
        <script src="../js/projetos/busca_projetos.js" ></script>
        <script src="../js/jquery.js" ></script>
        <script src="../js/projetos/adiciona_projeto.js" ></script>
    </head>
    <body>
        <div class="conteudo_da_pagina">  
            <header class="row_funcionario">
                <div class="row_func">
                    <div id="titulo_funcionario" class="col-sm-8 col-md-8 col-xs-6">
                        <div id="span_func"><span>Projetos</span></div>
                    </div>
                    <div id="campo_pesquisa" class="col-sm-4 col-md-4 col-xs-6">
                        <?php
                        $pagina_veiculo = $_REQUEST['c'];
                        if ($pagina_veiculo != "cria-projeto") {
                            ?>
                            <form name="form_pesquisa" id="form_pesquisa" method="post" action="">
                                <input type="text" name="pesquisaCliente" id="pesquisaCliente" value="" tabindex="1" placeholder="  Pesquisar projetos..." />	
                            </form>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </header>
            <div class="eventos_relacionados" class="col-sm-12 col-md-12 col-xs-12">
                <div id="botoes">
                    <a href="telaPrincipal.php?t=projetos&c=cria-projeto" class="btn btn-primary" id="button_relatorio_periodo"><span class="glyphicon glyphicon-pencil"></span>Novo</a>
                    <a href="telaPrincipal.php?t=projetos" class="btn btn-primary" id="button_relatorio"><span class="glyphicon glyphicon-floppy-disk"></span>Consultar</a>
                </div>
            </div>
            <?php
            if ($pagina_veiculo == "cria-projeto") {
                ?>
                <hr>
                <div class="recebe_resposta_projeto"></div>
                <div class="form_projetos">
                    <form class="formulario_projeto" method="post">
                        <div class="col-sm-12 col-md-12 col-xs-12" style="height: 70px; ">
                            <div class="col-sm-6 col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label  class="col-md-4 control-label">Nome do Projeto:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" name="nome_projeto" placeholder="Nome do Projeto" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label  class="col-md-2 control-label">UGB:</label>
                                    <div class="col-md-10" style="height: 35px; ;">
                                        <select class="selectpicker" name="ugb" style="width: 100%;height: 100%;">
                                            <option></option>
                                            <?php
                                            $q_op_ugb = "SELECT * FROM ugb";
                                            $ugb = mysql_query($q_op_ugb);
                                            while ($tipo = mysql_fetch_array($ugb)) {
                                                $id_ugb = $tipo['id_ugb'];
                                                $nome_ugb = $tipo['nome'];
                                                ?>
                                                <option value="<?php echo $id_ugb; ?>" style="color:black;"> <?php echo $nome_ugb; ?></option><br/>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12" style="height: 320px; ">
                            <div class="col-sm-12 col-md-12 col-xs-12" style="height: 40px;">
                                <table class="table table-hover">
                                    <tr style="background: #666666; color:white;font-size: 1em; ">
                                        <td style="width:15%;  text-align:left;">Codigo</td>
                                        <td style="width:50%;  text-align:left; ">Nome da Tarefa</td>
                                        <td style="width:20%;  text-align:left; ">Duracao</td>
                                        <td style="width:15%;  text-align:center; ">Selecionar</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-12 col-md-12 col-xs-12" style="height: 260px; overflow-y: scroll;overflow-x: hidden;">
                                <table class="table table-hover" >
                                    <?php
                                    $sql = "select * from tarefas";
                                    $result = mysql_query($sql);
                                    while ($recebe = mysql_fetch_array($result)) {
                                        $id_tarefa = $recebe['id_tarefa'];
                                        $nome_da_tarefa = $recebe['nome'];
                                        $duracao = $recebe['duracao'];
                                        ?>
                                        <tr style=" font-size: 1em;">
                                            <td style="text-align: left; width:15%;"><?php echo $id_tarefa ?></td>
                                            <td style="text-align: left; width:50%;"><?php echo $nome_da_tarefa ?></td>
                                            <td style="text-align: left; width:20%; "><?php echo $duracao ?></td>
                                            <td style="text-align: left; width:15%;"><center><input type="checkbox" name="id_tarefa[]" value="<?php echo $id_tarefa ?>"</center></td>
                                        </tr>
                                        <?php
                                      }
                                   ?>
                                </table> 
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12" style="height: 90px; margin-top:20px; ">
                            <label  class="col-md-4 control-label">Descricao do Projeto:</label>
                            <textarea rows="3" cols="130"  name="descricao"></textarea>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12" style="height: 70px; margin-top:20px; ">
                            <button style="background: #01669F; color:white; margin-left:80%;margin-top:20px;" type="submit" class="btn btn-default">Salvar Projeto</button>
                        </div>
                    </form>
                </div> 
                <?php
            } else {
                ?>
                <div>
                    <table class='table table-hover'>
                        <thead>
                            <tr style="background: #666666; color:white;font-size: 0.9em;">
                                <th style = ' width: 5%; text-align: left;'>Codigo</th>
                                <th style = ' width: 25%;  text-align: left;'>Projeto</th>
                                <th style = ' width: 5%; '>Duracao</th>
                                <th style = ' width: 40%; text-align: left;'>Descricao</th>
                                <th style = ' width: 4%;  '>Editar</th>
                                <th style = ' width: 4%;  '>Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                    </table>
                </div>
                <div class="row_conteudo">
                    <div id="contentLoading">
                        <center><div id="loading"></div></center>
                    </div>
                    <section class="jumbotron">
                        <div id="MostraPesq"></div>
                    </section>
                </div>
                <?php
            }
            ?>
        </div>
    </body>
</html>
