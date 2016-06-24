<?php

class programacaoSemanal {

    private $dia_semana;
    private $motoristaA;
    private $motoristaB;
    private $veiculo;
    private $rota;

    function getMotoristaB() {
        return $this->motoristaB;
    }

    function setMotoristaB($motoristaB) {
        $this->motoristaB = $motoristaB;
    }

    function getMotoristaA() {
        return $this->motoristaA;
    }

    function getVeiculo() {
        return $this->veiculo;
    }

    function getRota() {
        return $this->rota;
    }

    function setMotoristaA($motoristaA) {
        $this->motoristaA = $motoristaA;
    }

    function setVeiculo($veiculo) {
        $this->veiculo = $veiculo;
    }

    function setRota($rota) {
        $this->rota = $rota;
    }

    function getDia_semana() {
        return $this->dia_semana;
    }

    function setDia_semana($dia_semana) {
        $this->dia_semana = $dia_semana;
    }

    function getIdDiaSemana($id_dia) {
        $sql_id = "select dia_semana.dia_semana from dia_semana  where dia_semana.id_dia = $id_dia";
        $aux_dia = mysql_query($sql_id);
        $id__dia = mysql_fetch_row($aux_dia);
        return $id_do_dia = $id__dia[0];
    }

    function montaDia(programacaoSemanal $obj) {
        $dia = $obj->getDia_semana();
        session_start("dia");
        $_SESSION['id_dia'] = $dia;
        $sql_edit = "select programacao_semanal.id_motoristaA,programacao_semanal.id_motoristaB,rotas.nome_rota,rotas.cor,rotas.id_rota,veiculos.nome_veiculo,veiculos.id_veiculo "
                            . "from `programacao_semanal` join `dia_semana` on (dia_semana.id_dia = programacao_semanal.id_diasemana) "
                            . "join `rotas` "
                            . "on (rotas.id_rota = programacao_semanal.id_rota) join `veiculos` on (veiculos.id_veiculo = programacao_semanal.id_veiculo) where id_dia = $dia ";
        ?>
        <div class="container" style="width: 100%; ">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">

                    <div class="panel panel-default panel-table">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col col-xs-6">
                                    <h3 class="panel-title"><?php echo $diasemana = $this->getIdDiaSemana($dia); ?></h3>
                                </div>
                                <div class="col col-xs-6 text-right">
                                    <button type="button" class="btn btn-sm btn-primary btn-create" onclick="openModalViagemAdiciona('viagem')">Adicionar Viagem</button>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-list">
                                <thead>
                                    <tr>
                                        <th><em class="fa fa-cog"></em></th>
                                        <th class="hidden-xs">Motorista</th>
                                        <th>Destino</th>
                                        <th>Veiculos</th>
                                    </tr> 
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                   
                                        $result_edit = mysql_query($sql_edit);
                                        while ($aux_edit = mysql_fetch_array($result_edit)) {
                                            $nome_rotas = $aux_edit['nome_rota'];
                                            $nome_veiculos = $aux_edit['nome_veiculo'];
                                            $cor_rota = $aux_edit['cor'];
                                            $id_rota = $aux_edit['id_rota'];
                                            $id_veiculo = $aux_edit['id_veiculo'];
                                            $id_motoristaA = $aux_edit['id_motoristaA'];
                                            $id_motoristaB = $aux_edit['id_motoristaB'];
                                            $sql_motoristaA = "select motoristas.nome_motorista from `motoristas` join `programacao_semanal` on (programacao_semanal.id_motoristaA = motoristas.id_motorista) where id_diasemana = $dia and id_motoristaA = $id_motoristaA ";
                                            $aux_motoristaA = mysql_query($sql_motoristaA);
                                            $motoristaA = mysql_fetch_row($aux_motoristaA);
                                            $nome_motoristaA = $motoristaA[0];
                                            $sql_motoristaB = "select motoristas.nome_motorista from `motoristas` join `programacao_semanal` on (programacao_semanal.id_motoristaB = motoristas.id_motorista) where id_diasemana = $dia and id_motoristaB = $id_motoristaB ";
                                            $aux_motoristaB = mysql_query($sql_motoristaB);
                                            $motoristaB = mysql_fetch_row($aux_motoristaB);
                                            $nome_motoristaB = $motoristaB[0];
                                            ?>
                                            <td align="center">
                                             <!-- <a class="btn btn-default"><em class="fa fa-pencil" onclick="openModalViagemEdite('editeviagem')"><span class="glyphicon glyphicon-pencil" style="color: #006600;"></span></em></a>-->
                                              <a class="btn btn-danger" href="telaPrincipal.php?t=programacao-semanal&v=edita-programacao&dia_semana=<?php echo $dia; ?>&id_motoristaA=<?php echo $id_motoristaA ?>&id_motoristaB=<?php echo $id_motoristaB ?>&id_rota=<?php echo $id_rota ?>&id_veiculo=<?php echo $id_veiculo ?>" onClick="return confirm('Deseja realmente deletar o veiculo:')"><span style="color: #006600; font-size: 0.7em;">X</span></a>   
                                            </td>
                                            <?php
                                            if (empty($nome_motoristaB)) {
                                                ?>
                                                <td style="background: <?php echo $cor_rota ?>"><?php echo $nome_motoristaA ?></td>
                                                <?php
                                            } else {
                                                ?>
                                                <td style="background: <?php echo $cor_rota ?>"><?php echo $nome_motoristaA . "/" . $nome_motoristaB ?></td>
                                                <?php
                                            }
                                            ?>
                                            <td style="background: <?php echo $cor_rota ?>"><?php echo $nome_rotas ?></td>
                                            <td style="background: <?php echo $cor_rota ?>"><?php echo $nome_veiculos ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                        <div class="panel-footer">

                        </div>
                    </div>

                </div></div></div>
        <?php
    }

    function visualizaProgramacao() {
        ?>
        <table class="table table-hover" style="background: white;" >
            <tr style="height: 40px; background: #01669F; color:white; font-size: 1em;">
                <td>Dia</td>
                <td>Motorista</td>
                <td>Destino</td>
                <td>Veiculos</td>
            </tr>
            <?php
            $sql_programcao = "select dia_semana.id_dia,dia_semana.dia_semana from dia_semana where  1";
            $result = mysql_query($sql_programcao);
            while ($id_da_semana = mysql_fetch_array($result)) {
                $id_do_dia = $id_da_semana['id_dia'];
                $dia_da_semana = $id_da_semana['dia_semana'];
                $sql_count_viagens = "select count(programacao_semanal.id_diasemana) from `programacao_semanal` join `dia_semana` on (programacao_semanal.id_diasemana = dia_semana.id_dia) where id_dia = $id_do_dia";
                $aux_count = mysql_query($sql_count_viagens);
                $quantidade_viagens = mysql_fetch_row($aux_count);
                $count_viagens = $quantidade_viagens[0];
                ?>
                <tr>
                    <td rowspan="<?php echo $count_viagens ?>" style="margin-top:5px; background: #01669F; color:white; font-size: 1em;"><?php echo $dia_da_semana ?></td>
                    <?php
                    $sql_viagem_dia = "select programacao_semanal.id_motoristaA,programacao_semanal.id_motoristaB,rotas.nome_rota,rotas.cor,veiculos.nome_veiculo "
                            . "from `programacao_semanal` join `dia_semana` on (dia_semana.id_dia = programacao_semanal.id_diasemana) "
                            . "join `rotas` "
                            . "on (rotas.id_rota = programacao_semanal.id_rota) join `veiculos` on (veiculos.id_veiculo = programacao_semanal.id_veiculo) where id_dia = $id_do_dia ";

                    $result_viagem_dia = mysql_query($sql_viagem_dia);
                    while ($viagem_dia = mysql_fetch_array($result_viagem_dia)) {
                        $rotas = $viagem_dia['nome_rota'];
                        $veiculos = $viagem_dia['nome_veiculo'];
                        $cor_da_rota = $viagem_dia['cor'];
                        $id_motoristaA = $viagem_dia['id_motoristaA'];
                        $id_motoristaB = $viagem_dia['id_motoristaB'];
                        $sql_motoristaA = "select motoristas.nome_motorista from `motoristas` join `programacao_semanal` on (programacao_semanal.id_motoristaA = motoristas.id_motorista) where id_diasemana = $id_do_dia and id_motoristaA = $id_motoristaA ";
                        $aux_motoristaA = mysql_query($sql_motoristaA);
                        $motoristaA = mysql_fetch_row($aux_motoristaA);
                        $nome_motoristaA = $motoristaA[0];
                        $sql_motoristaB = "select motoristas.nome_motorista from `motoristas` join `programacao_semanal` on (programacao_semanal.id_motoristaB = motoristas.id_motorista) where id_diasemana = $id_do_dia and id_motoristaB = $id_motoristaB ";
                        $aux_motoristaB = mysql_query($sql_motoristaB);
                        $motoristaB = mysql_fetch_row($aux_motoristaB);
                        $nome_motoristaB = $motoristaB[0];
                        if (empty($nome_motoristaB)) {
                            ?>
                            <td style="background: <?php echo $cor_da_rota ?>"><?php echo $nome_motoristaA ?></td>
                            <?php
                        } else {
                            ?>
                            <td style="background: <?php echo $cor_da_rota ?>"><?php echo $nome_motoristaA . "/" . $nome_motoristaB ?></td>
                            <?php
                        }
                        ?>
                        <td style="background: <?php echo $cor_da_rota ?>"><?php echo $rotas ?></td>
                        <td style="background: <?php echo $cor_da_rota ?>"><?php echo $veiculos ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
        <?php
    }

    function adicionaViagem(programacaoSemanal $obj) {
        session_start("dia");
        $dia = $_SESSION['id_dia'];
        $motoristaA = $obj->getMotoristaA();
        $motoristaB = $obj->getMotoristaB();
        $rota = $obj->getRota();
        $veiculo = $obj->getVeiculo();
        $sql_insere_viagem = "insert into programacao_semanal (id_diasemana,id_motoristaA,id_motoristaB,id_rota,id_veiculo) values ('$dia','$motoristaA','$motoristaB','$rota','$veiculo')";
        $conexao_select = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        mysqli_autocommit($conexao_select, FALSE);
        if (mysqli_query($conexao_select, $sql_insere_viagem)) {
            mysqli_commit($conexao_select);
            echo "<script>alert('Viagem cadastrada com sucesso!')</script>";
            echo "<script>location.reload();</script>";
        } else {
            mysqli_rollback($conexao_select);
            echo "<script>alert('Falha ao inserir a viagem!')</script>";
        }
    }

}

?>
