<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/controle-manutencao/controle.css" type="text/css">
        <link rel="stylesheet" href="../style/modal/adiciona_atividade_controle.css" type="text/css">
        <link rel="stylesheet" href="../style/bootstrap/class_table.css" type="text/css">
        <script src="../js/controle-manutencao/busca_manutencao_preventiva.js"></script>
        <script src="../js/modal/adiciona_atividade_controle.js"></script>
        <script src="../js/jquery.js"></script>
        <script src="../js/controle-manutencao/insere_atividade_tabela.js"></script>
    </head>
    <body>
        <div class="recebe_resposta_insere"></div>
        <header class="row_controle-manutencao">
            <div class="row_controle">
                <div id="titulo_controle" class="col-sm-12 col-md-12 col-xs-12"><span>Cadastro de Veiculos no Controle de Manutenção Preventivo</span></div>
            </div>
            <div id="menu_left">
                <div class="col-md-12 col-sm-12 col-xs-12" id="campo_veiculo">
                    <label class="col-md-2 col-sm-2 col-xs-2">Veiculo</label>
                    <form  method="post" action="" class="form_manutencao_preventiva">
                        <select class="col-md-5 col-sm-5" id="campo"  class="selectpicker" name="veiculo" style="height: 30px;">
                            <option value="0" selected="selected" ></option>
                            <?php
                            $conexao_select_veiculo = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
                            $conexao_select_veiculo->set_charset("utf8");
                            $q_veiculos = "SELECT veiculos.id_veiculo,veiculos.nome_veiculo from veiculos where 1";
                            $query_select_veiculo = mysqli_query($conexao_select_veiculo, $q_veiculos);
                            while ($row = $query_select_veiculo->fetch_assoc()) {
                                $nome_veiculo = $row['nome_veiculo'];
                                $id_veiculo = $row['id_veiculo'];
                                ?>
                                <option value="<?php echo $id_veiculo; ?>" style="color:black;"> <?php echo $nome_veiculo; ?></option>
                                <?php
                            }
                            ?>
                        </select> 
                        <button style="margin-left:10px;" class="col-md-4 col-sm-4" type="submit" class="btn btn-primary">Pesquisar</button>
                    </form>
                </div>
            </div>
        </header>
        <div class="row_conteudo-controle-manutencao">
            <div id="container"></div>
        </div>
        <div  id="adiciona_atividade" class="modalDialog_adiciona_atividade">
            <div id="adiciona">
                <a id="btnClose" href="#" title="Close" class="close" onclick="fecha_modal('adiciona_atividade')">X</a>
                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin:30px 0px 0px 5px;">
                    <label class="col-md-3 col-sm-3 col-xs-3">Atividade</label>
                    <form  method="post" action="" class="form_controle">
                        <select class="col-md-4 col-sm-4" id="campo"  class="selectpicker" name="adiciona_atividade_controle" style="height: 30px;">
                            <option value="0" selected="selected"></option>
                            <?php
                            $conexao_select_atividade_preventiva = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
                            $conexao_select_atividade_preventiva->set_charset("utf8");
                            $q_atividade_preventiva = "select atividades_controle.id_atividade_controle,atividades_controle.nome_atividade from atividades_controle where atividades_controle.tipo_atividade ='preventiva'";
                            $query_select_atividade_preventiva = mysqli_query($conexao_select_atividade_preventiva, $q_atividade_preventiva);
                            while ($row = $query_select_atividade_preventiva->fetch_assoc()) {
                                $nome_atividade_preventiva = $row['nome_atividade'];
                                $id_atividade_preventiva = $row['id_atividade_controle'];
                                ?>
                                <option value="<?php echo $id_atividade_preventiva; ?>" style="color:black;"><?php echo $nome_atividade_preventiva;?></option>
                                <?php
                            }
                            ?>
                        </select> 
                        <button style="margin-left:10px; background: #01669F; color:white; font-size:1.1em;" class="col-md-4 col-sm-4" type="submit" class="btn btn-primary">Inserir</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
