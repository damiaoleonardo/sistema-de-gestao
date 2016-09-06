<?php

class tarefas {

    private $id_projeto;
    private $id_projeto_executa;
    private $tipo_tarefa;
    private $id_tarefa_executa;
    private $status_tarefa;
    private $id_tarefa;
    private $id_veiculo;
    private $id_funcionario;
    private $id_tipo_veiculo;
    private $data_inicial;
    private $data_final;

    function getId_projeto() {
        return $this->id_projeto;
    }

    function getId_projeto_executa() {
        return $this->id_projeto_executa;
    }

    function getTipo_tarefa() {
        return $this->tipo_tarefa;
    }

    function setId_projeto($id_projeto) {
        $this->id_projeto = $id_projeto;
    }

    function setId_projeto_executa($id_projeto_executa) {
        $this->id_projeto_executa = $id_projeto_executa;
    }

    function setTipo_tarefa($tipo_tarefa) {
        $this->tipo_tarefa = $tipo_tarefa;
    }
    
    function getId_tarefa_executa() {
        return $this->id_tarefa_executa;
    }

    function getStatus_tarefa() {
        return $this->status_tarefa;
    }

    function getId_tarefa() {
        return $this->id_tarefa;
    }

    function getId_veiculo() {
        return $this->id_veiculo;
    }

    function getId_funcionario() {
        return $this->id_funcionario;
    }

    function getId_tipo_veiculo() {
        return $this->id_tipo_veiculo;
    }

    function getData_inicial() {
        return $this->data_inicial;
    }

    function getData_final() {
        return $this->data_final;
    }

    function setId_tarefa_executa($id_executa) {
        $this->id_tarefa_executa = $id_executa;
    }

    function setStatus_tarefa($status_tarefa) {
        $this->status_tarefa = $status_tarefa;
    }

    function setId_tarefa($id_tarefa) {
        $this->id_tarefa = $id_tarefa;
    }

    function setId_veiculo($id_veiculo) {
        $this->id_veiculo = $id_veiculo;
    }

    function setId_funcionario($id_funcionario) {
        $this->id_funcionario = $id_funcionario;
    }

    function setId_tipo_veiculo($id_tipo_veiculo) {
        $this->id_tipo_veiculo = $id_tipo_veiculo;
    }

    function setData_inicial($data_inicial) {
        $this->data_inicial = $data_inicial;
    }

    function setData_final($data_final) {
        $this->data_final = $data_final;
    }

