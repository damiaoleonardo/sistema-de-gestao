<?php

class TabelaExecucao {

    function calculaDiferenca($hora_inicial, $hora_final) {
        $i = 1;
        $tempo_total;
        $tempos = array($hora_final, $hora_inicial);
        foreach ($tempos as $tempo) {
            $segundos = 0;
            list($h, $m, $s) = explode(':', $tempo);
            $segundos += $h * 3600;
            $segundos += $m * 60;
            $segundos += $s;
            $tempo_total[$i] = $segundos;
            $i++;
           }
        $segundos = $tempo_total[1] - $tempo_total[2];
        $horas = floor($segundos / 3600);
        $segundos -= $horas * 3600;
        $minutos = str_pad((floor($segundos / 60)), 2, '0', STR_PAD_LEFT);
        $segundos -= $minutos * 60;
        $segundos = str_pad($segundos, 2, '0', STR_PAD_LEFT);
        return "$horas:$minutos:$segundos";
    }

    function tabelaInicialativo() {
        ?>
        <table class='table table-hover'>
            <tr><td colspan="5" style="background:#449d44; color:white; font-size:1.1em;">Ativos<td></tr>
            <tr  style="font-size: 1.2em; background: #adadad; color:white;">
                <td>Funcionario</td>
                <td>Projeto</td>
                <td>Veiculo</td>
                <td>Horas Trabalhada</td>
                <td>Meta</td>
            </tr>
            <?php
            $sql = "SELECT projeto_executa.nome_projeto,projeto_executa.id_projeto_executa,projeto_executa.id_veiculo,projeto_executa.id_projeto, projeto_executa.horas_concluidas, projeto_executa.duracao, veiculos.nome_veiculo, funcionarios.sobrenome,funcionarios.id_funcionario
FROM projeto_executa
JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )
JOIN funcionario_executa ON ( projeto_executa.id_projeto_executa = funcionario_executa.id_projeto_executa
AND projeto_executa.id_projeto = funcionario_executa.id_projeto
AND projeto_executa.id_veiculo = funcionario_executa.id_veiculo )
JOIN funcionarios ON ( funcionario_executa.id_funcionario = funcionarios.id_funcionario )
WHERE funcionario_executa.status_funcionario_tarefa = 'ativo'";
            $result = mysql_query($sql);
            while ($dados_ativos = mysql_fetch_array($result)) {
                $id_funcionario = $dados_ativos['id_funcionario'];
                $id_do_projeto_executa = $dados_ativos['id_projeto_executa'];
                $id_do_projeto = $dados_ativos['id_projeto'];
                $id_do_veiculo = $dados_ativos['id_veiculo'];
                $nome_funcionario = $dados_ativos['sobrenome'];
                $nome_do_projeto = $dados_ativos['nome_projeto'];
                $nome_do_veiculo = $dados_ativos['nome_veiculo'];
                $horas_concluida = $dados_ativos['horas_concluidas'];
                $meta = $dados_ativos['duracao'];
                ?>
                <tr style="font-size: 1.1em;">
                    <td><a style="color:black;"  href=""><?php echo $nome_funcionario ?></a></td>
                    <td><a style="color:black;" href="telaprincipal.php?t=/relatorios_tarefas&id_projeto=<?php echo $id_do_projeto ?>&id_executa=<?php echo $id_do_projeto_executa ?>&id_veiculo=<?php echo $id_do_veiculo ?>&flag=1"><?php echo $nome_do_projeto ?></a></td>
                    <td><?php echo $nome_do_veiculo ?></td>
                    <td><?php echo $horas_concluida ?></td>
                    <td><?php echo $meta ?></td>
                </tr>  
                <?php
            }
            ?>
            <tr  style="height: 25px;">
                <td colspan="5"></td> 
            </tr>
            <tr style="font-size: 1.1em; background:salmon; color:white; height: 35px;">
                <td colspan="5">Inativos</td>
            </tr>
            <tr style="font-size: 1.1em; background: #adadad; color:white;">
                <td colspan="3">Funcionario</td>
                <td>Status</td>
                <td>Tempo Inativo</td>
            </tr>
            <?php
            $data_da_busca_funcionario_inativo = date('Y-m-d');
            $sql_funcionario_inativos = "select funcionarios.sobrenome,funcionarios.id_funcionario from funcionarios where funcionarios.disponibilidade = 'inativo'";

            $result_funcionarios_inativos = mysql_query($sql_funcionario_inativos);
            while ($aux_funcionarios_inativo = mysql_fetch_array($result_funcionarios_inativos)) {
                $sobrenome_funcionario_inativo = $aux_funcionarios_inativo['sobrenome'];
                $id_funcionario_inativo = $aux_funcionarios_inativo['id_funcionario'];
                $sql_funcionario_inativo = " SELECT max(funcionario_executa.hora_final)
                                         FROM funcionarios
                                         JOIN funcionario_executa ON ( funcionario_executa.id_funcionario = funcionarios.id_funcionario )
                                         WHERE funcionarios.disponibilidade = 'inativo'
                                         AND funcionario_executa.data_tarefa = '$data_da_busca_funcionario_inativo'
                                         AND funcionario_executa.id_funcionario = $id_funcionario_inativo";
                $result_funcionario_inativo = mysql_query($sql_funcionario_inativo);
                $hora_final_funcionario = mysql_fetch_row($result_funcionario_inativo);
                $horafinal = $hora_final_funcionario[0];
                
                if (empty($horafinal)) {
                    $ultimo_registro = "07:00:00";
                } else {
                    $ultimo_registro = $horafinal;
                }
                // $diferenca = calculaDiferenca("07:00:00","07:30:00");
                //  $hora_atual_do_bacno = horadobanco();
                //  $hora_inicial = DateTime::createFromFormat('H:i:s', $hora_atual_do_bacno);
                //  $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $ultimo_registro);
                //  $intervalo = $hora_inicial->diff($horainicio_da_tarefas);
                //  $hora_concluidas = $intervalo->format('%H:%I:%S');
                ?>
                <tr style="font-size: 1.1em;">
                    <td colspan="3"><?php echo $sobrenome_funcionario_inativo ?></td>
                    <td style="background: salmon; color: white;f">INATIVO</td>
                    <td style=" color: black;"><?php echo $horafinal ?> </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    }

}
