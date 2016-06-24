<?php
require('../../../model/Conexao/Connection.class.php');
$conexao = Connection::getInstance();

class projetos_tarefas {

    private $id_executa;
    private $status_projeto;
    private $ugb;
    private $id_projeto;
    private $id_veiculo;
    private $id_tarefa;
    private $id_funcionario;
    private $id_tipo_veiculo;
    private $data_inicial;
    private $data_final;

    function getUgb() {
        return $this->ugb;
    }

    function setUgb($ugb) {
        $this->ugb = $ugb;
    }

    function getStatus_projeto() {
        return $this->status_projeto;
    }

    function setStatus_projeto($status_projeto) {
        $this->status_projeto = $status_projeto;
    }

    function getId_executa() {
        return $this->id_executa;
    }

    function setId_executa($id_executa) {
        $this->id_executa = $id_executa;
    }

    function getId_projeto() {
        return $this->id_projeto;
    }

    function getId_veiculo() {
        return $this->id_veiculo;
    }

    function getId_tarefa() {
        return $this->id_tarefa;
    }

    function getId_funcionario() {
        return $this->id_funcionario;
    }

    function getId_tipo_veiculo() {
        return $this->id_tipo_veiculo;
    }

    function getData_inicial() {
        return $this->data_inicial;
    }

    function getData_final() {
        return $this->data_final;
    }

    function setId_projeto($id_projeto) {
        $this->id_projeto = $id_projeto;
    }

    function setId_veiculo($id_veiculo) {
        $this->id_veiculo = $id_veiculo;
    }

    function setId_tarefa($id_tarefa) {
        $this->id_tarefa = $id_tarefa;
    }

    function setId_funcionario($id_funcionario) {
        $this->id_funcionario = $id_funcionario;
    }

    function setId_tipo_veiculo($id_tipo_veiculo) {
        $this->id_tipo_veiculo = $id_tipo_veiculo;
    }

    function setData_inicial($data_inicial) {
        $this->data_inicial = $data_inicial;
    }

    function setData_final($data_final) {
        $this->data_final = $data_final;
    }

    function MontaSelectTarefas(projetos_tarefas $obj) {
        $id_tarefa = $obj->getId_tarefa();
        $sql = "select tarefas.id_tarefa,tarefas.nome from tarefas where 1";
        $result = mysql_query($sql);
    }

    function montaTabela($sql, $status) {
        $satus_projeto = $status;
        $result = mysql_query($sql);
        while ($recebe_dados = mysql_fetch_array($result)) {
            $id_do_projeto = $recebe_dados['id_projeto'];
            $id_veiculo = $recebe_dados['id_veiculo'];
            $id_executa = $recebe_dados['id_projeto_executa'];
            $nome_projeto = $recebe_dados['nome_projeto'];
            $nome_veiculo = $recebe_dados['nome_veiculo'];
            $data_inicio = $recebe_dados['data_inicio'];
            $data_final = $recebe_dados['data_final'];
            $tempo_gasto = $recebe_dados['horas_concluidas'];
            $meta = $recebe_dados['duracao'];
            ?>
            <table class='table table-hover'>
                <tr style="font-size:0.9em;">
                    <td style="width: 30%;"><a href="#" onclick="openModal('<?php echo $id_do_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_executa ?>', 'tarefasProjeto')"><?php echo $nome_projeto ?></a></td>
                    <td style="width: 15%;"><?php echo $nome_veiculo ?></td>
                    <td style="width: 15%;"><?php echo $data_inicio ?></td>
                    <td style="width: 15%;"><?php echo $data_final ?></td>
                    <?php
                    if ($satus_projeto == "open") {
                        ?>
                        <td style="width: 15%; background: #01669F; color:white;"><?php echo $tempo_gasto ?></td>
                        <?php
                    } else if ($satus_projeto == "concluido") {
                        if ($tempo_gasto < $meta) {
                            ?>
                            <td style="width: 15%; background: #3c763d; color:white;"><?php echo $tempo_gasto ?></td>
                            <?php
                        } else {
                            ?>
                            <td style="width: 15%; background: #c7254e; color:white;"><?php echo $tempo_gasto ?></td>
                            <?php
                        }
                    }else {
                        ?>
                            <td style="width: 15%; background: #666666; color:white;"><?php echo $tempo_gasto ?></td>
                       <?php 
                    }
                    ?>
                    <td style="width: 10%;"><?php echo $meta ?></td>
                </tr>
            </table>
            <?php
        }
    }

