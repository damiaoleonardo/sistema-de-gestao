<?php

class programacao_semanal {

   function visualizaProgramacao() {
        ?>
     <div id="painel" style="font: 15px Tahoma; cursor: default; height: 550px; overflow: hidden; background-color: #DFEDFE; padding-left: 10px;  padding-right: 10px" onmouseover="Parar()" onmouseout="Rolar()">
        <table class="table table-hover" style="background: white; font-size: 1.2em;">
            <tr style="height: 60px; background: #01669F; color:white; ">
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
                        $cor = $viagem_dia['cor'];
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
                        <td style="background: <?php echo $cor ?>"><?php echo $nome_motoristaA ?></td>
                            <?php
                        } else {
                            ?>
                            <td style="background: <?php echo $cor ?>"><?php echo $nome_motoristaA . "/" . $nome_motoristaB ?></td>
                            <?php
                        }
                        ?>
                        <td style="background: <?php echo $cor ?>"><?php echo $rotas ?></td>
                        <td style="background: <?php echo $cor ?>"><?php echo $veiculos ?></td>
                    </tr>
                     
                    <?php
                }
            }
            ?>
               <tr style="height: 50px; background: lightpink">
                        <td></td>
                        <td></td>
                         <td></td>
                    </tr>    
        </table>
    </div>
        <?php
    }

}
