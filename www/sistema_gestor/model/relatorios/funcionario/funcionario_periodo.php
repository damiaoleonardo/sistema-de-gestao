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
        <div style="width: 45%; float:left;   height: 100%; overflow: scroll;">
            <table class="table table-hover" >
                <tr class="coluna" style=" color:black; background: #999; height: 50px;">
                    <td>Dia</td><td>Tempo Ativo</td><td>Tempo Inativo</td><td>Total</td><td>Tempo Extra</td>
                </tr>
                <?php
                try {
                    $host = "localhost";
                    $user = "root";
                    $pass = "";
                    $banco = "sistema de gerenciamento";
                    $conexao = mysql_connect($host, $user, $pass)or die(mysql_error());
                    $bd = mysql_select_db($banco, $conexao)or die(mysql_error());
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }
                $horas_concluidas_funcionario_por_dia = array();
                $horas_extras = array();
                if ($dia_da_semana = $this->diaSemana($data_inicio) == "Sexta-Feira") {
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
                    $horas_concluidas_funcionario_por_dia[] = $horas_concluidas = $aux_dia_a_dia_do_funcionario['horas_concluidas'];
                }
                $horas_trabalhadas_pelo_funcionario = $this->somarhoras_funcionario($horas_concluidas_funcionario_por_dia);
                $intervalo = $this->calcula_diferenca($horas_trabalhadas_pelo_funcionario, $meta_diaria);
                $tempo_inativo = $intervalo->format('%H:%I:%S');
                ?>
                <tr>
                    <td><a style=" cursor: pointer;" herf="" onclick="openModal('<?php echo $id_funcionario ?>', '<?php echo $data_inicio ?>', 'editCourseModal')"><?php echo $data_inicio ?></a></td>
                    <td><?php echo $horas_trabalhadas_pelo_funcionario ?></td><td><?php echo $tempo_inativo ?></td><td><?php echo $meta_diaria ?></td><td><?php echo $meta_diaria ?></td>
                </tr>
            </table>
        </div>
        <div id="grafico" style="width: 55%;float:left; height: 100%; overflow: scroll;">
            <table class="table table-hover" >
                <tr style=" color:black;">
                    <td style="text-align: center;">Grafico</td>
                </tr>
                <?php
                $porcentagem_grafico = array();
                $result_grafico = mysql_query($sql_dia_funcionario);
                while ($aux_dia_a_dia_do_funcionario = mysql_fetch_array($result_grafico)) {
                    $horas_realizadas = $aux_dia_a_dia_do_funcionario['horas_concluidas'];
                    $nome_tarefa = $aux_dia_a_dia_do_funcionario['nome'];
                    $horas_realizadas_em_minutos = $this->transformahoraemminuto($horas_realizadas);
                    $meta_diaria_em_minutos = $this->transformahoraemminuto($meta_diaria) . "<br>";
                    $porcentagem_tempo_concluido = $horas_realizadas_em_minutos / $meta_diaria_em_minutos * 100;
                    $resultado = substr($porcentagem_tempo_concluido, 0, 2);
                    //veririfca se a porcentagem é maior que zero,se caso for ela entre no grafico,caso contrario ela nao entra
                    if ($resultado > 0) {
                        $verificaarray = $this->verificaTarefanoArray($nome_tarefa, $porcentagem_grafico);
                        if ($verificaarray) {
                            $tam_array = sizeof($porcentagem_grafico);
                            for ($i = 0; $i < $tam_array; $i++) {
                                if ($nome_tarefa == $porcentagem_grafico[$i]) {
                                    $porcentagem_grafico[$i + 1]+= $resultado;
                                }
                            }
                        } else {
                            $porcentagem_grafico[] = $nome_tarefa;
                            $porcentagem_grafico[] = $resultado;
                        }
                    }
                }

                $porcentagem_grafico_total = $this->transferenciadearray($porcentagem_grafico);
                // print_r($porcentagem_grafico_total);
                // tempo inativo do funcionario 
                $tempoinativo = $this->transformahoraemminuto($tempo_inativo) / $meta_diaria_em_minutos * 100;
                $tempo_inativo_func = substr($tempoinativo, 0, 2);
                $porcentagem_grafico_total[] = array("TEMPO INATIVO", $tempo_inativo_func);
                //print_r($porcentagem_grafico_total);
                //passagem do array  via session para a pagina gera_grafico_funcionario.php para montar o grafico de pizza
                session_start("array");
                $_SESSION["lista"] = $porcentagem_grafico_total;
                ?>
                <tr>
                    <td style="width: 100%;height: 425px; ">
                        <?php
                        if ($id_funcionario == 1) {
                            $dia_da_semana = $this->diaSemana($data_inicio);
                            if ($dia_da_semana == "Segunda-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_1/gera_graficoSegunda.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Terça-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_1/gera_graficoTerca.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Quarta-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_1/gera_graficoQuarta.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Quinta-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_1/gera_graficoQuinta.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Sexta-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_1/gera_graficoSexta.php" alt = "" title = ""/>
                                <?php
                            }
                        } else if ($id_funcionario == 2) {
                            $dia_da_semana = $this->diaSemana($data_inicio);
                            if ($dia_da_semana == "Segunda-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_2/gera_graficoTwoSegunda.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Terça-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_2/gera_graficoTwoTerca.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Quarta-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_2/gera_graficoTwoQuarta.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Quinta-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_2/gera_graficoTwoQuinta.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Sexta-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_2/gera_graficoTwoSexta.php" alt = "" title = ""/>
                                <?php
                            }
                        } else if ($id_funcionario == 3) {
                            $dia_da_semana = $this->diaSemana($data_inicio);
                            if ($dia_da_semana == "Segunda-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_3/gera_graficoTreeSegunda.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Terça-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_3/gera_graficoTreeTerca.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Quarta-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_3/gera_graficoTreeQuarta.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Quinta-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_3/gera_graficoTreeQuinta.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Sexta-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_3/gera_graficoTreeSexta.php" alt = "" title = ""/>
                                <?php
                            }
                        } else if ($id_funcionario == 4) {
                            $dia_da_semana = $this->diaSemana($data_inicio);
                            if ($dia_da_semana == "Segunda-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_4/gera_graficoFourSegunda.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Terça-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_4/gera_graficoFourTerca.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Quarta-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_4/gera_graficoFourQuarta.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Quinta-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_4/gera_graficoFourQuinta.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Sexta-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_4/gera_graficoFourSexta.php" alt = "" title = ""/>
                                <?php
                            }
                        } else if ($id_funcionario == 5) {
                            $dia_da_semana = $this->diaSemana($data_inicio);
                            if ($dia_da_semana == "Segunda-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_5/gera_graficoFiveSegunda.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Terça-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_5/gera_graficoFiveTerca.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Quarta-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_5/gera_graficoFiveQuarta.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Quinta-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_5/gera_graficoFiveQuinta.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Sexta-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_5/gera_graficoFiveSexta.php" alt = "" title = ""/>
                                <?php
                            }
                        } else if ($id_funcionario == 6) {
                            $dia_da_semana = $this->diaSemana($data_inicio);
                            if ($dia_da_semana == "Segunda-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_6/gera_graficoSegunda.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Terça-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_6/gera_graficoTerca.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Quarta-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_6/gera_graficoQuarta.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Quinta-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_6/gera_graficoQuinta.php" alt = "" title = ""/>
                                <?php
                            } else if ($dia_da_semana == "Sexta-Feira") {
                                ?>
                                <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_6/gera_graficoSexta.php" alt = "" title = ""/>
                                <?php
                            }
                        } else {
                            ?>
                            <img id="imagem" src= "../model/relatorios/funcionario/graficos/gera_grafico_funcionario_six.php" alt = "" title = ""/>
                            <?php
                        }
                        ?>
                    </td>
                </tr>                
            </table>
        </div>
        <?php
    }

    function totalHorasPeriodo($data_inicio, $data_final, $id_funcionario) {
        $horas_somadas = array();
        $sql_horas = "SELECT distinct funcionario_executa.data_tarefa FROM `tarefas` JOIN `funcionario_executa` ON ( tarefas.id_tarefa = funcionario_executa.id_tarefa ) WHERE funcionario_executa.id_funcionario = $id_funcionario
                                              AND funcionario_executa.data_tarefa >= '$data_inicio' and funcionario_executa.data_tarefa <= '$data_final' ";
        $result_horas = mysql_query($sql_horas);
        while ($aux_horas = mysql_fetch_array($result_horas)) {
            $dia_da_semana = $aux_horas['data_tarefa'];
            $dia_da_semana_periodo = $this->diaSemana($dia_da_semana);
            if ($dia_da_semana_periodo == "Sexta-Feira") {
                $meta_diaria_periodo = "08:00:00";
            } else {
                $meta_diaria_periodo = "09:00:00";
            }
            $horas_somadas[] = $meta_diaria_periodo;
        }
        return $valor = $this->somarhoras_funcionario($horas_somadas);
    }

    function MontaTabelaInformacaoPeriodo(funcionario_periodo $obj) {

        $id_funcionario_periodo = $obj->getId_funcionario();
        $data_inicio_periodo = $obj->getData_inicio();
        $data_final_periodo = $obj->getData_final();
        ?>
        <div style="width: 35%; float:left;   height: 100%; overflow: scroll;">
            <table class="table table-hover">
                <tr style=" color:black; background: #999; height: 50px;">
                    <td>Dia</td><td>Tempo Ativo</td><td>Tempo Inativo</td><td>Total</td><td>Tempo Extra</td>
                </tr>
                <?php
                try {
                    $host = "localhost";
                    $user = "root";
                    $pass = "";
                    $banco = "sistema de gerenciamento";
                    $conexao = mysql_connect($host, $user, $pass)or die(mysql_error());
                    $bd = mysql_select_db($banco, $conexao)or die(mysql_error());
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }

                $total_meta = $this->totalHorasPeriodo($data_inicio_periodo, $data_final_periodo, $id_funcionario_periodo);
                $porcentagem_grafico_periodo = array();
                $horas_somadas_do_tempo_ativo_funcionario = array();
                $horas_somadas_do_tempo_inativo_funcionario = array();
                // $horas_somadas_do_tempo_extra_funcionario = array();
                $horas_somadas_do_tempo_media_diaria_funcionario = array();
                $horas_concluidas_funcionario_dia = array();
                // $horas_extras_periodo = array();




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

                    $sql_dia_funcionario_periodo = "SELECT tarefas.id_tarefa, tarefas.nome, tarefas.duracao, funcionario_executa.horas_concluidas,funcionario_executa.data_tarefa,funcionario_executa.id_veiculo,funcionario_executa.id_projeto,funcionario_executa.id_projeto_executa,funcionario_executa.hora_inicial,funcionario_executa.flag_tarefa_relatorio,funcionario_executa.hora_final
                                              FROM `tarefas` JOIN `funcionario_executa` ON ( tarefas.id_tarefa = funcionario_executa.id_tarefa )
                                              WHERE funcionario_executa.id_funcionario = $id_funcionario_periodo
                                              AND funcionario_executa.data_tarefa = '$data_selecionada'";
                    $result_dia_funcionario_periodo = mysql_query($sql_dia_funcionario_periodo);
                    while ($aux_dia_a_dia_do_funcionario_periodo = mysql_fetch_array($result_dia_funcionario_periodo)) {
                        $nome_da_tarefa = $aux_dia_a_dia_do_funcionario_periodo['nome'];
                        $horas_concluidas_periodo = $aux_dia_a_dia_do_funcionario_periodo['horas_concluidas'];
                        $horas_concluidas_funcionario_dia[] = $horas_concluidas_periodo;


                        $horas_realizadas_em_minutos = $this->transformahoraemminuto($horas_concluidas_periodo);
                        $meta_geral_diaria_em_minutos = $this->transformahoraemminuto($total_meta) . "<br>";
                        $porcentagem_tempo_concluido = $horas_realizadas_em_minutos / $meta_geral_diaria_em_minutos * 100;
                        $resultado_periodo = substr($porcentagem_tempo_concluido, 0, 2);
                        //veririfca se a porcentagem é maior que zero,se caso for ela entre no grafico,caso contrario ela nao entra
                        if ($resultado_periodo > 0) {
                            $verificaarray_periodo = $this->verificaTarefanoArray($nome_da_tarefa, $porcentagem_grafico_periodo);
                            if ($verificaarray_periodo) {
                                $tam_array = sizeof($porcentagem_grafico_periodo);
                                for ($i = 0; $i < $tam_array; $i++) {
                                    if ($nome_da_tarefa == $porcentagem_grafico_periodo[$i]) {
                                        $porcentagem_grafico_periodo[$i + 1]+= $resultado_periodo;
                                    }
                                }
                            } else {
                                $porcentagem_grafico_periodo[] = $nome_da_tarefa;
                                $porcentagem_grafico_periodo[] = $resultado_periodo;
                            }
                        }
                    }

                    $horas_trabalhadas_pelo_funcionario_dia_somadas = $this->somarhoras_funcionario($horas_concluidas_funcionario_dia);
                    $intervalo_periodo = $this->calcula_diferenca($horas_trabalhadas_pelo_funcionario_dia_somadas, $meta_diaria_periodo);
                    $tempo_inativo_periodo = $intervalo_periodo->format('%H:%I:%S');
                    $tempoinativo_periodo = $this->transformahoraemminuto($tempo_inativo_periodo) / $meta_geral_diaria_em_minutos * 100;
                    $tempo_inativo_funcionario = substr($tempoinativo_periodo, 0, 2);


                    $verifica_tarefa_in_array = $this->verificaTarefanoArray("TEMPO INATIVO", $porcentagem_grafico_periodo);
                    if ($verifica_tarefa_in_array) {
                        $tam_array_tarefas = sizeof($porcentagem_grafico_periodo);
                        for ($j = 0; $j < $tam_array_tarefas; $j++) {
                            if ("TEMPO INATIVO" == $porcentagem_grafico_periodo[$j]) {
                                $porcentagem_grafico_periodo[$j + 1]+= $tempo_inativo_funcionario;
                            }
                        }
                    } else {
                        $porcentagem_grafico_periodo[] = "TEMPO INATIVO";
                        $porcentagem_grafico_periodo[] = $tempo_inativo_funcionario;
                    }



                    // $horas_concluidas_funcionario_por_periodo[] = array($data_selecionada, $horas_trabalhadas_pelo_funcionario_dia_somadas, $meta_diaria_periodo);
                    // print_r($horas_concluidas_funcionario_por_periodo);
                    ?>
                    <tr>
                        <td><a style=" cursor: pointer;" herf="" onclick="openModal('<?php echo $id_funcionario_periodo ?>', '<?php echo $data_selecionada ?>', 'editCourseModal')"><?php echo $data_selecionada ?></a></td>
                        <td><?php echo $horas_trabalhadas_pelo_funcionario_dia_somadas ?></td>
                        <td><?php echo $tempo_inativo_periodo ?></td>
                        <td><?php echo $meta_diaria_periodo ?></td>
                        <td><?php echo $meta_diaria_periodo ?></td>
                    </tr>

                    <?php
                    $horas_somadas_do_tempo_ativo_funcionario[] = $horas_trabalhadas_pelo_funcionario_dia_somadas;
                    $horas_somadas_do_tempo_inativo_funcionario[] = $tempo_inativo_periodo;
                    $horas_somadas_do_tempo_media_diaria_funcionario [] = $meta_diaria_periodo;
                    unset($horas_concluidas_funcionario_dia);
                    unset($horas_trabalhadas_pelo_funcionario_dia_somadas);
                    unset($dia_da_semana_periodo);
                }

           
                $porcentagem_grafico_total = $this->transferenciadearray($porcentagem_grafico_periodo);
                //print_r($porcentagem_grafico_total);
                session_start("array");
                $_SESSION["lista"] = $porcentagem_grafico_total;

                $horas_totais_somadas_ativas = $this->somarhoras_funcionario($horas_somadas_do_tempo_ativo_funcionario);
                $horas_totais_somadas_inativas = $this->somarhoras_funcionario($horas_somadas_do_tempo_inativo_funcionario);
                $meta_total_das_horas = $this->somarhoras_funcionario($horas_somadas_do_tempo_media_diaria_funcionario);

                unset($horas_somadas_do_tempo_ativo_funcionario);
                unset($horas_somadas_do_tempo_inativo_funcionario);
                unset($horas_somadas_do_tempo_media_diaria_funcionario);
                ?>
                <tr style=" color:black; background: #999; height: 50px;">
                    <td>Total</td>
                    <td><?php echo $horas_totais_somadas_ativas ?></td>
                    <td><?php echo $horas_totais_somadas_inativas ?></td>
                    <td><?php echo $meta_total_das_horas ?></td>
                    <td></td>
                </tr>
            </table>
        </div>
        <div id="grafico" style="width: 65%;float:left; height: 100%; overflow: scroll;">
            <table class="table table-hover" >
                <tr style=" color:black;">
                    <td style="text-align: center;">Grafico</td>
                </tr>
                <tr>
                    <td style="width: 100%;height: 425px;">
                        <div id="mostra">  
                            <img id="imagem" src= "../model/relatorios/funcionario/graficos/funcionario_1/gera_graficoSegunda.php" alt = "" title = ""/>
                        </div> 
                    </td>
                </tr>
            </table>
        </div>
        <?php
    }

}
