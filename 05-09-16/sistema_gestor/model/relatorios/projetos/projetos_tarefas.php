<?php
class projetos_tarefas {

    private $id_executa;
    private $status_projeto;
    private $ugb;
    private $id_projeto;
    private $id_veiculo;
    private $id_tarefa;
    private $id_funcionario;
    private $id_tipo_veiculo;
    private $data_inicial;
    private $data_final;

    function getUgb() {
        return $this->ugb;
    }

    function setUgb($ugb) {
        $this->ugb = $ugb;
    }

    function getStatus_projeto() {
        return $this->status_projeto;
    }

    function setStatus_projeto($status_projeto) {
        $this->status_projeto = $status_projeto;
    }

    function getId_executa() {
        return $this->id_executa;
    }

    function setId_executa($id_executa) {
        $this->id_executa = $id_executa;
    }

    function getId_projeto() {
        return $this->id_projeto;
    }

    function getId_veiculo() {
        return $this->id_veiculo;
    }

    function getId_tarefa() {
        return $this->id_tarefa;
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

    function setId_projeto($id_projeto) {
        $this->id_projeto = $id_projeto;
    }

    function setId_veiculo($id_veiculo) {
        $this->id_veiculo = $id_veiculo;
    }

    function setId_tarefa($id_tarefa) {
        $this->id_tarefa = $id_tarefa;
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

    function montaTabela($sql, $status_projeto) {
        $media = array();
        $cont_num_horas_para_media = 0;
        $cont_tarefa = 0;
        $conexao_select_dados = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_select_dados->set_charset("utf8");
        $conexao_select_dados->query($sql);
        if ($conexao_select_dados->affected_rows == 0){
            echo "<center><p style='margin-top:70px; font-size:1.5em;'>Nenhum resultado foi encontrado</p></center>";
        }else{
            $query_select_dados = mysqli_query($conexao_select_dados, $sql);
            ?>
            <table class='table table-hover'>
                <?php
                while ($row = $query_select_dados->fetch_assoc()) {
                    $id_do_projeto = $row['id_projeto'];
                    $id_veiculo = $row['id_veiculo'];
                    $id_executa = $row['id_projeto_executa'];
                    $nome_projeto = $row['nome_projeto'];
                    $nome_veiculo = $row['nome_veiculo'];
                    $data_inicio = $row['data_inicio'];
                    $data_final = $row['data_final'];
                    $tempo_gasto = $row['horas_concluidas'];
                    $meta = $row['duracao'];
                    ?>
                    <tr style="font-size:0.9em;">
                        <td style="width: 30%;"><a href="#" onclick="openModal('<?php echo $id_do_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_executa ?>', 'tarefasProjeto')"><?php echo $nome_projeto ?></a></td>
                        <td style="width: 15%;"><?php echo $nome_veiculo ?></td>
                        <td style="width: 15%;"><?php echo $datainicio = $this->invertedata($data_inicio, '-') ?></td>
                        <td style="width: 15%;"><?php echo $datafinal = $this->invertedata($data_final, '-') ?></td>
                        <?php
                        if ($status_projeto == "open") {
                            ?>
                            <td style="width: 15%; background: #01669F; color:white;"><?php echo $tempo_gasto ?></td>
                            <?php
                        } else if ($status_projeto == "concluido") {
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
                    if ($status_projeto == "concluido") {
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
                if ($status_projeto == "concluido") {
                    $horas_totais = $this->somarhoras($media);
                    $horas_totais_minutos = $this->transformahoraemminuto($horas_totais);
                    $media_geral_minutos = $horas_totais_minutos / $cont_num_horas_para_media;
                    $media_geral = $this->minutoemhora($media_geral_minutos);
                }
                ?>
            </table>
            <?php
            if ($status_projeto == "concluido") {
                ?>
                <script>
                    document.getElementById("media_projeto").innerHTML = "<?php echo $media_geral; ?>";
                </script>
                <?php
            } else {
                ?>
                <script>
                    document.getElementById("media_projeto").innerHTML = "00:00:00";
                </script>
                <?php
            }
        }
    }

    function montaTabelaTarefas(projetos_tarefas $obj) {
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $id_executa = $obj->getId_executa();
        ?>
        <table class="table table-hover" cellpadding=1 cellspacing=1 style="margin-top:35px;">
            <tr style="font-weight: bold; background: #666666; color:white;font-size: 0.9em;">
                <td >Tarefa</td>
                <td>Status</td>
                <td>Meta</td>
                <td>Tempo Gasto</td>
                <td>Data inicial</td>
                <td>Data final</td>
            </tr>
            <?php
            $conexao_select_dados_projeto = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
            $conexao_select_dados_projeto->set_charset("utf8");
            $flag_tarefa = 0;
            $sql_relatorio_tarefa = "select tarefas_executa.id_tarefa_executa,tarefas_executa.id_tarefa,tarefas_executa.status,tarefas_executa.tipo_tarefa,tarefas_executa.duracao,tarefas_executa.horas_concluidas,tarefas_executa.data_inicio, tarefas_executa.data_final,tarefas.nome from `tarefas` join `tarefas_executa` on (tarefas_executa.id_tarefa = tarefas.id_tarefa) join `projeto_executa` on (tarefas_executa.id_projeto_executa = projeto_executa.id_projeto_executa and tarefas_executa.id_projeto = projeto_executa.id_projeto and tarefas_executa.id_veiculo = projeto_executa.id_veiculo) where tarefas_executa.id_projeto_executa = '$id_executa' and tarefas_executa.id_projeto = '$id_projeto' and tarefas_executa.id_veiculo = '$id_veiculo' ";
            $query_select_tarefa = mysqli_query($conexao_select_dados_projeto, $sql_relatorio_tarefa);
            while ($row = $query_select_tarefa->fetch_assoc()) {
                $id_tarefa_executa = $row['id_tarefa_executa'];
                $codigo_tarefa = $row['id_tarefa'];
                $nome_tarefa = $row['nome'];
                $status_tarefa = $row['status'];
                $duracao_tarefa = $row['duracao'];
                $horas_concluidas = $row['horas_concluidas'];
                $data_inicio_tarefa = $row['data_inicio'];
                $data_final_tarefa = $row['data_final'];
                $tipo_tarefa = $row['tipo_tarefa'];
                $data_inicio_da_tarefa = $this->invertedata($data_inicio_tarefa, "-", "/");
                $data_final_da_tarefa = $this->invertedata($data_final_tarefa, "-", "/");
                $flag_tarefa ++;
                ?>
                <?php
                if ($flag_tarefa == 2) {
                    ?>
                    <tr style="font-weight: bold; background: #666666; color:white;font-size: 0.9em;">
                        <td>Tarefa</td>
                        <td>Status</td>
                        <td>Meta</td>
                        <td>Tempo Gasto</td>
                        <td>Data inicial</td>
                        <td>Data final</td>
                    </tr>
                    <?php
                    $flag_tarefa --;
                }
                ?>
                <tr>

                    <td style="text-align: left;"><a style="text-decoration: none; color:black; font-size: 0.9em; " href="#"><?php echo $nome_tarefa ?></a></td>
                    <?php
                    if ($status_tarefa == "notopen") {
                        ?>
                        <td style="background: orange; color: white; font-size: 0.9em;"><?php echo "nao iniciada" ?></td>
                        <?php
                    } else if ($status_tarefa == "open") {
                        ?>
                        <td style="background:#01669F; color:white; font-size: 0.9em;"><?php echo "aberta" ?></td>
                        <?php
                    } else if ($status_tarefa == "pause") {
                        ?>
                        <td style="background:#ff7f24;color: white; font-size: 0.9em; "><?php echo "pausada" ?></td>
                        <?php
                    } else if ($status_tarefa == "concluida") {
                        ?>
                        <td style="background: darkgreen ;color: white; font-size: 0.9em;"><?php echo "concluida" ?></td>
                        <?php
                    }
                    ?>

                    <?php
                    if ($tipo_tarefa == "liberada") {
                        ?>
                        <td style="font-size: 0.9em;"><?php echo "Não Determinado" ?></td>
                        <?php
                    } else {
                        ?>
                        <td style="font-size: 0.9em;"><?php echo $duracao_tarefa ?></td>
                        <?php
                    }
                    ?>
                    <td style="font-size: 0.9em;"><?php echo $horas_concluidas ?></td>
                    <td style="font-size: 0.9em;"><?php echo $data_inicio_da_tarefa ?></td>
                    <td style="font-size: 0.9em;"><?php echo $data_final_da_tarefa ?></td>
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
                        $sql_descricao_tarefa = "select descricao_tarefa.descricao from descricao_tarefa where descricao_tarefa.id_tarefa_executa = $id_tarefa_executa and descricao_tarefa.id_projeto_executa = $id_executa and descricao_tarefa.id_projeto = $id_projeto and descricao_tarefa.id_veiculo = $id_veiculo and descricao_tarefa.id_tarefa = $codigo_tarefa";
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
                                            <td><a href="http://192.168.0.109/sistema_gestor/descricao_das_tarefas/<?php echo $data_final_tarefa ?>/+<?php echo $descricao_da_tarefa ?>" target="_blank">
                                                    <img title="FRASE" alt="Imagem da descrição" src=""/></a></td>
                                            <?php
                                        } else {
                                            ?>
                                            <td>
                                                <audio controls preload="auto">
                                                    <source src="http://192.168.0.109/sistema_gestor/descricao_das_tarefas/<?php echo $data_final_tarefa ?>/+<?php echo $descricao_da_tarefa ?>" type="audio/mpeg">

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
            </tr>
            <tr>
                <td colspan="7" style="height: 50px;"></td>
            </tr>
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
            $sql_relatorio_funcionario = "select funcionario_executa.horas_concluidas,funcionario_executa.data_tarefa,funcionario_executa.hora_inicial,funcionario_executa.hora_final,funcionarios.sobrenome,funcionarios.id_funcionario from `funcionarios` join `funcionario_executa` on (funcionario_executa.id_funcionario = funcionarios.id_funcionario) join `tarefas_executa` on (funcionario_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and funcionario_executa.id_projeto = tarefas_executa.id_projeto and funcionario_executa.id_veiculo = tarefas_executa.id_veiculo and funcionario_executa.id_tarefa = tarefas_executa.id_tarefa) where funcionario_executa.id_projeto_executa = '$id_executa' and funcionario_executa.id_projeto = '$id_projeto' and funcionario_executa.id_veiculo = '$id_veiculo' and funcionario_executa.id_tarefa ='$codigo_tarefa' and funcionario_executa.flag_tarefa_relatorio != '1' "; 
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
            <?php
        }
        $flag_tarefa = 0;
        ?>
        </table>
        <?php
    }

    function projetos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa  where projeto_executa.id_projeto = $id_projeto and  projeto_executa.status = '$status'";
        return $sql;
    }

    function projetosDatas(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa  where projeto_executa.id_projeto = $id_projeto and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status'  ";
        return $sql;
    }

    function veiculos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa  where projeto_executa.id_veiculo = $id_veiculo and projeto_executa.status = '$status' ";
        return $sql;
    }

    function veiculosDatas(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` where projeto_executa.id_veiculo = $id_veiculo and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status'   ";
        return $sql;
    }

    function tipoVeiculo(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_tipoveiculo = $obj->getId_tipo_veiculo();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) where veiculos.id_tipo = $id_tipoveiculo  and projeto_executa.status = '$status' ";
        return $sql;
    }

    function projetoTipoDatas(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $id_tipoveiculo = $obj->getId_tipo_veiculo();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) where veiculos.id_tipo = $id_tipoveiculo and projeto_executa.id_projeto = $id_projeto and  projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status'  ";
        return $sql;
    }

    function ugb(projetos_tarefas $obj) {
        $id_ugb = $obj->getUgb();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa`  join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where  projeto_executa.id_ugb = $id_ugb and projeto_executa.status = '$status'";
        return $sql;
    }

    function ugbDatas(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_ugb = $obj->getUgb();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa`  join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where  projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status'";
        return $sql;
    }

    function ugbVeiculo(projetos_tarefas $obj) {
        $id_ugb = $obj->getUgb();
        $id_veiculo = $obj->getId_veiculo();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_veiculo = $id_veiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.status = '$status'";
        return $sql;
    }

    function ugbVeiculoDatas(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_ugb = $obj->getUgb();
        $id_veiculo = $obj->getId_veiculo();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_veiculo = $id_veiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status'";
        return $sql;
    }

    function ugbProjeto(projetos_tarefas $obj) {
        $id_ugb = $obj->getUgb();
        $id_projeto = $obj->getId_projeto();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_ugb = $id_ugb and projeto_executa.status = '$status' ";
        return $sql;
    }

    function ugbProjetoDatas(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_ugb = $obj->getUgb();
        $id_projeto = $obj->getId_projeto();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_ugb = $id_ugb and  projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status' ";
        return $sql;
    }

    function ugbTipoVeiculo(projetos_tarefas $obj) {
        $id_tipoVeiculo = $obj->getId_tipo_veiculo();
        $id_ugb = $obj->getUgb();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where  veiculos.id_tipo = $id_tipoVeiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.status = '$status' ";
        return $sql;
    }

    function ugbTipoVeiculoDatas(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_tipoVeiculo = $obj->getId_tipo_veiculo();
        $id_ugb = $obj->getUgb();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where  veiculos.id_tipo = $id_tipoVeiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status' ";
        return $sql;
    }

    function projetoVeiculoUgb(projetos_tarefas $obj) {
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $status = $obj->getStatus_projeto();
        $id_ugb = $obj->getUgb();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.id_ugb = $id_ugb  and projeto_executa.status = '$status'";
        return $sql;
    }

    function projetoVeiculoUgbDatas(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $status = $obj->getStatus_projeto();
        $id_ugb = $obj->getUgb();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final'  and projeto_executa.status = '$status'";
        return $sql;
    }

    function projetoTipoVeiculoUgb(projetos_tarefas $obj) {
        $id_projeto = $obj->getId_projeto();
        $id_tipoVeiculo = $obj->getId_tipo_veiculo();
        $status = $obj->getStatus_projeto();
        $id_ugb = $obj->getUgb();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and veiculos.id_tipo = $id_tipoVeiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.status = '$status'";
        return $sql;
    }

    function projetoTipoVeiculoUgbDatas(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_projeto = $obj->getId_projeto();
        $id_tipoVeiculo = $obj->getId_tipo_veiculo();
        $status = $obj->getStatus_projeto();
        $id_ugb = $obj->getUgb();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and veiculos.id_tipo = $id_tipoVeiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status'";
        return $sql;
    }

    function tipoVeiculoDatas(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_tipoveiculo = $obj->getId_tipo_veiculo();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) where veiculos.id_tipo = $id_tipoveiculo and  projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status'  ";
        return $sql;
    }

    function projetosVeiculos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.status = '$status' ";
        return $sql;
    }

    function projetosVeiculosDatas(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and projeto_executa.status = '$status' ";
        return $sql;
    }

    function projetoTipo(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $id_tipoveiculo = $obj->getId_tipo_veiculo();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) where veiculos.id_tipo = $id_tipoveiculo and projeto_executa.id_projeto = $id_projeto and projeto_executa.status = '$status' ";
        return $sql;
    }

    ///  todos as funções para os projetos com status igual a concluido ou abertos
    function projetosStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa  where projeto_executa.id_projeto = $id_projeto and  ( projeto_executa.status = $status)";
        return $sql;
    }

    function projetosDatasStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa  where projeto_executa.id_projeto = $id_projeto and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status) ";
        return $sql;
    }

    function veiculosStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa  where projeto_executa.id_veiculo = $id_veiculo and ( projeto_executa.status = $status)";
        return $sql;
    }

    function veiculosDatasStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` where projeto_executa.id_veiculo = $id_veiculo and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status)  ";
        return $sql;
    }

    function tipoVeiculoStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_tipoveiculo = $obj->getId_tipo_veiculo();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) where veiculos.id_tipo = $id_tipoveiculo  and ( projeto_executa.status = $status) ";
        return $sql;
    }

