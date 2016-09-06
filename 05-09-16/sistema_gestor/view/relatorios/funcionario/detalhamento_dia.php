<?php

function diaSemana($data) {
    $ano = substr("$data", 0, 4);
    $mes = substr("$data", 5, -3);
    $dia = substr("$data", 8, 9);
    $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));
    switch ($diasemana) {
        case"0": $diasemana = "Domingo";
            break;
        case"1": $diasemana = "Segunda-Feira";
            break;
        case"2": $diasemana = "Terça-Feira";
            break;
        case"3": $diasemana = "Quarta-Feira";
            break;
        case"4": $diasemana = "Quinta-Feira";
            break;
        case"5": $diasemana = "Sexta-Feira";
            break;
        case"6": $diasemana = "Sábado";
            break;
    }return "$diasemana";
}

function somarhoras_funcionario($times) {
    $seconds = 0;
    foreach ($times as $time) {
        list( $g, $i, $s ) = explode(':', $time);
        $seconds += $g * 3600;
        $seconds += $i * 60;
        $seconds += $s;
    }
    $hours = floor($seconds / 3600);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    if ($hours == 0 || $hours < 10) {
        $hours = "0" . $hours;
    }
    if ($minutes == 0 || $minutes < 10) {
        $minutes = "0" . $minutes;
    }
    if ($seconds == 0 || $seconds < 10) {
        $seconds = "0" . $seconds;
    }
    return "{$hours}:{$minutes}:{$seconds}";
}

function invertedata($data, $separar = "/", $juntar = "/") {
    return implode($juntar, array_reverse(explode($separar, $data)));
}

function comparaHoras($primeira_hora, $segunda_hora) {
    if ($primeira_hora == $segunda_hora) {
        return 1;
    }
    return 0;
}

function transformahoraemminuto($hora) {
    $quebraHora = explode(":", $hora); //retorna um array onde cada elemento é separado por ":"
    $minutos = $quebraHora[0];
    $minutos = $minutos * 60;
    $minutos = $minutos + $quebraHora[1];
    return $minutos;
}

function comparaintervalodetempo($horario1, $horario2) {
    $hora_inicial_da_tarefa = DateTime::createFromFormat('H:i:s', $horario1);
    $hora_inicio_da_tarefas = DateTime::createFromFormat('H:i:s', $horario2);
    $intervalo_entre_horas_em_minutos = $hora_inicial_da_tarefa->diff($hora_inicio_da_tarefas);
    $intervalos_entre_horas = $intervalo_entre_horas_em_minutos->format('%H:%I:%S');
    return $intervalos_entre_horas;
}

