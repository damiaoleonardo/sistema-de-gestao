<?php
require('model/Conexao/Connection.class.php');
$conexao = Connection::getInstance();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistema de Gestão</title>
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="style/tela_principal.css" type="text/css">
        <link rel="stylesheet" href="style/bootstrap/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="style/bootstrap/class_table.css" type="text/css">
    </head>
    <body>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12" id="header"></div>
            <div class="col-md-12 col-sm-12 col-xs-12" id="conteudo">
                <div  id="tela_left">
                    <?php
                    require './control/paginaInicial/TabelaInicialativosController.php';
                    ?>
                </div>
                <div  id="tela_right">
                    <?php
                    require './control/paginaInicial/projeto_abertos.php';
                    ?>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12" id="footer"></div>
        </div>
    </body>
</html>
