<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style/controle-manutencao/controle_manutencao.css" type="text/css">
        <link rel="stylesheet" href="../style/bootstrap/class_table.css" type="text/css">
        <title></title>
    </head>
    <body>
        <header class="row_controle-manutencao">
            <div class="row_controle">
                <div id="titulo_controle" class="col-sm-12 col-md-12 col-xs-12"><span>Quadro de Manutenção Preventiva</span></div>
            </div>
        </header>
        <div class="row_conteudo-controle-manutencao">
          <!--  <table class="table table-hover">
                <tr style="font-size:0.9em;">
                    <td rowspan="2" style="width: 20%;">QUADRO DE MANUTENÇÃO</td>
                    <td colspan="2" style="width: 20%;">TROCA DE OLEO</td>
                    <td colspan="2" style="width: 20%;">TROCA DE OLEO DA CAIXA DIFERENCIAL</td>
                    <td colspan="2" style="width: 20%;">TROCA DO FILTRO DE AR</td>
                    <td colspan="2" style="width: 20%;">REVISÃO MOTOR PARTIDA/ALTERNADOR</td>
                </tr>
                <tr  style="font-size:0.9em;">
                    <td>KM</td>
                    <td>SM</td>
                    <td>KM</td>
                    <td>SM</td>
                    <td>KM</td>
                    <td>SM</td>
                    <td>KM</td>
                    <td>SM</td>
                </tr>
            </table>-->
            <?php
            require '../control/controle-manutencao/controleManutencaoPreventivaController.php';
            ?>
        </div>
    </body>
</html>
