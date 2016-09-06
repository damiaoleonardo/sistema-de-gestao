<?php
if (isset($_GET['flag_atividade'])) {
    $conexao_delete_atividade = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
    $erro_delete_atividade = 0;
    $id_atividade = $_GET['id_atividade_controle'];
    $sql_delete_atividade = "delete from atividades_controle where atividades_controle.id_atividade_controle = $id_atividade";
    if (!mysqli_query($conexao_delete_atividade, $sql_delete_atividade)) {
        $erro_delete_atividade++;
    }
    if ($erro_delete_atividade == 0) {
        mysqli_commit($conexao_delete_atividade);
        echo "<script>alert('Atividade excluida com sucesso!')</script>";
        echo "<script>location.href='telaPrincipal.php?t=atividades-controle'</script>";
    } else {
        mysqli_rollback($conexao_delete_atividade);
        echo "<script>alert('Erro ao excluir a Atividade!')</script>";
        echo "<script>location.href='telaPrincipal.php?t=atividades-controle'</script>";
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/controle-manutencao/atividades-controle.css" type="text/css">
        <script src="../js/jquery.js"></script>
        <script src="../js/controle-manutencao/busca_atividades.js"></script>
        <script src="../js/controle-manutencao/adiciona_atividade.js"></script>
        <script src="../js/controle-manutencao/atualiza_atividade.js"></script>
    </head>
    <body>
        <div class="conteudo_da_pagina_atividades">  
            <header class="row_atividades">
                <div class="row_atividades">
                    <div id="titulo_atividades" class="col-sm-8 col-md-8 col-xs-6">
                        <div id="span_atividades"><span>Atividades do Controle</span></div>
                    </div>
                    <div id="campo_pesquisa" class="col-sm-4 col-md-4 col-xs-6">
                        <?php
                        $pagina_atividade = $_REQUEST['a'];
                        if ($pagina_atividade != "cria-atividade") {
                            ?>
                            <form name="form_pesquisa" id="form_pesquisa" method="post" action="">
                                <input type="text" name="pesquisaCliente" id="pesquisaCliente" value="" tabindex="1" placeholder="  Pesquisar atividades..." />	
                            </form>
                            <?php
                        }
                        ?>       
                    </div>
                </div>
            </header>
            <div class="eventos_relacionados_atividades" class="col-sm-12 col-md-12 col-xs-12">
                <div id="botoes">
                    <a href="telaPrincipal.php?t=atividades-controle&a=cria-atividade" class="btn btn-primary" id="button_relatorio_periodo"><span class="glyphicon glyphicon-pencil"></span>Nova atividade</a>
                    <a href="telaPrincipal.php?t=atividades-controle" class="btn btn-primary" id="button_relatorio"><span class="glyphicon glyphicon-floppy-disk"></span>Consultar atividades</a>
                </div>
            </div>
            <?php
            if ($pagina_atividade == "cria-atividade") {
                ?>
                <div class="recebe_resposta"></div>
                <div class="formulario_atividades">
                    <form class="form-horizontal" role="form" method="post">
                        <div class="col-sm-12 col-md-12 col-xs-12" style="margin-top:10px;">
                            <div class="col-sm-12 col-lg-12">
                                <div class="form-group">
                                    <label  class="col-md-3 control-label">Nome:</label>
                                   <select class="col-sm-8 col-lg-8" class="selectpicker" style="height: 30px; margin-left:15px;" name="projeto">
                                    <option value="0" selected="selected" ></option>
                                    <?php 
                                     include '../model/controle-manutencao/ControleManutencao.php';
                                     $controle = new ControleManutencao();
                                     $dados_projeto = $controle->getDadosTarefas();
                                     $tamanho_array = sizeof($dados_projeto);
                                     for($i= 0; $i < $tamanho_array ; $i+=2){
                                       ?>
                                        <option value="<?php echo $dados_projeto[$i] ?>" selected="selected"><?php echo $dados_projeto[$i + 1] ?></option>
                                       <?php
                                     }
                                    ?>
                                   </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-12">
                              <div class="form-group">
                                <label class="col-md-3 control-label">Tipo:</label>
                                <select class="col-sm-8 col-lg-8" class="selectpicker" style="height: 30px; margin-left:15px;"  name="campo_select_tipo">
                                    <option value="0" selected="selected" ></option>
                                    <option value="inspecao" selected="selected">Inspecao</option>
                                    <option value="preventiva" selected="selected">Preventiva</option>
                                </select>
                               </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12">
                            <button style="background: #01669F; color:white; margin-left:80%;margin-top:20px;" type="submit" class="btn btn-default">Salvar Atividade</button>
                       </div>
                    </form>
                </div>
                <?php
            }else if($pagina_atividade == "atualiza_atividade"){
                $id_atividade = $_GET['id_atividade_controle'];
                include '../model/controle-manutencao/ControleManutencao.php';
                $controle = new ControleManutencao();
                $dados_atividade =  $controle->getDadosAtividades($id_atividade);
                session_start("nome_atividade");
                $_SESSION['nome_da_atividade']= $dados_atividade[0];
                $_SESSION['id_atividade']  = $id_atividade;
                ?>
           <div class="recebe_resposta"></div>
                <div class="formulario_atividades">
                    <form class="form-update" role="form" method="post">
                        <div class="col-sm-12 col-md-12 col-xs-12" style="margin-top:10px;">
                            <div class="col-sm-12 col-lg-12" style="height: 60px;">
                                <div class="form-group">
                                    <label  class="col-md-3 control-label">Nome:</label>
                                    <select class="col-sm-8 col-lg-8" class="selectpicker" style="height: 30px; margin-left:15px;"  name="projeto_update">
                                     <?php 
                                     $dados_projeto_update = $controle->getDadosProjetos();
                                     $tamanho_array = sizeof($dados_projeto_update);
                                     for($i= 0; $i < $tamanho_array ; $i+=2){
                                       ?>
                                        <option value="<?php echo $dados_projeto_update[$i] ?>" selected="selected"><?php echo $dados_projeto_update[$i + 1] ?></option>
                                       <?php
                                     }
                                    ?>
                                  </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-12">
                              <div class="form-group">
                                <label class="col-md-3 control-label">Tipo:</label>
                                <select class="col-sm-8 col-lg-8" class="selectpicker" style="height: 30px; margin-left:15px;"  name="campo_select_tipo_update">
                                    <option value="<?php echo $dados_atividade[1]  ?>" selected="selected" ><?php echo $dados_atividade[1] ?></option>
                                    <option value="inspecao" selected="selected">Inspecao</option>
                                    <option value="preventina" selected="selected">Preventiva</option>
                                </select>
                               </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12">
                            <button style="background: #01669F; color:white; margin-left:80%;margin-top:20px;" type="submit" class="btn btn-default">Alterar Atividade</button>
                       </div>
                    </form>
                </div>
            <?php
            } else {
                 ?>
                <div>
                    <table class='table table-hover' style="width: 97%;">
                        <thead>
                            <tr style="background: #666666; color:white;font-size: 1em">
                                <th style = ' width: 10%; text-align: left; '>Codigo</th>
                                <th style = ' width: 60%;text-align: left;'>Nome</th>
                                <th style = ' width: 10%;'>Tipo</th>
                                <th style = ' width: 10%;'>Editar</th>
                                <th style = ' width: 10%;'>Excluir</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="row_conteudo_atividades">
                    <div id="contentLoading"><center><div id="loading"></div></center></div>
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