    function montaTabelaTarefas(projetos_tarefas $obj) {
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $id_executa = $obj->getId_executa();
        ?>
        <table class="table table-hover" cellpadding=1 cellspacing=1 style="margin-top:20px;">
            <tr>
                <td style="font-weight: bold; background: #666666; color:white;font-size: 0.9em;">Tarefa</td>
                <td style="font-weight: bold; background: #666666; color:white;font-size: 0.9em;">Status</td>
                <td style="font-weight: bold; background: #666666; color:white;font-size: 0.9em;">Meta</td>
                <td style="font-weight: bold; background: #666666; color:white;font-size: 0.9em;">Tempo Gasto</td>
                <td style="font-weight: bold; background: #666666; color:white;font-size: 0.9em;">Data inicial</td>
                <td style="font-weight: bold; background: #666666; color:white;font-size: 0.9em;">Data final</td>
                <td style="font-weight: bold; background: #666666; color:white;font-size: 0.9em;">Realizado</td>
            </tr>
            <?php

            function invertedata($data, $separar = "/", $juntar = "/") {
                return implode($juntar, array_reverse(explode($separar, $data)));
            }

            $flag_tarefa = 0;
            $sql_relatorio_tarefa = "select tarefas_executa.id_tarefa,tarefas_executa.status,tarefas_executa.tipo_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio, tarefas_executa.data_final,tarefas.nome from `tarefas` join `tarefas_executa` on (tarefas_executa.id_tarefa = tarefas.id_tarefa) join `projeto_executa` on (tarefas_executa.id_projeto_executa = projeto_executa.id_projeto_executa and tarefas_executa.id_projeto = projeto_executa.id_projeto and tarefas_executa.id_veiculo = projeto_executa.id_veiculo) where tarefas_executa.id_projeto_executa = '$id_executa' and tarefas_executa.id_projeto = '$id_projeto' and tarefas_executa.id_veiculo = '$id_veiculo' ";
            $result_gera_relatorio_tarefa = mysql_query($sql_relatorio_tarefa);
            while ($aux_gera_relatorio_tarefa = mysql_fetch_array($result_gera_relatorio_tarefa)) {
                $codigo_tarefa = $aux_gera_relatorio_tarefa['id_tarefa'];
                $nome_tarefa = $aux_gera_relatorio_tarefa['nome'];
                $status_tarefa = $aux_gera_relatorio_tarefa['status'];
                $duracao_tarefa = $aux_gera_relatorio_tarefa['duracao'];
                $horas_concluidas = $aux_gera_relatorio_tarefa['horas_concluidas'];
                $data_inicio_tarefa = $aux_gera_relatorio_tarefa['data_inicio'];
                $data_final_tarefa = $aux_gera_relatorio_tarefa['data_final'];
                $tipo_tarefa = $aux_gera_relatorio_tarefa['tipo_tarefa'];
                $data_inicio_da_tarefa = invertedata($data_inicio_tarefa, "-", "/");
                $data_final_da_tarefa = invertedata($data_final_tarefa, "-", "/");
                $flag_tarefa ++;
                ?>
                <?php
                if ($flag_tarefa == 2) {
                    ?>
                    <tr>
                        <td style="font-weight: bold; background: #666666; color:white;font-size: 0.9em;">Tarefa</td>
                        <td style="font-weight: bold; background: #666666; color:white;font-size: 0.9em;">Status</td>
                        <td style="font-weight: bold; background: #666666; color:white;font-size: 0.9em;">Meta</td>
                        <td style="font-weight: bold; background: #666666; color:white;font-size: 0.9em;">Tempo Gasto</td>
                        <td style="font-weight: bold; background: #666666; color:white;font-size: 0.9em;">Data inicial</td>
                        <td style="font-weight: bold; background: #666666; color:white;font-size: 0.9em;">Data final</td>
                        <td style="font-weight: bold; background: #666666; color:white;font-size: 0.9em;">Realizado</td>
                    </tr>
                    <?php
                    $flag_tarefa --;
                }
                ?>
                <tr>

                    <td style="text-align: left;"><a style="text-decoration: none; color:black; font-size: 0.9em; " href="#"><?php echo $nome_tarefa ?></a></td>
                    <?php
                    if ($status_tarefa == "notopen") {
                        ?>
                        <td style="background: orange; color: white; font-size: 0.9em;"><?php echo "nao iniciada" ?></td>
                        <?php
                    } else if ($status_tarefa == "open") {
                        ?>
                        <td style="background:#01669F; color:white; font-size: 0.9em;"><?php echo "aberta" ?></td>
                        <?php
                    } else if ($status_tarefa == "pause") {
                        ?>
                        <td style="background:#ff7f24;color: white; font-size: 0.9em; "><?php echo "pausada" ?></td>
                        <?php
                    } else if ($status_tarefa == "concluida") {
                        ?>
                        <td style="background: darkgreen ;color: white; font-size: 0.9em;"><?php echo "concluida" ?></td>
                        <?php
                    }
                    ?>

                    <?php
                    if ($tipo_tarefa == "liberada") {
                        ?>
                        <td style="font-size: 0.9em;"><?php echo "Não Determinado" ?></td>
                        <?php
                    } else {
                        ?>
                        <td style="font-size: 0.9em;"><?php echo $duracao_tarefa ?></td>
                        <?php
                    }
                    ?>
                    <td style="font-size: 0.9em;"><?php echo $horas_concluidas ?></td>
                    <td style="font-size: 0.9em;"><?php echo $data_inicio_da_tarefa ?></td>
                    <td style="font-size: 0.9em;"><?php echo $data_final_da_tarefa ?></td>
                    <?php
                    if ($tipo_tarefa == "liberada") {
                        ?>
                        <td style="font-size: 0.9em;"><?php echo $descricao_da_tarefa ?></td>
                        <?php
                    } else {
                        ?>
                        <td style="font-size: 0.9em;"><?php echo "Tarefa Especificada" ?></td>
                        <?php
                    }
                    ?>
                </tr>

                <tr>
                    <td colspan="7" style="height: 50px;"></td>
                </tr>
                <tr style=" background: #3c763d; color:white;font-size: 0.9em; font-weight: bold;">
                    <td colspan="3">Funcionario</td>
                    <td>Dia de execução</td>
                    <td>Hora Inicial</td>
                    <td>Horas Trabalhadas</td>
                    <td>Hora Final</td>
                </tr>
                <?php
                $flag_mesclagem = 0;
                $sql_relatorio_funcionario = "select funcionario_executa.horas_concluidas,funcionario_executa.data_tarefa,funcionario_executa.hora_inicial,funcionario_executa.hora_final,funcionarios.sobrenome,funcionarios.id_funcionario from `funcionarios` join `funcionario_executa` on (funcionario_executa.id_funcionario = funcionarios.id_funcionario) join `tarefas_executa` on (funcionario_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and funcionario_executa.id_projeto = tarefas_executa.id_projeto and funcionario_executa.id_veiculo = tarefas_executa.id_veiculo and funcionario_executa.id_tarefa = tarefas_executa.id_tarefa) where funcionario_executa.id_projeto_executa = '$id_executa' and funcionario_executa.id_projeto = '$id_projeto' and funcionario_executa.id_veiculo = '$id_veiculo' and funcionario_executa.id_tarefa ='$codigo_tarefa' and funcionario_executa.flag_tarefa_relatorio != '1' ";
                $result_gera_relatorio_funcionario = mysql_query($sql_relatorio_funcionario);
                while ($aux_gera_relatorio_funcionario = mysql_fetch_array($result_gera_relatorio_funcionario)) {
                    $codigo_funcionario = $aux_gera_relatorio_funcionario['id_funcionario'];
                    $nome_funcionario = $aux_gera_relatorio_funcionario['sobrenome'];
                    $data_tarefa = $aux_gera_relatorio_funcionario['data_tarefa'];
                    $horas_concluidas_funcionario = $aux_gera_relatorio_funcionario['horas_concluidas'];
                    $horas_inicial_funcionario = $aux_gera_relatorio_funcionario['hora_inicial'];
                    $horas_final_funcionario = $aux_gera_relatorio_funcionario['hora_final'];
                    $data_tarefa_invertida = invertedata($data_tarefa, "-", "/");
                    ?>
                    <tr>
                        <th style="text-align: left;" colspan="3"><?php echo $nome_funcionario ?></th>  
                        <th style="font-size: 1em;"><?php echo $data_tarefa_invertida ?></th>
                        <th style=" font-size: 1em;"><?php echo $horas_inicial_funcionario ?></th>
                        <th><?php echo $horas_concluidas_funcionario ?></th>
                        <th style="  font-size: 1em;"><?php echo $horas_final_funcionario ?></th>
                    </tr>
                    <?php
                   }
                ?>
                <tr>
                    <td colspan="7" style="height: 50px;"></td>
                </tr>
                <?php
            }
            $flag_tarefa = 0;
            ?>
        </table>
        <?php
      }

