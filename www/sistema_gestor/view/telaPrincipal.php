<?php
require('../model/Conexao/Connection.class.php');
$conexao = Connection::getInstance();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistema de Gestão</title>
        <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="../style/principal/principal.css" type="text/css">
        <link rel="stylesheet" href="../style/bootstrap/class_table.css" type="text/css">
        <link rel="stylesheet" href="../style/bootstrap/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="../style/principal/menu.css" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
    <body>
        <header>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
                        <div class="collapse navbar-collapse navbar-ex1-collapse" style="color: white;">
                            <ul class="nav navbar-nav" style="margin-left: 0px ; ">
                                <li><a href="telaPrincipal.php?t=home"><span style="color:white; font-size:1em;">Execucao</span></a></li>
                                <li class="menu-item dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" ><span style="color:white; font-size:1em;">Cadastro</span><b class="caret"></b></a>
                                    <ul class="dropdown-menu"  >
                                        <li style="text-align: left;"><a href="telaPrincipal.php?t=funcionarios">Funcionarios</a></li>
                                        <li style="text-align: left;"><a href="telaPrincipal.php?t=veiculos">Veiculos</a></li>
                                        <li style="text-align: left;"><a href="telaPrincipal.php?t=tarefas">Tarefas</a></li>
                                        <li style="text-align: left;"><a href="telaPrincipal.php?t=projetos">Projetos</a></li>
                                    </ul>
                                </li>
                                <li><a href="telaPrincipal.php?t=controle-manutencao-veiculos"><span style="color:white; font-size:1em;">Controle de Manutenção</span></a></li>
                                <li class="menu-item dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color:white; font-size:1em;">Relatorios<b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li style="text-align: left;"><a href="telaPrincipal.php?t=relatorios/projetos">Projeto</a></li>
                                        <li style="text-align: left;"><a href="telaPrincipal.php?t=relatorios/tarefas">Tarefas</a></li> 
                                        <li class="menu-item dropdown dropdown-submenu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-align: left;">Funcionario</a>
                                            <ul class="dropdown-menu">
                                                <li class="menu-item">
                                                    <a href="telaPrincipal.php?t=relatorios/funcionario/custo">Custo</a>
                                                </li>
                                                <li class="menu-item ">
                                                    <a href="telaPrincipal.php?t=relatorios/funcionario/ativo-inativo">Ativo/Inativo</a>
                                                </li>
                                                <!--  <li class="menu-item dropdown dropdown-submenu">
                                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Level 2</a>
                                                      <ul class="dropdown-menu">
                                                          <li>
                                                              <a href="#">Link 3</a>
                                                          </li>
                                                      </ul>
                                                  </li>-->
                                            </ul>
                                        </li>
                                        <li style="text-align: left;"><a href="telaPrincipal.php?t=projetos">Graficos</a></li>
                                    </ul>
                                </li>
                                <li id="usuario" style="text-align: left; float:right; width: 200px; ">
                                    <a  class="dropdown-toggle" data-toggle="dropdown" href="#"  ><img src="../img/usuario.png"><span>Diogenes</span></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Troca Senha</a></li>
                                        <li><a href="../index.php">Sair</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="conteudo_central">          
            <?php
            $tabela = $_REQUEST['t'];
            if ($tabela == 'home') {
                ?>
                <div class="tela_inicial"><?php require 'grafico_execucao.php'; ?></div><?php
            } else if ($tabela == 'funcionarios') {
                ?>
                <div class="funcionario"><?php require './funcionario/funcionario.php'; ?></div><?php
            } else if ($tabela == 'veiculos') {
                ?>
                <div class="veiculos"><?php require './veiculos/veiculos.php'; ?></div><?php
            } else if ($tabela == 'projetos') {
                ?>
                <div class="projetos"><?php require './projetos/projetos.php'; ?></div><?php
            } else if ($tabela == 'tarefas') {
                ?>
                <div class="tarefas"><?php require './tarefas/tarefas.php'; ?></div><?php
            } else if ($tabela == 'controle-manutencao-veiculos') {
                ?>
                <div class="controle_manutencao"><?php require './controle-manutencao/controle_manutencao.php'; ?></div><?php
            } else if ($tabela == 'relatorios/tarefas') {
                ?>
                <div class="relatorio_projeto"><?php require './relatorios/tarefas/tarefas.php'; ?></div><?php
            } else if ($tabela == 'relatorios/projetos') {
                ?>
                <div class="relatorio_projeto"><?php require './relatorios/projetos/projetos.php'; ?></div><?php
            } else if ($tabela == 'relatorios/funcionario/custo') {
                ?>
                <div class="relatorio_funcionario-custo"><?php require './relatorios/funcionario/relatorio_custo.php';?></div><?php
            } else if ($tabela == 'relatorios/funcionario/ativo-inativo') {
                ?>
                <div class="relatorio_funcionario-inativo-ativo"><?php require './relatorios/funcionario/relatorio_periodo.php';?></div><?php
            }
            ?>             
        </div>
        <footer>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12"></div>
            </div>
        </footer>
    </body>
</html>

<!--

 <ul class="nav nav-tabs" style="border-bottom: 1px solid #204d74">
                        <li><a href="telaPrincipal.php?t=home">Execução</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Cadastros<span class="caret"></span></a>
                            <ul class="dropdown-menu"  >
                                <li style="text-align: left;"><a href="telaPrincipal.php?t=funcionarios">Funcionarios</a></li>
                                <li style="text-align: left;"><a href="telaPrincipal.php?t=veiculos">Veiculos</a></li>
                                <li style="text-align: left;"><a href="telaPrincipal.php?t=tarefas">Tarefas</a></li>
                                <li style="text-align: left;"><a href="telaPrincipal.php?t=projetos">Projetos</a></li>
                            </ul>
                        </li>
                        <li><a href="telaPrincipal.php?t=controle-manutencao-veiculos">Controle de Manutenção</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Relatorios<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li style="text-align: left;"><a href="telaPrincipal.php?t=relatorios/projetos">Projeto</a></li>
                                <li style="text-align: left;"><a href="telaPrincipal.php?t=relatorios/tarefas">Tarefas</a></li> 
                                <li style="text-align: left;"><a href="#">Graficos</a></li>
                            </ul>
                        </li>                        
                    </ul>



<div id="usuario" class="col-md-3 col-sm-2 col-xs-4">
                    <a  class="dropdown-toggle" data-toggle="dropdown" href="#"><img src="../img/usuario.png"><span class="caret"></span></a><span>Diogenes</span>
                    <ul class="dropdown-menu">
                        <li><a href="#">Troca Senha</a></li>
                        <li><a href="../index.php">Sair</a></li>
                    </ul>
                </div>

-->



