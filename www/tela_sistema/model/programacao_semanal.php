<?php

class programacao_semanal {
    
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
                    $sql_viagem_dia = "select  motoristas.nome_motorista,rotas.nome_rota,rotas.cor,veiculos.nome_veiculo "
                            . "from `programacao_semanal` join `dia_semana` on (dia_semana.id_dia = programacao_semanal.id_diasemana) "
                            . "join `motoristas` on (motoristas.id_motorista = programacao_semanal.id_motorista ) join `rotas` "
                            . "on (rotas.id_rota = programacao_semanal.id_rota) join `veiculos` on (veiculos.id_veiculo = programacao_semanal.id_veiculo) where id_dia = $id_do_dia ";

                    $result_viagem_dia = mysql_query($sql_viagem_dia);
                    while ($viagem_dia = mysql_fetch_array($result_viagem_dia)) {
                        $motorista = $viagem_dia['nome_motorista'];
                        $rotas = $viagem_dia['nome_rota'];
                        $veiculos = $viagem_dia['nome_veiculo'];
                        $cor = $viagem_dia['cor'];
                        ?>
                        <td style="background: <?php echo $cor ?> "><?php echo $motorista ?></td>
                        <td style="background: <?php echo $cor ?> "><?php echo $rotas ?></td>
                        <td style="background: <?php echo $cor ?> "><?php echo $veiculos ?></td>
                    </tr>
                    <?php
                }
                ?>
                    <tr style="height: 3px; ">
                        
                    </tr> 
              <?php
            }
            ?>
        </table>
        <?php
    }
}
