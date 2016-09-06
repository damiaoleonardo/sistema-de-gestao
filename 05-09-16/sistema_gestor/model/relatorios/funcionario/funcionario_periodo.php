<?php

class funcionario_periodo {

    private $id_funcionario;
    private $data_inicio;
    private $data_final;

    function getId_funcionario() {
        return $this->id_funcionario;
    }

    function getData_inicio() {
        return $this->data_inicio;
    }

    function getData_final() {
        return $this->data_final;
    }

    function setId_funcionario($id_funcionario) {
        $this->id_funcionario = $id_funcionario;
    }

    function setData_inicio($data_inicio) {
        $this->data_inicio = $data_inicio;
    }

    function setData_final($data_final) {
        $this->data_final = $data_final;
    }

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

    function transformahoraemminuto($hora) {
        $quebraHora = explode(":", $hora); //retorna um array onde cada elemento é separado por ":"
        $minutos = $quebraHora[0];
        $minutos = $minutos * 60;
        $minutos = $minutos + $quebraHora[1];
        return $minutos;
    }

    function transformahoraemsegundo($hora) {
        $quebraHora = explode(":", $hora); //retorna um array onde cada elemento é separado por ":"
        $minutos = $quebraHora[0];
        $minutos = $minutos * 60;
        $minutos = $minutos + $quebraHora[1];
        $segundos = $quebraHora[2];
        $segundos = $segundos / 60;
        $segundos_total = $minutos + $segundos;
        return $segundos_total * 60;
    }

    function calcula_diferenca($hora_inicio, $horas_final) {
        $hora_inicial = DateTime::createFromFormat('H:i:s', $hora_inicio);
        $hora_final = DateTime::createFromFormat('H:i:s', $horas_final);
        return $intervalo = $hora_inicial->diff($hora_final);
    }

    function verificaTarefanoArray($nome_tarefa, $array) {
        if (in_array($nome_tarefa, $array)) {
            return true;
        }
    }

    function somavaloresarray($array) {
        $tamanho_array = sizeof($array);
        $total = 0;
        for ($i = 1; $i < $tamanho_array; $i += 2) {
            $total += $array[$i];
            //  echo "recebido = ". $array[$i] . "<br>";
            // echo "total = ". $total . "<br>";
        }
        return $total;
    }