    function projetoTipoDatasStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $id_tipoveiculo = $obj->getId_tipo_veiculo();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) where veiculos.id_tipo = $id_tipoveiculo and projeto_executa.id_projeto = $id_projeto and  projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status)  ";
        return $sql;
    }

    function ugbStatusTodos(projetos_tarefas $obj) {
        $id_ugb = $obj->getUgb();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa`  join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where  projeto_executa.id_ugb = $id_ugb and  ( projeto_executa.status = $status)";
        return $sql;
    }

    function ugbDatasStatusTodos(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_ugb = $obj->getUgb();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa`  join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where  projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status)";
        return $sql;
    }

    function ugbVeiculoStatusTodos(projetos_tarefas $obj) {
        $id_ugb = $obj->getUgb();
        $id_veiculo = $obj->getId_veiculo();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_veiculo = $id_veiculo and projeto_executa.id_ugb = $id_ugb and ( projeto_executa.status = $status)";
        return $sql;
    }

    function ugbVeiculoDatasStatusTodos(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_ugb = $obj->getUgb();
        $id_veiculo = $obj->getId_veiculo();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_veiculo = $id_veiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status)";
        return $sql;
    }

    function ugbProjetoStatusTodos(projetos_tarefas $obj) {
        $id_ugb = $obj->getUgb();
        $id_projeto = $obj->getId_projeto();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_ugb = $id_ugb and ( projeto_executa.status = $status) ";
        return $sql;
    }

    function ugbProjetoDatasStatusTodos(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_ugb = $obj->getUgb();
        $id_projeto = $obj->getId_projeto();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_ugb = $id_ugb and  projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status) ";
        return $sql;
    }

    function ugbTipoVeiculoStatusTodos(projetos_tarefas $obj) {
        $id_tipoVeiculo = $obj->getId_tipo_veiculo();
        $id_ugb = $obj->getUgb();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where  veiculos.id_tipo = $id_tipoVeiculo and projeto_executa.id_ugb = $id_ugb and ( projeto_executa.status = $status) ";
        return $sql;
    }

    function ugbTipoVeiculoDatasStatusTodos(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_tipoVeiculo = $obj->getId_tipo_veiculo();
        $id_ugb = $obj->getUgb();
        $status = $obj->getStatus_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where  veiculos.id_tipo = $id_tipoVeiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status) ";
        return $sql;
    }

    function projetoVeiculoUgbStatusTodos(projetos_tarefas $obj) {
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $status = $obj->getStatus_projeto();
        $id_ugb = $obj->getUgb();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.id_ugb = $id_ugb  and ( projeto_executa.status = $status)";
        return $sql;
    }

    function projetoVeiculoUgbDatasStatusTodos(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $status = $obj->getStatus_projeto();
        $id_ugb = $obj->getUgb();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final'  and ( projeto_executa.status = $status)";
        return $sql;
    }

    function projetoTipoVeiculoUgbStatusTodos(projetos_tarefas $obj) {
        $id_projeto = $obj->getId_projeto();
        $id_tipoVeiculo = $obj->getId_tipo_veiculo();
        $status = $obj->getStatus_projeto();
        $id_ugb = $obj->getUgb();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and veiculos.id_tipo = $id_tipoVeiculo and projeto_executa.id_ugb = $id_ugb and ( projeto_executa.status = $status)";
        return $sql;
    }

    function projetoTipoVeiculoUgbDatasStatusTodos(projetos_tarefas $obj) {
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $id_projeto = $obj->getId_projeto();
        $id_tipoVeiculo = $obj->getId_tipo_veiculo();
        $status = $obj->getStatus_projeto();
        $id_ugb = $obj->getUgb();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) join `ugb` on (projeto_executa.id_ugb = ugb.id_ugb) where projeto_executa.id_projeto = $id_projeto and veiculos.id_tipo = $id_tipoVeiculo and projeto_executa.id_ugb = $id_ugb and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status)";
        return $sql;
    }

    function tipoVeiculoDatasStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_tipoveiculo = $obj->getId_tipo_veiculo();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) where veiculos.id_tipo = $id_tipoveiculo and  projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status)  ";
        return $sql;
    }

    function projetosVeiculosStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and ( projeto_executa.status = $status) ";
        return $sql;
    }

    function projetosVeiculosDatasStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from projeto_executa where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ( projeto_executa.status = $status) ";
        return $sql;
    }

    function projetoTipoStatusTodos(projetos_tarefas $obj) {
        $status = $obj->getStatus_projeto();
        $id_projeto = $obj->getId_projeto();
        $id_tipoveiculo = $obj->getId_tipo_veiculo();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.nome_veiculo,projeto_executa.data_inicio,projeto_executa.data_final,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `tipo_veiculo` on (veiculos.id_tipo = tipo_veiculo.id_tipo) where veiculos.id_tipo = $id_tipoveiculo and projeto_executa.id_projeto = $id_projeto and ( projeto_executa.status = $status) ";
        return $sql;
    }

}
