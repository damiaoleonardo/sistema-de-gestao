<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/relatorios/funcionario/funcionario_custo.css" type="text/css">
        <link rel="stylesheet" href="../style/modal/janela_modal.css" type="text/css" >
        <script src="../js/modal/janela_modal.js"></script>
        <script src="../js/relatorios/requisicao_formulario.js"></script>
    </head>
    <body>
        <div class="row_funcionario">
            <form class="form_relatorio_funcionario_periodo" action="" method="post">
                <div id="nome_funcionario" class="col-md-5 col-sm-5 col-xs-5">
                    <label id="label_fun">Funcionario</label> 
                    <select class="selectpicker"  name="campo_select_funcionario" name="campo_select_funcionario" >
                        <option value="0" selected="selected"></option>
                        <?php
                        $q_funcionario = "SELECT funcionarios.id_funcionario,funcionarios.sobrenome from funcionarios where 1";
                        $op_funcionario = mysql_query($q_funcionario);
                        while ($aux_funcionario = mysql_fetch_array($op_funcionario)) {
                            $nome_funcionario = $aux_funcionario['sobrenome'];
                            $id_funcionario = $aux_funcionario['id_funcionario'];
                            ?>
                            <option value="<?php echo $id_funcionario; ?>" style="color:black;"> <?php echo $nome_funcionario; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div id="periodo_datas" class="col-md-5 col-sm-5 col-xs-5">
                    <label id="label_dI">Data Inicio</label> 
                    <input class="select_dataI" type="date" name="select_dataI">
                    <label id="label_dF">Data Final</label> 
                    <input class="select_dataF" type="date" name="select_dataF">
                </div>
                <div id="button_relatorio_funci" class="col-md-2 col-sm-2 col-xs-2"><button style="background: #01669F; color:white;" type="submit" class="btn btn-default">Pesquisar</button></div>
            </form>
        </div>
        <div  class="contans_funcionario_periodo">
            <div class="tabela_funcionario"></div>
        </div>
        <div  id="editCourseModal" class="modalDialog">
            <div id="recebe_dados"></div>
        </div>
    </body>
</html>
