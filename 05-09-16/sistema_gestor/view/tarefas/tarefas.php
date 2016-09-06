<?php
if (isset($_GET['flag_tarefa'])) {
    $conexao_delete_tarefa = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
    $erro_delete_tarefa = 0;
    $id_tarefa = $_GET['id_tarefa'];
    $sql_delete_tarefa = "delete from tarefas where tarefas.id_tarefa = $id_tarefa";
    if (!mysqli_query($conexao_delete_tarefa, $sql_delete_tarefa)) {
        $erro_delete_tarefa++;
    }
    $sql_delete_certificadores = "delete from certificacoes where certificacoes.id_tarefa = $id_tarefa";
    if (!mysqli_query($conexao_delete_tarefa, $sql_delete_certificadores)) {
        $erro_delete_tarefa++;
    }
    if ($erro_delete_tarefa == 0) {
        mysqli_commit($conexao_delete_tarefa);
        echo "<script>alert('Tarefa excluida com sucesso!')</script>";
        echo "<script>location.href='../view/telaPrincipal.php?t=tarefas'</script>";
    } else {
        mysqli_rollback($conexao_delete_tarefa);
        echo "<script>alert('Erro ao excluir a tarefa!')</script>";
        echo "<script>location.href='../view/telaPrincipal.php?t=tarefas'</script>";
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/tarefas/tarefas.css" type="text/css">
        <link href="../style/tarefas/css_duracao.css" rel="stylesheet">
        <script src="../js/jquery.js"></script>
        <script src="../js/tarefas/busca_tarefa.js" ></script>
        <script src="../js/tarefas/js_duracao.js"></script>
        <script src="../js/tarefas/adiciona_tarefa.js"></script>
        <script src="../js/tarefas/atualiza_tarefa.js"></script>
    </head>
    <body>
        <div class="conteudo_da_pagina">  
            <header class="row_funcionario">
                <div class="row_func">
                    <div id="titulo_funcionario" class="col-sm-8 col-md-8 col-xs-6">
                        <div id="span_func"><span>Tarefas</span></div>
                    </div>
                    <div id="campo_pesquisa" class="col-sm-4 col-md-4 col-xs-6">
                        <?php
                        $pagina_tarefa = $_REQUEST['ta'];
                        if ($pagina_tarefa != "cria-tarefa" && $pagina_tarefa != "edit-tarefa") {
                            ?>
                            <form name="form_pesquisa" id="form_pesquisa" method="post" action="">
                                <input type="text" name="pesquisaCliente" id="pesquisaCliente" value="" tabindex="1" placeholder="  Pesquisar tarefas..." />	
                            </form>
                            <?php
                        }
                        ?>  
                    </div>
                </div>
            </header>
            <div class="eventos_relacionados" class="col-sm-12 col-md-12 col-xs-12">
                <div id="botoes">
                    <a href="telaPrincipal.php?t=tarefas&ta=cria-tarefa" class="btn btn-primary" id="button_relatorio_periodo"><span class="glyphicon glyphicon-pencil"></span>Adicionar Tarefa</a>
                    <a href="telaPrincipal.php?t=tarefas" class="btn btn-primary" id="button_relatorio"><span class="glyphicon glyphicon-floppy-disk"></span>Consultar</a>
                </div>
            </div>
            <?php
            if ($pagina_tarefa == "cria-tarefa") {
                ?>
                <div class="recebe_resposta_tarefa"></div>
                <div class="form_tarefas">
                    <form class="formulario_tarefa" method="post">
                        <div class="col-sm-12 col-md-12 col-xs-12" style="height: 70px; ">
                            <div class="col-sm-6 col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label  class="col-md-3 control-label">Nome:</label>
                                    <div class="col-md-9">
                                        <input class="form-control" name="nome_tarefa" placeholder="Nome" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xs-6">
                                <label  class="col-md-3 control-label">Duracao:</label>
                                <div id="datetimepicker3" class="input-append">
                                    <input data-format="hh:mm:ss" name="duracao" value="00:00:00" type="text"></input>
                                    <span class="add-on">
                                        <i data-time-icon="icon-calendar" data-date-icon="icon-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12" style="height: 220px;">
                            <div class="col-sm-12 col-md-12 col-xs-12" style="height: 40px;">
                                <table class="table table-hover">
                                    <tr style="background: #666666; color:white;font-size: 1.1em; ">
                                        <td style="width:10%;  text-align:left;">Codigo</td>
                                        <td style="width:40%;  text-align:left; ">Nome</td>
                                        <td style="width:15%;  text-align:center; ">select</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-12 col-md-12 col-xs-12" style="height: 190px; overflow: scroll;">
                                <table class="table table-hover" >
                                    <?php
                                    $sql = "select * from funcionarios where tipo= 'Funcionario'";
                                    $result = mysql_query($sql);
                                    while ($recebe = mysql_fetch_array($result)) {
                                        $id_funcionario = $recebe['id_funcionario'];
                                        $nome = $recebe['sobrenome'];
                                        ?>
                                        <tr>
                                            <td style="text-align: left;"><?php echo $id_funcionario ?></td>
                                            <td style="text-align: left;"><?php echo $nome ?></td>
                                            <td><center><input type="checkbox" name="id_funcionario[]" value="<?php echo $id_funcionario ?>"</center></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </table> 
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12" style="height: 100px; margin-top:20px;">
                            <label  class="col-md-3 control-label">Descricao:</label>
                            <textarea rows="3" cols="60"  name="descricao"></textarea>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12" style="height: 100px; margin-top:20px; ">
                            <button style="background: #01669F; color:white; margin-left:80%;margin-top:20px;" type="submit" class="btn btn-default">Salvar Tarefa</button>
                        </div>
                    </form>
                </div>  
                <?php
            } else if ($pagina_tarefa == "edit-tarefa") {
                include '../model/tarefas/tarefa.php';
                $tarefa = new Tarefa();
                $id_tarefa = $_GET['id'];
                $dados_da_tarefa = $tarefa->getDadosTarefas($id_tarefa);
                session_start("dados_tarefa");
                $_SESSION['id_da_tarefa'] = $id_tarefa;
                ?>
                <div class="recebe_resposta_atualiza_tarefa"></div>
                <div class="form_tarefas">
                    <form class="formulario_atualiza_tarefa" method="post" action="">
                        <div class="col-sm-12 col-md-12 col-xs-12" style="height: 70px;">
                            <div class="col-sm-6 col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Nome:</label>
                                    <div class="col-md-9">
                                        <input class="form-control" name="nome_tarefa_atualiza" value="<?php echo $dados_da_tarefa[0]; ?>" placeholder="Nome" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xs-6">
                                <label  class="col-md-3 control-label">Duracao:</label>
                                <div id="datetimepicker3" class="input-append">
                                    <input data-format="hh:mm:ss" name="duracao_atualiza" value="<?php echo $dados_da_tarefa[1]; ?>" type="text"></input>
                                    <span class="add-on">
                                        <i data-time-icon="icon-calendar" data-date-icon="icon-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12" style="height: 220px;">
                            <div class="col-sm-12 col-md-12 col-xs-12" style="height: 40px;">
                                <table class="table table-hover">
                                    <tr style="background: #666666; color:white;font-size: 1.1em; ">
                                        <td style="width:10%;  text-align:left;">Codigo</td>
                                        <td style="width:40%;  text-align:left; ">Nome</td>
                                        <td style="width:15%;  text-align:center; ">select</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-12 col-md-12 col-xs-12" style="height: 190px; overflow: scroll;">
                                <table class="table table-hover" >
                                    <?php
                                    $sql = "select * from funcionarios where tipo= 'Funcionario'";
                                    $result = mysql_query($sql);
                                    while ($recebe = mysql_fetch_array($result)) {
                                        $id_funcionario = $recebe['id_funcionario'];
                                        $nome = $recebe['sobrenome'];
                                        ?>
                                        <tr>
                                            <td style="text-align: left;"><?php echo $id_funcionario ?></td>
                                            <td style="text-align: left;"><?php echo $nome ?></td>
                                            <td><center><input type="checkbox" name="id_funcionario_atualiza[]" <?php
                                            if ($tarefa->getcheckbox($id_tarefa, $id_funcionario)) {
                                                echo "checked";
                                            }
                                            ?>  value="<?php echo $id_funcionario ?>" ></center></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </table> 
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12" style="height: 100px; margin-top:20px;">
                            <label  class="col-md-3 control-label">Descricao:</label>
                            <textarea rows="3" cols="60"  name="descricao_atualiza"><?php echo $dados_da_tarefa[2]; ?></textarea>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12" style="height: 100px; margin-top:20px; ">
                            <button style="background: #01669F; color:white; margin-left:80%;margin-top:20px;" type="submit" class="btn btn-default">Salvar Alterações</button>
                        </div>
                    </form>
                </div>  
                <?php
            } else {
                ?>
                <div>
                    <table class='table table-hover'>
                        <thead>
                            <tr style=" background: #666666; color:white;font-size: 1em;">
                                <th style = ' width: 5%; text-align: left;'>Codigo</th>
                                <th style = ' width: 15%; text-align: left; '>Nome</th>
                                <th style = ' width: 10%; '>Duracao</th>
                                <th style = ' width: 30%; text-align: left;'>Descricao</th>
                                <th style = ' width: 5%; '>Editar</th>
                                <th style = ' width: 5%; '>Excluir</th>
                            </tr>
                        </thead>
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
