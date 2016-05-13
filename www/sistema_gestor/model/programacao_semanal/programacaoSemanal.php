<?php

class programacaoSemanal {

    private $dia_semana;

    function getDia_semana() {
        return $this->dia_semana;
    }

    function setDia_semana($dia_semana) {
        $this->dia_semana = $dia_semana;
    }

    function montaDia(programacaoSemanal $obj) {
        $dia = $obj->getDia_semana();
        $sql_edit = "select  motoristas.nome_motorista,rotas.nome_rota,veiculos.nome_veiculo "
                . "from `programacao_semanal` join `dia_semana` on (dia_semana.id_dia = programacao_semanal.id_diasemana) "
                . "join `motoristas` on (motoristas.id_motorista = programacao_semanal.id_motorista ) join `rotas` "
                . "on (rotas.id_rota = programacao_semanal.id_rota) join `veiculos` on (veiculos.id_veiculo = programacao_semanal.id_veiculo) where dia_semana = '$dia' ";
        ?>
        <div class="container" style="width: 100%; ">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">

                    <div class="panel panel-default panel-table">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col col-xs-6">
                                    <h3 class="panel-title"><?php echo $dia ?></h3>
                                </div>
                                <div class="col col-xs-6 text-right">
                                    <button type="button" class="btn btn-sm btn-primary btn-create">Adicionar Viagem</button>
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
                                            $nome_motorista = $aux_edit['nome_motorista'];
                                            $nome_rotas = $aux_edit['nome_rota'];
                                            $nome_veiculos = $aux_edit['nome_veiculo'];
                                            ?>
                                            <td align="center">
                                                <a class="btn btn-default"><em class="fa fa-pencil"></em></a>
                                                <a class="btn btn-danger"><em class="fa fa-trash"></em></a>
                                            </td>
                                            <td class="hidden-xs"><?php echo $nome_motorista ?></td>
                                            <td><?php echo $nome_rotas ?></td>
                                            <td><?php echo $nome_veiculos ?></td>
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
                    $sql_viagem_dia = "select  motoristas.nome_motorista,rotas.nome_rota,veiculos.nome_veiculo "
                            . "from `programacao_semanal` join `dia_semana` on (dia_semana.id_dia = programacao_semanal.id_diasemana) "
                            . "join `motoristas` on (motoristas.id_motorista = programacao_semanal.id_motorista ) join `rotas` "
                            . "on (rotas.id_rota = programacao_semanal.id_rota) join `veiculos` on (veiculos.id_veiculo = programacao_semanal.id_veiculo) where id_dia = $id_do_dia ";

                    $result_viagem_dia = mysql_query($sql_viagem_dia);
                    while ($viagem_dia = mysql_fetch_array($result_viagem_dia)) {
                        $motorista = $viagem_dia['nome_motorista'];
                        $rotas = $viagem_dia['nome_rota'];
                        $veiculos = $viagem_dia['nome_veiculo'];
                        ?>
                        <td><?php echo $motorista ?></td>
                        <td><?php echo $rotas ?></td>
                        <td><?php echo $veiculos ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
        <?php
    }

}
?>
