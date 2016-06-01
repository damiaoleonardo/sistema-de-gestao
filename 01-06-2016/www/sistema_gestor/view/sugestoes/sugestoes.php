<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style/sugestoes/sugestoes.css" type="text/css">
        <link rel="stylesheet" href="../style/bootstrap/class_table.css" type="text/css">
    </head>
    <body>
        <header class="row_sugestoes">
            <div class="row_sugestoes">
                <div id="titulo_sugestoes" class="col-sm-12 col-md-12 col-xs-12"><span>Sugestoes</span></div>
            </div>
        </header>
        <div class="row_sugestoes_contans">
            <div>
                <table class="table table-hover" style="font-size: 1em; background: white;">
                    <tr>
                        <td style="width: 10%;">Motorista</td>
                        <td style="width: 10%;">Data enviada</td>
                        <td style="width: 35%;">Como é Hoje</td>
                        <td style="width: 35%;">Como deve ser</td>
                        <td style="width: 10%;"></td>
                    </tr>
                </table>
            </div>
            <div style="overflow-y: scroll; overflow-x: hidden; height: 460px;">
                <?php
                require '../control/sugestoes/sugestoesController.php';
                ?>
            </div>
        </div>
    </body>
</html>