$id_do_funcionario_especifico = $_GET['id_funcionario'];
$data_selecionada = $_GET['data'];
$data_selecionada_para_consulta = invertedata($data_selecionada, '/', '/');
?>
<a id="btnClose" href="#" title="Close" class="close" onclick="fecha_modal('detalhamento_dia_funcionario')" >X</a>
<div class="geral_relatorio_funcionario">
    <div id="menus">	
    </div>
    <nav style="height: 50px;"></nav>
    <div class="contans" style="">
        <table class="table table-hover">
            <tr style="font-weight: bold; background: #666666; color:white;font-size: 1em; ">
                <td colspan="3">Tarefas</td>
                <td style=" width: 15%;">Horas produzidas</td>
                <td>Meta</td> 
                <td>Veiculo</td>
            </tr>
            <tr>
                <td style="height: 10px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php
            $conexao_dados_projeto = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
            $conexao_dados_projeto->set_charset("utf8");
            $flag_hora_inicial_parte_manha = 0;
            $flag_hora_inicial_parte_tarde = 0;
            $flag_hora_inicial_parte_noite = 0;
            $flag_linha_tempo_extra = 0;
            $flag_linha_tempo_extra_almoco = 0;
            $flag_linha_manha_tarde = 0;
            $flag_linha_almoco = 0;
            $flag_status_tarefas = 0;
            $flag_quebra_horario = 0;

            $horas_concluidas_funcionario_por_dia = array();
            $sql_dia_a_dia_do_funcionario = "SELECT  tarefas.id_tarefa, tarefas.nome, tarefas.duracao, funcionario_executa.horas_concluidas,funcionario_executa.id_veiculo,funcionario_executa.id_projeto,funcionario_executa.id_projeto_executa,funcionario_executa.hora_inicial,funcionario_executa.flag_tarefa_relatorio,funcionario_executa.hora_final,funcionario_executa.codigo
                                              FROM `tarefas` JOIN `funcionario_executa` ON ( tarefas.id_tarefa = funcionario_executa.id_tarefa )
                                              WHERE funcionario_executa.id_funcionario =$id_do_funcionario_especifico
                                              AND funcionario_executa.data_tarefa = '$data_selecionada_para_consulta' order by funcionario_executa.hora_inicial asc";
            $result_select_dados = mysqli_query($conexao_dados_projeto, $sql_dia_a_dia_do_funcionario);
            while ($row = $result_select_dados->fetch_assoc()) {
                $codigo_funcionario_executa = $row['codigo'];
                $codigo_tarefa = $row['id_tarefa'];
                $nome_tarefa = $row['nome'];
                $duracao_tarefa = $row['duracao'];
                $horas_concluidas = $row['horas_concluidas'];
                $hora_inicial_tarefa = $row['hora_inicial'];
                $hora_final_tarefa = $row['hora_final'];
                $flag_tarefa_relatorio = $row['flag_tarefa_relatorio'];
                $id_veiculo_func = $row['id_veiculo'];
                $id_projeto_func = $row['id_projeto'];
                $id_projeto_executa_func = $row['id_projeto_executa'];
                $conexao_dados_tarefa = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
                $conexao_dados_tarefa->set_charset("utf8");
                $sql_informacoes_adicionais_tarefa = "SELECT tarefas_executa.id_tarefa_executa,tarefas_executa.horas_inicio_tarefa,tarefas_executa.horas_final, veiculos.nome_veiculo
                                                              FROM `tarefas_executa`
                                                              JOIN `veiculos` ON ( tarefas_executa.id_veiculo = veiculos.id_veiculo )
                                                              WHERE tarefas_executa.id_tarefa = $codigo_tarefa  and tarefas_executa.id_projeto = $id_projeto_func and tarefas_executa.id_veiculo = $id_veiculo_func and tarefas_executa.id_projeto_executa = $id_projeto_executa_func";
                $result_select_dados_tarefa = mysqli_query($conexao_dados_tarefa, $sql_informacoes_adicionais_tarefa);
                while ($aux_row = $result_select_dados_tarefa->fetch_assoc()) {
                    $id_tarefa_executa = $aux_row['id_tarefa_executa'];
                    $nome_veiculo = $aux_row['nome_veiculo'];
                }

                // verifica se a atividade do dia do funcionario esta em pause ou se ja foi finalizada


                if ($flag_tarefa_relatorio != 1) {

                    // verifica se o dia e um dia de sexta feira ou nao
                    if (diaSemana($data_selecionada) == "Sexta-Feira") {

                        $meta_diaria = "08:00:00";
                        if ($hora_inicial_tarefa >= "00:00:00" && $hora_final_tarefa <= "07:00:00") {
                            if ($flag_linha_tempo_extra == 0) {
                                ?>
                                <tr><td colspan="7" style="height: 50px; background: #204d74; color:white;  font-size: 1em; ">Tempo extra ao dia do funcionario</td></tr>
                                <?php
                                $flag_linha_tempo_extra = 1;
                            }
                            $ultima_atualizacao = $hora_inicial_tarefa;
                        } else if ($hora_inicial_tarefa >= "07:00:00" && $hora_final_tarefa <= "11:00:00") {
                            if ($flag_hora_inicial_parte_manha == 0) {
                                ?>
                                <tr><td colspan="7" style="height: 60px; background: #888; color:white;  font-size: 1em; ">Periodo da Manha</td></tr>
                                <?php
                                $ultima_atualizacao = "07:00:00";
                                $aux_hora_final = "00:00:00";
                                $flag_hora_inicial_parte_manha = 1;
                                $flag_linha_tempo_extra = 0;
                            } else if ($flag_hora_inicial_parte_manha == 1) {
                                $ultima_atualizacao = $aux_hora_final;
                            }
                            $horas_concluidas_funcionario_por_dia[] = $horas_concluidas;
                        } else if ($hora_inicial_tarefa >= "12:00:00" && $hora_final_tarefa <= "16:00:00") {
                            if ($flag_hora_inicial_parte_tarde == 0) {
                                ?>
                                <tr><td colspan="7" style="height: 60px; background: #67b168; color:white;  font-size: 1em; ">Periodo da tarde</td></tr>
                                <?php
                                $ultima_atualizacao = "12:00:00";
                                $aux_hora_final = "00:00:00";
                                $flag_hora_inicial_parte_tarde = 1;
                                $flag_linha_tempo_extra = 0;
                            } else if ($flag_hora_inicial_parte_tarde == 1) {
                                $ultima_atualizacao = $aux_hora_final;
                            }
                            $horas_concluidas_funcionario_por_dia[] = $horas_concluidas;
                        } else if ($hora_inicial_tarefa >= "16:00:00" && $hora_final_tarefa <= "23:59:59") {
                            if ($flag_linha_tempo_extra == 0) {
                                ?>
                                <tr><td colspan="7" style="height: 50px; background: #204d74; color:white;  font-size: 1em; ">Tempo extra ao dia do funcionario</td></tr>
                                <?php
                                $flag_linha_tempo_extra = 1;
                            }
                            $ultima_atualizacao = $hora_inicial_tarefa;
                        } else if ($hora_inicial_tarefa >= "00:00:00" && $hora_inicial_tarefa <= "07:00:00" && $hora_final_tarefa > "07:00:00") {
                            if ($flag_linha_tempo_extra == 0) {
                                ?>
                                <tr><td colspan="7" style="height: 50px; background: #204d74; color:white;  font-size: 1em; ">Tempo extra ao dia do funcionario</td></tr>
                                <?php
                                $flag_linha_tempo_extra = 1;
                                $horainicial_anterior = DateTime::createFromFormat('H:i:s', $hora_inicial_tarefa);
                                $horainicio_da_tarefas_anterior = DateTime::createFromFormat('H:i:s', "07:00:00");
                                $intervalo_anterior = $horainicial_anterior->diff($horainicio_da_tarefas_anterior);
                                $hora_concluidas_anterior = $intervalo_anterior->format('%H:%I:%S');
                                $horas_ja_concluida = transformahoraemminuto($hora_concluidas_anterior);
                                $duracao_geral = transformahoraemminuto($meta_diaria);
                                $pintadiv = $horas_ja_concluida / $duracao_geral;
                                $tamanho = $pintadiv * 100 . "%";
                                ?>
                                <tr style="font-size: 0.9em; color:white;">
                                    <td style="height: 50px;background: #67b168; "><?php echo $hora_inicial_tarefa ?></td>
                                    <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_anterior . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                    <td style="height: 50px; background: #67b168; "><?php echo "07:00:00" ?></td>
                                    <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_anterior ?></td>
                                    <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                    <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr><td colspan="7" style="height: 60px; background: #67b168; color:white;  font-size: 1em; ">Periodo da Manha</td></tr>
                            <?php
                            $horainicial_posterior = DateTime::createFromFormat('H:i:s', "07:00:00");
                            $horainicio_da_tarefas_posterior = DateTime::createFromFormat('H:i:s', $hora_final_tarefa);
                            $intervalo_posterior = $horainicial_posterior->diff($horainicio_da_tarefas_posterior);
                            $hora_concluidas_posterior = $intervalo_posterior->format('%H:%I:%S');
                            $horas_concluidas_funcionario_por_dia[] = $hora_concluidas_posterior;
                            $horas__concluida = transformahoraemminuto($hora_concluidas_posterior);
                            $duracao__geral = transformahoraemminuto($meta_diaria);
                            $pinta_div = $horas__concluida / $duracao__geral;
                            $tamanho = $pinta_div * 100 . "%";
                            $flag_hora_inicial_parte_manha = 1;
                            $flag_linha_tempo_extra = 0;
                            ?>
                            <tr style="font-size: 0.9em; color:white;">
                                <td style="height: 50px;background: #67b168; "><?php echo "07:00:00" ?></td>
                                <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_posterior . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                <td style="height: 50px; background: #67b168;  "><?php echo $hora_final_tarefa ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_posterior ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                            </tr>
                            <?php
                            $flag_quebra_horario = 1;
                        } else if ($hora_inicial_tarefa >= "07:00:00" && $hora_inicial_tarefa <= "11:00:00" && $hora_final_tarefa > "11:00:00") {
                            $horainicial_anterior = DateTime::createFromFormat('H:i:s', $hora_inicial_tarefa);
                            $horainicio_da_tarefas_anterior = DateTime::createFromFormat('H:i:s', "11:00:00");
                            $intervalo_anterior = $horainicial_anterior->diff($horainicio_da_tarefas_anterior);
                            $hora_concluidas_anterior = $intervalo_anterior->format('%H:%I:%S');
                            $horas_ja_concluida = transformahoraemminuto($hora_concluidas_anterior);
                            $horas_concluidas_funcionario_por_dia[] = $hora_concluidas_anterior;
                            $duracao_geral = transformahoraemminuto($meta_diaria);
                            $pintadiv = $horas_ja_concluida / $duracao_geral;
                            $tamanho = $pintadiv * 100 . "%";
                            ?>
                            <tr style="font-size: 0.9em; color:white;">
                                <td style="height: 50px;background: #67b168; "><?php echo $hora_inicial_tarefa ?></td>
                                <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_anterior . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                <td style="height: 50px; background: #67b168; "><?php echo "11:00:00" ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_anterior ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                            </tr>
                            <?php
                            if ($flag_linha_tempo_extra == 0) {
                                ?>
                                <tr><td colspan="7" style="height: 50px; background: #204d74; color:white;  font-size: 1em; ">Tempo extra no almoço</td></tr>
                                <?php
                                $flag_linha_tempo_extra = 1;
                            }
                            $horainicial_posterior = DateTime::createFromFormat('H:i:s', "11:00:00");
                            $horainicio_da_tarefas_posterior = DateTime::createFromFormat('H:i:s', $hora_final_tarefa);
                            $intervalo_posterior = $horainicial_posterior->diff($horainicio_da_tarefas_posterior);
                            $hora_concluidas_posterior = $intervalo_posterior->format('%H:%I:%S');
                            $horas__concluida = transformahoraemminuto($hora_concluidas_posterior);
                            $duracao__geral = transformahoraemminuto($meta_diaria);
                            $pinta_div = $horas__concluida / $duracao__geral;
                            $tamanho = $pinta_div * 100 . "%";
                            $flag_hora_inicial_parte_manha = 1;
                            ?>
                            <tr style="font-size: 0.9em; color:white;">
                                <td style="height: 50px;background: #67b168; "><?php echo "11:00:00" ?></td>
                                <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_posterior . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                <td style="height: 50px; background: #67b168;  "><?php echo $hora_final_tarefa ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_posterior ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                            </tr>
                            <?php
                            $flag_quebra_horario = 1;
                        } else if ($hora_inicial_tarefa >= "11:00:00" && $hora_inicial_tarefa <= "12:00:00" && $hora_final_tarefa > "12:00:00") {
                            if ($flag_linha_tempo_extra == 0) {
                                ?>
                                <tr><td colspan="7" style="height: 50px; background: #204d74; color:white;  font-size: 1em; ">Tempo extra ao dia do funcionario</td></tr>
                                <?php
                                $flag_linha_tempo_extra = 1;
                                $horainicial_anterior = DateTime::createFromFormat('H:i:s', $hora_inicial_tarefa);
                                $horainicio_da_tarefas_anterior = DateTime::createFromFormat('H:i:s', "12:00:00");
                                $intervalo_anterior = $horainicial_anterior->diff($horainicio_da_tarefas_anterior);
                                $hora_concluidas_anterior = $intervalo_anterior->format('%H:%I:%S');
                                $horas_ja_concluida = transformahoraemminuto($hora_concluidas_anterior);
                                $duracao_geral = transformahoraemminuto($meta_diaria);
                                $pintadiv = $horas_ja_concluida / $duracao_geral;
                                $tamanho = $pintadiv * 100 . "%";
                                ?>
                                <tr style="font-size: 0.9em; color:white;">
                                    <td style="height: 50px;background: #67b168; "><?php echo $hora_inicial_tarefa ?></td>
                                    <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_anterior . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                    <td style="height: 50px; background: #67b168; "><?php echo "12:00:00" ?></td>
                                    <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_anterior ?></td>
                                    <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                    <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr><td colspan="7" style="height: 60px; background: #67b168; color:white;  font-size: 1em; ">Periodo da Tarde</td></tr>
                            <?php
                            $horainicial_posterior = DateTime::createFromFormat('H:i:s', "12:00:00");
                            $horainicio_da_tarefas_posterior = DateTime::createFromFormat('H:i:s', $hora_final_tarefa);
                            $intervalo_posterior = $horainicial_posterior->diff($horainicio_da_tarefas_posterior);
                            $hora_concluidas_posterior = $intervalo_posterior->format('%H:%I:%S');
                            $horas_concluidas_funcionario_por_dia[] = $hora_concluidas_posterior;
                            $horas__concluida = transformahoraemminuto($hora_concluidas_posterior);
                            $duracao__geral = transformahoraemminuto($meta_diaria);
                            $pinta_div = $horas__concluida / $duracao__geral;
                            $tamanho = $pinta_div * 100 . "%";
                            $flag_hora_inicial_parte_manha = 1;
                            $flag_linha_tempo_extra = 0;
                            ?>
                            <tr style="font-size: 0.9em; color:white;">
                                <td style="height: 50px;background: #67b168; "><?php echo "12:00:00" ?></td>
                                <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_posterior . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                <td style="height: 50px; background: #67b168;  "><?php echo $hora_final_tarefa ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_posterior ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                            </tr>
                            <?php
                            $flag_quebra_horario = 1;
                        } else if ($hora_inicial_tarefa >= "12:00:00" && $hora_inicial_tarefa <= "16:00:00" && $hora_final_tarefa > "16:00:00") {

                            $horainicial_anterior = DateTime::createFromFormat('H:i:s', $hora_inicial_tarefa);
                            $horainicio_da_tarefas_anterior = DateTime::createFromFormat('H:i:s', "17:00:00");
                            $intervalo_anterior = $horainicial_anterior->diff($horainicio_da_tarefas_anterior);
                            $hora_concluidas_anterior = $intervalo_anterior->format('%H:%I:%S');
                            $horas_ja_concluida = transformahoraemminuto($hora_concluidas_anterior);
                            $horas_concluidas_funcionario_por_dia[] = $hora_concluidas_anterior;
                            $duracao_geral = transformahoraemminuto($meta_diaria);
                            $pintadiv = $horas_ja_concluida / $duracao_geral;
                            $tamanho = $pintadiv * 100 . "%";
                            ?>
                            <tr style="font-size: 0.9em; color:white;">
                                <td style="height: 50px;background: #67b168; "><?php echo $hora_inicial_tarefa ?></td>
                                <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_anterior . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                <td style="height: 50px; background: #67b168; "><?php echo "16:00:00" ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_anterior ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                            </tr>
                            <?php
                            if ($flag_linha_tempo_extra == 0) {
                                ?>
                                <tr><td colspan="7" style="height: 50px; background: #204d74; color:white;  font-size: 1em; ">Tempo extra ao dia do funcionario</td></tr>
                                <?php
                                $flag_linha_tempo_extra = 1;
                            }
                            $horainicial_posterior = DateTime::createFromFormat('H:i:s', "16:00:00");
                            $horainicio_da_tarefas_posterior = DateTime::createFromFormat('H:i:s', $hora_final_tarefa);
                            $intervalo_posterior = $horainicial_posterior->diff($horainicio_da_tarefas_posterior);
                            $hora_concluidas_posterior = $intervalo_posterior->format('%H:%I:%S');
                            $horas__concluida = transformahoraemminuto($hora_concluidas_posterior);
                            $duracao__geral = transformahoraemminuto($meta_diaria);
                            $pinta_div = $horas__concluida / $duracao__geral;
                            $tamanho = $pinta_div * 100 . "%";
                            $flag_hora_inicial_parte_manha = 1;
                            ?>
                            <tr style="font-size: 0.9em; color:white;">
                                <td style="height: 50px;background: #67b168; "><?php echo "16:00:00" ?></td>
                                <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_posterior . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                <td style="height: 50px; background: #67b168;  "><?php echo $hora_final_tarefa ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_posterior ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                            </tr>
                            <?php
                            $flag_quebra_horario = 1;
                        }
                        //////////////////////////    dia da semana entre segunda a quinta feira        //////////////////////   
                    } else {
                        $meta_diaria = "09:00:00";
                        if ($hora_inicial_tarefa >= "00:00:00" && $hora_final_tarefa <= "07:00:00") {
                            if ($flag_linha_tempo_extra == 0) {
                                ?>
                                <tr><td colspan="7" style="height: 50px; background: #204d74; color:white;  font-size: 1em; ">Tempo extra ao dia do funcionario</td></tr>
                                <?php
                                $flag_linha_tempo_extra = 1;
                            }
                            $ultima_atualizacao = $hora_inicial_tarefa;
                        } else if ($hora_inicial_tarefa >= "07:00:00" && $hora_final_tarefa <= "11:00:00") {
                            if ($flag_hora_inicial_parte_manha == 0) {
                                ?>
                                <tr><td colspan="7" style="height: 60px; background: #888; color:white;  font-size: 1em; ">Periodo da Manha</td></tr>
                                <?php
                                $ultima_atualizacao = "07:00:00";
                                $flag_hora_inicial_parte_manha = 1;
                                $flag_linha_tempo_extra = 0;
                            } else if ($flag_hora_inicial_parte_manha == 1) {
                                $ultima_atualizacao = $aux_hora_final;
                            }
                            $horas_concluidas_funcionario_por_dia[] = $horas_concluidas;
                        } else if ($hora_inicial_tarefa >= "12:00:00" && $hora_final_tarefa <= "17:00:00") {
                            if ($flag_hora_inicial_parte_tarde == 0) {
                                ?>
                                <tr><td colspan="7" style="height: 60px; background: #67b168; color:white;  font-size: 1em; ">Periodo da tarde</td></tr>
                                <?php
                                $ultima_atualizacao = "12:00:00";
                                $flag_hora_inicial_parte_tarde = 1;
                                $flag_linha_tempo_extra = 0;
                            } else if ($flag_hora_inicial_parte_tarde == 1) {
                                $ultima_atualizacao = $aux_hora_final;
                            }
                            $horas_concluidas_funcionario_por_dia[] = $horas_concluidas;
                        } else if ($hora_inicial_tarefa >= "17:00:00" && $hora_final_tarefa <= "23:59:59") {
                            if ($flag_linha_tempo_extra == 0) {
                                ?>
                                <tr><td colspan="7" style="height: 50px; background: #204d74; color:white;  font-size: 1em; ">Tempo extra ao dia do funcionario</td></tr>
                                <?php
                                $flag_linha_tempo_extra = 1;
                            }
                            $ultima_atualizacao = $hora_inicial_tarefa;
                        } else if ($hora_inicial_tarefa >= "00:00:00" && $hora_inicial_tarefa <= "07:00:00" && $hora_final_tarefa > "07:00:00") {
                            if ($flag_linha_tempo_extra == 0) {
                                ?>
                                <tr><td colspan="7" style="height: 50px; background: #204d74; color:white;  font-size: 1em; ">Tempo extra ao dia do funcionario</td></tr>
                                <?php
                                $flag_linha_tempo_extra = 1;
                                $horainicial_anterior = DateTime::createFromFormat('H:i:s', $hora_inicial_tarefa);
                                $horainicio_da_tarefas_anterior = DateTime::createFromFormat('H:i:s', "07:00:00");
                                $intervalo_anterior = $horainicial_anterior->diff($horainicio_da_tarefas_anterior);
                                $hora_concluidas_anterior = $intervalo_anterior->format('%H:%I:%S');
                                $horas_ja_concluida = transformahoraemminuto($hora_concluidas_anterior);
                                $duracao_geral = transformahoraemminuto($meta_diaria);
                                $pintadiv = $horas_ja_concluida / $duracao_geral;
                                $tamanho = $pintadiv * 100 . "%";
                                ?>
                                <tr style="font-size: 0.9em; color:white;">
                                    <td style="height: 50px;background: #67b168; "><?php echo $hora_inicial_tarefa ?></td>
                                    <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_anterior . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                    <td style="height: 50px; background: #67b168; "><?php echo "07:00:00" ?></td>
                                    <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_anterior ?></td>
                                    <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                    <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr><td colspan="7" style="height: 60px; background: #67b168; color:white;  font-size: 1em; ">Periodo da Manha</td></tr>
                            <?php
                            $horainicial_posterior = DateTime::createFromFormat('H:i:s', "07:00:00");
                            $horainicio_da_tarefas_posterior = DateTime::createFromFormat('H:i:s', $hora_final_tarefa);
                            $intervalo_posterior = $horainicial_posterior->diff($horainicio_da_tarefas_posterior);
                            $hora_concluidas_posterior = $intervalo_posterior->format('%H:%I:%S');
                            $horas_concluidas_funcionario_por_dia[] = $hora_concluidas_posterior;
                            $horas__concluida = transformahoraemminuto($hora_concluidas_posterior);
                            $duracao__geral = transformahoraemminuto($meta_diaria);
                            $pinta_div = $horas__concluida / $duracao__geral;
                            $tamanho = $pinta_div * 100 . "%";
                            $flag_hora_inicial_parte_manha = 1;
                            $flag_linha_tempo_extra = 0;
                            ?>
                            <tr style="font-size: 0.9em; color:white;">
                                <td style="height: 50px;background: #67b168; "><?php echo "07:00:00" ?></td>
                                <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_posterior . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                <td style="height: 50px; background: #67b168;  "><?php echo $hora_final_tarefa ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_posterior ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                            </tr>
                            <?php
                            $flag_quebra_horario = 1;
                        } else if ($hora_inicial_tarefa >= "07:00:00" && $hora_inicial_tarefa <= "11:00:00" && $hora_final_tarefa > "11:00:00") {
                            $horainicial_anterior = DateTime::createFromFormat('H:i:s', $hora_inicial_tarefa);
                            $horainicio_da_tarefas_anterior = DateTime::createFromFormat('H:i:s', "11:00:00");
                            $intervalo_anterior = $horainicial_anterior->diff($horainicio_da_tarefas_anterior);
                            $hora_concluidas_anterior = $intervalo_anterior->format('%H:%I:%S');
                            $horas_ja_concluida = transformahoraemminuto($hora_concluidas_anterior);
                            $horas_concluidas_funcionario_por_dia[] = $hora_concluidas_anterior;
                            $duracao_geral = transformahoraemminuto($meta_diaria);
                            $pintadiv = $horas_ja_concluida / $duracao_geral;
                            $tamanho = $pintadiv * 100 . "%";
                            ?>
                            <tr style="font-size: 0.9em; color:white;">
                                <td style="height: 50px;background: #67b168; "><?php echo $hora_inicial_tarefa ?></td>
                                <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_anterior . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                <td style="height: 50px; background: #67b168; "><?php echo "11:00:00" ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_anterior ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                            </tr>
                            <?php
                            if ($flag_linha_tempo_extra == 0) {
                                ?>
                                <tr><td colspan="7" style="height: 50px; background: #204d74; color:white;  font-size: 1em; ">Tempo extra no almoço</td></tr>
                                <?php
                                $flag_linha_tempo_extra = 1;
                                $flag_linha_tempo_extra_almoco = 1;
                            }
                            $horainicial_posterior = DateTime::createFromFormat('H:i:s', "11:00:00");
                            $horainicio_da_tarefas_posterior = DateTime::createFromFormat('H:i:s', $hora_final_tarefa);
                            $intervalo_posterior = $horainicial_posterior->diff($horainicio_da_tarefas_posterior);
                            $hora_concluidas_posterior = $intervalo_posterior->format('%H:%I:%S');
                            $horas__concluida = transformahoraemminuto($hora_concluidas_posterior);
                            $duracao__geral = transformahoraemminuto($meta_diaria);
                            $pinta_div = $horas__concluida / $duracao__geral;
                            $tamanho = $pinta_div * 100 . "%";
                            $flag_hora_inicial_parte_manha = 1;
                            ?>
                            <tr style="font-size: 0.9em; color:white;">
                                <td style="height: 50px;background: #67b168; "><?php echo "11:00:00" ?></td>
                                <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_posterior . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                <td style="height: 50px; background: #67b168;  "><?php echo $hora_final_tarefa ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_posterior ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                            </tr>
                            <?php
                            $flag_quebra_horario = 1;
                        } else if ($hora_inicial_tarefa >= "11:00:00" && $hora_inicial_tarefa <= "12:00:00" && $hora_final_tarefa > "12:00:00" && $hora_final_tarefa <= "17:00:00") {
                            if ($flag_linha_tempo_extra == 0) {
                                ?>
                                <tr><td colspan="7" style="height: 50px; background: #204d74; color:white;  font-size: 1em; ">Tempo extra ao dia do funcionario</td></tr>
                                <?php
                                $flag_linha_tempo_extra = 1;
                                $horainicial_anterior = DateTime::createFromFormat('H:i:s', $hora_inicial_tarefa);
                                $horainicio_da_tarefas_anterior = DateTime::createFromFormat('H:i:s', "12:00:00");
                                $intervalo_anterior = $horainicial_anterior->diff($horainicio_da_tarefas_anterior);
                                $hora_concluidas_anterior = $intervalo_anterior->format('%H:%I:%S');
                                $horas_ja_concluida = transformahoraemminuto($hora_concluidas_anterior);
                                $duracao_geral = transformahoraemminuto($meta_diaria);
                                $pintadiv = $horas_ja_concluida / $duracao_geral;
                                $tamanho = $pintadiv * 100 . "%";
                                ?>
                                <tr style="font-size: 0.9em; color:white;">
                                    <td style="height: 50px;background: #67b168; "><?php echo $hora_inicial_tarefa ?></td>
                                    <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_anterior . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                    <td style="height: 50px; background: #67b168; "><?php echo "12:00:00" ?></td>
                                    <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_anterior ?></td>
                                    <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                    <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                                </tr>
                                <?php
                            } else if ($flag_linha_tempo_extra_almoco = 1) {
                                $flag_linha_tempo_extra = 1;
                                $flag_hora_inicial_parte_tarde = 1;
                                $horainicial_anterior = DateTime::createFromFormat('H:i:s', $hora_inicial_tarefa);
                                $horainicio_da_tarefas_anterior = DateTime::createFromFormat('H:i:s', "12:00:00");
                                $intervalo_anterior = $horainicial_anterior->diff($horainicio_da_tarefas_anterior);
                                $hora_concluidas_anterior = $intervalo_anterior->format('%H:%I:%S');
                                $horas_ja_concluida = transformahoraemminuto($hora_concluidas_anterior);
                                $duracao_geral = transformahoraemminuto($meta_diaria);
                                $pintadiv = $horas_ja_concluida / $duracao_geral;
                                $tamanho = $pintadiv * 100 . "%";
                                ?>
                                <tr style="font-size: 0.9em; color:white;">
                                    <td style="height: 50px;background: #67b168; "><?php echo $hora_inicial_tarefa ?></td>
                                    <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_anterior . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                    <td style="height: 50px; background: #67b168; "><?php echo "12:00:00" ?></td>
                                    <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_anterior ?></td>
                                    <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                    <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr><td colspan="7" style="height: 60px; background: #67b168; color:white;  font-size: 1em; ">Periodo da Tarde</td></tr>
                            <?php
                            $horainicial_posterior = DateTime::createFromFormat('H:i:s', "12:00:00");
                            $horainicio_da_tarefas_posterior = DateTime::createFromFormat('H:i:s', $hora_final_tarefa);
                            $intervalo_posterior = $horainicial_posterior->diff($horainicio_da_tarefas_posterior);
                            $hora_concluidas_posterior = $intervalo_posterior->format('%H:%I:%S');
                            $horas_concluidas_funcionario_por_dia[] = $hora_concluidas_posterior;
                            $horas__concluida = transformahoraemminuto($hora_concluidas_posterior);
                            $duracao__geral = transformahoraemminuto($meta_diaria);
                            $pinta_div = $horas__concluida / $duracao__geral;
                            $tamanho = $pinta_div * 100 . "%";
                            $flag_hora_inicial_parte_manha = 1;
                            $flag_linha_tempo_extra = 0;
                            ?>
                            <tr style="font-size: 0.9em; color:white;">
                                <td style="height: 50px;background: #67b168; "><?php echo "12:00:00" ?></td>
                                <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_posterior . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                <td style="height: 50px; background: #67b168;  "><?php echo $hora_final_tarefa ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_posterior ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                            </tr>
                            <?php
                            $flag_quebra_horario = 1;
                        } else if ($hora_inicial_tarefa >= "11:00:00" && $hora_inicial_tarefa <= "12:00:00" && $hora_final_tarefa > "17:00:00") {
                            $horainicial_anterior = DateTime::createFromFormat('H:i:s', $hora_inicial_tarefa);
                            $horainicio_da_tarefas_anterior = DateTime::createFromFormat('H:i:s', "12:00:00");
                            $intervalo_anterior = $horainicial_anterior->diff($horainicio_da_tarefas_anterior);
                            $hora_concluidas_anterior = $intervalo_anterior->format('%H:%I:%S');
                            $horas_ja_concluida = transformahoraemminuto($hora_concluidas_anterior);
                            $duracao_geral = transformahoraemminuto($meta_diaria);
                            $pintadiv = $horas_ja_concluida / $duracao_geral;
                            $tamanho = $pintadiv * 100 . "%";
                            ?>
                            <tr style="font-size: 0.9em; color:white;">
                                <td style="height: 50px;background: #67b168; "><?php echo $hora_inicial_tarefa ?></td>
                                <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_anterior . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                <td style="height: 50px; background: #67b168; "><?php echo "12:00:00" ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_anterior ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                            </tr>
                            <tr><td colspan="7" style="height: 60px; background: #67b168; color:white;  font-size: 1em; ">Periodo da Tarde</td></tr>
                            <?php
                            $horainicial_posterior = DateTime::createFromFormat('H:i:s', "12:00:00");
                            $horainicio_da_tarefas_posterior = DateTime::createFromFormat('H:i:s', "17:00:00");
                            $intervalo_posterior = $horainicial_posterior->diff($horainicio_da_tarefas_posterior);
                            $hora_concluidas_posterior = $intervalo_posterior->format('%H:%I:%S');
                            $horas_concluidas_funcionario_por_dia[] = $hora_concluidas_posterior;
                            $horas__concluida = transformahoraemminuto($hora_concluidas_posterior);
                            $duracao__geral = transformahoraemminuto($meta_diaria);
                            $pinta_div = $horas__concluida / $duracao__geral;
                            $tamanho = $pinta_div * 100 . "%";
                            $flag_hora_inicial_parte_manha = 1;
                            $flag_linha_tempo_extra = 0;
                            ?>
                            <tr style="font-size: 0.9em; color:white;">
                                <td style="height: 50px;background: #67b168; "><?php echo "12:00:00" ?></td>
                                <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_posterior . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                <td style="height: 50px; background: #67b168;  "><?php echo "17:00:00" ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_posterior ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                            </tr>
                            <tr><td colspan="7" style="height: 50px; background: #204d74; color:white;  font-size: 1em; ">Tempo extra ao dia do funcionario</td></tr>
                            <?php
                            $horainicial_posterior_horario = DateTime::createFromFormat('H:i:s', "17:00:00");
                            $horainicio_da_tarefas_posterior_horario = DateTime::createFromFormat('H:i:s', $hora_final_tarefa);
                            $intervalo_posterior_horario = $horainicial_posterior_horario->diff($horainicio_da_tarefas_posterior_horario);
                            $hora_concluidas_posterior_horario = $intervalo_posterior_horario->format('%H:%I:%S');
                            $horas_ja_concluida_posterior_horario = transformahoraemminuto($hora_concluidas_posterior_horario);
                            $duracao_geral_posterior_horario = transformahoraemminuto($meta_diaria);
                            $pintadiv = $horas_ja_concluida_posterior_horario / $duracao_geral_posterior_horario;
                            $tamanho = $pintadiv * 100 . "%";
                            ?>
                            <tr style="font-size: 0.9em; color:white;">
                                <td style="height: 50px;background: #67b168; "><?php echo "17:00:00" ?></td>
                                <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_posterior_horario . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                <td style="height: 50px; background: #67b168; "><?php echo $hora_final_tarefa ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_posterior_horario ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                            </tr>
                            <?php
                            $flag_quebra_horario = 1;
                        } else if ($hora_inicial_tarefa >= "12:00:00" && $hora_inicial_tarefa <= "17:00:00" && $hora_final_tarefa > "17:00:00") {
                            $horainicial_anterior = DateTime::createFromFormat('H:i:s', $hora_inicial_tarefa);
                            $horainicio_da_tarefas_anterior = DateTime::createFromFormat('H:i:s', "17:00:00");
                            $intervalo_anterior = $horainicial_anterior->diff($horainicio_da_tarefas_anterior);
                            $hora_concluidas_anterior = $intervalo_anterior->format('%H:%I:%S');
                            $horas_ja_concluida = transformahoraemminuto($hora_concluidas_anterior);
                            $horas_concluidas_funcionario_por_dia[] = $hora_concluidas_anterior;
                            $duracao_geral = transformahoraemminuto($meta_diaria);
                            $pintadiv = $horas_ja_concluida / $duracao_geral;
                            $tamanho = $pintadiv * 100 . "%";
                            ?>
                            <tr style="font-size: 0.9em; color:white;">
                                <td style="height: 50px;background: #67b168; "><?php echo $hora_inicial_tarefa ?></td>
                                <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_anterior . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                <td style="height: 50px; background: #67b168; "><?php echo "17:00:00" ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_anterior ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                            </tr>
                            <?php
                            if ($flag_linha_tempo_extra == 0) {
                                ?>
                                <tr><td colspan="7" style="height: 50px; background: #204d74; color:white;  font-size: 1em; ">Tempo extra ao dia do funcionario</td></tr>
                                <?php
                                $flag_linha_tempo_extra = 1;
                            }
                            $horainicial_posterior = DateTime::createFromFormat('H:i:s', "17:00:00");
                            $horainicio_da_tarefas_posterior = DateTime::createFromFormat('H:i:s', $hora_final_tarefa);
                            $intervalo_posterior = $horainicial_posterior->diff($horainicio_da_tarefas_posterior);
                            $hora_concluidas_posterior = $intervalo_posterior->format('%H:%I:%S');
                            $horas__concluida = transformahoraemminuto($hora_concluidas_posterior);
                            $duracao__geral = transformahoraemminuto($meta_diaria);
                            $pinta_div = $horas__concluida / $duracao__geral;
                            $tamanho = $pinta_div * 100 . "%";
                            $flag_hora_inicial_parte_manha = 1;
                            ?>
                            <tr style="font-size: 0.9em; color:white;">
                                <td style="height: 50px;background: #67b168; "><?php echo "17:00:00" ?></td>
                                <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block;"><?php echo $hora_concluidas_posterior . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                <td style="height: 50px; background: #67b168;  "><?php echo $hora_final_tarefa ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $hora_concluidas_posterior ?></td>
                                <td style=" background: #67b168;  border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                                <td style=" background: #67b168; "><?php echo $nome_veiculo ?></td>
                            </tr>
                            <?php
                            $flag_quebra_horario = 1;
                        }
                    }

                    if ($flag_quebra_horario == 0) {
                        $hora_inicial = DateTime::createFromFormat('H:i:s', $ultima_atualizacao);
                        $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $hora_inicial_tarefa);
                        $intervalo = $hora_inicial->diff($horainicio_da_tarefas);
                        $hora_concluidas = $intervalo->format('%H:%I:%S');
                        $horas_ja_concluida = transformahoraemminuto($hora_concluidas);
                        $duracao_geral = transformahoraemminuto($meta_diaria);
                        $pintadiv = $horas_ja_concluida / $duracao_geral;
                        $tamanho = $pintadiv * 100 . "%";
                        ?>
                        <tr style="font-size: 1em; color:white;">
                            <td style="height: 50px; background: #67b168; "><?php echo $ultima_atualizacao ?></td>
                            <td style=" text-align: left; width: 20%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: blue; display: block; font-size: 0.9em;"><?php echo $hora_concluidas . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . "INATIVO" ?><div id="execucao_tarefas" style="background: red; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                            <td style="height: 50px; background: #67b168; "><?php echo $hora_inicial_tarefa ?></td>
                            <td colspan="4" style="background: #E38585;  ">Tempo Inativo = <?php echo $hora_concluidas ?></td>
                        </tr>
                        <tr style="font-size: 1em; color:white;">
                            <?php
                            $horas__concluida = transformahoraemminuto($horas_concluidas);
                            $duracao__geral = transformahoraemminuto($meta_diaria);
                            $pinta_div = $horas__concluida / $duracao__geral;
                            $tamanho = $pinta_div * 100 . "%";
                            ?>
                            <td style="height: 50px;background: #67b168; "><?php echo $hora_inicial_tarefa ?></td>
                            <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block; font-size: 0.9em;"><?php echo $horas_concluidas . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                            <td style="height: 50px; background: #67b168;"><?php echo $hora_final_tarefa ?></td>
                            <td style=" background: #67b168; border-right:1px solid white;"><?php echo $horas_concluidas ?></td>
                            <td style=" background: #67b168; border-right:1px solid white;"><?php echo $duracao_tarefa ?></td>
                            <td style=" background: #67b168;"><?php echo $nome_veiculo ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
                </td>
                </tr>
                <?php
                $aux_hora_final = $hora_final_tarefa;
                $flag_quebra_horario = 0;
            }

            if ($codigo_tarefa == null || $nome_tarefa == null || $duracao_tarefa == null) {
                ?>
                <tr>
                    <td style="height: 50px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="height: 50px; color: black;">
                    <td></td>
                    <td></td> 
                    <td>Este Funcionario não esta com nenhum registro de atividades para este dia solicitado</td>
                    <td></td>
                </tr> 
            </table>
        </div>
        <table  class="table table-hover">
            <tr style="background: #0077b3; color: white; font-size: 0.9em; ">
                <td>Soma Total Diaria</td>
                <td><?php echo "00:00:00" ?></td>
            </tr> 
        </table>
        <?php
    } else {
        ?>
        <table  class="table table-hover">
            <tr style="background: #0077b3; color: white; font-size: 0.9em; ">
                <?php $horas_trabalhadas_pelo_funcionario = somarhoras_funcionario($horas_concluidas_funcionario_por_dia); ?>
                <td>Soma Total Diaria</td>
                <td><?php echo $horas_trabalhadas_pelo_funcionario ?></td>
            </tr> 
        </table>
        <?php
        $horas_trabalhadas_pelo_funcionario = "";
    }
    ?> 
    <footer></footer>
</div>