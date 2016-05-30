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
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php
        $tabela = $_REQUEST['t'];
        if ($tabela == 'home') {
            ?>
            <meta http-equiv="refresh" content="20">
            <?php
        }
        ?>
        <header>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
                        <div class="collapse navbar-collapse navbar-ex1-collapse" style="color: white; font-size:1em;">
                            <ul class="nav navbar-nav" style="margin-left: 0px ; ">
                                <li><a href="telaPrincipal.php?t=home"><span style="color:white;">Execucao</span></a></li>
                                <li class="menu-item dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" ><span style="color:white;">Cadastro</span><b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li style="text-align: left;"><a href="telaPrincipal.php?t=funcionarios">Funcionarios</a></li>
                                        <li style="text-align: left;"><a href="telaPrincipal.php?t=veiculos">Veiculos</a></li>
                                        <li style="text-align: left;"><a href="telaPrincipal.php?t=tarefas">Tarefas</a></li>
                                        <li style="text-align: left;"><a href="telaPrincipal.php?t=projetos">Projetos</a></li>
                                        <li class="menu-item dropdown dropdown-submenu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-align: left; ">Viagens</a>
                                            <ul class="dropdown-menu" >
                                                <li class="menu-item " style="text-align: left;">
                                                    <a href="telaPrincipal.php?t=rotas">Rotas</a>
                                                </li>
                                                <li class="menu-item " style="text-align: left;">
                                                    <a href="telaPrincipal.php?t=motoristas">Motorista</a>
                                                </li>                                 
                                            </ul>
                                        </li>
                                        <li class="menu-item dropdown dropdown-submenu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-align: left; ">Exibição TV</a>
                                            <ul class="dropdown-menu" >
                                                <li class="menu-item " style="text-align: left;">
                                                    <a href="telaPrincipal.php?t=ugb-do-mes">UGB do Mes</a>
                                                </li>
                                                <li class="menu-item " style="text-align: left;">
                                                    <a href="telaPrincipal.php?t=ugb-tipo">UGB tipo</a>
                                                </li> 
                                                <li class="menu-item " style="text-align: left;">
                                                    <a href="telaPrincipal.php?t=slider-imagens">Imagens Slider</a>
                                                </li>  
                                            </ul>
                                        </li>   
                                    </ul>
                                </li>
                                <li><a href="telaPrincipal.php?t=controle-manutencao-veiculos"><span style="color:white; ">Controle de Manutenção</span></a></li>
                                <li><a href="telaPrincipal.php?t=programacao-semanal"><span style="color:white; ">Programação Semanal</span></a></li>
                                <li class="menu-item dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color:white;">Relatorios<b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="telaPrincipal.php?t=relatorios/projetos-finalizado" style="text-align: left; "><span style="color:white; ">Projetos</span></a></li>
                                        <li><a href="telaPrincipal.php?t=relatorios/tarefas" style="text-align: left; ">Tarefas</a></li> 
                                        <li class="menu-item dropdown dropdown-submenu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-align: left; ">Funcionario</a>
                                            <ul class="dropdown-menu" >
                                                <li class="menu-item " style="text-align: left;">
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
                                    </ul>
                                </li>
                                <li class="menu-item dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" ><span style="color:white;">Indicadores</span><b class="caret"></b></a>
                                    <ul class="dropdown-menu"  >
                                        <li style="text-align: left;  "><a href="telaPrincipal.php?t=atividade-semanal">Atividade Semanal</a></li>

                                    </ul>
                                </li>
                                <li id="usuario" style="text-align: left; float:right; width: 200px;">
                                    <a  class="dropdown-toggle" data-toggle="dropdown" href="#"><img src="../img/usuario.png"><span>Diogenes</span></span></a>
                                    <ul class="dropdown-menu" >
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
            } else if ($tabela == 'relatorios/projetos-finalizado') {
                ?>
                <div class="relatorio_projeto"><?php require './relatorios/projetos/projetos_finalizados.php'; ?></div><?php
            } else if ($tabela == 'relatorios/funcionario/custo') {
                ?>
                <div class="relatorio_funcionario-custo"><?php require './relatorios/funcionario/relatorio_custo.php'; ?></div><?php
            } else if ($tabela == 'relatorios/funcionario/ativo-inativo') {
                ?>
                <div class="relatorio_funcionario-inativo-ativo"><?php require './relatorios/funcionario/relatorio_periodo.php'; ?></div><?php
            } else if ($tabela == 'atividade-semanal') {
                ?>
                <div class="atividade_semanal"><?php require './indicadores/indicadores.php'; ?></div><?php
            } else if ($tabela == 'programacao-semanal') {
                ?>
                <div class="programacao-semanal"><?php require './programacao-semanal/programacao_semanal.php'; ?></div><?php
            } else if ($tabela == 'rotas') {
                ?>
                <div class="rotas"><?php require './rotas/rotas.php'; ?></div><?php
            } else if ($tabela == 'motoristas') {
                ?>
                <div class="motoristas"><?php require './motorista/motorista.php'; ?></div><?php
            } else if ($tabela == 'ugb-do-mes') {
                ?>
                <div class="ugb_mes"><?php require './ugb_do_mes/ugb_mes.php'; ?></div><?php
            } else if ($tabela == 'ugb-tipo') {
                ?>
                <div class="ugb_mes"><?php require './ugb_tipo/ugb_tipo.php'; ?></div><?php
            } else {
                ?>
                <div class="tela_inicial"><?php require 'grafico_execucao.php'; ?></div><?php
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



