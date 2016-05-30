<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/projetos/projetos.css" type="text/css">
        <script src="../js/projetos/busca_projetos.js" ></script>
        <script src="../js/jquery.js" ></script>
    </head>
    <body>
        <div class="conteudo_da_pagina">  
            <header class="row_funcionario">
                <div class="row_func">
                    <div id="titulo_funcionario" class="col-sm-8 col-md-8 col-xs-6">
                        <div id="span_func"><span>Projetos</span></div>
                    </div>
                    <div id="campo_pesquisa" class="col-sm-4 col-md-4 col-xs-6">
                        <form name="form_pesquisa" id="form_pesquisa" method="post" action="">
                            <input type="text" name="pesquisaCliente" id="pesquisaCliente" value="" tabindex="1" placeholder="  Pesquisar projetos..." />	
                        </form>
                    </div>
                </div>
            </header>
            <div class="eventos_relacionados" class="col-sm-12 col-md-12 col-xs-12">
                <div id="botoes">
                    <a href="#" class="btn btn-primary" id="button_relatorio_periodo"><span class="glyphicon glyphicon-pencil"></span>Novo</a>
                    <a href="#" class="btn btn-primary" id="button_relatorio"><span class="glyphicon glyphicon-floppy-disk"></span>Consultar</a>
                </div>
            </div>
            <div>
                <table class='table table-hover'>
                    <thead>
                        <tr style="background: #666666; color:white;font-size: 1.0em;">
                            <th style = ' width: 5%; text-align: left;'>Codigo</th>
                            <th style = ' width: 25%;  text-align: left;'>Projeto</th>
                            <th style = ' width: 5%; '>Duracao</th>
                            <th style = ' width: 40%; text-align: left;'>Descricao</th>
                            <th style = ' width: 5%;  '>Editar</th>
                            <th style = ' width: 5%;  '>Excluir</th>
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
        </div>
    </body>
</html>
