<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/relatorios/projetos/projetos.css" type="text/css">
        <link rel="stylesheet" href="../style/relatorios/projetos/bootstrap-datepicker3.css"/>
        <link rel="stylesheet" href="../style/bootstrap/class_table.css" type="text/css">
        <script src='../js/relatorios/projetos/data_inicio.js'></script>
        <script src='../js/relatorios/projetos/data_final.js'></script>
        <script src='../js/relatorios/projetos/requisicao.js'></script>
        <script src="../js/jquery-1.12.0.js"></script>
        <script type="text/javascript" src="../js/relatorios/projetos/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="../js/relatorios/projetos/bootstrap-datepicker.min.js"></script>
         <style>
            .modalDialog {
                position: fixed;
                font-family: Arial, Helvetica, sans-serif;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                background: rgba(0,0,0,0.8);
                z-index: 99999;
                opacity:0;
                -webkit-transition: opacity 400ms ease-in;
                -moz-transition: opacity 400ms ease-in;
                transition: opacity /*400ms*/ ease-in;
                pointer-events: none;
              }
            .modalDialog > div {
                overflow: scroll;
                width: 85%;
                height: 80%;
                position: relative;
                margin: 5% auto;
                padding: 5px 20px 13px 20px;
                border-radius: 10px;
                background: #fff;
                background: -moz-linear-gradient(#fff, #999);
                background: -webkit-linear-gradient(#fff, #999);
                background: -o-linear-gradient(#fff, #999);
              }
            .close {
                background: #606061;
                color: #FFFFFF;
                line-height: 25px;
                position: absolute;
                right: 10px;
                text-align: center;
                top: 5px;
                width: 30px;
                text-decoration: none;
                font-weight: bold;
                -webkit-border-radius: 12px;
                -moz-border-radius: 12px;
                border-radius: 12px;
                -moz-box-shadow: 1px 1px 3px #000;
                -webkit-box-shadow: 1px 1px 3px #000;
                box-shadow: 1px 1px 3px #000;
              }
            .close:hover { background: #00d9ff;}
        </style>
        <script type="text/javascript">
            function openModal(id_projeto,id_veiculo,id_executa,idModal) {
                var dialog = document.getElementById(idModal);
                dialog.style.opacity = 1;
                dialog.style.pointerEvents = "auto";
                loadContent('tarefas_projeto', "../control/relatorio/projetos/tarefasProjetos_controller.php?id_projeto="+id_projeto+"&id_veiculo="+id_veiculo+"&id_executa="+id_executa);
            }
              function loadContent(idElement, urlDest) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (xhttp.readyState === 4 && xhttp.status === 200) {
                        document.getElementById(idElement).innerHTML = xhttp.responseText;
                    }
                };
                xhttp.open("GET", urlDest, true);
                xhttp.send();
            }
            function fecha_modal(idModal) {
                var dialog = document.getElementById(idModal);
                dialog.style.opacity = 0;
                dialog.style.pointerEvents = "none";
            }
        </script>
</head>
    <body>
        <div class="recebe_resposta"></div>
        <form class="form_relatorio_projeto" action="" method="post">
            <header class="row_relatorio_projeto">
                <div id="primeiro_campo" class="col-sm-4 col-md-4 col-xs-4">
                    <div id="projeto" class="col-sm-12 col-md-12 col-xs-12">
                        <label class="label">Projeto</label>
                        <select class="selectpicker"  name="campo_select_projeto" >
                            <option value="0" selected="selected" ></option>
                            <?php
                            $q_op = "SELECT projeto.id_projeto,projeto.nome from projeto where 1";
                            $op = mysql_query($q_op);
                            while ($aux_projeto = mysql_fetch_array($op)) {
                                $nome_projeto = $aux_projeto['nome'];
                                $id_projeto = $aux_projeto['id_projeto'];
                                ?>
                                <option value="<?php echo $id_projeto; ?>" style="color:black;"> <?php echo $nome_projeto; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div id="veiculo" class="col-sm-12 col-md-12 col-xs-12">
                        <label class="label">Veiculo</label>
                        <select class="selectpicker"  name="campo_select_veiculo" >
                            <option value="0" selected="selected" ></option>
                            <?php
                            $q_veiculos = "SELECT veiculos.id_veiculo,veiculos.nome_veiculo from veiculos where 1";
                            $op_veiculos = mysql_query($q_veiculos);
                            while ($aux_veiculo = mysql_fetch_array($op_veiculos)) {
                                $nome_veiculo = $aux_veiculo['nome_veiculo'];
                                $id_veiculo = $aux_veiculo['id_veiculo'];
                                ?>
                                <option value="<?php echo $id_veiculo; ?>" style="color:black;"> <?php echo $nome_veiculo; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div id="segundo_campo" class="col-sm-3 col-md-3 col-xs-3">
                    <div id="tipoveiculo" class="col-sm-12 col-md-12 col-xs-12">
                        <label class="label">Tipo Veiculo</label>
                        <select class="selectpicker"  name="campo_select_tipo" >
                            <option value="0" selected="selected" ></option>
                            <?php
                            $q_tipo = "SELECT tipo_veiculo.id_tipo,tipo_veiculo.tipo from tipo_veiculo where 1";
                            $op_tipos = mysql_query($q_tipo);
                            while ($aux_tipo = mysql_fetch_array($op_tipos)) {
                                $tipo = $aux_tipo['tipo'];
                                $id_tipo = $aux_tipo['id_tipo'];
                                ?>
                                <option value="<?php echo $id_tipo; ?>" style="color:black;"> <?php echo $tipo; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div id="terceiro_campo" class="col-sm-3 col-md-3 col-xs-3" >
                    <div id="data_inicio" class="col-sm-12 col-md-12 col-xs-12">
                         <label class="control-label col-sm-12 col-md-12 col-xs-12 requiredField" for="date" style="font-size:1em; color:white;">Data Inicio</label>
                                            <div class="col-sm-9 col-md-9 col-xs-9">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                    <input style="height: 24px;" class="form-control" id="date" name="data_inicio" placeholder="YYYY/MM/DD" type="text"/>
                                                </div>
                                            </div>
                        
                    </div>
                    <div id="data_final" class="col-sm-12 col-md-12 col-xs-12">  
                            <label class="control-label col-sm-12 col-md-12 col-xs-12 requiredField" for="date" style="font-size:1em; color:white;">Data Final</label>
                                            <div class="col-sm-9 col-md-9 col-xs-9" >
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                    <input style="height: 24px;" class="form-control" id="date" name="data_final" placeholder="YYYY/MM/DD" type="text"/>
                                                </div>
                                            </div>
                                  </div>
                    </div>
                <div id="campo_button" class="col-sm-2 col-md-2 col-xs-2"><button type="submit"  class="btn btn-default">Pesquisar</button></div>
            </header>
        </form>
        <div class="recebe_projetos">
            <table id="descricao_projetos"  class='table table-hover' >
                <tr>
                    <td style="width: 30%;">Projeto</td>
                    <td style="width: 15%;">Veiculo</td>
                    <td style="width: 15%;">Data Inicial</td>
                    <td style="width: 15%;">Data Final</td>
                    <td style="width: 15%;">Tempo Gasto</td>
                    <td style="width: 10%;">Meta</td>
                </tr>
            </table>
            <div class="conteudo_dinamico"></div>
            <table id="media_projetos" class='table table-hover'>
                <tr>
                    <td>Media dos Projetos</td>
                    <td>00:00:00</td>
                </tr>
            </table>
        </div>
        <div  id="tarefasProjeto" class="modalDialog">
            <div id="tarefas_projeto"></div>
        </div>
    </body>
</html>