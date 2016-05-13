<?php

class ControleManutencao {

    private $veiculo;
    private $tarefa;
    private $km;
    private $semana;

    function monta_tabela_controle() {
        ?>
        <table class="table table-hover" style="font-size: 1em; background: white; ">
            <?php
            $flag_cabecalho = 0;
            $sql_id_veiculo = "select veiculos.id_veiculo,veiculos.nome_veiculo,veiculos.placa from veiculos where veiculos.id_tipo != 5 and veiculos.id_tipo != 8";
            $result = mysql_query($sql_id_veiculo);
            while ($id_do_veiculo = mysql_fetch_array($result)) {
                $id_veiculo = $id_do_veiculo['id_veiculo'];
                $veiculo = $id_do_veiculo['nome_veiculo'];
                $placa_veiculo = $id_do_veiculo['placa'];

                $sql_tarefas = "select veiculos.nome_veiculo,veiculos.placa,tarefas.nome,controle_manutencao.km,controle_manutencao.semana from `controle_manutencao` join `veiculos` on (controle_manutencao.id_veiculo_controle = veiculos.id_veiculo ) join `tarefas` on (tarefas.id_tarefa = controle_manutencao.id_tarefa_controle) where id_veiculo_controle = $id_veiculo ";
                $result_tarefas = mysql_query($sql_tarefas);
                ?>
                <tr>
                    <?php
                    if ($flag_cabecalho == 0) {
                        ?>
                    <td colspan="2">QUADRO DE MANUTENCAO</td>
                        <?php
                    } else {
                        ?>
                        <td><?php echo $aux_veiculo ?></td>
                        <td><?php echo $aux_placa ?></td>
                        <?php
                    }

                    $flag_cabecalho ++;
                    while ($informaçoes_manutencao = mysql_fetch_array($result_tarefas)) {
                        $tarefa = $informaçoes_manutencao['nome'];
                        $km = $informaçoes_manutencao['km'];
                        $semana = $informaçoes_manutencao['semana'];
                        ?>
                        <td>
                            <table class="table table-hover" style="font-size: 0.9em;  background: #777; color:white;">
                                <tr>
                                    <?php
                                    if ($flag_cabecalho == 1) {
                                        ?>
                                        <td colspan="2"><?php echo $tarefa; ?></td>
                                    <tr>
                                        <td>HRS / KM</td>
                                        <td>SEM / KM</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                        </tr>


                    <?php
                    if ($flag_cabecalho != 1) {
                        ?>
                      <tr style="width: 100%; height: 100%; ">
                        <td><?php echo $aux_km; ?></td>
                        <td><?php echo $aux_semana . " / " . "16"; ?></td>
                       </tr>
                       <?php
                    } 
                    ?>
                </table>
                </td>
                <?php
               $aux_km = $km;
               $aux_semana = $semana;
            }
            ?>
            </tr>
            <?php
            $aux_veiculo = $veiculo;
            $aux_placa = $placa_veiculo;
            
        }
        ?>
        </table>
        <?php
    }

    
    
    
    
    
    
    
    
    
function montar_cabecalho(){
    ?>
<table class="table table-hover" style="font-size: 1em; background: white; ">
    
    
</table>
   
<?php    
}

    
    
    
    
}
