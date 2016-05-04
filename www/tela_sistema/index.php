<?php
require('model/Conexao/Connection.class.php');
$conexao = Connection::getInstance();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="refresh" content="30">
        <title>Sistema de Gestão</title>
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon"/>
        <link rel="stylesheet" href="style/tela_principal.css" type="text/css">
        <link rel="stylesheet" href="style/bootstrap/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="style/bootstrap/class_table.css" type="text/css">

        <script language="javascript">
            ScrollRate = 20;

            function scrollDiv_init() {
                DivElmnt = document.getElementById('tela_right');
                ReachedMaxScroll = false;

                DivElmnt.scrollTop = 0;
                PreviousScrollTop = 0;

                ScrollInterval = setInterval('scrollDiv()', ScrollRate);
            }

            function scrollDiv() {

                if (!ReachedMaxScroll) {
                    DivElmnt.scrollTop = PreviousScrollTop;
                    PreviousScrollTop++;

                    ReachedMaxScroll = DivElmnt.scrollTop >= (DivElmnt.scrollHeight - DivElmnt.offsetHeight);
                } else {
                    ReachedMaxScroll = (DivElmnt.scrollTop == 0) ? false : true;

                    DivElmnt.scrollTop = PreviousScrollTop;
                    PreviousScrollTop--;
                }
            }

            function pauseDiv() {
                clearInterval(ScrollInterval);
            }

            function resumeDiv() {
                PreviousScrollTop = DivElmnt.scrollTop;
                ScrollInterval = setInterval('scrollDiv()', ScrollRate);
            }
        </script>
    </head>
    <body  onLoad="scrollDiv_init()" >
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12" id="header"></div>
            <div class="col-md-12 col-sm-12 col-xs-12" id="conteudo">
                <div  id="tela_left">
                    <?php
                    require './control/paginaInicial/TabelaInicialativosController.php';
                    ?>
                </div>
                <div  id="tela_right"  style="overflow:auto;" >
                    <div id="MyDivName" onMouseOver="pauseDiv()" onMouseOut="resumeDiv()">
                    <?php
                    require './control/paginaInicial/projeto_abertos.php';
                    ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12" id="footer"></div>
        </div>
    </body>
</html>