    function somarhoras($times) {
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

    function minutoemhora($minutos) {
        $hora = floor($minutos / 60);
        $resto = $minutos % 60;
        if ($hora < 10) {
            if ($resto < 10) {
                return '0' . $hora . ':0' . $resto . ':00';
            } else {
                return '0' . $hora . ':' . $resto . ':00';
            }
        } else {
            if ($resto < 10) {
                return '0' . $hora . ':0' . $resto . ':00';
            } else {
                return '0' . $hora . ':' . $resto . ':00';
            }
        }
    }

    function transformahoraemminuto($hora) {
        $quebraHora = explode(":", $hora); //retorna um array onde cada elemento é separado por ":"
        $minutos = $quebraHora[0];
        $minutos = $minutos * 60;
        $minutos = $minutos + $quebraHora[1];
        return $minutos;
    }

    function invertedata($data, $separar = "/", $juntar = "/") {
        return implode($juntar, array_reverse(explode($separar, $data)));
    }

    function montaTabelaTarefa($sql_tarefa, $status_tarefa) {
        $media = array();
        $cont_num_horas_para_media = 0;
        $cont_tarefa = 0;
        $conexao_select_dados_tarefa = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_select_dados_tarefa->set_charset("utf8");
        $conexao_select_dados_tarefa->query($sql_tarefa);
        if ($conexao_select_dados_tarefa->affected_rows == 0) {
            echo "<center><p style='margin-top:70px; font-size:1.5em;'>Nenhum resultado foi encontrado</p></center>";
        } else {
            $query_select_dados = mysqli_query($conexao_select_dados_tarefa, $sql_tarefa);
            ?>
            <table class='table table-hover'>
                <?php
                while ($row = $query_select_dados->fetch_assoc()) {
                    $id_da_tarefa = $row['id_tarefa'];
                    $id_veiculo = $row['id_veiculo'];
                    $id_tarefa_executa = $row['id_tarefa_executa'];
                    $nome_tarefa = $row['nome'];
                    $nome_veiculo = $row['nome_veiculo'];
                    $data_inicio = $row['data_inicio'];
                    $data_final = $row['data_final'];
                    $tempo_gasto = $row['horas_concluidas'];
                    $meta = $row['duracao'];
                    $tipo_tarefa = $row['tipo_tarefa'];
                    $id_projeto_executa = $row['id_projeto_executa'];
                    $id_projeto = $row['id_projeto'];
                    ?>
                    <tr style="font-size:0.9em;">
                        <td style="width: 30%;"><a href="#" onclick="openModalTarefa('<?php echo $data_final ?>','<?php echo $id_projeto ?>','<?php echo $id_projeto_executa ?>','<?php echo $tipo_tarefa ?>','<?php echo $id_da_tarefa ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_tarefa_executa ?>', 'tarefas_detalhes')"><?php echo $nome_tarefa ?></a></td>
                        <td style="width: 15%;"><?php echo $nome_veiculo ?></td>
                        <td style="width: 15%;"><?php echo $datainicio = $this->invertedata($data_inicio, '-') ?></td>
                        <td style="width: 15%;"><?php echo $datafinal = $this->invertedata($data_final, '-') ?></td>
                        <?php
                        if ($status_tarefa == "open") {
                            ?>
                            <td style="width: 15%; background: #01669F; color:white;"><?php echo $tempo_gasto ?></td>
                            <?php
                        } else if ($status_tarefa == "concluida") {
                            if ($tempo_gasto < $meta) {
                                ?>
                                <td style="width: 15%; background: #3c763d; color:white;"><?php echo $tempo_gasto ?></td>
                                <?php
                            } else {
                                ?>
                                <td style="width: 15%; background: #c7254e; color:white;"><?php echo $tempo_gasto ?></td>
                                <?php
                            }
                          } else {
                            ?>
                            <td style="width: 15%; background: #666666; color:white;"><?php echo $tempo_gasto ?></td>
                            <?php
                        }
                        ?>
                        <td style="width: 10%;"><?php echo $meta ?></td>
                    </tr>

                    <?php
                    if ($status_tarefa == "concluida") {
                        $meta_em_minutos = $this->transformahoraemminuto($meta);
                        $margem_minutos_esquerda = $meta_em_minutos * 0.5;
                        $margem_minutos_direita = $meta_em_minutos * 0.2;
                        $tempo_realizado = $this->transformahoraemminuto($tempo_gasto);
                        if ($tempo_realizado >= ($meta_em_minutos - $margem_minutos_esquerda) and $tempo_realizado <= ( $meta_em_minutos + $margem_minutos_direita)) {
                            $media[] = $tempo_gasto;
                            $cont_num_horas_para_media ++;
                        }
                        $cont_tarefa ++;
                    }
                }
                if ($status_tarefa == "concluida") {
                    $horas_totais = $this->somarhoras($media);
                    $horas_totais_minutos = $this->transformahoraemminuto($horas_totais);
                    $media_geral_minutos = $horas_totais_minutos / $cont_num_horas_para_media;
                    $media_geral = $this->minutoemhora($media_geral_minutos);
                }
                ?>
            </table>
            <?php
            if ($status_tarefa == "concluida") {
                ?>
                <script>
                    document.getElementById("media_tarefa").innerHTML = "<?php echo $media_geral; ?>";
                </script>
                <?php
            } else {
                ?>
                <script>
                    document.getElementById("media_tarefa").innerHTML = "00:00:00";
                </script>
                <?php
            }
        }
    }
    
    
    
 function getIdProjetoExecuta($id_tarefa_executa) {
        $id_projeto = array();
        $conexao_id_projeto_executa = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_id_projeto_executa->set_charset("utf8");
        $sql_tarefa_projeto = "select tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto from tarefas_executa where tarefas_executa.id_tarefa_executa=$id_tarefa_executa";
        $result_id_projeto_executa = mysqli_query($conexao_id_projeto_executa, $sql_tarefa_projeto);
        if ($result_id_projeto_executa) {
            while ($row = $result_id_projeto_executa->fetch_assoc()){
                $id_projeto[] = $row['id_projeto_executa'];
                $id_projeto[] = $row['id_projeto'];
              }
            $result_id_projeto_executa->free();
            return $id_projeto;
        } else {
            throw new Exception('<script>alert("Ocorreu um erro na busca pelo identificador do projeto!")</script>');
        }
       }
    

function montaDetalhesTarefas(tarefas $obj) {
        $id_tarefa = $obj->getId_tarefa();
        $id_veiculo = $obj->getId_veiculo();
        $id_tarefa_executa = $obj->getId_tarefa_executa();
        $id_projeto_executa = $obj->getId_projeto_executa();
        $id_projeto = $obj->getId_projeto();
        $tipo_tarefa = $obj->getTipo_tarefa();
        $data_tarefa = $obj->getData_final();
        try {
             $id_dos_projeto = $this->getIdProjetoExecuta($id_tarefa_executa);
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        ?>
        <table class="table table-hover" cellpadding=1 cellspacing=1 style="margin-top:35px;">
             

 <?php
                    if ($tipo_tarefa == "liberada") {
                        ?>
                    <tr style=" height: 50px;">
                        <td colspan="6">Descrição do que foi realizado</td>
                    </tr>
                    <tr style="font-size: 0.9em;">
                        <?php
                        $conexao_select_dados_descricao = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
                        $conexao_select_dados_descricao->set_charset("utf8");
                        $sql_descricao_tarefa = "select descricao_tarefa.descricao from descricao_tarefa where descricao_tarefa.id_tarefa_executa = $id_tarefa_executa and descricao_tarefa.id_projeto_executa = $id_projeto_executa and descricao_tarefa.id_projeto = $id_projeto and descricao_tarefa.id_veiculo = $id_veiculo and descricao_tarefa.id_tarefa = $id_tarefa";
                        $query_select_descricao = mysqli_query($conexao_select_dados_descricao, $sql_descricao_tarefa);
                        while ($row = $query_select_descricao->fetch_assoc()) {
                            $descricao_da_tarefa = $row['descricao'];
                            ?>
                            <td><table class="table table-hover"><tr><td>
                                            <?php
                                            $arquivo_descricao = explode('.', $descricao_da_tarefa);
                                            $extensao_arquivo = $arquivo_descricao[1];
                                       if ($extensao_arquivo == 'jpg') {
                                                ?>
                                            <td><a href="http://192.168.0.109/sistema_gestor/descricao_das_tarefas/<?php echo $data_tarefa ?>/+<?php echo $descricao_da_tarefa ?>" target="_blank">
                                                    <img title="FRASE" alt="Imagem da descrição" src=""/></a></td>
                                            <?php
                                        } else {
                                            ?>
                                            <td>
                                                <audio controls preload="auto">
                                                    <source src="http://192.168.0.109/sistema_gestor/descricao_das_tarefas/<?php echo $data_tarefa ?>/+<?php echo $descricao_da_tarefa ?>" type="audio/mpeg">

                                                </audio>
                                            </td>
                                            <?php
                                        }
                                        ?>
                                        </td></tr></table></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>  
            <tr style=" background: #3c763d; color:white;font-size: 0.9em; font-weight: bold;">
                <td colspan="2">Funcionario</td>
                <td>Dia de execução</td>
                <td>Hora Inicial</td>
                <td>Horas Trabalhadas</td>
                <td>Hora Final</td>
            </tr>
        <?php
        $conexao_select_horas_func = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_select_horas_func->set_charset("utf8");
        $sql_relatorio_funcionario = "select funcionario_executa.horas_concluidas,funcionario_executa.data_tarefa,funcionario_executa.hora_inicial,funcionario_executa.hora_final,funcionarios.sobrenome,funcionarios.id_funcionario from `funcionarios` join `funcionario_executa` on (funcionario_executa.id_funcionario = funcionarios.id_funcionario) join `tarefas_executa` on (funcionario_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and funcionario_executa.id_projeto = tarefas_executa.id_projeto and funcionario_executa.id_veiculo = tarefas_executa.id_veiculo and funcionario_executa.id_tarefa = tarefas_executa.id_tarefa) where funcionario_executa.id_projeto_executa = $id_dos_projeto[0] and funcionario_executa.id_projeto = $id_dos_projeto[1] and funcionario_executa.id_veiculo = $id_veiculo and funcionario_executa.id_tarefa =$id_tarefa and funcionario_executa.flag_tarefa_relatorio != 1  ";
        $query_select_horas_func = mysqli_query($conexao_select_horas_func, $sql_relatorio_funcionario);
        while ($row = $query_select_horas_func->fetch_assoc()) {
            $nome_funcionario = $row['sobrenome'];
            $data_tarefa = $row['data_tarefa'];
            $horas_concluidas_funcionario = $row['horas_concluidas'];
            $horas_inicial_funcionario = $row['hora_inicial'];
            $horas_final_funcionario = $row['hora_final'];
            $data_tarefa_invertida = $this->invertedata($data_tarefa, "-", "/");
            ?>
                <tr>
                    <th style="text-align: left;" colspan="2"><?php echo $nome_funcionario ?></th>  
                    <th style="font-size: 1em;"><?php echo $data_tarefa_invertida ?></th>
                    <th style=" font-size: 1em;"><?php echo $horas_inicial_funcionario ?></th>
                    <th><?php echo $horas_concluidas_funcionario ?></th>
                    <th style="  font-size: 1em;"><?php echo $horas_final_funcionario ?></th>
                </tr>
            <?php
        }
        ?>
            <tr>
                <td colspan="6" style="height: 50px;"></td>
            </tr>
        </table>
        <?php
    }

    function tarefa(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_tarefa = $obj->getId_tarefa();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from tarefas_executa join veiculos on (veiculos.id_veiculo = tarefas_executa.id_veiculo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) where tarefas_executa.id_tarefa = $id_tarefa and tarefas_executa.status = '$status'";
        return $sql_tarefa;
    }

    function tarefasDatas(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_tarefa = $obj->getId_tarefa();
        $data_inicial = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from tarefas_executa join veiculos on (veiculos.id_veiculo = tarefas_executa.id_veiculo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) where tarefas_executa.id_tarefa = $id_tarefa and tarefas_executa.data_inicio >= '$data_inicial' and tarefas_executa.data_final <= '$data_final' and tarefas_executa.status = '$status'";
        return $sql_tarefa;
     }
    function tarefasveiculo(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_veiculo = $obj->getId_veiculo();
        $id_tarefa = $obj->getId_tarefa();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from tarefas_executa join veiculos on (veiculos.id_veiculo = tarefas_executa.id_veiculo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) where tarefas_executa.id_veiculo = $id_veiculo and tarefas_executa.id_tarefa = $id_tarefa and tarefas_executa.status = '$status'";
        return $sql_tarefa;
    }
    function tarefasveiculoDatas(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_veiculo = $obj->getId_veiculo();
        $id_tarefa = $obj->getId_tarefa();
        $data_inicial = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from tarefas_executa join veiculos on (veiculos.id_veiculo = tarefas_executa.id_veiculo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) where tarefas_executa.id_veiculo = $id_veiculo and tarefas_executa.id_tarefa = $id_tarefa and tarefas_executa.data_inicio >= '$data_inicial' and tarefas_executa.data_final <= '$data_final' and tarefas_executa.status = '$status'";
        return $sql_tarefa;
    }
    function tarefastipoVeiculo(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_tipo = $obj->getId_tipo_veiculo();
        $id_tarefa = $obj->getId_tarefa();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from `tarefas_executa` join `veiculos` on (tarefas_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) where veiculos.id_tipo = $id_tipo and tarefas_executa.id_tarefa = $id_tarefa and  tarefas_executa.status = '$status' ";
        return $sql_tarefa;
    }
    function tarefastipoVeiculoDatas(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_tipo = $obj->getId_tipo_veiculo();
        $id_tarefa = $obj->getId_tarefa();
        $data_inicial = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from `tarefas_executa` join `veiculos` on (tarefas_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) where veiculos.id_tipo = $id_tipo and tarefas_executa.id_tarefa = $id_tarefa  and tarefas_executa.data_inicio >= '$data_inicial' and tarefas_executa.data_final <= '$data_final' and and tarefas_executa.status = '$status' ";
        return $sql_tarefa;
    }
    function tarefasfuncionario(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_funcionario = $obj->getId_funcionario();
        $id_tarefa = $obj->getId_tarefa();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from tarefas_executa join veiculos on (veiculos.id_veiculo = tarefas_executa.id_veiculo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) join funcionario_executa on (tarefas_executa.id_tarefa = funcionario_executa.id_tarefa and tarefas_executa.id_veiculo = funcionario_executa.id_veiculo and tarefas_executa.id_projeto = funcionario_executa.id_projeto and funcionario_executa.id_projeto and tarefas_executa.id_projeto_executa = funcionario_executa.id_projeto_executa) where funcionario_executa.id_funcionario = $id_funcionario and tarefas_executa.id_tarefa = $id_tarefa and tarefas_executa.status = '$status' ";
        return $sql_tarefa;
    }
    function tarefasfuncionarioDatas(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_funcionario = $obj->getId_funcionario();
        $id_tarefa = $obj->getId_tarefa();
        $data_inicial = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from tarefas_executa join veiculos on (veiculos.id_veiculo = tarefas_executa.id_veiculo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) join funcionario_executa on (tarefas_executa.id_tarefa = funcionario_executa.id_tarefa and tarefas_executa.id_veiculo = funcionario_executa.id_veiculo and tarefas_executa.id_projeto = funcionario_executa.id_projeto and funcionario_executa.id_projeto and tarefas_executa.id_projeto_executa = funcionario_executa.id_projeto_executa) where funcionario_executa.id_funcionario = $id_funcionario and tarefas_executa.id_tarefa = $id_tarefa and tarefas_executa.status = '$status' and tarefas_executa.data_inicio >= '$data_inicial' and tarefas_executa.data_final <= '$data_final'";
        return $sql_tarefa;
    }
    
    function tarefasveiculofuncionario(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_veiculo = $obj->getId_veiculo();
        $id_tarefa = $obj->getId_tarefa();
        $id_funcionario = $obj->getId_funcionario();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from tarefas_executa join veiculos on (veiculos.id_veiculo = tarefas_executa.id_veiculo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) join funcionario_executa on (tarefas_executa.id_tarefa = funcionario_executa.id_tarefa and tarefas_executa.id_veiculo = funcionario_executa.id_veiculo and tarefas_executa.id_projeto = funcionario_executa.id_projeto and funcionario_executa.id_projeto and tarefas_executa.id_projeto_executa = funcionario_executa.id_projeto_executa) where tarefas_executa.id_veiculo = $id_veiculo and tarefas_executa.id_tarefa = $id_tarefa and funcionario_executa.id_funcionario = $id_funcionario and tarefas_executa.status = '$status' ";
        return $sql_tarefa;
    }
    function tarefasveiculofuncionarioDatas(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_veiculo = $obj->getId_veiculo();
        $id_funcionario = $obj->getId_funcionario();
        $id_tarefa = $obj->getId_tarefa();
        $data_inicial = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from tarefas_executa join veiculos on (veiculos.id_veiculo = tarefas_executa.id_veiculo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) join funcionario_executa on (tarefas_executa.id_tarefa = funcionario_executa.id_tarefa and tarefas_executa.id_veiculo = funcionario_executa.id_veiculo and tarefas_executa.id_projeto = funcionario_executa.id_projeto and funcionario_executa.id_projeto and tarefas_executa.id_projeto_executa = funcionario_executa.id_projeto_executa) where tarefas_executa.id_veiculo = $id_veiculo and tarefas_executa.id_tarefa = $id_tarefa and funcionario_executa.id_funcionario = $id_funcionario and tarefas_executa.status = '$status' and tarefas_executa.data_inicio >= '$data_inicial' and tarefas_executa.data_final <= '$data_final' ";
        return $sql_tarefa;
    }
    
    function tarefastipoveiculofuncionario(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_tipo = $obj->getId_tipo_veiculo();
        $id_tarefa = $obj->getId_tarefa();
        $id_funcionario = $obj->getId_funcionario();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from `tarefas_executa` join `veiculos` on (tarefas_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) join funcionario_executa on (tarefas_executa.id_tarefa = funcionario_executa.id_tarefa and tarefas_executa.id_veiculo = funcionario_executa.id_veiculo and tarefas_executa.id_projeto = funcionario_executa.id_projeto and funcionario_executa.id_projeto and tarefas_executa.id_projeto_executa = funcionario_executa.id_projeto_executa) where veiculos.id_tipo = $id_tipo and tarefas_executa.id_tarefa = $id_tarefa and funcionario_executa.id_funcionario = $id_funcionario and  tarefas_executa.status = '$status'";
        return $sql_tarefa;
    }
    function tarefastipoveiculofuncionarioDatas(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_tipo = $obj->getId_tipo_veiculo();
        $id_tarefa = $obj->getId_tarefa();
        $id_funcionario = $obj->getId_funcionario();
        $data_inicial = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from `tarefas_executa` join `veiculos` on (tarefas_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) join funcionario_executa on (tarefas_executa.id_tarefa = funcionario_executa.id_tarefa and tarefas_executa.id_veiculo = funcionario_executa.id_veiculo and tarefas_executa.id_projeto = funcionario_executa.id_projeto and funcionario_executa.id_projeto and tarefas_executa.id_projeto_executa = funcionario_executa.id_projeto_executa) where veiculos.id_tipo = $id_tipo and tarefas_executa.id_tarefa = $id_tarefa and funcionario_executa.id_funcionario = $id_funcionario and  tarefas_executa.status = '$status' and tarefas_executa.data_inicio >= '$data_inicial' and tarefas_executa.data_final <= '$data_final'";
        return $sql_tarefa;
    }
    
    // tarefas com status tanto abertas quanto concluidas
    
     function tarefatodos(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_tarefa = $obj->getId_tarefa();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from tarefas_executa join veiculos on (veiculos.id_veiculo = tarefas_executa.id_veiculo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) where tarefas_executa.id_tarefa = $id_tarefa and (tarefas_executa.status = $status)";
        return $sql_tarefa;
    }

    function tarefasDatastodos(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_tarefa = $obj->getId_tarefa();
        $data_inicial = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from tarefas_executa join veiculos on (veiculos.id_veiculo = tarefas_executa.id_veiculo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) where tarefas_executa.id_tarefa = $id_tarefa and tarefas_executa.data_inicio >= '$data_inicial' and tarefas_executa.data_final <= '$data_final' and (tarefas_executa.status = $status)";
        return $sql_tarefa;
    }
    function tarefasveiculotodos(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_veiculo = $obj->getId_veiculo();
        $id_tarefa = $obj->getId_tarefa();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from tarefas_executa join veiculos on (veiculos.id_veiculo = tarefas_executa.id_veiculo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) where tarefas_executa.id_veiculo = $id_veiculo and tarefas_executa.id_tarefa = $id_tarefa and (tarefas_executa.status = $status)";
        return $sql_tarefa;
    }
    function tarefasveiculoDatastodos(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_veiculo = $obj->getId_veiculo();
        $id_tarefa = $obj->getId_tarefa();
        $data_inicial = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from tarefas_executa join veiculos on (veiculos.id_veiculo = tarefas_executa.id_veiculo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) where tarefas_executa.id_veiculo = $id_veiculo and tarefas_executa.id_tarefa = $id_tarefa and tarefas_executa.data_inicio >= '$data_inicial' and tarefas_executa.data_final <= '$data_final' and (tarefas_executa.status = $status)";
        return $sql_tarefa;
    }
    function tarefastipoVeiculotodos(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_tipo = $obj->getId_tipo_veiculo();
        $id_tarefa = $obj->getId_tarefa();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from `tarefas_executa` join `veiculos` on (tarefas_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) where veiculos.id_tipo = $id_tipo and tarefas_executa.id_tarefa = $id_tarefa and  (tarefas_executa.status = $status) ";
        return $sql_tarefa;
    }
    function tarefastipoVeiculoDatastodos(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_tipo = $obj->getId_tipo_veiculo();
        $id_tarefa = $obj->getId_tarefa();
        $data_inicial = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from `tarefas_executa` join `veiculos` on (tarefas_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) where veiculos.id_tipo = $id_tipo and tarefas_executa.id_tarefa = $id_tarefa  and tarefas_executa.data_inicio >= '$data_inicial' and tarefas_executa.data_final <= '$data_final' and and (tarefas_executa.status = $status) ";
        return $sql_tarefa;
    }
    function tarefasfuncionariotodos(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_funcionario = $obj->getId_funcionario();
        $id_tarefa = $obj->getId_tarefa();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from tarefas_executa join veiculos on (veiculos.id_veiculo = tarefas_executa.id_veiculo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) join funcionario_executa on (tarefas_executa.id_tarefa = funcionario_executa.id_tarefa and tarefas_executa.id_veiculo = funcionario_executa.id_veiculo and tarefas_executa.id_projeto = funcionario_executa.id_projeto and funcionario_executa.id_projeto and tarefas_executa.id_projeto_executa = funcionario_executa.id_projeto_executa) where funcionario_executa.id_funcionario = $id_funcionario and tarefas_executa.id_tarefa = $id_tarefa and (tarefas_executa.status = $status)";
        return $sql_tarefa;
    }
    function tarefasfuncionarioDatastodos(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_funcionario = $obj->getId_funcionario();
        $id_tarefa = $obj->getId_tarefa();
        $data_inicial = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from tarefas_executa join veiculos on (veiculos.id_veiculo = tarefas_executa.id_veiculo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) join funcionario_executa on (tarefas_executa.id_tarefa = funcionario_executa.id_tarefa and tarefas_executa.id_veiculo = funcionario_executa.id_veiculo and tarefas_executa.id_projeto = funcionario_executa.id_projeto and funcionario_executa.id_projeto and tarefas_executa.id_projeto_executa = funcionario_executa.id_projeto_executa) where funcionario_executa.id_funcionario = $id_funcionario and tarefas_executa.id_tarefa = $id_tarefa and (tarefas_executa.status = $status) and tarefas_executa.data_inicio >= '$data_inicial' and tarefas_executa.data_final <= '$data_final'";
        return $sql_tarefa;
    }
    
    function tarefasveiculofuncionariotodos(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_veiculo = $obj->getId_veiculo();
        $id_tarefa = $obj->getId_tarefa();
        $id_funcionario = $obj->getId_funcionario();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from tarefas_executa join veiculos on (veiculos.id_veiculo = tarefas_executa.id_veiculo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) join funcionario_executa on (tarefas_executa.id_tarefa = funcionario_executa.id_tarefa and tarefas_executa.id_veiculo = funcionario_executa.id_veiculo and tarefas_executa.id_projeto = funcionario_executa.id_projeto and funcionario_executa.id_projeto and tarefas_executa.id_projeto_executa = funcionario_executa.id_projeto_executa) where tarefas_executa.id_veiculo = $id_veiculo and tarefas_executa.id_tarefa = $id_tarefa and funcionario_executa.id_funcionario = $id_funcionario and (tarefas_executa.status = $status) ";
        return $sql_tarefa;
     }
    function tarefasveiculofuncionarioDatastodos(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_veiculo = $obj->getId_veiculo();
        $id_funcionario = $obj->getId_funcionario();
        $id_tarefa = $obj->getId_tarefa();
        $data_inicial = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from tarefas_executa join veiculos on (veiculos.id_veiculo = tarefas_executa.id_veiculo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) join funcionario_executa on (tarefas_executa.id_tarefa = funcionario_executa.id_tarefa and tarefas_executa.id_veiculo = funcionario_executa.id_veiculo and tarefas_executa.id_projeto = funcionario_executa.id_projeto and funcionario_executa.id_projeto and tarefas_executa.id_projeto_executa = funcionario_executa.id_projeto_executa) where tarefas_executa.id_veiculo = $id_veiculo and tarefas_executa.id_tarefa = $id_tarefa and funcionario_executa.id_funcionario = $id_funcionario and (tarefas_executa.status = $status) and tarefas_executa.data_inicio >= '$data_inicial' and tarefas_executa.data_final <= '$data_final' ";
        return $sql_tarefa;
    }
    
    function tarefastipoveiculofuncionariotodos(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_tipo = $obj->getId_tipo_veiculo();
        $id_tarefa = $obj->getId_tarefa();
        $id_funcionario = $obj->getId_funcionario();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from `tarefas_executa` join `veiculos` on (tarefas_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) join funcionario_executa on (tarefas_executa.id_tarefa = funcionario_executa.id_tarefa and tarefas_executa.id_veiculo = funcionario_executa.id_veiculo and tarefas_executa.id_projeto = funcionario_executa.id_projeto and funcionario_executa.id_projeto and tarefas_executa.id_projeto_executa = funcionario_executa.id_projeto_executa) where veiculos.id_tipo = $id_tipo and tarefas_executa.id_tarefa = $id_tarefa and funcionario_executa.id_funcionario = $id_funcionario and  (tarefas_executa.status = $status)";
        return $sql_tarefa;
    }
    function tarefastipoveiculofuncionarioDatastodos(tarefas $obj) {
        $status = $obj->getStatus_tarefa();
        $id_tipo = $obj->getId_tipo_veiculo();
        $id_tarefa = $obj->getId_tarefa();
        $id_funcionario = $obj->getId_funcionario();
        $data_inicial = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql_tarefa = "SELECT DISTINCT tarefas_executa.id_projeto_executa,tarefas_executa.id_projeto,tarefas_executa.tipo_tarefa,tarefas_executa.id_tarefa_executa,tarefas.nome,veiculos.nome_veiculo,tarefas_executa.id_veiculo, tarefas_executa.id_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio,tarefas_executa.data_final from `tarefas_executa` join `veiculos` on (tarefas_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join tarefas on (tarefas.id_tarefa = tarefas_executa.id_tarefa) join funcionario_executa on (tarefas_executa.id_tarefa = funcionario_executa.id_tarefa and tarefas_executa.id_veiculo = funcionario_executa.id_veiculo and tarefas_executa.id_projeto = funcionario_executa.id_projeto and funcionario_executa.id_projeto and tarefas_executa.id_projeto_executa = funcionario_executa.id_projeto_executa) where veiculos.id_tipo = $id_tipo and tarefas_executa.id_tarefa = $id_tarefa and funcionario_executa.id_funcionario = $id_funcionario and  (tarefas_executa.status = $status) and tarefas_executa.data_inicio >= '$data_inicial' and tarefas_executa.data_final <= '$data_final'";
        return $sql_tarefa;
    }

}
