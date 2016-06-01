<?php
if (isset($_GET['flag'])) {
    $id = $_GET['id'];
    $sql = "delete from veiculos where veiculos.id_veiculo = $id";
    mysql_query($sql);
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/veiculos/veiculos.css" type="text/css">
        <script src="../js/jquery.js" ></script>
        <script src="../js/veiculos/busca_veiculos.js"></script>
        <script src="../js/veiculos/adiciona_veiculo.js"></script>
        <script src="../js/veiculos/edita_veiculos.js"></script>
    </head>
    <body>
        <div class="conteudo_da_pagina_veiculo">  
            <header class="row_veiculos">
                <div class="row_veiculo">
                    <div id="titulo_veiculo" class="col-sm-8 col-md-8 col-xs-6">
                        <div id="span_veiculo"><span>Veiculos</span></div>
                    </div>
                    <div id="campo_pesquisa" class="col-sm-4 col-md-4 col-xs-6">
                        <?php
                        $pagina_veiculo = $_REQUEST['v'];
                        if ($pagina_veiculo != "cria-veiculo") {
                            ?>
                            <form name="form_pesquisa" id="form_pesquisa" method="post" action="">
                                <input type="text" name="pesquisaCliente" id="pesquisaCliente" value="" tabindex="1" placeholder="  Pesquisar veiculos..." />	
                            </form>
                            <?php
                        }
                        ?>       
                    </div>
                </div>
            </header>
            <div class="eventos_relacionados_veiculos" class="col-sm-12 col-md-12 col-xs-12" >
                <div id="botoes">
                    <a href="telaPrincipal.php?t=veiculos&v=cria-veiculo" class="btn btn-primary" id="button_relatorio_periodo"><span class="glyphicon glyphicon-pencil"></span>Novo</a>
                    <a href="telaPrincipal.php?t=veiculos" class="btn btn-primary" id="button_relatorio"><span class="glyphicon glyphicon-floppy-disk"></span>Consultar</a>
                </div>
            </div>
            <?php
            if ($pagina_veiculo == "cria-veiculo") {
                ?>
                <div class="recebe_resposta"></div>
                <div class="formulario_veiculo">
                    <form class="form-horizontal" role="form" method="post">
                        <div class="col-sm-12 col-md-12 col-xs-12" style="margin-top:10px;" >
                            <div class="col-sm-12 col-lg-12" >
                                <div class="form-group">
                                    <label  class="col-md-3 control-label">Nome:</label>
                                    <div class="col-md-9">
                                        <input class="form-control" name="nome" placeholder="Nome" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12" style="margin-top:10px;">
                            <div class="col-sm-12 col-lg-12">
                                <div class="form-group">
                                    <label  class="col-md-3 control-label">Placa:</label>
                                    <div class="col-md-4">
                                        <input class="form-control" placeholder="XHF" name="letras" type="text">
                                    </div>
                                    <div class="col-md-5">
                                        <input class="form-control" placeholder="1234" name="numeros" type="text">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12" style="margin-top:10px;">
                            <div class="col-sm-12 col-lg-12" >
                                <div class="form-group">
                                    <label  class="col-md-3 control-label">Tipo:</label>
                                    <div class="col-md-9" style="height: 35px; ;">
                                        <select class="selectpicker" name="tipo" style="width: 100%;height: 100%;">
                                            <option></option>
                                            <?php
                                            $q_op = "SELECT * FROM tipo_veiculo";
                                            $tipo_veiculo = mysql_query($q_op);
                                            while ($tipo = mysql_fetch_array($tipo_veiculo)) {
                                                $id_tipo = $tipo['id_tipo'];
                                                $nome = $tipo['tipo'];
                                                ?>
                                                <option value="<?php echo $id_tipo; ?>" style="color:black;"> <?php echo $nome; ?></option><br/>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12">
                            <button style="background: #01669F; color:white; margin-left:80%;margin-top:20px;" type="submit" class="btn btn-default">Salvar</button>
                        </div>
                    </form>
                </div>
                <?php
            } else if ($pagina_veiculo == "edit-veiculo") {
                $id_veiculo = $_GET['id'];
                $nome_veiculo = $_GET['nome'];
                $placa_veiculo = $_GET['placa'];
                $placas = explode("-", $placa_veiculo);
                $id_tipo_veiculo = $_GET['tipo'];
                $sql_tipo = "select tipo_veiculo.tipo from tipo_veiculo where tipo_veiculo.id_tipo = $id_tipo_veiculo";
                $result_tipo_do_veiculo = mysql_query($sql_tipo);
                $result_tipo_veiculo = mysql_fetch_row($result_tipo_do_veiculo);
                $tipoveiculo = $result_tipo_veiculo[0];
                session_start("id_veiculo_edit");
                $_SESSION['id_veiculo'] = $id_veiculo;
                ?>
                <div class="recebe_resposta_edit"></div>
                <div class="formulario_veiculo">
                    <form class="form-horizontal_edit" role="form" method="post">
                        <div class="col-sm-12 col-md-12 col-xs-12" style="margin-top:10px;" >
                            <div class="col-sm-12 col-lg-12" >
                                <div class="form-group">
                                    <label  class="col-md-3 control-label">Nome:</label>
                                    <div class="col-md-9">
                                        <input class="form-control" placeholder="Nome" value="<?php echo $nome_veiculo ?>" name="nome" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12" style="margin-top:10px;">
                            <div class="col-sm-12 col-lg-12">
                                <div class="form-group">
                                    <label  class="col-md-3 control-label">Placa:</label>
                                    <div class="col-md-4">
                                        <input class="form-control" name="letras" value="<?php echo $placas[0]; ?>" placeholder="XHF" type="text">
                                    </div>
                                    <div class="col-md-5">
                                        <input class="form-control" name="numeros" value="<?php echo $placas[1]; ?>" placeholder="1234" type="text">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12" style="margin-top:10px;">
                            <div class="col-sm-12 col-lg-12" >
                                <div class="form-group">
                                    <label  class="col-md-3 control-label">Tipo:</label>
                                    <div class="col-md-9" style="height: 35px; ;">
                                        <select class="selectpicker" name="tipo_veiculo" style="width: 100%; height: 100%;">
                                            <option value="<?php echo $id_tipo_veiculo ?>"><?php echo $tipoveiculo ?></option>
                                            <?php
                                            $q_op_tipo = "SELECT * FROM tipo_veiculo";
                                            $result_tipo = mysql_query($q_op_tipo);
                                            while ($tipo_veiculos = mysql_fetch_array($result_tipo)) {
                                                $id_tipo = $tipo_veiculos['id_tipo'];
                                                $nome = $tipo_veiculos['tipo'];
                                                ?>
                                                <option value="<?php echo $id_tipo; ?>" style="color:black;"> <?php echo $nome; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12">
                            <button style="background: #01669F; color:white; margin-left:80%;margin-top:20px;" type="submit" class="btn btn-default">Alterar</button>
                        </div>
                    </form>
                </div>
                <?php
            } else {
                ?>
                <div>
                    <table class='table table-hover' style="width: 97%;">
                        <thead>
                            <tr style="background: #666666; color:white;font-size: 1.0em">
                                <th style = ' text-align: left; '>Codigo</th>
                                <th style = ' width: 37%;' >Nome</th>
                                <th style = ' width: 20%;  '>Placa</th>
                                <th style = ' width: 22%; '>Tipo</th>
                                <th style = ' width: 8%;  '>Editar</th>
                                <th style = ' width: 8%;  '>Excluir</th>
                            </tr>
                        </thead>
                  
                    </table>
                </div>
                <div class="row_conteudo_veiculo">
                    <div id="contentLoading"><center><div id="loading"></div></center></div>
                    <section class="jumbotron">
                        <div id="MostraPesq"></div></section>
                </div>
                <?php
            }
            ?>
        </div>

    </body>
</html>