    function projetos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa  where projeto_executa.id_projeto = $id_projeto and  projeto_executa.status = '$status'";
        return $sql;
    }

    function projetosDatas(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa  where projeto_executa.id_projeto = $id_projeto and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status'  ";
        return $sql;
    }

    function veiculos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa  where projeto_executa.id_veiculo = $id_veiculo and projeto_executa.status = '$status' ";
        return $sql;
    }

    function veiculosDatas(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` where projeto_executa.id_veiculo = $id_veiculo and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status'   ";
        return $sql;
    }

    function tipoVeiculo(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_tipoveiculo = $obj->getId_tipo_veiculo();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) where veiculos.id_tipo = $id_tipoveiculo  and projeto_executa.status = '$status' ";
        return $sql;
    }

    function projetoTipoDatas(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $id_tipoveiculo = $obj->getId_tipo_veiculo();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) where veiculos.id_tipo = $id_tipoveiculo and projeto_executa.id_projeto = $id_projeto and  projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status'  ";
        return $sql;
    }

    function ugb(projetos_tarefas $obj) {
        $id_ugb = $obj->getUgb();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa`  join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where  projeto_executa.id_ugb = $id_ugb and projeto_executa.status = '$status'";
        return $sql;
    }

    function ugbDatas(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_ugb = $obj->getUgb();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa`  join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where  projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status'";
        return $sql;
    }

    function ugbVeiculo(projetos_tarefas $obj) {
        $id_ugb = $obj->getUgb();
        $id_veiculo = $obj->getId_veiculo();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_veiculo = $id_veiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.status = '$status'";
        return $sql;
    }

    function ugbVeiculoDatas(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_ugb = $obj->getUgb();
        $id_veiculo = $obj->getId_veiculo();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_veiculo = $id_veiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status'";
        return $sql;
    }

    function ugbProjeto(projetos_tarefas $obj) {
        $id_ugb = $obj->getUgb();
        $id_projeto = $obj->getId_projeto();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_ugb = $id_ugb and projeto_executa.status = '$status' ";
        return $sql;
    }

    function ugbProjetoDatas(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_ugb = $obj->getUgb();
        $id_projeto = $obj->getId_projeto();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_ugb = $id_ugb and  projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status' ";
        return $sql;
    }

    function ugbTipoVeiculo(projetos_tarefas $obj) {
        $id_tipoVeiculo = $obj->getId_tipo_veiculo();
        $id_ugb = $obj->getUgb();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where  veiculos.id_tipo = $id_tipoVeiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.status = '$status' ";
        return $sql;
    }

    function ugbTipoVeiculoDatas(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_tipoVeiculo = $obj->getId_tipo_veiculo();
        $id_ugb = $obj->getUgb();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where  veiculos.id_tipo = $id_tipoVeiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status' ";
        return $sql;
    }

    function projetoVeiculoUgb(projetos_tarefas $obj) {
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $status = $obj->getStatus_projeto();
        $id_ugb = $obj->getUgb();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.id_ugb = $id_ugb  and projeto_executa.status = '$status'";
        return $sql;
    }

    function projetoVeiculoUgbDatas(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $status = $obj->getStatus_projeto();
        $id_ugb = $obj->getUgb();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final'  and projeto_executa.status = '$status'";
        return $sql;
    }

    function projetoTipoVeiculoUgb(projetos_tarefas $obj) {
        $id_projeto = $obj->getId_projeto();
        $id_tipoVeiculo = $obj->getId_tipo_veiculo();
        $status = $obj->getStatus_projeto();
        $id_ugb = $obj->getUgb();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and veiculos.id_tipo = $id_tipoVeiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.status = '$status'";
        return $sql;
    }

    function projetoTipoVeiculoUgbDatas(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_projeto = $obj->getId_projeto();
        $id_tipoVeiculo = $obj->getId_tipo_veiculo();
        $status = $obj->getStatus_projeto();
        $id_ugb = $obj->getUgb();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and veiculos.id_tipo = $id_tipoVeiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status'";
        return $sql;
    }

    function tipoVeiculoDatas(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_tipoveiculo = $obj->getId_tipo_veiculo();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) where veiculos.id_tipo = $id_tipoveiculo and  projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status'  ";
        return $sql;
    }

    function projetosVeiculos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.status = '$status' ";
        return $sql;
    }

    function projetosVeiculosDatas(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status' ";
        return $sql;
    }

    function projetoTipo(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $id_tipoveiculo = $obj->getId_tipo_veiculo();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) where veiculos.id_tipo = $id_tipoveiculo and projeto_executa.id_projeto = $id_projeto and projeto_executa.status = '$status' ";
        return $sql;
    }
    
    ///  todos as funções para os projetos com status igual a concluido ou abertos
     function projetosStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa  where projeto_executa.id_projeto = $id_projeto and  ( projeto_executa.status = $status)";
        return $sql;
    }

    function projetosDatasStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa  where projeto_executa.id_projeto = $id_projeto and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status) ";
        return $sql;
    }

    function veiculosStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa  where projeto_executa.id_veiculo = $id_veiculo and ( projeto_executa.status = $status)";
        return $sql;
    }

    function veiculosDatasStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` where projeto_executa.id_veiculo = $id_veiculo and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status)  ";
        return $sql;
    }

    function tipoVeiculoStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_tipoveiculo = $obj->getId_tipo_veiculo();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) where veiculos.id_tipo = $id_tipoveiculo  and ( projeto_executa.status = $status) ";
        return $sql;
    }

    function projetoTipoDatasStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $id_tipoveiculo = $obj->getId_tipo_veiculo();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) where veiculos.id_tipo = $id_tipoveiculo and projeto_executa.id_projeto = $id_projeto and  projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status)  ";
        return $sql;
    }

    function ugbStatusTodos(projetos_tarefas $obj) {
        $id_ugb = $obj->getUgb();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa`  join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where  projeto_executa.id_ugb = $id_ugb and projeto_executa.status = '$status'";
        return $sql;
    }

    function ugbDatasStatusTodos(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_ugb = $obj->getUgb();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa`  join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where  projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status)";
        return $sql;
    }

    function ugbVeiculoStatusTodos(projetos_tarefas $obj) {
        $id_ugb = $obj->getUgb();
        $id_veiculo = $obj->getId_veiculo();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_veiculo = $id_veiculo and projeto_executa.id_ugb = $id_ugb and ( projeto_executa.status = $status)";
        return $sql;
    }

    function ugbVeiculoDatasStatusTodos(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_ugb = $obj->getUgb();
        $id_veiculo = $obj->getId_veiculo();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_veiculo = $id_veiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status)";
        return $sql;
    }

    function ugbProjetoStatusTodos(projetos_tarefas $obj) {
        $id_ugb = $obj->getUgb();
        $id_projeto = $obj->getId_projeto();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_ugb = $id_ugb and ( projeto_executa.status = $status) ";
        return $sql;
    }

    function ugbProjetoDatasStatusTodos(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_ugb = $obj->getUgb();
        $id_projeto = $obj->getId_projeto();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_ugb = $id_ugb and  projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status) ";
        return $sql;
    }

    function ugbTipoVeiculoStatusTodos(projetos_tarefas $obj) {
        $id_tipoVeiculo = $obj->getId_tipo_veiculo();
        $id_ugb = $obj->getUgb();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where  veiculos.id_tipo = $id_tipoVeiculo and projeto_executa.id_ugb = $id_ugb and ( projeto_executa.status = $status) ";
        return $sql;
    }

    function ugbTipoVeiculoDatasStatusTodos(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_tipoVeiculo = $obj->getId_tipo_veiculo();
        $id_ugb = $obj->getUgb();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where  veiculos.id_tipo = $id_tipoVeiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status) ";
        return $sql;
    }

    function projetoVeiculoUgbStatusTodos(projetos_tarefas $obj) {
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $status = $obj->getStatus_projeto();
        $id_ugb = $obj->getUgb();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.id_ugb = $id_ugb  and ( projeto_executa.status = $status)";
        return $sql;
    }

    function projetoVeiculoUgbDatasStatusTodos(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $status = $obj->getStatus_projeto();
        $id_ugb = $obj->getUgb();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final'  and ( projeto_executa.status = $status)";
        return $sql;
    }

    function projetoTipoVeiculoUgbStatusTodos(projetos_tarefas $obj) {
        $id_projeto = $obj->getId_projeto();
        $id_tipoVeiculo = $obj->getId_tipo_veiculo();
        $status = $obj->getStatus_projeto();
        $id_ugb = $obj->getUgb();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and veiculos.id_tipo = $id_tipoVeiculo and projeto_executa.id_ugb = $id_ugb and ( projeto_executa.status = $status)";
        return $sql;
    }

    function projetoTipoVeiculoUgbDatasStatusTodos(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_projeto = $obj->getId_projeto();
        $id_tipoVeiculo = $obj->getId_tipo_veiculo();
        $status = $obj->getStatus_projeto();
        $id_ugb = $obj->getUgb();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and veiculos.id_tipo = $id_tipoVeiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status)";
        return $sql;
    }

    function tipoVeiculoDatasStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_tipoveiculo = $obj->getId_tipo_veiculo();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) where veiculos.id_tipo = $id_tipoveiculo and  projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status)  ";
        return $sql;
    }

    function projetosVeiculosStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and ( projeto_executa.status = $status) ";
        return $sql;
    }

    function projetosVeiculosDatasStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status) ";
        return $sql;
    }

    function projetoTipoStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $id_tipoveiculo = $obj->getId_tipo_veiculo();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) where veiculos.id_tipo = $id_tipoveiculo and projeto_executa.id_projeto = $id_projeto and ( projeto_executa.status = $status) ";
        return $sql;
    }
    
    
    
    
    

}
