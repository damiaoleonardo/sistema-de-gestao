<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/funcionario/funcionario.css" type="text/css">
        <script src="../js/mostrar_dados.js" ></script>
    </head>
    <body>
        <div class="conteudo_da_pagina">  
            <header class="row_funcionario">
                <div class="row_func">
                    <div id="titulo_funcionario" class="col-sm-8 col-md-8 col-xs-6">
                        <div id="span_func"><span>Funcionarios</span></div>
                    </div>
                    <div id="campo_pesquisa" class="col-sm-4 col-md-4 col-xs-6">
                        <form name="form_pesquisa" id="form_pesquisa" method="post" action="">
                            <input type="text" name="pesquisaCliente" id="pesquisaCliente" value="" tabindex="1" placeholder="  Pesquisar funcionarios..." />	
                        </form>
                    </div>
                </div>
            </header>
            <?php
            $pagina = $_REQUEST['f'];
            if ($pagina == "cria-funcionario") {
                ?>
                <div class="formulario_funcionario">
                    <form class="form-horizontal" role="form" method="post">
                        <div class="row" class="col-sm-4 col-md-4 col-xs-4" >
                            
                            <div class="col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <label  class="col-md-4 control-label">Nome:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" placeholder="Nome" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <label  class="col-md-4 control-label">Sobrenome</label>
                                    <div class="col-md-8">
                                        <input class="form-control"  placeholder="sobrenome" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <label  class="col-md-4 control-label">Tipo:</label>
                                    <div class="col-md-8"  style="height: 35px; ">
                                      <select class="selectpicker" style="width: 100%;height: 100%;">
                                             <option></option>
                                            <option>Administrador</option>
                                            <option>Funcionario</option>
                                            
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" class="col-sm-4 col-md-4 col-xs-4" >
                            <div class="col-sm-6 col-lg-4" >
                                <div class="form-group">
                                    <label  class="col-md-4 control-label">UGB:</label>
                                    <div class="col-md-8" style="height: 35px; ;">
                                        <select class="selectpicker" style="width: 100%;height: 100%;">
                                            <option>Mustard</option>
                                            <option>Ketchup</option>
                                            <option>Relish</option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <label  class="col-md-4 control-label">Endereço</label>
                                    <div class="col-md-8">
                                        <input class="form-control"  placeholder="Endereço" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <label  class="col-md-4 control-label">Bairro:</label>
                                    <div class="col-md-8">
                                        <input class="form-control"  placeholder="Bairro" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" class="col-sm-4 col-md-4 col-xs-4" >
                            <div class="col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <label  class="col-md-4 control-label">Cidade:</label>
                                    <div class="col-md-8">
                                        <input class="form-control"  placeholder="Cidade" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <label  class="col-md-4 control-label">Cep:</label>
                                    <div class="col-md-8">
                                        <input class="form-control"  placeholder="Cep" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <label  class="col-md-4 control-label">UF:</label>
                                    <div class="col-md-8" style="height: 35px; ">
                                        <select class="selectpicker" style="width: 40%;height: 100%;">
                                            <option>Mustard</option>
                                            <option>Ketchup</option>
                                            <option>Relish</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" class="col-sm-4 col-md-4 col-xs-4" >
                             <div class="col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <label  class="col-md-4 control-label">Data de Nascimento:</label>
                                    <div class="col-md-8" style="width: 40%;height: 100%;">
                                        <input class="form-control"  placeholder="Data" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <label  class="col-md-4 control-label">Login:</label>
                                    <div class="col-md-8">
                                        <input class="form-control"  placeholder="Login" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <label  class="col-md-4 control-label">Senha:</label>
                                    <div class="col-md-8">
                                        <input class="form-control"  placeholder="Senha" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>                
                       </form>   
                      </div>
                <?php
            } else {
                ?>
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
        <div class="eventos_relacionados">
            <div id="header"></div>
            <div id="botoes">
                <a href="telaPrincipal.php?t=funcionarios&f=cria-funcionario" class="btn btn-primary" id="button_relatorio_periodo"><span class="glyphicon glyphicon-pencil"></span>Novo</a>
                <a href="telaPrincipal.php?t=funcionarios" class="btn btn-primary" id="button_relatorio"><span class="glyphicon glyphicon-floppy-disk"></span>Consultar</a>
                <a href="#" class="btn btn-primary" id="button_relatorio"><span class="glyphicon glyphicon-floppy-disk"></span>Imprimir</a>
            </div>
        </div>
    </body>
</html>
