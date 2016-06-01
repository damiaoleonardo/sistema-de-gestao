<?php

class ControleManutencao {

    function monta_tabela_controle() {
        ?>
        <table class="table table-hover" style="font-size: 1em; background: white;">

            <?php
            $sql_id_veiculo = "select veiculos.id_veiculo,veiculos.nome_veiculo,veiculos.placa from veiculos where veiculos.id_tipo != 5 and veiculos.id_tipo != 8";
            $result = mysql_query($sql_id_veiculo);
            while ($id_do_veiculo = mysql_fetch_array($result)) {
                $id_veiculo = $id_do_veiculo['id_veiculo'];
                $veiculo = $id_do_veiculo['nome_veiculo'];
                $placa_veiculo = $id_do_veiculo['placa'];
                $aux_id_veiculo = $id_veiculo;
                ?>

                <tr>
                    <td style="width: 10%; "><?php echo $veiculo ?></td>
                    <td style="width: 10%;"><?php echo $placa_veiculo ?></td>
                    <?php
                    $sql_tarefas = "select veiculos.nome_veiculo,veiculos.placa,tarefas.nome,controle_manutencao.km,controle_manutencao.semana from `controle_manutencao` join `veiculos` on (controle_manutencao.id_veiculo_controle = veiculos.id_veiculo ) join `tarefas` on (tarefas.id_tarefa = controle_manutencao.id_tarefa_controle) where id_veiculo_controle = $id_veiculo ";
                    $result_tarefas = mysql_query($sql_tarefas);
                    while ($informaçoes_manutencao = mysql_fetch_array($result_tarefas)) {
                        $tarefa = $informaçoes_manutencao['nome'];
                        $km = $informaçoes_manutencao['km'];
                        $semana = $informaçoes_manutencao['semana'];
                        ?>
                        <td style="width: 20%; ">
                            <table  class="table table-hover">
                                <tr>
                                    <td style="color: royalblue; width: 50%;"><?php echo $km ?></td>
                                    <td style="color: royalblue; width: 50%;"><?php echo $semana ?></td>
                                </tr>
                            </table>
                        </td>

                        <?php
                    }
                    ?>
                </tr>
                <?php
            }
            ?>

        </table>
        <?php
    }
}
