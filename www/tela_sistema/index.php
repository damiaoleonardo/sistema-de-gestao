<?php
require('model/Conexao/Connection.class.php');
$conexao = Connection::getInstance();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="refresh" content="50">
        <title>Sistema de Gestão</title>
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon"/>
        <link rel="stylesheet" href="style/tela_principal.css" type="text/css">
        <link rel="stylesheet" href="style/slider_show.css" type="text/css">
        <link rel="stylesheet" href="style/bootstrap/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="style/bootstrap/class_table.css" type="text/css">
        <script src="js/arquivo_slider.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.js"></script>
        <script src="js/scroll_auto.js"></script>
        <script src="js/scrollauto_programacao.js"></script>
        <style>
            indicators {
                bottom: 0px;
            }
            .carousel-indicators {
                position: absolute;
                bottom: 0px;
                left: 0%;
                z-index: 0;
                width: 1300px;
                padding-left: 0;
                margin-left: 0%;
                text-align: center;
                list-style: none;
            }
            .carousel {
                width: 100%;
                height: 540px;
                margin-bottom: 60px;
            }

            .carousel .item {
                width: 100%;
                height: 540px;
                background-color: #777;
            }
            .carousel-inner > .item > img {
                top: 0;
                left: 0;
                min-width: 100%;
                height: 500px;
            }

            .carousel .item {
                height: 100%;
                background-color: white;
            }
            .carousel-caption {
                right: 0%;
                left: 0%;
                padding-bottom: 0px;
            }
            .carousel-caption {
                position: relative;
                right: 0%;
                bottom: 0px;
                left: 0%;
                z-index: 10;
                padding-top: 0px;
                padding-bottom: 0px;
                text-align: center;
                text-shadow: 0 0px 0px rgba(0,0,0,.6);
            }
            .container {
                width: 1300px;
            }
            .container {

                padding-right: 20px;
                padding-left: 0px;
                margin-right: 0px;
                margin-left: 0px;

            }
        </style>
    </head>
    <body onload="scrollDiv_init(); Rolar();">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12" id="header"></div>
            <div class="col-md-12 col-sm-12 col-xs-12" id="conteudo">
                <div id="myCarousel" class="carousel slide" data-ride="carousel" >
                    <div class="carousel-inner" role="listbox" >
                        <div class="item active">
                            <div class="container">
                                <div class="carousel-caption">
                                    <div  style=" height: 90%; width: 100%; margin-left:2%; margin-top:2%; ">
                                        <?php
                                        require './control/paginaInicial/TabelaInicialativosController.php';
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">                 
                            <div >
                                <div class="carousel-caption">
                                    <div style=" width: 100%;   margin-top:2%;">
                                        <table class='table table-hover' style="width: 100%;">
                                            <tr style="background:#449d44; color:white;"><td colspan="5" >Projetos Abertos </td></tr>
                                            <tr style="font-size: 1.2em; background: #adadad; color:white;">
                                                <td style="width: 25%;">Funcionario</td>
                                                <td style="width: 50%;">Projeto</td>
                                                <td style="width: 25%;">Veiculo</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div style="width: 100%;margin-top:2%; overflow:auto;">
                                        <div id="MyDivName" onMouseOver="pauseDiv()" onMouseOut="resumeDiv()">
                                            <?php
                                              require './control/paginaInicial/projeto_abertos.php';
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  
                            parte das telas que nao foram utilizadas no momento
                            <div class="item" >                 
                                    <div style="width: 100%; height: 100%;">
                                        <div>
                            <?php
                            require './control/paginaInicial/ugb_mes.php';
                            ?>
        
                                        </div>
                                    </div>
                                </div>
                                <div class="item">                 
                                    <div style="width: 100%; height: 100%;">
                                        <div>
                            <?php
                            require './control/paginaInicial/ugb_tipo.php';
                            ?>
        
                                        </div>
                                    </div>
                                </div>
                                <div class="item">                 
                                    <div style="width: 100%; height: 100%;">
                                        <div>
                            <?php
                            require './control/paginaInicial/aniversariantes_mes.php';
                            ?>
                                        </div>
                                    </div>
                                </div>-->
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12" id="footer" ></div>
            </div>
    </body>
</html>
