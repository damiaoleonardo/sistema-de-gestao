<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/ugb_mes/ugb_mes.css" type="text/css">
    </head>
    <body>
        <div class="conteudo_da_pagina_ugb_mes">  
            <header class="row_ugb_mes">
                <div class="row_ugb_mes">
                    <div id="titulo_ugb_mes" class="col-sm-12 col-md-12 col-xs-12">
                        <div id="span_ugb_mes"><span>UGB do mes</span></div>
                    </div>
                </div>
            </header>
            <div class="eventos_relacionados_ugb_mes" class="col-sm-12 col-md-12 col-xs-12">
                <div id="botoes">
                    <?php
                    require '../control/ugb_mes/ugb_mes.php';
                    ?>
                   <form class="imagem"  method="post" enctype="multipart/form-data">
                       <div class="col-sm-10 col-md-10 col-xs-10">
                        <input class="col-sm-6 col-md-6 col-xs-6" type="file" name="arquivo" id="nome"/><input type="submit" name="imagem" value="Salvar imagem" />
                       </div>
                   </form>
                </div>
            </div>  
            <div class="row_conteudo_ugb_mes">
                    <div>
                       <?php
                        foreach (glob("./ugb_do_mes/imagem_ugb/*.jpg") as $filename) {
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
