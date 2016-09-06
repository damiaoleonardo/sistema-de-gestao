<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/rotas/rotas.css" type="text/css">
        <script src="../js/jquery.js" ></script>
        <script src="../js/rotas/busca_rotas.js"></script>
        <script src="../js/rotas/adiciona_veiculo.js"></script>
        <script src="../js/rotas/edita_veiculos.js"></script>
    </head>
    <body>
        <div class="conteudo_da_pagina_rotas">  
            <header class="row_rotas">
                <div class="row_rotas">
                    <div id="titulo_rotas" class="col-sm-8 col-md-8 col-xs-6">
                        <div id="span_rotas"><span>Rotas</span></div>
                    </div>
                    <div id="campo_pesquisa" class="col-sm-4 col-md-4 col-xs-6">
                        <?php
                        $pagina_rota = $_REQUEST['r'];
                        if ($pagina_rota != "rotas") {
                            ?>
                            <form name="form_pesquisa" id="form_pesquisa" method="post" action="">
                                <input type="text" name="pesquisaCliente" id="pesquisaCliente" value="" tabindex="1" placeholder="  Pesquisar rotas..." />	
                            </form>
                            <?php
                        }
                        ?>       
                    </div>
                </div>
            </header>
            <div class="eventos_relacionados_rotas" class="col-sm-12 col-md-12 col-xs-12" >
                <div id="botoes">
                    <a href="telaPrincipal.php?t=rotas&r=cria-rota" class="btn btn-primary" id="button_relatorio_periodo"><span class="glyphicon glyphicon-pencil"></span>Novo</a>
                    <a href="telaPrincipal.php?t=rotas" class="btn btn-primary" id="button_relatorio"><span class="glyphicon glyphicon-floppy-disk"></span>Consultar rota</a>
                </div>
            </div>
            <?php
            if ($pagina_rota == "cria-rota") {
                ?>
                <div class="recebe_resposta"></div>
                <div class="formulario_rota">
                    <form class="form-horizontal" role="form" method="post">
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
                        <div class="col-sm-12 col-md-12 col-xs-12" style="margin-top:10px;">
                            <div class="col-sm-12 col-lg-12">
                                <div class="form-group">
                                    <label  class="col-md-3 control-label">Cor:</label>
                                    <div class="col-md-9">
                                      <input type="color" name="cor_rota">
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
            } else {
                ?>
                <div>
                    <table class='table table-hover' style="width: 97%;">
                        <thead>
                            <tr style="background: #666666; color:white;font-size: 1em">
                                <th style = ' text-align: left; '>Codigo</th>
                                <th style = ' width: 60%;text-align: left;'>Nome</th>
                                <th style = ' width: 20%;'>Cor</th>
                                <th style = ' width: 10%;'>Editar</th>
                                <th style = ' width: 10%;'>Excluir</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="row_conteudo_rotas">
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
