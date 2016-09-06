<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/informacoes_mes/informacoes_mes.css" type="text/css">
    </head>
    <body>
        <div class="conteudo_da_pagina_informacao_mes">  
            <header class="row_informacao_mes">
                <div class="row_informacao_mes">
                    <div id="titulo_informacao_mes" class="col-sm-12 col-md-12 col-xs-12">
                        <div id="span_informacao_mes"><span>Informação do mês</span></div>
                    </div>
                </div>
            </header>
            <div class="eventos_relacionados_informacao_mes" class="col-sm-12 col-md-12 col-xs-12">
                <div id="botoes">
                    <?php
                    require '../control/informacao_mes/informacao_mes.php';
                    ?>
                   <form class="imagem"  method="post" enctype="multipart/form-data">
                       <div class="col-sm-10 col-md-10 col-xs-10">
                        <input class="col-sm-6 col-md-6 col-xs-6" type="file" name="arquivo" id="nome"/><input type="submit" name="imagem" value="Salvar imagem" />
                       </div>
                   </form>
                </div>
            </div>  
            <div class="row_conteudo_informacao_mes">
                   <div>
                       <?php
                        foreach (glob("./informacoes_mes/imagem_informacoes/*.jpg") as $filename){
                            ?>
                           <img id="imagem_ugb" src='<?php echo $filename ?>'><br>
                            <?php
                        }
                        ?>
                   </div>
            </div>
        </div>
    </body>
</html>
