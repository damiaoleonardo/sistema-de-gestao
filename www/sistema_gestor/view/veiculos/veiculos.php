<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/veiculos/veiculos.css" type="text/css">
        <script src="../js/mostrar_dados.js" ></script>
    </head>
    <body>
        <div class="conteudo_da_pagina_veiculo">  
            <header class="row_veiculos">
                <div class="row_veiculo">
                    <div id="titulo_veiculo" class="col-sm-8 col-md-8 col-xs-6">
                        <div id="span_veiculo"><span>Veiculos</span></div>
                    </div>
                    <div id="campo_pesquisa" class="col-sm-4 col-md-4 col-xs-6">
                        <form name="form_pesquisa" id="form_pesquisa" method="post" action="">
                            <input type="text" name="pesquisaCliente" id="pesquisaCliente" value="" tabindex="1" placeholder="  Pesquisar veiculos..." />	
                        </form>
                    </div>
                </div>
            </header>
            <?php
            $pagina_veiculo = $_REQUEST['v'];
            if ($pagina_veiculo == "cria-veiculo") {
                ?>
                <div class="formulario_veiculo">
                    <form class="form-horizontal" role="form" method="post">
                    <div class="col-sm-12 col-md-12 col-xs-12" style="margin-top:10px;" >
                        <div class="col-sm-12 col-lg-12" >
                            <div class="form-group">
                                <label  class="col-md-3 control-label">Nome:</label>
                                <div class="col-md-9">
                                    <input class="form-control" placeholder="Nome" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-xs-12" style="margin-top:10px;">
                        <div class="col-sm-12 col-lg-12">
                            <div class="form-group">
                                <label  class="col-md-3 control-label">Placa:</label>
                                <div class="col-md-4">
                                    <input class="form-control" placeholder="XHF" type="text">
                                </div>
                                <div class="col-md-5">
                                    <input class="form-control" placeholder="1234" type="text">
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-xs-12" style="margin-top:10px;">
                        <div class="col-sm-12 col-lg-12" >
                            <div class="form-group">
                                <label  class="col-md-3 control-label">Tipo:</label>
                                <div class="col-md-9" style="height: 35px; ;">
                                    <select class="selectpicker" style="width: 100%;height: 100%;">
                                        <option></option>
                                        <option>Mustard</option>
                                        <option>Ketchup</option>
                                        <option>Relish</option>
                                    </select>
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
                <div class="row_conteudo_veiculo">
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
        <div class="eventos_relacionados_veiculos">
            <div id="header"></div>
            <div id="botoes">
                <a href="telaPrincipal.php?t=veiculos&v=cria-veiculo" class="btn btn-primary" id="button_relatorio_periodo"><span class="glyphicon glyphicon-pencil"></span>Novo</a>
                <a href="telaPrincipal.php?t=veiculos" class="btn btn-primary" id="button_relatorio"><span class="glyphicon glyphicon-floppy-disk"></span>Consultar</a>
                <a href="#" class="btn btn-primary" id="button_relatorio"><span class="glyphicon glyphicon-floppy-disk"></span>Imprimir</a>
            </div>
        </div>
    </body>
</html>