    function transferenciadearray($array) {
        $tamanho_array = sizeof($array);
        for ($i = 0; $i < $tamanho_array; $i += 2) {
            $porcentagem_grafico_total[] = array($array[$i], $array[$i + 1]);
        }
        return $porcentagem_grafico_total;
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

    function MontaTabelaInformacaoDia(funcionario_periodo $obj) {
        $id_funcionario = $obj->getId_funcionario();
        $data_inicio = $obj->getData_inicio();
        ?>
        <div style="width: 45%; float:left;  height: 100%;  overflow-y: scroll; ">
            <table class="table table-hover">
                <tr class="coluna" style=" color:black; background: #999; height: 50px;">
                    <td>Data</td><td>Tempo Ativo</td><td>Tempo Inativo</td><td>Meta Diaria</td><td>Tempo Extra</td>
                </tr>
                <?php
                try {
                    $host = "localhost";
                    $user = "root";
                    $pass = "";
                    $banco = "sistema_de_gestao";
                    $conexao = mysql_connect($host, $user, $pass)or die(mysql_error());
                    $bd = mysql_select_db($banco, $conexao)or die(mysql_error());
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }
                $horas_concluidas_funcionario_por_dia = array();
                $horas_extras = array();
                if ($this->diaSemana($data_inicio) == "Sexta-Feira") {
                    $meta_diaria = "08:00:00";
                } else {
                    $meta_diaria = "09:00:00";
                }
                $sql_dia_funcionario = "SELECT tarefas.id_tarefa, tarefas.nome, tarefas.duracao, funcionario_executa.horas_concluidas,funcionario_executa.id_veiculo,funcionario_executa.id_projeto,funcionario_executa.id_projeto_executa,funcionario_executa.hora_inicial,funcionario_executa.flag_tarefa_relatorio,funcionario_executa.hora_final
                                              FROM `tarefas` JOIN `funcionario_executa` ON ( tarefas.id_tarefa = funcionario_executa.id_tarefa )
                                              WHERE funcionario_executa.id_funcionario = $id_funcionario
                                              AND funcionario_executa.data_tarefa = '$data_inicio' order by funcionario_executa.hora_inicial asc";
                $result_dia_funcionario = mysql_query($sql_dia_funcionario);
                while ($aux_dia_a_dia_do_funcionario = mysql_fetch_array($result_dia_funcionario)) {
                    $hora_inicial = $aux_dia_a_dia_do_funcionario['hora_inicial'];
                    $hora_final = $aux_dia_a_dia_do_funcionario['hora_final'];
                    if ($this->diaSemana($data_inicio) == "Sexta-Feira") {
                        if ($hora_inicial >= "00:00:00" && $hora_final <= "07:00:00") {
                            $horainicial = DateTime::createFromFormat('H:i:s', $hora_inicial);
                            $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $hora_final);
                            $intervalo = $horainicial->diff($horainicio_da_tarefas);
                            $hora_concluidas = $intervalo->format('%H:%I:%S');
                            $horas_extras[] = $hora_concluidas;
                        } else if ($hora_inicial >= "07:00:00" && $hora_final <= "11:00:00") {
                            $horas_concluidas_funcionario_por_dia[] = $aux_dia_a_dia_do_funcionario['horas_concluidas'];
                        } else if ($hora_inicial >= "12:00:00" && $hora_final <= "16:00:00") {
                            $horas_concluidas_funcionario_por_dia[] = $aux_dia_a_dia_do_funcionario['horas_concluidas'];
                        } else if ($hora_inicial >= "16:00:00" && $hora_final <= "23:59:59") {
                            $horainicial = DateTime::createFromFormat('H:i:s', $hora_inicial);
                            $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $hora_final);
                            $intervalo = $horainicial->diff($horainicio_da_tarefas);
                            $hora_concluidas = $intervalo->format('%H:%I:%S');
                            $horas_extras[] = $hora_concluidas;
                        } else if ($hora_inicial >= "00:00:00" && $hora_inicial <= "07:00:00" && $hora_final > "07:00:00") {
                            $horainicial_extra = DateTime::createFromFormat('H:i:s', $hora_inicial);
                            $horainicio_da_tarefas_extra = DateTime::createFromFormat('H:i:s', "07:00:00");
                            $intervalo_extra = $horainicial_extra->diff($horainicio_da_tarefas_extra);
                            $hora_concluidas_extra = $intervalo_extra->format('%H:%I:%S');
                            $horas_extras[] = $hora_concluidas_extra;
                            $horainicial = DateTime::createFromFormat('H:i:s', "07:00:00");
                            $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $hora_final);
                            $intervalo = $horainicial->diff($horainicio_da_tarefas);
                            $hora_concluidas = $intervalo->format('%H:%I:%S');
                            $horas_concluidas_funcionario_por_dia[] = $hora_concluidas;
                        } else if ($hora_inicial >= "07:00:00" && $hora_inicial <= "11:00:00" && $hora_final > "11:00:00") {
                            $horainicial = DateTime::createFromFormat('H:i:s', $hora_inicial);
                            $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', "11:00:00");
                            $intervalo = $horainicial->diff($horainicio_da_tarefas);
                            $hora_concluidas = $intervalo->format('%H:%I:%S');
                            $horas_concluidas_funcionario_por_dia[] = $hora_concluidas;
                            $horainicial_extra = DateTime::createFromFormat('H:i:s', "11:00:00");
                            $horainicio_da_tarefas_extra = DateTime::createFromFormat('H:i:s', $hora_final);
                            $intervalo_extra = $horainicial_extra->diff($horainicio_da_tarefas_extra);
                            $hora_concluidas_extra = $intervalo_extra->format('%H:%I:%S');
                            $horas_extras[] = $hora_concluidas_extra;
                        } else if ($hora_inicial >= "11:00:00" && $hora_inicial <= "12:00:00" && $hora_final > "12:00:00") {
                            $horainicial_extra = DateTime::createFromFormat('H:i:s', $hora_inicial);
                            $horainicio_da_tarefas_extra = DateTime::createFromFormat('H:i:s', "12:00:00");
                            $intervalo_extra = $horainicial_extra->diff($horainicio_da_tarefas_extra);
                            $hora_concluidas_extra = $intervalo_extra->format('%H:%I:%S');
                            $horas_extras[] = $hora_concluidas_extra;
                            $horainicial = DateTime::createFromFormat('H:i:s', "12:00:00");
                            $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $hora_final);
                            $intervalo = $horainicial->diff($horainicio_da_tarefas);
                            $hora_concluidas = $intervalo->format('%H:%I:%S');
                            $horas_concluidas_funcionario_por_dia[] = $hora_concluidas;
                        } else if ($hora_inicial >= "12:00:00" && $hora_inicial <= "16:00:00" && $hora_final > "16:00:00") {
                            $horainicial = DateTime::createFromFormat('H:i:s', $hora_inicial);
                            $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', "17:00:00");
                            $intervalo = $horainicial->diff($horainicio_da_tarefas);
                            $hora_concluidas = $intervalo->format('%H:%I:%S');
                            $horas_concluidas_funcionario_por_dia[] = $hora_concluidas;
                            $horainicial_extra = DateTime::createFromFormat('H:i:s', "17:00:00");
                            $horainicio_da_tarefas_extra = DateTime::createFromFormat('H:i:s', $hora_final);
                            $intervalo_extra = $horainicial_extra->diff($horainicio_da_tarefas_extra);
                            $hora_concluidas_extra = $intervalo_extra->format('%H:%I:%S');
                            $horas_extras[] = $hora_concluidas_extra;
                        }
                    } else {
                        /////////////////////////////////////////////////////////////////////////////////////////////////

                        if ($hora_inicial >= "00:00:00" && $hora_final <= "07:00:00") {
                            $horainicial = DateTime::createFromFormat('H:i:s', $hora_inicial);
                            $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $hora_final);
                            $intervalo = $horainicial->diff($horainicio_da_tarefas);
                            $hora_concluidas = $intervalo->format('%H:%I:%S');
                            $horas_extras[] = $hora_concluidas;
                        } else if ($hora_inicial >= "07:00:00" && $hora_final <= "11:00:00") {
                            $horas_concluidas_funcionario_por_dia[] = $aux_dia_a_dia_do_funcionario['horas_concluidas'];
                        } else if ($hora_inicial >= "12:00:00" && $hora_final <= "17:00:00") {
                            $horas_concluidas_funcionario_por_dia[] = $aux_dia_a_dia_do_funcionario['horas_concluidas'];
                        } else if ($hora_inicial >= "17:00:00" && $hora_final <= "23:59:59") {
                            $horainicial = DateTime::createFromFormat('H:i:s', $hora_inicial);
                            $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $hora_final);
                            $intervalo = $horainicial->diff($horainicio_da_tarefas);
                            $hora_concluidas = $intervalo->format('%H:%I:%S');
                            $horas_extras[] = $hora_concluidas;
                        } else if ($hora_inicial >= "00:00:00" && $hora_inicial <= "07:00:00" && $hora_final > "07:00:00") {
                            $horainicial_extra = DateTime::createFromFormat('H:i:s', $hora_inicial);
                            $horainicio_da_tarefas_extra = DateTime::createFromFormat('H:i:s', "07:00:00");
                            $intervalo_extra = $horainicial_extra->diff($horainicio_da_tarefas_extra);
                            $hora_concluidas_extra = $intervalo_extra->format('%H:%I:%S');
                            $horas_extras[] = $hora_concluidas_extra;
                            $horainicial = DateTime::createFromFormat('H:i:s', "07:00:00");
                            $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $hora_final);
                            $intervalo = $horainicial->diff($horainicio_da_tarefas);
                            $hora_concluidas = $intervalo->format('%H:%I:%S');
                            $horas_concluidas_funcionario_por_dia[] = $hora_concluidas;
                        } else if ($hora_inicial >= "07:00:00" && $hora_inicial <= "11:00:00" && $hora_final > "11:00:00") {
                            $horainicial = DateTime::createFromFormat('H:i:s', $hora_inicial);
                            $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', "11:00:00");
                            $intervalo = $horainicial->diff($horainicio_da_tarefas);
                            $hora_concluidas = $intervalo->format('%H:%I:%S');
                            $horas_concluidas_funcionario_por_dia[] = $hora_concluidas;
                            $horainicial_extra = DateTime::createFromFormat('H:i:s', "11:00:00");
                            $horainicio_da_tarefas_extra = DateTime::createFromFormat('H:i:s', $hora_final);
                            $intervalo_extra = $horainicial_extra->diff($horainicio_da_tarefas_extra);
                            $hora_concluidas_extra = $intervalo_extra->format('%H:%I:%S');
                            $horas_extras[] = $hora_concluidas_extra;
                        } else if ($hora_inicial >= "11:00:00" && $hora_inicial <= "12:00:00" && $hora_final > "12:00:00" && $hora_final <= "17:00:00") {
                            $horainicial_extra = DateTime::createFromFormat('H:i:s', $hora_inicial);
                            $horainicio_da_tarefas_extra = DateTime::createFromFormat('H:i:s', "12:00:00");
                            $intervalo_extra = $horainicial_extra->diff($horainicio_da_tarefas_extra);
                            $hora_concluidas_extra = $intervalo_extra->format('%H:%I:%S');
                            $horas_extras[] = $hora_concluidas_extra;
                            $horainicial = DateTime::createFromFormat('H:i:s', "12:00:00");
                            $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $hora_final);
                            $intervalo = $horainicial->diff($horainicio_da_tarefas);
                            $hora_concluidas = $intervalo->format('%H:%I:%S');
                            $horas_concluidas_funcionario_por_dia[] = $hora_concluidas;
                        } else if ($hora_inicial >= "11:00:00" && $hora_inicial <= "12:00:00" && $hora_final > "17:00:00") {
                            $horainicial_extra = DateTime::createFromFormat('H:i:s', $hora_inicial);
                            $horainicio_da_tarefas_extra = DateTime::createFromFormat('H:i:s', "12:00:00");
                            $intervalo_extra = $horainicial_extra->diff($horainicio_da_tarefas_extra);
                            $hora_concluidas_extra = $intervalo_extra->format('%H:%I:%S');
                            $horas_extras[] = $hora_concluidas_extra;
                            $horainicial = DateTime::createFromFormat('H:i:s', "12:00:00");
                            $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', "17:00:00");
                            $intervalo = $horainicial->diff($horainicio_da_tarefas);
                            $hora_concluidas = $intervalo->format('%H:%I:%S');
                            $horas_concluidas_funcionario_por_dia[] = $hora_concluidas;
                            $horainicial_extra_posterior_17_00_00 = DateTime::createFromFormat('H:i:s', "17:00:00");
                            $horainicio_da_tarefas_extra_posterior_17_00_00 = DateTime::createFromFormat('H:i:s', $hora_final);
                            $intervalo_extra_posterior_17_00_00 = $horainicial_extra_posterior_17_00_00->diff($horainicio_da_tarefas_extra_posterior_17_00_00);
                            $hora_concluidas_extra_posterior_17_00_00 = $intervalo_extra_posterior_17_00_00->format('%H:%I:%S');
                            $horas_extras[] = $hora_concluidas_extra_posterior_17_00_00;
                        } else if ($hora_inicial >= "12:00:00" && $hora_inicial <= "17:00:00" && $hora_final > "17:00:00") {
                            $horainicial = DateTime::createFromFormat('H:i:s', $hora_inicial);
                            $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', "17:00:00");
                            $intervalo = $horainicial->diff($horainicio_da_tarefas);
                            $hora_concluidas = $intervalo->format('%H:%I:%S');
                            $horas_concluidas_funcionario_por_dia[] = $hora_concluidas;
                            $horainicial_extra = DateTime::createFromFormat('H:i:s', "17:00:00");
                            $horainicio_da_tarefas_extra = DateTime::createFromFormat('H:i:s', $hora_final);
                            $intervalo_extra = $horainicial_extra->diff($horainicio_da_tarefas_extra);
                            $hora_concluidas_extra = $intervalo_extra->format('%H:%I:%S');
                            $horas_extras[] = $hora_concluidas_extra;
                        }
                    }
                }
                $horas_trabalhadas_pelo_funcionario = $this->somarhoras_funcionario($horas_concluidas_funcionario_por_dia);
                $intervalo = $this->calcula_diferenca($horas_trabalhadas_pelo_funcionario, $meta_diaria);
                $tempo_inativo = $intervalo->format('%H:%I:%S');
                $horas_extra_trabalhadas_pelo_funcionario = $this->somarhoras_funcionario($horas_extras);
                ?>
                <tr>
                    <td><a style=" cursor: pointer;" herf="" onclick="openModal_funcionario('<?php echo $id_funcionario ?>', '<?php echo $data_inicio ?>', 'detalhamento_dia_funcionario')"><?php echo $data_inicio ?></a></td>
                    <td><?php echo $horas_trabalhadas_pelo_funcionario ?></td>
                    <td><?php echo $tempo_inativo ?></td>
                    <td><?php echo $meta_diaria ?></td>
                    <td><?php echo $horas_extra_trabalhadas_pelo_funcionario ?></td>
                </tr>
            </table>
        </div>
        <div id="grafico" style="width: 55%;float:left; height: 100%; ">
            <div style="width: 100%; height: 450px;">
                <table class="table table-hover">
                    <?php
                    $porcentagem_grafico = array();
                    $result_grafico = mysql_query($sql_dia_funcionario);
                    while ($aux_dia_a_dia_do_funcionario = mysql_fetch_array($result_grafico)) {
                        $nome_tarefa = $aux_dia_a_dia_do_funcionario['nome'];
                        $horas_realizadas = $aux_dia_a_dia_do_funcionario['horas_concluidas'];
                        $horas_realizadas_em_segundos = $this->transformahoraemsegundo($horas_realizadas);
                        $meta_diaria_em_segundos = $this->transformahoraemsegundo($meta_diaria);
                        $porcentagem_tempo_concluido_com_segundos = $horas_realizadas_em_segundos / $meta_diaria_em_segundos * 100;
                        //verifica se a porcentagem é maior que zero,se caso for ela entre no grafico,caso contrario ela nao entra
                        if ($porcentagem_tempo_concluido_com_segundos > 0) {
                            $verificaarray = $this->verificaTarefanoArray($nome_tarefa, $porcentagem_grafico);
                            if ($verificaarray) {

                                $tam_array = sizeof($porcentagem_grafico);
                                for ($i = 0; $i < $tam_array; $i+= 2) {
                                    if ($nome_tarefa == $porcentagem_grafico[$i]) {
                                        $porcentagem_grafico[$i + 1]+= $porcentagem_tempo_concluido_com_segundos;
                                    }
                                }
                            } else {
                                $porcentagem_grafico[] = $nome_tarefa;
                                $porcentagem_grafico[] = $porcentagem_tempo_concluido_com_segundos;
                            }
                        }
                    }
                 //   print_r($porcentagem_grafico);
                    $tamanho_array = sizeof($porcentagem_grafico);
                    for ($i = 1; $i < $tamanho_array; $i += 2) {
                        $porcentagem_grafico[$i] = floor($porcentagem_grafico[$i]);
                    }
                    $tempoinativo = $this->transformahoraemsegundo($tempo_inativo) / $meta_diaria_em_segundos * 100;
                //   echo "<br>"  . $teste = floor($tempoinativo);
                    $tempo_inativo_func = floor($tempoinativo);
                    if ($tempo_inativo_func > 0) {
                        $porcentagem_grafico[] = "TEMPO INATIVO";
                        $porcentagem_grafico[] = $tempo_inativo_func;
                    }
                 //echo "<br>";
                 //  print_r($porcentagem_grafico);
                    ?>
                    <tr>
                        <td style="width: 100%;height: 350px;">    
                            <?php
                            include "../../../model/relatorios/funcionario/libchart/libchart/classes/libchart.php";
                            $chart = new PieChart();
                            $dataSet = new XYDataSet();
                            $nome_imagem = $id_funcionario . $data_inicio;
                            $tamanho_do_array = sizeof($porcentagem_grafico);
                            for ($i = 0; $i < $tamanho_do_array; $i +=2) {
                                $dataSet->addPoint(new Point($porcentagem_grafico[$i], $porcentagem_grafico[$i + 1]));
                            }
                            $chart->setDataSet($dataSet);
                            $chart->setTitle("Relatorio dia do funcionario");
                            $chart->render("../../../model/relatorios/funcionario/libchart/demo/generated/$nome_imagem.png");
                            ?>
                            <img alt="Grafico de Pizza"  src="../model/relatorios/funcionario/libchart/demo/generated/<?php echo $nome_imagem ?>.png" style="border: 1px solid gray;"/>
                        </td>
                    </tr>                
                </table>
            </div>
            <div style="height: 420px; width: 100%;"> 
                <?php
                ?>
            </div>
        </div>
        <?php
    }

    function tamanhoArray($array) {
        $tamanho_do_array_para_contagem = sizeof($array);
        for ($i = 1; $i < $tamanho_do_array_para_contagem; $i += 2) {
            $valor_total += round($array[$i]);
        }
        return $valor_total;
    }

    function verificaArray($array) {
      
        $tamanho_array = tamanhoArray($array);
            if ($tamanho_array > 100) {
            while ($tamanho_array > 100) {
                
            }
        }
    }

    function MontaTabelaInformacaoPeriodo(funcionario_periodo $obj) {
        $id_funcionario_periodo = $obj->getId_funcionario();
        $data_inicio_periodo = $obj->getData_inicio();
        $data_final_periodo = $obj->getData_final();
        ?>
        <div style="width: 45%; float:left;  height: 100%;  overflow-y: scroll;">
            <table class="table table-hover">
                <tr style=" color:black; background: #999; height: 50px;">
                    <td>Dia</td><td>Tempo Ativo</td><td>Tempo Inativo</td><td>Total</td><td>Tempo Extra</td>
                </tr>
                <?php
                try {
                    $host = "localhost";
                    $user = "root";
                    $pass = "";
                    $banco = "sistema_de_gestao";
                    $conexao = mysql_connect($host, $user, $pass)or die(mysql_error());
                    $bd = mysql_select_db($banco, $conexao)or die(mysql_error());
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }
                $horas_somadas_do_tempo_ativo_funcionario = array();
                $horas_somadas_do_tempo_inativo_funcionario = array();
                $horas_somadas_do_tempo_extra_funcionario = array();
                $horas_somadas_do_tempo_meta_diaria_funcionario = array();
                $horas_concluidas_funcionario_dia = array();
                $horas_extras_periodo = array();

                $sql_selecionar_periodo = "SELECT distinct funcionario_executa.data_tarefa FROM `tarefas` JOIN `funcionario_executa` ON ( tarefas.id_tarefa = funcionario_executa.id_tarefa ) WHERE funcionario_executa.id_funcionario = $id_funcionario_periodo
                                              AND funcionario_executa.data_tarefa >= '$data_inicio_periodo' and funcionario_executa.data_tarefa <= '$data_final_periodo' ";
                $result_seleciona_periodo = mysql_query($sql_selecionar_periodo);
                while ($aux_seleciona_periodo = mysql_fetch_array($result_seleciona_periodo)) {
                    $data_selecionada = $aux_seleciona_periodo['data_tarefa'];
                    $dia_da_semana_periodo = $this->diaSemana($data_selecionada);
                    if ($dia_da_semana_periodo == "Sexta-Feira") {
                        $meta_diaria_periodo = "08:00:00";
                    } else {
                        $meta_diaria_periodo = "09:00:00";
                    }
                    $sql_dia_funcionario = "SELECT tarefas.id_tarefa, tarefas.nome, tarefas.duracao, funcionario_executa.horas_concluidas,funcionario_executa.id_veiculo,funcionario_executa.id_projeto,funcionario_executa.id_projeto_executa,funcionario_executa.hora_inicial,funcionario_executa.flag_tarefa_relatorio,funcionario_executa.hora_final
                                              FROM `tarefas` JOIN `funcionario_executa` ON ( tarefas.id_tarefa = funcionario_executa.id_tarefa )
                                              WHERE funcionario_executa.id_funcionario = $id_funcionario_periodo
                                              AND funcionario_executa.data_tarefa = '$data_selecionada' order by funcionario_executa.hora_inicial asc";
                    $result_dia_funcionario = mysql_query($sql_dia_funcionario);
                    while ($aux_dia_a_dia_do_funcionario = mysql_fetch_array($result_dia_funcionario)) {
                        $hora_inicial = $aux_dia_a_dia_do_funcionario['hora_inicial'];
                        $hora_final = $aux_dia_a_dia_do_funcionario['hora_final'];
                        if ($this->diaSemana($data_inicio) == "Sexta-Feira") {
                            if ($hora_inicial >= "00:00:00" && $hora_final <= "07:00:00") {
                                $horainicial = DateTime::createFromFormat('H:i:s', $hora_inicial);
                                $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $hora_final);
                                $intervalo = $horainicial->diff($horainicio_da_tarefas);
                                $hora_concluidas = $intervalo->format('%H:%I:%S');
                                $horas_extras_periodo[] = $hora_concluidas;
                            } else if ($hora_inicial >= "07:00:00" && $hora_final <= "11:00:00") {
                                $horas_concluidas_funcionario_dia[] = $aux_dia_a_dia_do_funcionario['horas_concluidas'];
                            } else if ($hora_inicial >= "12:00:00" && $hora_final <= "16:00:00") {
                                $horas_concluidas_funcionario_dia[] = $aux_dia_a_dia_do_funcionario['horas_concluidas'];
                            } else if ($hora_inicial >= "16:00:00" && $hora_final <= "23:59:59") {
                                $horainicial = DateTime::createFromFormat('H:i:s', $hora_inicial);
                                $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $hora_final);
                                $intervalo = $horainicial->diff($horainicio_da_tarefas);
                                $hora_concluidas = $intervalo->format('%H:%I:%S');
                                $horas_extras_periodo[] = $hora_concluidas;
                            } else if ($hora_inicial >= "00:00:00" && $hora_inicial <= "07:00:00" && $hora_final > "07:00:00") {
                                $horainicial_extra = DateTime::createFromFormat('H:i:s', $hora_inicial);
                                $horainicio_da_tarefas_extra = DateTime::createFromFormat('H:i:s', "07:00:00");
                                $intervalo_extra = $horainicial_extra->diff($horainicio_da_tarefas_extra);
                                $hora_concluidas_extra = $intervalo_extra->format('%H:%I:%S');
                                $horas_extras_periodo[] = $hora_concluidas_extra;
                                $horainicial = DateTime::createFromFormat('H:i:s', "07:00:00");
                                $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $hora_final);
                                $intervalo = $horainicial->diff($horainicio_da_tarefas);
                                $hora_concluidas = $intervalo->format('%H:%I:%S');
                                $horas_concluidas_funcionario_dia[] = $hora_concluidas;
                            } else if ($hora_inicial >= "07:00:00" && $hora_inicial <= "11:00:00" && $hora_final > "11:00:00") {
                                $horainicial = DateTime::createFromFormat('H:i:s', $hora_inicial);
                                $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', "11:00:00");
                                $intervalo = $horainicial->diff($horainicio_da_tarefas);
                                $hora_concluidas = $intervalo->format('%H:%I:%S');
                                $horas_concluidas_funcionario_dia[] = $hora_concluidas;
                                $horainicial_extra = DateTime::createFromFormat('H:i:s', "11:00:00");
                                $horainicio_da_tarefas_extra = DateTime::createFromFormat('H:i:s', $hora_final);
                                $intervalo_extra = $horainicial_extra->diff($horainicio_da_tarefas_extra);
                                $hora_concluidas_extra = $intervalo_extra->format('%H:%I:%S');
                                $horas_extras_periodo[] = $hora_concluidas_extra;
                            } else if ($hora_inicial >= "11:00:00" && $hora_inicial <= "12:00:00" && $hora_final > "12:00:00" && $hora_final <= "16:00:00") {
                                $horainicial_extra = DateTime::createFromFormat('H:i:s', $hora_inicial);
                                $horainicio_da_tarefas_extra = DateTime::createFromFormat('H:i:s', "12:00:00");
                                $intervalo_extra = $horainicial_extra->diff($horainicio_da_tarefas_extra);
                                $hora_concluidas_extra = $intervalo_extra->format('%H:%I:%S');
                                $horas_extras_periodo[] = $hora_concluidas_extra;
                                $horainicial = DateTime::createFromFormat('H:i:s', "12:00:00");
                                $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $hora_final);
                                $intervalo = $horainicial->diff($horainicio_da_tarefas);
                                $hora_concluidas = $intervalo->format('%H:%I:%S');
                                $horas_concluidas_funcionario_dia[] = $hora_concluidas;
                            } else if ($hora_inicial >= "11:00:00" && $hora_inicial <= "12:00:00" && $hora_final > "16:00:00") {
                                $horainicial_extra = DateTime::createFromFormat('H:i:s', $hora_inicial);
                                $horainicio_da_tarefas_extra = DateTime::createFromFormat('H:i:s', "12:00:00");
                                $intervalo_extra = $horainicial_extra->diff($horainicio_da_tarefas_extra);
                                $hora_concluidas_extra = $intervalo_extra->format('%H:%I:%S');
                                $horas_extras_periodo[] = $hora_concluidas_extra;
                                $horainicial = DateTime::createFromFormat('H:i:s', "12:00:00");
                                $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', "16:00:00");
                                $intervalo = $horainicial->diff($horainicio_da_tarefas);
                                $hora_concluidas = $intervalo->format('%H:%I:%S');
                                $horas_concluidas_funcionario_dia[] = $hora_concluidas;
                                $horainicial_extra_posterior_16_00_00 = DateTime::createFromFormat('H:i:s', "16:00:00");
                                $horainicio_da_tarefas_extra_posterior_16_00_00 = DateTime::createFromFormat('H:i:s', $hora_final);
                                $intervalo_extra_posterior_16_00_00 = $horainicial_extra_posterior_16_00_00->diff($horainicio_da_tarefas_extra_posterior_16_00_00);
                                $hora_concluidas_extra_posterior_16_00_00 = $intervalo_extra_posterior_16_00_00->format('%H:%I:%S');
                                $horas_extras_periodo[] = $hora_concluidas_extra_posterior_16_00_00;
                            } else if ($hora_inicial >= "12:00:00" && $hora_inicial <= "16:00:00" && $hora_final > "16:00:00") {
                                $horainicial = DateTime::createFromFormat('H:i:s', $hora_inicial);
                                $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', "17:00:00");
                                $intervalo = $horainicial->diff($horainicio_da_tarefas);
                                $hora_concluidas = $intervalo->format('%H:%I:%S');
                                $horas_concluidas_funcionario_dia[] = $hora_concluidas;
                                $horainicial_extra = DateTime::createFromFormat('H:i:s', "17:00:00");
                                $horainicio_da_tarefas_extra = DateTime::createFromFormat('H:i:s', $hora_final);
                                $intervalo_extra = $horainicial_extra->diff($horainicio_da_tarefas_extra);
                                $hora_concluidas_extra = $intervalo_extra->format('%H:%I:%S');
                                $horas_extras_periodo[] = $hora_concluidas_extra;
                            }
                        } else {
                            ///////////////////////////// dia da semana entre segunda e quinta feira /////////////////////////////////////////
                            if ($hora_inicial >= "00:00:00" && $hora_final <= "07:00:00") {
                                $horainicial = DateTime::createFromFormat('H:i:s', $hora_inicial);
                                $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $hora_final);
                                $intervalo = $horainicial->diff($horainicio_da_tarefas);
                                $hora_concluidas = $intervalo->format('%H:%I:%S');
                                $horas_extras_periodo[] = $hora_concluidas;
                            } else if ($hora_inicial >= "07:00:00" && $hora_final <= "11:00:00") {
                                $horas_concluidas_funcionario_dia[] = $aux_dia_a_dia_do_funcionario['horas_concluidas'];
                            } else if ($hora_inicial >= "12:00:00" && $hora_final <= "17:00:00") {
                                $horas_concluidas_funcionario_dia[] = $aux_dia_a_dia_do_funcionario['horas_concluidas'];
                            } else if ($hora_inicial >= "17:00:00" && $hora_final <= "23:59:59") {
                                $horainicial = DateTime::createFromFormat('H:i:s', $hora_inicial);
                                $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $hora_final);
                                $intervalo = $horainicial->diff($horainicio_da_tarefas);
                                $hora_concluidas = $intervalo->format('%H:%I:%S');
                                $horas_extras_periodo[] = $hora_concluidas;
                            } else if ($hora_inicial >= "00:00:00" && $hora_inicial <= "07:00:00" && $hora_final > "07:00:00") {
                                $horainicial_extra = DateTime::createFromFormat('H:i:s', $hora_inicial);
                                $horainicio_da_tarefas_extra = DateTime::createFromFormat('H:i:s', "07:00:00");
                                $intervalo_extra = $horainicial_extra->diff($horainicio_da_tarefas_extra);
                                $hora_concluidas_extra = $intervalo_extra->format('%H:%I:%S');
                                $horas_extras_periodo[] = $hora_concluidas_extra;
                                $horainicial = DateTime::createFromFormat('H:i:s', "07:00:00");
                                $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $hora_final);
                                $intervalo = $horainicial->diff($horainicio_da_tarefas);
                                $hora_concluidas = $intervalo->format('%H:%I:%S');
                                $horas_concluidas_funcionario_dia[] = $hora_concluidas;
                            } else if ($hora_inicial >= "07:00:00" && $hora_inicial <= "11:00:00" && $hora_final > "11:00:00") {
                                $horainicial = DateTime::createFromFormat('H:i:s', $hora_inicial);
                                $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', "11:00:00");
                                $intervalo = $horainicial->diff($horainicio_da_tarefas);
                                $hora_concluidas = $intervalo->format('%H:%I:%S');
                                $horas_concluidas_funcionario_dia[] = $hora_concluidas;
                                $horainicial_extra = DateTime::createFromFormat('H:i:s', "11:00:00");
                                $horainicio_da_tarefas_extra = DateTime::createFromFormat('H:i:s', $hora_final);
                                $intervalo_extra = $horainicial_extra->diff($horainicio_da_tarefas_extra);
                                $hora_concluidas_extra = $intervalo_extra->format('%H:%I:%S');
                                $horas_extras_periodo[] = $hora_concluidas_extra;
                            } else if ($hora_inicial >= "11:00:00" && $hora_inicial <= "12:00:00" && $hora_final > "12:00:00" && $hora_final <= "17:00:00") {
                                $horainicial_extra = DateTime::createFromFormat('H:i:s', $hora_inicial);
                                $horainicio_da_tarefas_extra = DateTime::createFromFormat('H:i:s', "12:00:00");
                                $intervalo_extra = $horainicial_extra->diff($horainicio_da_tarefas_extra);
                                $hora_concluidas_extra = $intervalo_extra->format('%H:%I:%S');
                                $horas_extras_periodo[] = $hora_concluidas_extra;
                                $horainicial = DateTime::createFromFormat('H:i:s', "12:00:00");
                                $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $hora_final);
                                $intervalo = $horainicial->diff($horainicio_da_tarefas);
                                $hora_concluidas = $intervalo->format('%H:%I:%S');
                                $horas_concluidas_funcionario_dia[] = $hora_concluidas;
                            } else if ($hora_inicial >= "11:00:00" && $hora_inicial <= "12:00:00" && $hora_final > "17:00:00") {
                                $horainicial_extra = DateTime::createFromFormat('H:i:s', $hora_inicial);
                                $horainicio_da_tarefas_extra = DateTime::createFromFormat('H:i:s', "12:00:00");
                                $intervalo_extra = $horainicial_extra->diff($horainicio_da_tarefas_extra);
                                $hora_concluidas_extra = $intervalo_extra->format('%H:%I:%S');
                                $horas_extras_periodo[] = $hora_concluidas_extra;
                                $horainicial = DateTime::createFromFormat('H:i:s', "12:00:00");
                                $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', "17:00:00");
                                $intervalo = $horainicial->diff($horainicio_da_tarefas);
                                $hora_concluidas = $intervalo->format('%H:%I:%S');
                                $horas_concluidas_funcionario_dia[] = $hora_concluidas;
                                $horainicial_extra_posterior_17_00_00 = DateTime::createFromFormat('H:i:s', "17:00:00");
                                $horainicio_da_tarefas_extra_posterior_17_00_00 = DateTime::createFromFormat('H:i:s', $hora_final);
                                $intervalo_extra_posterior_17_00_00 = $horainicial_extra_posterior_17_00_00->diff($horainicio_da_tarefas_extra_posterior_17_00_00);
                                $hora_concluidas_extra_posterior_17_00_00 = $intervalo_extra_posterior_17_00_00->format('%H:%I:%S');
                                $horas_extras_periodo[] = $hora_concluidas_extra_posterior_17_00_00;
                            } else if ($hora_inicial >= "12:00:00" && $hora_inicial <= "17:00:00" && $hora_final > "17:00:00") {
                                $horainicial = DateTime::createFromFormat('H:i:s', $hora_inicial);
                                $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', "17:00:00");
                                $intervalo = $horainicial->diff($horainicio_da_tarefas);
                                $hora_concluidas = $intervalo->format('%H:%I:%S');
                                $horas_concluidas_funcionario_dia[] = $hora_concluidas;
                                $horainicial_extra = DateTime::createFromFormat('H:i:s', "17:00:00");
                                $horainicio_da_tarefas_extra = DateTime::createFromFormat('H:i:s', $hora_final);
                                $intervalo_extra = $horainicial_extra->diff($horainicio_da_tarefas_extra);
                                $hora_concluidas_extra = $intervalo_extra->format('%H:%I:%S');
                                $horas_extras_periodo[] = $hora_concluidas_extra;
                            }
                        }
                    }
                    $horas_trabalhadas_pelo_funcionario = $this->somarhoras_funcionario($horas_concluidas_funcionario_dia);
                    $intervalo = $this->calcula_diferenca($horas_trabalhadas_pelo_funcionario, $meta_diaria_periodo);
                    $tempo_inativo = $intervalo->format('%H:%I:%S');
                    $horas_extra_trabalhadas_pelo_funcionario = $this->somarhoras_funcionario($horas_extras_periodo);
                    ?>
                    <tr>
                        <td><a style=" cursor: pointer;" herf="" onclick="openModal_funcionario('<?php echo $id_funcionario_periodo ?>', '<?php echo $data_selecionada ?>', 'detalhamento_dia_funcionario')"><?php echo $data_selecionada ?></a></td>
                        <td><?php echo $horas_trabalhadas_pelo_funcionario ?></td>
                        <td><?php echo $tempo_inativo ?></td>
                        <td><?php echo $meta_diaria_periodo ?></td>
                        <td><?php echo $horas_extra_trabalhadas_pelo_funcionario ?></td>
                    </tr>
                    <?php
                    $horas_somadas_do_tempo_ativo_funcionario[] = $horas_trabalhadas_pelo_funcionario;
                    $horas_somadas_do_tempo_inativo_funcionario[] = $tempo_inativo;
                    $horas_somadas_do_tempo_meta_diaria_funcionario[] = $meta_diaria_periodo;
                    $horas_somadas_do_tempo_extra_funcionario[] = $horas_extra_trabalhadas_pelo_funcionario;
                    unset($horas_concluidas_funcionario_dia);
                    unset($meta_diaria_periodo);
                    unset($tempo_inativo);
                    unset($horas_extra_trabalhadas_pelo_funcionario);
                    unset($horas_extras_periodo);
                }
                ?>
                <?php
                $horas_totais_somadas_ativas = $this->somarhoras_funcionario($horas_somadas_do_tempo_ativo_funcionario);
                $horas_totais_somadas_inativas = $this->somarhoras_funcionario($horas_somadas_do_tempo_inativo_funcionario);
                $meta_total_das_horas = $this->somarhoras_funcionario($horas_somadas_do_tempo_meta_diaria_funcionario);
                $horas_extras_trabalhadas = $this->somarhoras_funcionario($horas_somadas_do_tempo_extra_funcionario);
                unset($horas_somadas_do_tempo_ativo_funcionario);
                unset($horas_somadas_do_tempo_inativo_funcionario);
                unset($horas_somadas_do_tempo_meta_diaria_funcionario);
                unset($horas_somadas_do_tempo_extra_funcionario);
                ?>
                <tr style=" color:black; background: #999; height: 50px;">
                    <td>Total</td>
                    <td><?php echo $horas_totais_somadas_ativas ?></td>
                    <td><?php echo $horas_totais_somadas_inativas ?></td>
                    <td><?php echo $meta_total_das_horas ?></td>
                    <td><?php echo $horas_extras_trabalhadas ?></td>
                </tr>
            </table>
        </div>
        <div id="grafico" style="width: 55%;float:left; height: 100%;">
            <div style="width: 100%; height: 450px;;">
                <table class="table table-hover" >
                    <tr style=" color:black;">
                        <td style="text-align: center;">Grafico</td>
                    </tr>
                    <tr>
                        <?php
                        $porcentagem_do_grafico = array();
                        $sql_selecionar_periodo_grafico = "SELECT distinct funcionario_executa.data_tarefa FROM `tarefas` JOIN `funcionario_executa` ON ( tarefas.id_tarefa = funcionario_executa.id_tarefa ) WHERE funcionario_executa.id_funcionario = $id_funcionario_periodo
                                              AND funcionario_executa.data_tarefa >= '$data_inicio_periodo' and funcionario_executa.data_tarefa <= '$data_final_periodo'";
                        $result_seleciona_periodo_grafico = mysql_query($sql_selecionar_periodo_grafico);
                        while ($aux_seleciona_periodo = mysql_fetch_array($result_seleciona_periodo_grafico)) {
                            $data_selecionada_grafico = $aux_seleciona_periodo['data_tarefa'];
                            $sql_dia_funcionario_grafico = "SELECT tarefas.id_tarefa, tarefas.nome, tarefas.duracao, funcionario_executa.horas_concluidas,funcionario_executa.id_veiculo,funcionario_executa.id_projeto,funcionario_executa.id_projeto_executa,funcionario_executa.hora_inicial,funcionario_executa.flag_tarefa_relatorio,funcionario_executa.hora_final
                                              FROM `tarefas` JOIN `funcionario_executa` ON ( tarefas.id_tarefa = funcionario_executa.id_tarefa )
                                              WHERE funcionario_executa.id_funcionario = $id_funcionario_periodo
                                              AND funcionario_executa.data_tarefa = '$data_selecionada_grafico' order by funcionario_executa.hora_inicial asc";

                            $result_grafico = mysql_query($sql_dia_funcionario_grafico);
                            while ($aux_dia_a_dia_grafico = mysql_fetch_array($result_grafico)) {
                                $nome_tarefa_grafico = $aux_dia_a_dia_grafico['nome'];
                                $horas_realizadas_grafico = $aux_dia_a_dia_grafico['horas_concluidas'];
                                $horas_realizadas_em_segundos = $this->transformahoraemsegundo($horas_realizadas_grafico);
                                $meta_diaria_em_segundos = $this->transformahoraemsegundo($meta_total_das_horas);
                                $porcentagem_tempo_concluido_com_segundos = $horas_realizadas_em_segundos / $meta_diaria_em_segundos * 100;
                                //verifica se a porcentagem é maior que zero,se caso for ela entre no grafico,caso contrario ela nao entra
                                if ($porcentagem_tempo_concluido_com_segundos > 0) {
                                    $verificaarray = $this->verificaTarefanoArray($nome_tarefa_grafico, $porcentagem_do_grafico);
                                    if ($verificaarray) {
                                        $tam_array_grafico = sizeof($porcentagem_do_grafico);
                                        for ($i = 0; $i < $tam_array_grafico; $i += 2) {
                                            if ($nome_tarefa_grafico == $porcentagem_do_grafico[$i]) {
                                                $porcentagem_do_grafico[$i + 1]+= $porcentagem_tempo_concluido_com_segundos;
                                            }
                                        }
                                    } else {
                                        $porcentagem_do_grafico[] = $nome_tarefa_grafico;
                                        $porcentagem_do_grafico[] = $porcentagem_tempo_concluido_com_segundos;
                                    }
                                }
                            }
                            $tamanho_array = sizeof($porcentagem_do_grafico);
                            for ($i = 1; $i < $tamanho_array; $i += 2) {
                                $porcentagem_do_grafico[$i] = floor($porcentagem_do_grafico[$i]);
                            }
                        }
                        $horas_tempo_inativo_total = $this->transformahoraemsegundo($horas_totais_somadas_inativas);
                        $horas_meta_diarias = $this->transformahoraemsegundo($meta_total_das_horas);
                        $tempoinativo = $horas_tempo_inativo_total / $horas_meta_diarias * 100;
                        $tempo_inativo_func = floor($tempoinativo);
                        if ($tempo_inativo_func > 0) {
                            $porcentagem_do_grafico[] = "TEMPO INATIVO";
                            $porcentagem_do_grafico[] = $tempo_inativo_func;
                        }

                        /*
                          $tamanho_do_array_para_contagem = sizeof($porcentagem_do_grafico);
                          for ($i = 1; $i < $tamanho_do_array_para_contagem; $i += 2) {
                          $valor_total += round($porcentagem_do_grafico[$i]);
                          }
                          if ($valor_total > 100) {

                          } */

                      //  print_r($porcentagem_do_grafico);
                        ?>
                        <td style="width: 100%;height: 425px;">
                            <div id="mostra">  
                                <?php
                                include "../../../model/relatorios/funcionario/libchart/libchart/classes/libchart.php";
                                $chart = new PieChart();
                                $dataSet = new XYDataSet();
                                $nome_imagem = $id_funcionario_periodo . $data_inicio_periodo . $data_final_periodo;
                                $tamanho_do_array = sizeof($porcentagem_do_grafico);
                                for ($i = 0; $i < $tamanho_do_array; $i +=2) {
                                    $dataSet->addPoint(new Point($porcentagem_do_grafico[$i], $porcentagem_do_grafico[$i + 1]));
                                }
                                $chart->setDataSet($dataSet);
                                $chart->setTitle("Relatorio dia do funcionario");
                                $chart->render("../../../model/relatorios/funcionario/libchart/demo/generated/$nome_imagem.png");
                                ?>
                                <img alt="Grafico de Pizza"  src="../model/relatorios/funcionario/libchart/demo/generated/<?php echo $nome_imagem ?>.png" style="border: 1px solid gray;"/>
                            </div> 
                        </td>
                    </tr>
                </table>
            </div>
            <div style="height: 420px; width: 100%;">
            </div>
        </div>
        <?php
    }
}
