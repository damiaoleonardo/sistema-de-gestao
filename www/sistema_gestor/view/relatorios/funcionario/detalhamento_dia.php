<?php
    require('../../../model/Conexao/Connection.class.php');
    $conexao = Connection::getInstance();
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

$id_do_funcionario_especifico = $_GET['id_funcionario'];
$data_selecionada = $_GET['data'];
$data_selecionada_para_consulta = invertedata($data_selecionada, '/', '/');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../style/bootstrap/class_table.css" type="text/css">
    </head>
    <body>
         <a id="btnClose" href="#" title="Close" class="close" onclick="fecha_modal('detalhamento_dia_funcionario')" >X</a>
        <div class="geral_relatorio_funcionario">
            <div id="menus">	
            </div>
            <nav style="height: 50px;"></nav>
            <div class="contans" style="" >
                <table class="table table-hover">
                    <tr>
                        <td style="font-weight: bold; background: #666666; color:white;font-size: 0.8em;  " colspan="3">Tarefas</td>
                        <td style="font-weight: bold; background: #666666; color:white;font-size: 0.8em; width: 10%;">Horas produzidas</td>
                        <td style="font-weight: bold; background: #666666; color:white;font-size: 0.8em; width: 10%;">Meta</td> 
                        <td style="font-weight: bold; background: #666666; color:white;font-size: 0.8em; ">Veiculo</td>
                        <td style="font-weight: bold; background: #666666; color:white;font-size: 0.8em; ">Descricao</td> 
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
                    $sql = "SELECT DATE_FORMAT(now(),'%H:%i:%s')";
                    $result = mysql_query($sql);
                    $hora_inicio = mysql_fetch_row($result);
                    $horario_atual = $hora_inicio[0];
                    
                    $hora_inicial = "07:00:00";
                    $meta_diaria = "09:00:00";
                    $flag_hora_inicial = 0;
                    $flag_status_tarefas = 0;
                    $hora_inicial_almoco = "11:00:00";
                    $hora_final_almoco = "11:00:00";
                    $almoco = "01:00:00";
                   
                   
                    
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

                    $horas_concluidas_funcionario_por_dia = array();
                    $sql_dia_a_dia_do_funcionario = "SELECT tarefas.id_tarefa, tarefas.nome, tarefas.duracao, funcionario_executa.horas_concluidas,funcionario_executa.id_veiculo,funcionario_executa.id_projeto,funcionario_executa.id_projeto_executa,funcionario_executa.hora_inicial,funcionario_executa.flag_tarefa_relatorio,funcionario_executa.hora_final
                                              FROM `tarefas` JOIN `funcionario_executa` ON ( tarefas.id_tarefa = funcionario_executa.id_tarefa )
                                              WHERE funcionario_executa.id_funcionario =$id_do_funcionario_especifico
                                              AND funcionario_executa.data_tarefa = '$data_selecionada_para_consulta' order by funcionario_executa.hora_inicial asc";
                    $result_dia_a_dia_do_funcionario = mysql_query($sql_dia_a_dia_do_funcionario);
                    while ($aux_dia_a_dia_do_funcionario = mysql_fetch_array($result_dia_a_dia_do_funcionario)) {
                        $codigo_tarefa = $aux_dia_a_dia_do_funcionario['id_tarefa'];
                        $nome_tarefa = $aux_dia_a_dia_do_funcionario['nome'];
                        $duracao_tarefa = $aux_dia_a_dia_do_funcionario['duracao'];
                        $horas_concluidas = $aux_dia_a_dia_do_funcionario['horas_concluidas'];
                        $hora_inicial_tarefa = $aux_dia_a_dia_do_funcionario['hora_inicial'];
                        $hora_final_tarefa = $aux_dia_a_dia_do_funcionario['hora_final'];
                        $flag_tarefa_relatorio = $aux_dia_a_dia_do_funcionario['flag_tarefa_relatorio'];
                        $id_veiculo_func = $aux_dia_a_dia_do_funcionario['id_veiculo'];
                        $id_projeto_func = $aux_dia_a_dia_do_funcionario['id_projeto'];
                        $id_projeto_executa_func = $aux_dia_a_dia_do_funcionario['id_projeto_executa'];

                        $horas_concluidas_funcionario_por_dia[] = $horas_concluidas;

                        $sql_informacoes_adicionais_tarefa = "SELECT tarefas_executa.horas_inicio_tarefa,tarefas_executa.horas_final, veiculos.nome_veiculo
                                                              FROM `tarefas_executa`
                                                              JOIN `veiculos` ON ( tarefas_executa.id_veiculo = veiculos.id_veiculo )
                                                              WHERE tarefas_executa.id_tarefa = $codigo_tarefa  and tarefas_executa.id_projeto = $id_projeto_func and tarefas_executa.id_veiculo = $id_veiculo_func and tarefas_executa.id_projeto_executa = $id_projeto_executa_func";
                        $result_informacoes_adicionais_tarefa = mysql_query($sql_informacoes_adicionais_tarefa);
                        while ($aux_informacoes_adicionais_tarefa = mysql_fetch_array($result_informacoes_adicionais_tarefa)) {
                         //   $descricao_tarefa = $aux_informacoes_adicionais_tarefa['descricao_da_tarefa'];
                            $nome_veiculo = $aux_informacoes_adicionais_tarefa['nome_veiculo'];
                            $tarefa_horas = $aux_informacoes_adicionais_tarefa['horas_inicio_tarefa'];
                            $horas_final = $aux_informacoes_adicionais_tarefa['horas_final'];
                        }

                        if ($flag_tarefa_relatorio != 1) {

                            if ($flag_hora_inicial == 0) {
                                $ultima_atualizacao = "07:00:00";
                                $aux_hora_final = "00:00:00";
                                $flag_hora_inicial = 1;
                            } else if ($flag_hora_inicial == 1) {
                                $ultima_atualizacao = $aux_hora_final;
                            }
                            ?>
                            <tr>
                                
                                <?php

                                
                                $hora_inicial = DateTime::createFromFormat('H:i:s', $ultima_atualizacao);
                                $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $hora_inicial_tarefa);
                                $intervalo = $hora_inicial->diff($horainicio_da_tarefas);
                                $hora_concluidas = $intervalo->format('%H:%I:%S');
                                $horas_ja_concluida = transformahoraemminuto($hora_concluidas);
                                $duracao_geral = transformahoraemminuto($meta_diaria);
                                $pintadiv = $horas_ja_concluida / $duracao_geral;
                                $tamanho = $pintadiv * 100 . "%";
                                ?>
                                <td style="height: 40px;background: #3a87ad; color:white; font-size: 0.9em; "><?php echo $ultima_atualizacao ?></td>
                                <td style=" text-align: left; width: 20%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: blue; display: block; font-size: 0.9em;"><?php echo $hora_concluidas . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . "INATIVO" ?><div id="execucao_tarefas" style="background: red; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                <td style="height: 40px; background: #3a87ad; color:white; font-size: 0.9em; "><?php echo $hora_inicial_tarefa ?></td>
                                <td style="font-size: 0.9em; background: #3a87ad;; color:white; "></td>
                                <td style="background:#3a87ad; color:white;">Sem meta</td>
                                <td colspan="3" style="background: #3a87ad; color:white; font-size: 0.9em;">Sem Informação</td>
                                <td></td>
                            </tr>
                            <tr>
                                <?php
                                $horas__concluida = transformahoraemminuto($horas_concluidas);
                                $duracao__geral = transformahoraemminuto($meta_diaria);
                                $pinta_div = $horas__concluida / $duracao__geral;
                                $tamanho = $pinta_div * 100 . "%";

                                ?>
                                <td style="height: 40px; background: #006600; color:white; font-size: 0.9em; "><?php echo $hora_inicial_tarefa ?></td>
                                <td style=" text-align: left; width: 40%;"><div id="barra_tarefa" style="width: 100%;  position: relative; color: black; display: block; font-size: 0.9em;"><?php echo $horas_concluidas . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nome_tarefa ?><div id="execucao_tarefas" style="background: green; color:white; border-radius: 3px; width: <?php echo $tamanho ?>; height: 40px; margin-top:-25px; filter:alpha(opacity=55);opacity:.55;  position: absolute;  "></div></div></td>
                                <td style="height: 40px; background: #006600; color:white; font-size: 0.9em; "><?php echo $hora_final_tarefa ?></td>
                                <td style="font-size: 0.9em; background: #006600; color:white;"><?php echo $horas_concluidas ?></td>
                                <td style="font-size: 0.9em; background: #006600; color:white;"><?php echo $duracao_tarefa ?></td>
                                <td style="font-size: 0.9em; background: #006600; color:white;"><?php echo $nome_veiculo ?></td>
                                <td style="font-size: 0.9em; background: #006600; color:white;"><?php // echo $descricao_tarefa ?></td>
                            </tr>
                            <?php

                           $aux_hora_final = $hora_final_tarefa;
                        }
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
                        

                        <?php
                    }
                    ?>

                </table>
            </div>
            <table  class="table table-hover">
                <tr>
                    <?php $horas_trabalhadas_pelo_funcionario = somarhoras_funcionario($horas_concluidas_funcionario_por_dia); ?>
                    <td style="background: #0077b3; color: white; font-size: 0.9em; ">Soma Total Diaria</td>
                    <td style="background: #0077b3; color: white; font-size: 0.9em; "><?php echo $horas_trabalhadas_pelo_funcionario ?></td>
                </tr> 
            </table>
            <footer></footer>
        </div>
    </body>
</html>
