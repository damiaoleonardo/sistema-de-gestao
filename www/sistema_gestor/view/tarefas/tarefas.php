<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/tarefas/tarefas.css" type="text/css">
        <script src="../js/mostrar_dados.js" ></script>
    </head>
    <body>
        <div class="conteudo_da_pagina">  
            <header class="row_funcionario">
                <div class="row_func">
                    <div id="titulo_funcionario" class="col-sm-8 col-md-8 col-xs-6">
                        <div id="span_func"><span>Tarefas</span></div>
                    </div>
                    <div id="campo_pesquisa" class="col-sm-4 col-md-4 col-xs-6">
                        <form name="form_pesquisa" id="form_pesquisa" method="post" action="">
                            <input type="text" name="pesquisaCliente" id="pesquisaCliente" value="" tabindex="1" placeholder="  Pesquisar tarefas..." />	
                        </form>
                    </div>
                </div>
            </header>
            <div class="row_conteudo">
                <div id="contentLoading">
                    <center><div id="loading"></div></center>
                </div>
                <section class="jumbotron">
                    <div id="MostraPesq"></div>
                </section>
            </div>
        </div>
        <div class="eventos_relacionados">
            <div id="header"></div>
            <div id="botoes">
                <a href="#" class="btn btn-primary" id="button_relatorio_periodo"><span class="glyphicon glyphicon-pencil"></span>Novo</a>
                <a href="#" class="btn btn-primary" id="button_relatorio"><span class="glyphicon glyphicon-floppy-disk"></span>Salvar</a>
            </div>
        </div>
    </body>
</html>
