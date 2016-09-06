<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style/relatorios/tarefas/tarefas.css" type="text/css">
        <link rel="stylesheet" href="../style/bootstrap/class_table.css" type="text/css">
        <link rel="stylesheet" href="../style/relatorios/tarefas/bootstrap-datepicker3.css" type="text/css">
        <link rel="stylesheet" href="../style/relatorios/tarefas/bootstrap-iso.css" type="text/css">
        <link rel="stylesheet" href="../style/relatorios/tarefas/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="../style/relatorios/tarefas/modal_detalhamento.css" type="text/css">
        <script src='../js/relatorios/gera_relatorio.js'></script>
        <script src='../js/relatorios/tarefas/bootstrap-datepicker.min.js'></script>
        <script src='../js/relatorios/tarefas/data_final.js'></script>
        <script src='../js/relatorios/tarefas/data_inicio.js'></script>
        <script src='../js/relatorios/tarefas/formden.js'></script>
        <script src='../js/relatorios/tarefas/requisicao_tarefa.js'></script>
        <script src='../js/modal/detalhamento_tarefa.js'></script>
    </head>
    <body>
        <form class="form_relatorio_tarefa" action="" method="post">
            <header class="row_relatorio_tarefa">
                <div id="primeiro_campo" class="col-sm-4 col-md-4 col-xs-4">
                    <div id="tarefa" class="col-sm-12 col-md-12 col-xs-12">
                        <label class="label">Tarefa</label>
                        <select class="selectpicker"  name="campo_select_tarefa">
                            <option value="0" selected="selected"></option>
                            <?php
                            $conexao_select_tarefa = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
                            $conexao_select_tarefa->set_charset("utf8");
                         //   $select_tarefa = "SELECT tarefas.id_tarefa,tarefas.nome from `tarefas` join tarefas_projeto on(tarefas_projeto.id_tarefa = tarefas.id_tarefa) join projeto on (projeto.id_projeto = tarefas_projeto.id_projeto) where projeto.flag_quant_tarefa = 1 ";
                            $select_tarefa = "SELECT distinct tarefas.id_tarefa,tarefas.nome from `tarefas` where 1  ";
                            $query_select_tarefa = mysqli_query($conexao_select_tarefa, $select_tarefa);
                            while ($row = $query_select_tarefa->fetch_assoc()) {
                                $nome_tarefa = $row['nome'];
                                $id_tarefa = $row['id_tarefa'];
                                ?>
                                <option value="<?php echo $id_tarefa; ?>" style="color:black;"> <?php echo $nome_tarefa; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div id="veiculo" class="col-sm-12 col-md-12 col-xs-12">
                        <label class="label">Veiculo</label>
                        <select class="selectpicker"  name="campo_select_veiculo" >
                            <option value="0" selected="selected"></option>
                            <?php
                            $conexao_select_veiculo = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
                            $conexao_select_veiculo->set_charset("utf8");
                            $q_veiculos = "SELECT veiculos.id_veiculo,veiculos.nome_veiculo from veiculos where 1";
                            $query_veiculos = mysqli_query($conexao_select_tarefa, $q_veiculos);
                            while ($row = $query_veiculos->fetch_assoc()) {
                                $nome_veiculo = $row['nome_veiculo'];
                                $id_veiculo = $row['id_veiculo'];
                                ?>
                                <option value="<?php echo $id_veiculo; ?>" style="color:black;"> <?php echo $nome_veiculo; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div id="veiculo" class="col-sm-12 col-md-12 col-xs-12">
                        <label class="label">Status</label>
                        <select class="selectpicker"  name="campo_select_status">
                            <option value="0" selected="selected" ></option>
                            <option value="concluida" selected="selected" >Concluida</option>
                            <option value="open" selected="selected" >Abertos</option>
                            <option value="'open' or tarefas_executa.status = 'concluida'" selected="selected" >Todos</option>
                        </select>
                    </div>
                </div>
                <div id="segundo_campo" class="col-sm-3 col-md-3 col-xs-3">

                    <div id="funcionario" class="col-sm-12 col-md-12 col-xs-12">
                        <label class="label">Funcionario</label>
                        <select class="selectpicker"  name="campo_select_funcionario" >
                            <option value="0" selected="selected"></option>
                            <?php
                            $conexao_select_funcionario = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
                            $conexao_select_funcionario->set_charset("utf8");
                            $q_funcionario = "SELECT funcionarios.id_funcionario,funcionarios.sobrenome from funcionarios where funcionarios.tipo != 'Administrador'";
                            $query_funcionarios = mysqli_query($conexao_select_funcionario, $q_funcionario);
                            while ($row = $query_funcionarios->fetch_assoc()) {
                                $nome_funcionario = $row['sobrenome'];
                                $id_funcionario = $row['id_funcionario'];
                                ?>
                                <option value="<?php echo $id_funcionario; ?>" style="color:black;"> <?php echo $nome_funcionario; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div id="tipoveiculo" class="col-sm-12 col-md-12 col-xs-12">
                        <label class="label">Tipo Veiculo</label>
                        <select class="selectpicker"  name="campo_select_tipo" >
                            <option value="0" selected="selected"></option>
                            <?php
                            $conexao_select_tipo = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
                            $conexao_select_tipo->set_charset("utf8");
                            $q_tipo = "SELECT tipo_veiculo.id_tipo,tipo_veiculo.tipo from tipo_veiculo where 1";
                            $query_tipo = mysqli_query($conexao_select_tipo, $q_tipo);
                            while ($row = $query_tipo->fetch_assoc()) {
                                $tipo = $row['tipo'];
                                $id_tipo = $row['id_tipo'];
                                ?>
                                <option value="<?php echo $id_tipo; ?>" style="color:black;"> <?php echo $tipo; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div id="terceiro_campo" class="col-sm-3 col-md-3 col-xs-3">
                    <div id="data_inicio" class="col-sm-12 col-md-12 col-xs-12">
                         <label class="control-label col-sm-12 col-md-12 col-xs-12 requiredField" for="date" style="font-size:1em; color:white;">Data Inicio</label>
                                            <div class="col-sm-9 col-md-9 col-xs-9">
                                                <div class="input-group">
                                                    <input style="height: 24px;" class="form-control" id="date" name="data_inicio" placeholder="YYYY/MM/DD" type="text"/>
                                                </div>
                                            </div>      
                    </div>
                    <div id="data_final" class="col-sm-12 col-md-12 col-xs-12">  
                            <label class="control-label col-sm-12 col-md-12 col-xs-12 requiredField" for="date" style="font-size:1em; color:white;">Data Final</label>
                                            <div class="col-sm-9 col-md-9 col-xs-9" >
                                                <div class="input-group">
                                                    <input style="height: 24px;" class="form-control" id="date" name="data_final" placeholder="YYYY/MM/DD" type="text"/>
                                                </div>
                                            </div>
                    </div>
                </div>
                <div id="campo_button" class="col-sm-2 col-md-2 col-xs-2"><button type="submit"  class="btn btn-default">Pesquisar</button></div>
            </header>
        </form>
        <div class="row_conteudo-controle-manutencao">
            <table id="descricao_tarefas"  class='table table-hover'>
                <tr>
                    <td style="width: 30%;">Tarefa</td>
                    <td style="width: 15%;">Veiculo</td>
                    <td style="width: 15%;">Data Inicial</td>
                    <td style="width: 15%;">Data Final</td>
                    <td style="width: 15%;">Tempo Gasto</td>
                    <td style="width: 10%;">Meta</td>
                </tr>
            </table>
            <div class="conteudo_dinamico_tarefa"></div>
            <table id="media_tarefas" class='table table-hover'>
                <tr>
                    <td>Media de execução</td>
                    <td id="media_tarefa"></td>
                </tr>
            </table>
        </div>
        <div  id="tarefas_detalhes" class="modalDialog">
            <div id="tarefa_detalhes"></div>
        </div>
    </body>
</html>
