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
                <div id="titulo_controle" class="col-sm-12 col-md-12 col-xs-12"><span>Controle de Manutenção</span></div>
            </div>
        </header>
        <div class="row_conteudo-controle-manutencao">
           <?php
         
            require '../control/controle-manutencao/controle_manutencaoController.php';
           ?>
        </div>
    </body>
</html>
