<?php
if (isset($_GET['flag_projeto'])) {
    $conexao_delete_projeto = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
    $erro_delete_projeto = 0;
    $id_projeto = $_GET['id_projeto'];
    $sql_delete_projeto = "delete from projeto where projeto.id_projeto = $id_projeto";
    if (!mysqli_query($conexao_delete_projeto, $sql_delete_projeto)) {
        $erro_delete_projeto++;
    }
    $sql_delete_tarefas_projeto = "delete from tarefas_projeto where tarefas_projeto.id_projeto = $id_projeto";
    if (!mysqli_query($conexao_delete_projeto, $sql_delete_tarefas_projeto)) {
        $erro_delete_projeto++;
    }
    if ($erro_delete_projeto == 0) {
        mysqli_commit($conexao_delete_projeto);
        echo "<script>alert('Projeto excluido com sucesso!')</script>";
        echo "<script>location.href='../view/telaPrincipal.php?t=projetos'</script>";
    } else {
        mysqli_rollback($conexao_delete_projeto);
        echo "<script>alert('Erro ao excluir o projeto!')</script>";
        echo "<script>location.href='../view/telaPrincipal.php?t=projetos'</script>";
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/projetos/projetos.css" type="text/css">
        <script src="../js/projetos/busca_projetos.js" ></script>
        <script src="../js/jquery.js" ></script>
        <script src="../js/projetos/adiciona_projeto.js" ></script>
        <script src="../js/projetos/atualiza_projeto.js" ></script>
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
                                    <div class="col-md-10" style="height: 35px;">
                                        <select class="selectpicker" name="ugb" style="width: 100%;height: 100%;">
                                            <option></option>
                                            <?php
                                            $q_op_ugb = "SELECT * FROM ugb";
                                            $ugb = mysql_query($q_op_ugb);
                                            while ($tipo = mysql_fetch_array($ugb)) {
                                                $id_ugb = $tipo['id_ugb'];
                                                $nome_ugb = $tipo['nome_ugb'];
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
            } else if ($pagina_veiculo == "edit-projeto") {
                include '../model/projetos/projetos.php';
                $projeto = new Projetos();
                $id_projeto = $_GET['id_projeto'];
                $dados_do_projeto = $projeto->getDadosProjeto($id_projeto);
                session_start("dados_projeto");
                $_SESSION['id_do_projeto'] = $id_projeto;
                ?>
                <hr>
                <div class="recebe_resposta_projeto_atualiza"></div>
                <div class="form_projetos">
                    <form class="formulario_projeto_atualiza" method="post">
                        <div class="col-sm-12 col-md-12 col-xs-12" style="height: 70px; ">
                            <div class="col-sm-6 col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label  class="col-md-4 control-label">Nome do Projeto:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" name="nome_projeto_atualiza" value="<?php echo $dados_do_projeto[0] ?>" placeholder="Nome do Projeto" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label  class="col-md-2 control-label">UGB:</label>
                                    <div class="col-md-10" style="height: 35px; ;">
                                        <select class="selectpicker" name="ugb_atualiza" style="width: 100%;height: 100%;">
                                            <option velue="<?php echo $dados_do_projeto[4] ?>"><?php echo $dados_do_projeto[1] ?></option>
                                            <?php
                                            $q_op_ugb = "SELECT * FROM ugb";
                                            $ugb = mysql_query($q_op_ugb);
                                            while ($tipo = mysql_fetch_array($ugb)) {
                                                $id_ugb = $tipo['id_ugb'];
                                                $nome_ugb = $tipo['nome_ugb'];
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
                                            <td style="text-align: left; width:15%;"><center><input type="checkbox" name="id_tarefa_atualiza[]" <?php
                                            if ($projeto->getcheckboxProjeto($id_projeto, $id_tarefa)) {
                                                echo "checked";
                                            }
                                            ?>  value="<?php echo $id_tarefa ?>" ></center></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </table> 
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12" style="height: 90px; margin-top:20px; ">
                            <label  class="col-md-4 control-label">Descricao do Projeto:</label>
                            <textarea rows="3" cols="130"  name="descricao_atualiza"><?php echo $dados_do_projeto[3]; ?></textarea>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12" style="height: 70px; margin-top:20px; ">
                            <button style="background: #01669F; color:white; margin-left:80%;margin-top:20px;" type="submit" class="btn btn-default">Salvar Alterações</button>
                        </div>
                    </form>
                </div> 
                <?php
            } else if ($pagina_veiculo == "view-projeto") {
                include '../model/projetos/projetos.php';
                $projeto_view = new Projetos();
                $id_projeto_view = $_GET['id_projeto'];
                $dados_do_projeto_view = $projeto_view->getDadosProjeto($id_projeto_view);
                $tarefa_do_projeto = $projeto_view->getTarefasProjeto($id_projeto_view);
                include '../model/tarefas/tarefa.php';
                $tarefas_do_projeto = new Tarefa();
                ?>
                <hr>
                <div class="recebe_resposta_projeto_atualiza"></div>
                <div class="form_projetos">
                    <div class="col-sm-12 col-md-12 col-xs-12" style="height: 70px; ">
                        <div class="col-sm-6 col-md-6 col-xs-6">
                            <div class="form-group">
                                <label  class="col-md-4 control-label">Nome do Projeto:</label>
                                <div class="col-md-8">
                                    <input class="form-control" readonly="readonly" value="<?php echo $dados_do_projeto_view[0] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-xs-6">
                            <div class="form-group">
                                <label  class="col-md-2 control-label">UGB:</label>
                                <div class="col-md-10" style="height: 35px; ;">
                                    <input class="form-control" readonly="readonly" value="<?php echo $dados_do_projeto_view[1] ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-xs-12" style="height: 320px; ">
                        <div class="col-sm-12 col-md-12 col-xs-12" style="height: 40px;">
                            <table class="table table-hover">
                                <tr style="background: #666666; color:white;font-size: 1em; ">
                                    <td style="width:35%;  text-align:left;">Nome da tarefa</td>
                                    <td style="width:15%;  text-align:left; ">Duracao</td>
                                    <td style="width:50%;  text-align:left; ">Descrição</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12" style="height: 260px; overflow-y: scroll;overflow-x: hidden;">
                            <table class="table table-hover">
                                    <?php
                                    $max = sizeof($tarefa_do_projeto);
                                    for ($i = 0; $i < $max; $i++) {
                                        $tarefa =  $tarefas_do_projeto->getDadosTarefas($tarefa_do_projeto[$i])
                                        ?>
                                        <tr style=" font-size: 0.9em;">
                                        <td style="text-align: left; width:35%;"><?php echo $tarefa[0] ?></td>
                                        <td style="text-align: left; width:15%;"><?php echo $tarefa[1] ?></td>
                                        <td style="text-align: left; width:50%; "><?php echo $tarefa[2] ?></td> 
                                        </tr>  
                                        <?php
                                    }
                                    ?>
                                  
                            </table> 
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-xs-12" style="height: 90px; margin-top:20px; ">
                        <label  class="col-md-4 control-label">Descricao do Projeto:</label>
                        <textarea rows="3" cols="130" readonly="readonly">  <?php echo $dados_do_projeto_view[3]; ?></textarea>
                    </div>
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
