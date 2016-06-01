<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/motoristas/motoristas.css" type="text/css">
        <script src="../js/jquery.js"></script>
        <script src="../js/motoristas/busca_motoristas.js"></script>
        <script src="../js/motoristas/adiciona_motoristas.js"></script>
        <script src="../js/motoristas/edita_motoristas.js"></script>
    </head>
    <body>
        <div class="conteudo_da_pagina_motoristas">  
            <header class="row_motoristas">
                <div class="row_motoristas">
                    <div id="titulo_motoristas" class="col-sm-8 col-md-8 col-xs-6">
                        <div id="span_motoristas"><span>Motoritas</span></div>
                    </div>
                    <div id="campo_pesquisa" class="col-sm-4 col-md-4 col-xs-6">
                        <?php
                        $pagina_motorista = $_REQUEST['m'];
                        if ($pagina_motorista != "motoristas") {
                            ?>
                            <form name="form_pesquisa" id="form_pesquisa" method="post" action="">
                                <input type="text" name="pesquisaCliente" id="pesquisaCliente" value="" tabindex="1" placeholder="  Pesquisar motoritas..." />	
                            </form>
                            <?php
                           }
                        ?>       
                    </div>
                </div>
            </header>
            <div class="eventos_relacionados_motoristas" class="col-sm-12 col-md-12 col-xs-12" >
                <div id="botoes">
                    <a href="telaPrincipal.php?t=motoristas&m=cria-motorista" class="btn btn-primary" id="button_relatorio_periodo"><span class="glyphicon glyphicon-pencil"></span>Novo</a>
                    <a href="telaPrincipal.php?t=motoristas" class="btn btn-primary" id="button_relatorio"><span class="glyphicon glyphicon-floppy-disk"></span>Consultar motorista</a>
                </div>
            </div>
            <?php
            if ($pagina_motorista == "cria-motorista") {
               ?>
                 <div class="recebe_resposta"></div>
                <div class="formulario_motorista">
                    <form class="form-horizontal" role="form" method="post">
                        <div class="col-sm-12 col-md-12 col-xs-12" style="margin-top:10px;" >
                            <div class="col-sm-12 col-lg-12" >
                                <div class="form-group">
                                    <label  class="col-md-3 control-label">Nome:</label>
                                    <div class="col-md-9">
                                        <input class="form-control" name="nome" placeholder="Nome" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12" style="margin-top:10px;">
                            <div class="col-sm-12 col-lg-12">
                               <div class="form-group">
                                    <label  class="col-md-3 control-label">Nome:</label>
                                    <div class="col-md-9">
                                        <input class="form-control" name="nome" placeholder="Nome" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12">
                            <button style="background: #01669F; color:white; margin-left:80%;margin-top:20px;" type="submit" class="btn btn-default">Salvar</button>
                        </div>
                    </form>
                </div>
            <?php
            }else{
            ?>
            <div>
                <table class='table table-hover' style="width: 97%;">
                    <thead>
                        <tr style="background: #666666; color:white;font-size: 1em">
                            <th style = ' text-align: left; '>Codigo</th>
                            <th style = ' width: 60%;text-align: left;'>Nome</th>
                            <th style = ' width: 15%;'>Editar</th>
                            <th style = ' width: 15%;'>Excluir</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="row_conteudo_motoristas">
                <div id="contentLoading"><center><div id="loading"></div></center></div>
                <section class="jumbotron">
                    <div id="MostraPesq"></div></section>
            </div>
            <?php
            }
            ?>
        </div>
    </body>
</html>
