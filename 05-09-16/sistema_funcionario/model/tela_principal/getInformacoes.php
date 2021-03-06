<?php

class getInformacoes {

    private $id_projeto;
    private $id_projeto_executa;
    private $id_veiculo;
    private $id_tarefa;
    private $id_funcionario;
    private $duracao_tarefa;
    private $quantidade_executores;
    private $status_funcionario;

    function getStatus_funcionario() {
        return $this->status_funcionario;
    }

    function setStatus_funcionario($status_funcionario) {
        $this->status_funcionario = $status_funcionario;
    }

    function getQuantidade_executores() {
        return $this->quantidade_executores;
    }

    function setQuantidade_executores($quantidade_executores) {
        $this->quantidade_executores = $quantidade_executores;
    }

    function getDuracao_tarefa() {
        return $this->duracao_tarefa;
    }

    function setDuracao_tarefa($duracao_tarefa) {
        $this->duracao_tarefa = $duracao_tarefa;
    }

    function getId_funcionario() {
        return $this->id_funcionario;
    }

    function setId_funcionario($id_funcionario) {
        $this->id_funcionario = $id_funcionario;
    }

    function getId_projeto_executa() {
        return $this->id_projeto_executa;
    }

    function setId_projeto_executa($id_projeto_executa) {
        $this->id_projeto_executa = $id_projeto_executa;
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

    function setId_projeto($id_projeto) {
        $this->id_projeto = $id_projeto;
    }

    function setId_veiculo($id_veiculo) {
        $this->id_veiculo = $id_veiculo;
    }

    function setId_tarefa($id_tarefa) {
        $this->id_tarefa = $id_tarefa;
    }

    function pegaquantidadeexecutorestarefa($id_do_projeto_executa, $id_do_projeto, $id_do_veiculo, $id_da_tarefa) {
        $query_quantidade_executores_tarefa = "select funcionario_executa.id_funcionario FROM funcionario_executa WHERE funcionario_executa.status_funcionario_tarefa = 'ativo' and funcionario_executa.id_projeto_executa = $id_do_projeto_executa and funcionario_executa.id_projeto = $id_do_projeto and funcionario_executa.id_veiculo = $id_do_veiculo and funcionario_executa.id_tarefa = $id_da_tarefa";
        $aux_consulta_executores_tarefa = mysql_query($query_quantidade_executores_tarefa);
        return $quantidades_exe_tarefa = mysql_num_rows($aux_consulta_executores_tarefa);
    }

    function transformahoraemminuto($hora) {
        $quebraHora = explode(":", $hora); //retorna um array onde cada elemento é separado por ":"
        $minutos = $quebraHora[0];
        $minutos = $minutos * 60;
        $minutos = $minutos + $quebraHora[1];
        return $minutos;
    }

    function horadobanco() {
        $sql_hora = "SELECT DATE_FORMAT(now(),'%H:%i:%s')";
        $result_hora = mysql_query($sql_hora);
        $hora_inicio = mysql_fetch_row($result_hora);
        $horainicio_tarefa = $hora_inicio[0];
        return $horainicio_tarefa;
    }

    function pegahorasconcluidasprojeto($id_do_projeto, $id_do_veiculo) {
        $sql_horas_projeto = "select projeto_executa.horas_concluidas from projeto_executa where projeto_executa.id_projeto = $id_do_projeto and projeto_executa.id_veiculo = $id_do_veiculo and projeto_executa.status !='concluido'";
        $result_horas_concluida = mysql_query($sql_horas_projeto);
        $result_horas_concluidas = mysql_fetch_row($result_horas_concluida);
        return $horas_do_projeto = $result_horas_concluidas[0];
    }

    function pegaultimaatualizacao($id_do_projeto, $id_do_veiculo) {
        $sql_atualiza_projeto = "select projeto_executa.ultima_atualizacao from projeto_executa where projeto_executa.id_projeto = $id_do_projeto and projeto_executa.id_veiculo = $id_do_veiculo and projeto_executa.status !='concluido'";
        $result_atualiza_projeto = mysql_query($sql_atualiza_projeto);
        $result_atualiza = mysql_fetch_row($result_atualiza_projeto);
        return $atualiza_projeto = $result_atualiza[0];
    }

    function pegaduracaoprojeto($id_do_projeto, $id_do_veiculo) {
        $sql_projeto = "select projeto_executa.duracao from projeto_executa where projeto_executa.id_projeto = $id_do_projeto and projeto_executa.id_veiculo = $id_do_veiculo and projeto_executa.status !='concluido'";
        $result_duracao = mysql_query($sql_projeto);
        $duracao_projeto = mysql_fetch_row($result_duracao);
        return $duracao_do_projetos = $duracao_projeto[0];
    }

    function pegaporcentagemprojeto($id_do_projeto, $id_do_veiculo) {
        $sql_projeto_porcentagem = "select projeto_executa.porcentagem_concluida from projeto_executa where projeto_executa.id_projeto = $id_do_projeto and projeto_executa.id_veiculo = $id_do_veiculo and projeto_executa.status !='concluido'";
        $result_porcentagem = mysql_query($sql_projeto_porcentagem);
        $porcentagem_projeto = mysql_fetch_row($result_porcentagem);
        return $porcentagem_do_projetos = $porcentagem_projeto[0];
    }

    function pegahorainicialtarefa($id_do_projeto, $id_do_veiculo, $id_da_tarefa) {
        $query = "select tarefas_executa.horas_inicio from tarefas_executa where tarefas_executa.id_projeto = $id_do_projeto and tarefas_executa.id_veiculo= $id_do_veiculo and tarefas_executa.id_tarefa = $id_da_tarefa and tarefas_executa.conclusao_projeto = 'nao concluido'";
        $aux_consulta = mysql_query($query);
        $hora_inicial_tarefa = mysql_fetch_row($aux_consulta);
        return $hora_inicial_da_tarefa = $hora_inicial_tarefa[0];
    }

    function calculadiferencaentrehoras($inicio, $fim) {
        $hora_inicio = DateTime::createFromFormat('H:i:s', $inicio);
        $horai_fim = DateTime::createFromFormat('H:i:s', $fim);
        $intervalo_entre_horas = $hora_inicio->diff($horai_fim);
        return $intervalo_horas = $intervalo_entre_horas->format('%H:%I:%S');
    }

    function pegaporcentagemconcluidatarefa($id_do_projeto, $id_do_veiculo, $id_da_tarefa) {
        $query_porcentagem_tarefa = "select tarefas_executa.porcentagem_concluida from tarefas_executa where tarefas_executa.id_projeto = $id_do_projeto and tarefas_executa.id_veiculo=$id_do_veiculo and tarefas_executa.id_tarefa = $id_da_tarefa and tarefas_executa.conclusao_projeto = 'nao concluido'";
        $aux_porcentagem_tarefa = mysql_query($query_porcentagem_tarefa);
        $porcentagem_conluida_tarefa = mysql_fetch_row($aux_porcentagem_tarefa);
        return $porcentagem_da_tarefa = $porcentagem_conluida_tarefa[0];
    }

    function pegastatustarefa($id_do_projeto, $id_do_veiculo, $id_da_tarefa) {
        $query_status_tarefa = "select tarefas_executa.status from tarefas_executa where tarefas_executa.id_projeto = $id_do_projeto and tarefas_executa.id_veiculo=$id_do_veiculo and tarefas_executa.id_tarefa = $id_da_tarefa and tarefas_executa.conclusao_projeto = 'nao concluido'";
        $aux_status_tarefa = mysql_query($query_status_tarefa);
        $status_tarefa = mysql_fetch_row($aux_status_tarefa);
        return $status_da_tarefa = $status_tarefa[0];
    }

    function pegahorasconluidatarefa($id_do_projeto, $id_do_veiculo, $id_da_tarefa) {
        $query_horas_concluida_tarefa = "select tarefas_executa.horas_concluidas from tarefas_executa where tarefas_executa.id_projeto = $id_do_projeto and tarefas_executa.id_veiculo= $id_do_veiculo and tarefas_executa.id_tarefa = $id_da_tarefa and tarefas_executa.conclusao_projeto = 'nao concluido'";
        $aux_concluidas_horas_tarefa = mysql_query($query_horas_concluida_tarefa);
        $horass_conluida_tarefas = mysql_fetch_row($aux_concluidas_horas_tarefa);
        return $tempo_concluido_da_tarefa = $horass_conluida_tarefas[0];
    }

    function pegahorasconluidofuncionario($id_do_projeto, $id_do_veiculo, $id_da_tarefa, $id_do_funcionario) {
        $query_horas_concluida_funcionario = "select funcionario_executa.horas_concluidas from funcionario_executa where funcionario_executa.id_projeto = $id_do_projeto and funcionario_executa.id_veiculo = $id_do_veiculo and funcionario_executa.id_tarefa = $id_da_tarefa and funcionario_executa.id_funcionario=$id_do_funcionario and funcionario_executa.status_funcionario_tarefa = 'ativo'";
        $aux_concluidas_horas_tarefa = mysql_query($query_horas_concluida_funcionario);
        $horass_conluida_funcionario = mysql_fetch_row($aux_concluidas_horas_tarefa);
        return $tempo_concluido_do_funcionario = $horass_conluida_funcionario[0];
    }

    function pegaidprojetofuncionario($id_do_funcionario) {
        $query_id_projeto = "select funcionario_executa.id_projeto from funcionario_executa where funcionario_executa.id_funcionario = $id_do_funcionario and funcionario_executa.status_funcionario_tarefa = 'ativo'";
        $aux_id_projeto_funcionario_tarefa = mysql_query($query_id_projeto);
        $funcionario_id_projeto = mysql_fetch_row($aux_id_projeto_funcionario_tarefa);
        return $id_projeto_funcionario_tarefa = $funcionario_id_projeto[0];
    }

    function pegaidveiculofuncionario($id_do_funcionario) {
        $query_id_veiculo = "select funcionario_executa.id_veiculo from funcionario_executa where funcionario_executa.id_funcionario = $id_do_funcionario and funcionario_executa.status_funcionario_tarefa = 'ativo'";
        $aux_id_veiculo_funcionario_tarefa = mysql_query($query_id_veiculo);
        $funcionario_id_veiculo = mysql_fetch_row($aux_id_veiculo_funcionario_tarefa);
        return $id_veiculo_funcionario_tarefa = $funcionario_id_veiculo[0];
    }

    function pegaidtarefafuncionario($id_do_funcionario) {
        $query_id_tarefa = "select funcionario_executa.id_tarefa from funcionario_executa where funcionario_executa.id_funcionario = $id_do_funcionario and funcionario_executa.status_funcionario_tarefa = 'ativo'";
        $aux_id_tarefa_funcionario_tarefa = mysql_query($query_id_tarefa);
        $funcionario_id_tarefa = mysql_fetch_row($aux_id_tarefa_funcionario_tarefa);
        return $id_tarefa_funcionario_tarefa = $funcionario_id_tarefa[0];
    }

    function pegaflagtarefasabertas($id_do_projeto, $id_do_veiculo, $id_do_funcionario) {
        $flag_tarefa_aberta = "select funcionario_executa.flag_tarefa_aberta from funcionario_executa where funcionario_executa.id_projeto = $id_do_projeto and funcionario_executa.id_veiculo = $id_do_veiculo  and funcionario_executa.id_funcionario=$id_do_funcionario and funcionario_executa.status_funcionario_tarefa = 'ativo'";
        $aux_flag_tarefa_aberta = mysql_query($flag_tarefa_aberta);
        $flag_tarefa = mysql_fetch_row($aux_flag_tarefa_aberta);
        return $flga_da_tarefa = $flag_tarefa[0];
    }

    function pegaflagtipotarefa($id_do_projeto, $id_do_veiculo, $id_da_tarefa) {
        $flag_tipo_tarefa = "select tarefas_executa.tipo_tarefa from tarefas_executa where tarefas_executa.id_projeto = $id_do_projeto and tarefas_executa.id_veiculo = $id_do_veiculo  and tarefas_executa.id_tarefa= $id_da_tarefa and tarefas_executa.status != 'concluida'";
        $aux_flag_tipo_tarefa = mysql_query($flag_tipo_tarefa);
        $flag_tarefa_tipo = mysql_fetch_row($aux_flag_tipo_tarefa);
        return $flga_do_tipo_tarefa = $flag_tarefa_tipo[0];
    }

    function pegahorasconluidastarefas($id_do_projeto, $id_do_veiculo) {
        $array = array();
        $query_tarefas = "select tarefas_executa.horas_concluidas from tarefas_executa where tarefas_executa.id_projeto=$id_do_projeto and tarefas_executa.id_veiculo = $id_do_veiculo and (tarefas_executa.status ='open' or tarefas_executa.status ='pause' or tarefas_executa.status = 'concluida') and tarefas_executa.conclusao_projeto = 'nao concluido'";
        $aux_horas_tarefas = mysql_query($query_tarefas);
        while ($aux_horas = mysql_fetch_array($aux_horas_tarefas)) {
            $horas_tarefas = $aux_horas['horas_concluidas'];
            $array[] = $horas_tarefas;
        }
        return $array;
    }

    function preenchearrayparavariosexecutores($time_tarefas, $x) {
        $array_executores = array();
        for ($i = 0; $i < $x; $i++) {
            $array_executores[] = $time_tarefas;
        }
        return $array_executores;
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

    function transformarminutosemhoras($mins) {
        if ($mins < 0)
            $min = abs($mins);
        else
            $min = $mins;
        $h = floor($min / 60);
        $m = ($min - ($h * 60)) / 100;
        $horas = $h + $m;
        if ($mins < 0)
            $horas *= -1;
        $sep = explode('.', $horas);
        $h = $sep[0];
        if (empty($sep[1]))
            $sep[1] = 00;
        $m = $sep[1];
        if (strlen($m) < 2)
            $m = $m . 0;
        return sprintf('%02d:%02d:00', $h, $m);
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

    function atualiza_tarefa_nao_liberada(getInformacoes $obj) {
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $id_funcionario = $obj->getId_funcionario();
        $id_tarefa = $obj->getId_tarefa();
        $duracao_tarefa = $obj->getDuracao_tarefa();
        $hora_atual_do_banco = $this->horadobanco();
        $hora_inicio_da_tarefa = $this->pegahorainicialtarefa($id_projeto, $id_veiculo, $id_tarefa);
        $horas_concluidas_do_banco = $this->pegahorasconluidatarefa($id_projeto, $id_veiculo, $id_tarefa);
        $hora_inicial = DateTime::createFromFormat('H:i:s', $hora_inicio_da_tarefa);
        $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $hora_atual_do_banco);
        $intervalo = $hora_inicial->diff($horainicio_da_tarefas);
        $hora_concluidas = $intervalo->format('%H:%I:%S');
        $array_tempo = array($hora_concluidas, $horas_concluidas_do_banco);
        $tempo_somado = $this->somarhoras($array_tempo);
        $hora_inicial_intervalo = DateTime::createFromFormat('H:i:s', $tempo_somado);
        $hora_final = DateTime::createFromFormat('H:i:s', $duracao_tarefa);
        $intervalo_entre_duracao_horasconcluida = $hora_inicial_intervalo->diff($hora_final);
        $duracao_restante = $intervalo_entre_duracao_horasconcluida->format('%H:%I:%S');
        $hora_ja_concluida = $this->transformahoraemminuto($tempo_somado);
        $duracao_geral_tarefa = $this->transformahoraemminuto($duracao_tarefa);
        $pintadiv = $hora_ja_concluida / $duracao_geral_tarefa;
        $porcentagem_concluida = $pintadiv * 100;
        $tamanho = $pintadiv * 100 . "%";
        $conexao_select = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        mysqli_autocommit($conexao_select, FALSE);
        $erro_da_query_tarefa = 0;
        $atualiza_tarefa_horas_concluidas = "UPDATE tarefas_executa SET horas_concluidas = '$tempo_somado',horas_inicio='$hora_atual_do_banco',horas_restante = '$duracao_restante', porcentagem_concluida = '$porcentagem_concluida' where tarefas_executa.id_projeto = $id_projeto and tarefas_executa.id_veiculo= $id_veiculo and tarefas_executa.id_tarefa = $id_tarefa and tarefas_executa.conclusao_projeto = 'nao concluido'";
        if (!mysqli_query($conexao_select, $atualiza_tarefa_horas_concluidas)) {

            $erro_da_query_tarefa++;
        }

        $horas_concluidas_funcionario = $this->pegahorasconluidofuncionario($id_projeto, $id_veiculo, $id_tarefa, $id_funcionario);
        $array_tempo_funcionario = array($hora_concluidas, $horas_concluidas_funcionario);
        $tempo_somado_funcionario = $this->somarhoras($array_tempo_funcionario);
        $atualiza_funcionario_executa = "UPDATE funcionario_executa SET horas_concluidas = '$tempo_somado_funcionario' where funcionario_executa.id_projeto = $id_projeto and funcionario_executa.id_veiculo= $id_veiculo and funcionario_executa.id_tarefa = $id_tarefa and funcionario_executa.id_funcionario=$id_funcionario and funcionario_executa.status_funcionario_tarefa = 'ativo' and funcionario_executa.status_tarefa != 'concluida' and funcionario_executa.status_tarefa != 'pause'";
        if (!mysqli_query($conexao_select, $atualiza_funcionario_executa)) {
            $erro_da_query_tarefa++;
        }
        $horas_das_tarefas = $this->pegahorasconluidastarefas($id_projeto, $id_veiculo);
        $horas_conluidas_das_tarefas = $this->somarhoras($horas_das_tarefas);
        $aux_da_porcentagem_projeto = $this->transformahoraemminuto($horas_conluidas_das_tarefas);
        $horas_concluidas_projeto = $this->pegahorasconcluidasprojeto($id_projeto, $id_veiculo);
        $horas_concluidas_projeto_minutos = $this->transformahoraemminuto($horas_concluidas_projeto);
        $atualiza_projeto_executa = "UPDATE projeto_executa SET horas_concluidas = '$horas_conluidas_das_tarefas',ultima_atualizacao = '$hora_atual_do_banco' where projeto_executa.id_projeto=$id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.status != 'concluido'";
        if (!mysqli_query($conexao_select, $atualiza_projeto_executa)) {
            $erro_da_query_tarefa++;
        }
        $duracao_do_projeto = $this->pegaduracaoprojeto($id_projeto, $id_veiculo);
        $duracao_do_projeto_minutos = $this->transformahoraemminuto($duracao_do_projeto);
        $porcentagem_do_projeto_concluida = $aux_da_porcentagem_projeto / $duracao_do_projeto_minutos * 100 . "%";
        $atualiza_porcentagem_projeto = "UPDATE projeto_executa SET porcentagem_concluida = '$porcentagem_do_projeto_concluida' where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.status != 'concluido' ";
        if (!mysqli_query($conexao_select, $atualiza_porcentagem_projeto)) {
            $erro_da_query_tarefa++;
        }

        if ($erro_da_query_tarefa == 0) {
            mysqli_commit($conexao_select);
            return $tamanho;
        } else {
            mysqli_rollback($conexao_select);
        }
    }

    function atualiza_tarefa_nao_liberada_com_varios_executores(getInformacoes $obj) {
        $id_projeto = $obj->getId_projeto();
        $id_veiculo = $obj->getId_veiculo();
        $id_tarefa = $obj->getId_tarefa();
        $duracao_tarefa = $obj->getDuracao_tarefa();
        $quantidade_de_executores = $obj->getQuantidade_executores();
        $horainicio_da_tarefa_2 = $this->horadobanco();
        $hora_inicio_da_tarefa_2 = $this->pegahorainicialtarefa($id_projeto, $id_veiculo, $id_tarefa);
        $horas_concluidas_do_banco_2 = $this->pegahorasconluidatarefa($id_projeto, $id_veiculo, $id_tarefa);
        $hora_inicial_2 = DateTime::createFromFormat('H:i:s', $hora_inicio_da_tarefa_2);
        $horainicio_da_tarefas_2 = DateTime::createFromFormat('H:i:s', $horainicio_da_tarefa_2);
        $intervalo_2 = $hora_inicial_2->diff($horainicio_da_tarefas_2);
        $hora_concluidas_2 = $intervalo_2->format('%H:%I:%S');
        $array_preenchido = $this->preenchearrayparavariosexecutores($hora_concluidas_2, $quantidade_de_executores);
        $horas_feitas_da_tarefa = $this->somarhoras($array_preenchido);
        $array_tempo_2 = array($horas_feitas_da_tarefa, $horas_concluidas_do_banco_2);
        $tempo_somado_2 = $this->somarhoras($array_tempo_2);
        $hora_inicial_intervalo_2 = DateTime::createFromFormat('H:i:s', $tempo_somado_2);
        $hora_final_2 = DateTime::createFromFormat('H:i:s', $duracao_tarefa);
        $intervalo_entre_duracao_horasconcluida_2 = $hora_inicial_intervalo_2->diff($hora_final_2);
        $duracao_restante_2 = $intervalo_entre_duracao_horasconcluida_2->format('%H:%I:%S');
        $hora_ja_concluida_2 = $this->transformahoraemminuto($tempo_somado_2);
        $duracao_geral_tarefa_2 = $this->transformahoraemminuto($duracao_tarefa);
        $pintadiv_2 = $hora_ja_concluida_2 / $duracao_geral_tarefa_2;
        $porcentagem_concluida_2 = $pintadiv_2 * 100;
        $tamanho = $pintadiv_2 * 100 . "%";
        $conexao_select_tarefa = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        mysqli_autocommit($conexao_select_tarefa, FALSE);
        $erro_finaliza_set_horas = 0;
        $array_set_horas_funcionario = array();
        $array_do_total_horas_tarefas = array();
        $sql_set_horas = "select funcionario_executa.horas_concluidas,funcionario_executa.id_funcionario,funcionario_executa.id_projeto_executa from funcionario_executa where funcionario_executa.id_projeto = '$id_projeto' and funcionario_executa.id_veiculo = '$id_veiculo' and funcionario_executa.id_tarefa = '$id_tarefa' and funcionario_executa.status_funcionario_tarefa = 'ativo' and funcionario_executa.status_tarefa = 'open'";
        $result_set_horas = mysql_query($sql_set_horas);
        while ($aux_set_horas = mysql_fetch_array($result_set_horas)) {
            $id_executa = $aux_set_horas['id_projeto_executa'];
            $ids_dos_funcionarios = $aux_set_horas['id_funcionario'];
            $horas_concluidas_do_funcionario = $aux_set_horas['horas_concluidas'];
            $array_set_horas_funcionario[] = $hora_concluidas_2;
            $array_set_horas_funcionario[] = $horas_concluidas_do_funcionario;
            $array_das_horas_do_funcionario = array($hora_concluidas_2, $horas_concluidas_do_funcionario);
            $hora_somada_do_funcionario = $this->somarhoras($array_das_horas_do_funcionario);
            $set_horas_funcionario = "UPDATE funcionario_executa SET horas_concluidas = '$hora_somada_do_funcionario' where funcionario_executa.id_projeto = '$id_projeto' and funcionario_executa.id_veiculo= '$id_veiculo' and funcionario_executa.id_tarefa = '$id_tarefa' and funcionario_executa.id_funcionario='$ids_dos_funcionarios' and funcionario_executa.status_funcionario_tarefa = 'ativo' and funcionario_executa.status_tarefa != 'concluida' and funcionario_executa.status_tarefa != 'pause'";
            if (!mysqli_query($conexao_select_tarefa, $set_horas_funcionario)) {
                $erro_finaliza_set_horas++;
            }
            if ($erro_finaliza_set_horas == 0) {
                mysqli_commit($conexao_select_tarefa);
            } else {
                mysqli_rollback($conexao_select_tarefa);
            }
            unset($array_set_horas_funcionario);
        }

        $sql_duracao_da_tarefa = "select funcionario_executa.horas_concluidas from funcionario_executa where funcionario_executa.id_projeto_executa = $id_executa and funcionario_executa.id_tarefa = $id_tarefa and funcionario_executa.id_veiculo = $id_veiculo ";
        $result_da_duracao = mysql_query($sql_duracao_da_tarefa);
        while ($aux_da_duracao = mysql_fetch_array($result_da_duracao)) {
            $horas_concluidas_por_funcionario = $aux_da_duracao['horas_concluidas'];
            $array_do_total_horas_tarefas[] = ($horas_concluidas_por_funcionario);
        }
        $tempo_da_tarefa = $this->somarhoras($array_do_total_horas_tarefas);
        $conexao_select = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        mysqli_autocommit($conexao_select, FALSE);
        $erro_finaliza = 0;
        $atualiza_tarefa_horas = "UPDATE tarefas_executa SET horas_concluidas = '$tempo_da_tarefa',horas_inicio='$horainicio_da_tarefa_2',horas_restante = '$duracao_restante_2', porcentagem_concluida = '$porcentagem_concluida_2' where tarefas_executa.id_projeto = $id_projeto and tarefas_executa.id_veiculo= $id_veiculo and tarefas_executa.id_tarefa = $id_tarefa and tarefas_executa.conclusao_projeto = 'nao concluido'";
        if (!mysqli_query($conexao_select, $atualiza_tarefa_horas)) {
            $erro_finaliza++;
        }
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $horas_das_tarefas_2 = $this->pegahorasconluidastarefas($id_projeto, $id_veiculo);
        $horas_conluidas_das_tarefas_2 = $this->somarhoras($horas_das_tarefas_2);
        $aux_da_porcentagem_projeto_2 = $this->transformahoraemminuto($horas_conluidas_das_tarefas_2);
        $horas_concluidas_projeto_2 = $this->pegahorasconcluidasprojeto($id_projeto, $id_veiculo);
        $horas_concluidas_projeto_minutos_2 = $this->transformahoraemminuto($horas_concluidas_projeto_2);
        $atualiza_projeto_horas = "UPDATE projeto_executa SET horas_concluidas = '$horas_conluidas_das_tarefas_2',ultima_atualizacao = '$horainicio_da_tarefa_2' where projeto_executa.id_projeto=$id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.status != 'concluido'";
        if (!mysqli_query($conexao_select, $atualiza_projeto_horas)) {
            $erro_finaliza++;
        }
        $duracao_do_projeto_2 = $this->pegaduracaoprojeto($id_projeto, $id_veiculo);
        $duracao_do_projeto_minutos_2 = $this->transformahoraemminuto($duracao_do_projeto_2);
        $porcentagem_do_projeto_concluida_2 = $aux_da_porcentagem_projeto_2 / $duracao_do_projeto_minutos_2 * 100 . "%";
        $atualiza_porcentagem_do_projeto = "UPDATE projeto_executa SET porcentagem_concluida = '$porcentagem_do_projeto_concluida_2' where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.status != 'concluido' ";
        if (!mysqli_query($conexao_select, $atualiza_porcentagem_do_projeto)) {
            $erro_finaliza++;
        }

        if ($erro_finaliza == 0) {
            mysqli_commit($conexao_select);
            return $tamanho;
        } else {
            mysqli_rollback($conexao_select);
        }
    }

    function getNomeVeiculo($id_executa) {
        $sql_nome_veiculo = "select projeto_executa.nome_veiculo from projeto_executa where projeto_executa.id_projeto_executa = $id_executa";
        $result_nome_veiculo = mysql_query($sql_nome_veiculo);
        $nome_veiculo = mysql_fetch_row($result_nome_veiculo);
        return $veiculo = $nome_veiculo[0];
    }

    function exibeTarefas(getInformacoes $obj) {
        $id_projeto = $obj->getId_projeto();
        $id_projeto_executa = $obj->getId_projeto_executa();
        $id_veiculo = $obj->getId_veiculo();
        $id_funcionario = $obj->getId_funcionario();
        $status_funcionario = $obj->getStatus_funcionario();
        ?>
        <table class="table table-hover" id="tabela_tarefas" style="width: 100%;">
            <tr style="height: 80px;  font-size:1.5em;">
                <td colspan="4"><?php echo $nome_veiculo = $this->getNomeVeiculo($id_projeto_executa); ?></td>
            </tr>
            <?php
            $sql = "select tarefas_projeto.id_tarefa from tarefas_projeto where tarefas_projeto.id_projeto = $id_projeto";
            $result = mysql_query($sql);
            while ($tarefas_informacao = mysql_fetch_array($result)) {
                $id_tarefa = $tarefas_informacao['id_tarefa'];
                $sql_juncao = "select tarefas.nome,tarefas.duracao from tarefas where tarefas.id_tarefa = $id_tarefa";
                $result_juncao = mysql_query($sql_juncao);
                while ($informacao_tarefas = mysql_fetch_array($result_juncao)) {
                    $nome_tarefa = $informacao_tarefas['nome'];
                    $duracao_tarefa = $informacao_tarefas['duracao'];
                    $horas_concluidas_tarefa = $this->pegahorasconluidatarefa($id_projeto, $id_veiculo, $id_tarefa);
                    $status_tarefa = $this->pegastatustarefa($id_projeto, $id_veiculo, $id_tarefa);

                    if ($status_tarefa == "notopen") {
                        ?>
                        <tr style="height: 80px;">
                            <td class="col-md-3 col-sm-3 col-xs-3" id="primeira_coluna"><?php echo $nome_tarefa ?></td>
                            <td class="col-md-5 col-sm-5 col-xs-5" id="segunda_coluna" style="height: 60px; margin:auto;" ><span style="font-size:1.5em; color:black;">Não Iniciada</span></td>
                            <td class="col-md-1 col-sm-1 col-xs-1" id="terceira_coluna"><span style="font-size:1.5em; color:black;"><?php echo $duracao_tarefa; ?></span></td>
                            <td class="col-md-3 col-sm-3 col-xs-3" id="quarta_coluna" style="margin: auto;">
                                <div class="col-md-4 col-sm-4 col-xs-4"  ><a href="" onclick="inicia_tarefa('<?php echo $status_funcionario ?>', '<?php echo $id_projeto_executa ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>')"><img src="../img/1430175909_StepForwardHot.png" ></a></div>
                                <div class="col-md-4 col-sm-4 col-xs-4"   ><a href="" onClick="alert('Tarefa ainda nao foi Iniciada!');"><img src="../img/1430175773_PauseHot.png" ></a></div>
                                <div class="col-md-4 col-sm-4 col-xs-4"   ><a href="" onClick="alert('Tarefa ainda nao foi Iniciada!');"><img src="../img/1430175354_Stop1Pressed.png" ></a></div>
                            </td>
                        </tr>
                        <?php
                    } else if ($status_tarefa == "open") {
                        $id_projeto_funcionario_ativo = $this->pegaidprojetofuncionario($id_funcionario);
                        $id_veiculo_funcionario_ativo = $this->pegaidveiculofuncionario($id_funcionario);
                        $id_tarefa_funcionario_ativo = $this->pegaidtarefafuncionario($id_funcionario);
                        $hora_atual = $this->horadobanco();
                        $dia_semana = $this->diaSemana(date('Y-m-d'));
                        if ($dia_semana == "Sexta-Feira") {
                            if ($hora_atual > "07:00:00" && $hora_atual < "07:00:20") {
                                ?>
                                <script>
                                    pausa_tarefa_automatica('<?php echo $status_funcionario ?>', '<?php echo $status_tarefa ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_projeto_executa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>');
                                </script> 
                                <?php
                            }else if ($hora_atual > "11:00:00" && $hora_atual < "11:00:20") {
                                ?>
                                <script>
                                    pausa_tarefa_automatica('<?php echo $status_funcionario ?>', '<?php echo $status_tarefa ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_projeto_executa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>');
                                </script> 
                                <?php
                            }else if ($hora_atual > "12:00:00" && $hora_atual < "12:00:20") {
                                ?>
                                <script>
                                    pausa_tarefa_automatica('<?php echo $status_funcionario ?>', '<?php echo $status_tarefa ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_projeto_executa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>');
                                </script> 
                                <?php
                            } else if ($hora_atual > "16:00:00" && $hora_atual < "16:00:20") {
                                ?>
                                <script>
                                    pausa_tarefa_automatica('<?php echo $status_funcionario ?>', '<?php echo $status_tarefa ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_projeto_executa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>');
                                </script> 
                                <?php
                            }
                        } else {
                            if ($hora_atual > "07:00:00" && $hora_atual < "07:00:20") {
                                ?>
                                <script>
                                    pausa_tarefa_automatica('<?php echo $status_funcionario ?>', '<?php echo $status_tarefa ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_projeto_executa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>');
                                </script> 
                                <?php
                            } else if ($hora_atual > "11:00:00" && $hora_atual < "11:00:20") {
                                ?>
                                <script>
                                    pausa_tarefa_automatica('<?php echo $status_funcionario ?>', '<?php echo $status_tarefa ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_projeto_executa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>');
                                </script> 
                                <?php
                            } else if ($hora_atual > "12:00:00" && $hora_atual < "12:00:20") {
                                ?>
                                <script>
                                    pausa_tarefa_automatica('<?php echo $status_funcionario ?>', '<?php echo $status_tarefa ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_projeto_executa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>');
                                </script> 
                                <?php
                            } else if ($hora_atual > "17:00:00" && $hora_atual < "17:00:20") {
                                ?>
                                <script>
                                    pausa_tarefa_automatica('<?php echo $status_funcionario ?>', '<?php echo $status_tarefa ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_projeto_executa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>');
                                </script> 
                                <?php
                            }
                        }
                        ?>
                        <tr style="height: 80px;">
                            <td class="col-md-3 col-sm-3 col-xs-3" id="primeira_coluna"><?php echo $nome_tarefa ?></td>
                            <?php
                            $tipo_tarefa = $this->pegaflagtipotarefa($id_projeto, $id_veiculo, $id_tarefa);
                            if ($tipo_tarefa == "liberada") {
                                $quantidade_de_executores_da_tarefa = $this->pegaquantidadeexecutorestarefa($id_projeto_executa, $id_projeto, $id_veiculo, $id_tarefa);
                                if ($quantidade_de_executores_da_tarefa == 1) {
                                    if ($id_projeto_funcionario_ativo == $id_projeto && $id_veiculo_funcionario_ativo == $id_veiculo && $id_tarefa_funcionario_ativo == $id_tarefa) {
                                        $duracao_parcial = date('H:i:s', strtotime('+60 minute', strtotime($horas_concluidas_tarefa)));
                                        $atualiza_tarefa = new getInformacoes();
                                        $atualiza_tarefa->setId_projeto($id_projeto);
                                        $atualiza_tarefa->setId_veiculo($id_veiculo);
                                        $atualiza_tarefa->setId_funcionario($id_funcionario);
                                        $atualiza_tarefa->setId_tarefa($id_tarefa);
                                        $atualiza_tarefa->setDuracao_tarefa($duracao_parcial);
                                        $tamanho = $this->atualiza_tarefa_nao_liberada($atualiza_tarefa);
                                    } else {
                                        $tamanho = $this->pegaporcentagemconcluidatarefa($id_projeto, $id_veiculo, $id_tarefa) . "%";
                                    }
                                } else {
                                    if ($id_projeto_funcionario_ativo == $id_projeto && $id_veiculo_funcionario_ativo == $id_veiculo && $id_tarefa_funcionario_ativo == $id_tarefa) {
                                        $duracao_parcial = date('H:i:s', strtotime('+60 minute', strtotime($horas_concluidas_tarefa)));
                                        $atualiza_tarefa_com_varios_executores = new getInformacoes();
                                        $atualiza_tarefa_com_varios_executores->setId_projeto($id_projeto);
                                        $atualiza_tarefa_com_varios_executores->setId_veiculo($id_veiculo);
                                        $atualiza_tarefa_com_varios_executores->setId_tarefa($id_tarefa);
                                        $atualiza_tarefa_com_varios_executores->setDuracao_tarefa($duracao_parcial);
                                        $atualiza_tarefa_com_varios_executores->setQuantidade_executores($quantidade_de_executores_da_tarefa);
                                        $tamanho = $this->atualiza_tarefa_nao_liberada_com_varios_executores($atualiza_tarefa_com_varios_executores);
                                    } else {
                                        $tamanho = $this->pegaporcentagemconcluidatarefa($id_projeto, $id_veiculo, $id_tarefa) . "%";
                                    }
                                }
                                if ($tamanho > 100) {
                                    ?> 
                                    <td class="col-md-5 col-sm-5 col-xs-5" id="segunda_coluna">
                                        <div class="progress progress-striped active" class="progress" style="height: 60px; margin:auto;" >                                     
                                            <div class="progress" style="height: 60px; margin:auto;" >
                                                <div class="progress-bar  progress-bar-info"aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 90%" >
                                                    <div style="margin-top:20px; "><span style="font-size:2em; color:black; "><?php echo $horas_concluidas_tarefa; ?></span></div>
                                                </div>
                                                <div class="progress-bar progress-bar-danger" role="progressbar" style="width:10%"></div>
                                            </div> 
                                        </div>  
                                    </td>

                                    <?php
                                    unset($tamanho);
                                    unset($atualiza_tarefa);
                                } else {
                                    ?>
                                    <td class="col-md-5 col-sm-5 col-xs-5" id="segunda_coluna">
                                        <div class="progress progress-striped active" class="progress" style="height: 60px; margin:auto;" >                                     
                                            <div class="progress" style="height: 60px; margin:auto;" >
                                                <div class="progress-bar  progress-bar-info"aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $tamanho ?>" >
                                                    <div style="margin-top:20px;"><span style="font-size:2em; color:black;"><?php echo $horas_concluidas_tarefa ?></span></div>
                                                </div>
                                            </div>
                                        </div>  
                                    </td>
                                    <?php
                                }
                                ?>
                                <td class="col-md-1 col-sm-1 col-xs-1" id="terceira_coluna" ><span style="font-size:1.5em; color:black; "><?php echo $duracao_tarefa; ?></span></td>
                                <td class="col-md-3 col-sm-3 col-xs-3" id="quarta_coluna" style="margin: auto;">
                                    <div class="col-md-4 col-sm-4 col-xs-4" ><a href="" onclick="reabre_tarefa('<?php echo $status_funcionario ?>', '<?php echo $status_tarefa ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_projeto_executa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>');"><img src="../img/1430175909_StepForwardHot.png" ></a></div>
                                    <div class="col-md-4 col-sm-4 col-xs-4" ><a href="" onclick="pausa_tarefa('<?php echo $status_funcionario ?>', '<?php echo $status_tarefa ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_projeto_executa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>');"><img src="../img/1430175773_PauseHot.png" ></a></div>
                                    <?php
                                    if ($quantidade_de_executores_da_tarefa == 1) {
                                        ?>
                                        <div class="col-md-4 col-sm-4 col-xs-4" ><a href="#" onclick="finaliza_tarefa_liberada('<?php echo $status_funcionario ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_projeto_executa ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>', '<?php echo $quantidade_de_executores_da_tarefa ?>');" ><img src="../img/1430175354_Stop1Pressed.png" ></a></div>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="col-md-4 col-sm-4 col-xs-4" ><a href="" onclick="finaliza_tarefa_liberada('<?php echo $status_funcionario ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_projeto_executa ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>', '<?php echo $quantidade_de_executores_da_tarefa ?>');" ><img src="../img/1430175354_Stop1Pressed.png" ></a></div>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        } else if ($tipo_tarefa == "nao liberada") {

                            $quantidade_de_executores_da_tarefa = $this->pegaquantidadeexecutorestarefa($id_projeto_executa, $id_projeto, $id_veiculo, $id_tarefa);
                            if ($quantidade_de_executores_da_tarefa == 1) {

                                if ($id_projeto_funcionario_ativo == $id_projeto && $id_veiculo_funcionario_ativo == $id_veiculo && $id_tarefa_funcionario_ativo == $id_tarefa) {
                                    $atualiza_tarefa = new getInformacoes();
                                    $atualiza_tarefa->setId_projeto($id_projeto);
                                    $atualiza_tarefa->setId_veiculo($id_veiculo);
                                    $atualiza_tarefa->setId_funcionario($id_funcionario);
                                    $atualiza_tarefa->setId_tarefa($id_tarefa);
                                    $atualiza_tarefa->setDuracao_tarefa($duracao_tarefa);
                                    $tamanho = $this->atualiza_tarefa_nao_liberada($atualiza_tarefa);
                                } else {
                                    $tamanho = $this->pegaporcentagemconcluidatarefa($id_projeto, $id_veiculo, $id_tarefa) . "%";
                                }
                            } else {

                                if ($id_projeto_funcionario_ativo == $id_projeto && $id_veiculo_funcionario_ativo == $id_veiculo && $id_tarefa_funcionario_ativo == $id_tarefa) {

                                    $atualiza_tarefa_com_varios_executores = new getInformacoes();
                                    $atualiza_tarefa_com_varios_executores->setId_projeto($id_projeto);
                                    $atualiza_tarefa_com_varios_executores->setId_veiculo($id_veiculo);
                                    $atualiza_tarefa_com_varios_executores->setId_tarefa($id_tarefa);
                                    $atualiza_tarefa_com_varios_executores->setDuracao_tarefa($duracao_tarefa);
                                    $atualiza_tarefa_com_varios_executores->setQuantidade_executores($quantidade_de_executores_da_tarefa);
                                    $tamanho = $this->atualiza_tarefa_nao_liberada_com_varios_executores($atualiza_tarefa_com_varios_executores);
                                } else {
                                    $tamanho = $this->pegaporcentagemconcluidatarefa($id_projeto, $id_veiculo, $id_tarefa) . "%";
                                }
                            }
                            if ($tamanho > 100) {
                                ?> 
                                <td class="col-md-5 col-sm-5 col-xs-5" id="segunda_coluna">
                                    <div class="progress progress-striped active" class="progress" style="height: 60px; margin:auto;" >                                     
                                        <div class="progress" style="height: 60px; margin:auto;" >
                                            <div class="progress-bar  progress-bar-info"aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 90%" >
                                                <div style="margin-top:20px; "><span style="font-size:2em; color:black; "><?php echo $horas_concluidas_tarefa; ?></span></div>
                                            </div>
                                            <div class="progress-bar progress-bar-danger" role="progressbar" style="width:10%"></div>
                                        </div> 
                                    </div>  
                                </td>

                                <?php
                                unset($tamanho);
                                unset($atualiza_tarefa);
                            } else {
                                ?>
                                <td class="col-md-5 col-sm-5 col-xs-5" id="segunda_coluna">
                                    <div class="progress progress-striped active" class="progress" style="height: 60px; margin:auto;" >                                     
                                        <div class="progress" style="height: 60px; margin:auto;" >
                                            <div class="progress-bar  progress-bar-info"aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $tamanho ?>" >
                                                <div style="margin-top:20px;"><span style="font-size:2em; color:black;"><?php echo $horas_concluidas_tarefa; ?></span></div>
                                            </div>
                                        </div>
                                    </div>  
                                </td>
                                <?php
                            }
                            ?>
                            <td class="col-md-1 col-sm-1 col-xs-1" id="terceira_coluna" ><span style="font-size:1.5em; color:black; "><?php echo $duracao_tarefa; ?></span></td>
                            <td class="col-md-3 col-sm-3 col-xs-3" id="quarta_coluna" style="margin: auto;">
                                <div class="col-md-4 col-sm-4 col-xs-4" ><a href="" onclick="reabre_tarefa('<?php echo $status_funcionario ?>', '<?php echo $status_tarefa ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_projeto_executa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>')"><img src="../img/1430175909_StepForwardHot.png" ></a></div>
                                <div class="col-md-4 col-sm-4 col-xs-4" ><a href="" onclick="pausa_tarefa('<?php echo $status_funcionario ?>', '<?php echo $status_tarefa ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_projeto_executa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>');"><img src="../img/1430175773_PauseHot.png" ></a></div>
                                <div class="col-md-4 col-sm-4 col-xs-4" ><a href="" onclick="finaliza_tarefa('<?php echo $status_tarefa ?>', '<?php echo $id_projeto_executa ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>')"><img src="../img/1430175354_Stop1Pressed.png" ></a></div>
                            </td>
                        </tr>
                        <?php
                    }
                } else if ($status_tarefa == "pause") {
                    $tamanho = $this->pegaporcentagemconcluidatarefa($id_projeto, $id_veiculo, $id_tarefa) . "%";
                    ?>
                    <tr style="height: 80px;">
                        <td class="col-md-3 col-sm-3 col-xs-3" id="primeira_coluna"><?php echo $nome_tarefa ?></td>
                        <td class="col-md-5 col-sm-5 col-xs-5" id="segunda_coluna">
                            <div class="progress progress-striped active" class="progress" style="height: 60px; margin:auto;"  >                                     
                                <div class="progress" style="height: 60px; margin:auto;" >
                                    <div class="progress-bar progress-bar-warning" style="width: <?php
                                    if ($tamanho > 100) {
                                        echo $tamanho = 100 . "%";
                                    } else {
                                        echo $tamanho;
                                    }
                                    ?>; ">
                                        <div style="margin-top:20px;"><span style="font-size:2em; color:black;"><?php echo $horas_concluidas_tarefa; ?></span></div>  
                                    </div>
                                </div>
                            </div>                              
                        </td>
                        <td class="col-md-1 col-sm-1 col-xs-1" id="terceira_coluna"><span style="font-size:1.5em; color:black;"><?php echo $duracao_tarefa; ?></span></td>
                        <td class="col-md-3 col-sm-3 col-xs-3" id="quarta_coluna" style="margin: auto;">
                            <div class="col-md-4 col-sm-4 col-xs-4"><a href=""  onclick="reabre_tarefa('<?php echo $status_funcionario ?>', '<?php echo $status_tarefa ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_projeto_executa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>')"><img src="../img/1430175909_StepForwardHot.png" ></a></div>
                            <div class="col-md-4 col-sm-4 col-xs-4"><a href="" onClick="alert('Tarefa se encontra Pausada!');"><img src="../img/1430175773_PauseHot.png" ></a></div>
                            <div class="col-md-4 col-sm-4 col-xs-4"><a href="" onClick="alert('Tarefa se encontra Pausada!!');"><img src="../img/1430175354_Stop1Pressed.png" ></a></div>
                        </td>
                    </tr>
                    <?php
                } else if ($status_tarefa == "concluida") {
                    $tamanho = $this->pegaporcentagemconcluidatarefa($id_projeto, $id_veiculo, $id_tarefa) . "%";
                    ?>
                    <tr style="height: 80px;">
                        <td class="col-md-3 col-sm-3 col-xs-3" id="primeira_coluna"><?php echo $nome_tarefa ?></td>
                        <td class="col-md-5 col-sm-5 col-xs-5" id="segunda_coluna">
                            <div class="progress " class="progress" style="height: 60px; margin:auto;">                                     
                                <div class="progress" style="height: 60px; margin:auto;" >
                                    <div class="progress-bar progress-bar-success" style="width: <?php
                                    if ($tamanho > 100) {
                                        echo $tamanho = 100 . "%";
                                    } else {
                                        echo $tamanho;
                                    }
                                    ?>">
                                        <div style="margin-top:20px;"><span style="font-size:2em; color:black;" ><?php echo $horas_concluidas_tarefa; ?></span></div>        
                                    </div>
                                </div>
                            </div>                              
                        </td>
                        <td class="col-md-1 col-sm-1 col-xs-1" id="terceira_coluna"><span style="font-size:1.5em; color:black;"><?php echo $duracao_tarefa; ?></span></td>
                        <td class="col-md-3 col-sm-3 col-xs-3" id="quarta_coluna" style="margin: auto;">
                            <div class="col-md-4 col-sm-4 col-xs-4"  ><a href="" onClick="alert('Tarefa ja foi finalizada!');"><img src="../img/1430175909_StepForwardHot.png" ></a></div>
                            <div class="col-md-4 col-sm-4 col-xs-4"  ><a href="" onClick="alert('Tarefa ja foi finalizada!');"><img src="../img/1430175773_PauseHot.png" ></a></div>
                            <div class="col-md-4 col-sm-4 col-xs-4"  ><a href="" onClick="alert('Tarefa ja foi finalizada!');"><img src="../img/1430175354_Stop1Pressed.png" ></a></div>
                        </td>
                    </tr>
                    <?php
                }
            }
        }
        ?>
        </table> 
        <?php
    }

    function getIdUgb($id_funcionario) {
        $conexao_select_id_ugb = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        mysqli_autocommit($conexao_select_id_ugb, FALSE);
        $sql_id_ugb = "select funcionarios.id_ugb from funcionarios where funcionarios.id_funcionario = $id_funcionario";
        $query_id_ugb = mysqli_query($conexao_select_id_ugb, $sql_id_ugb);
        $id_da_ugb = mysqli_fetch_row($query_id_ugb);
        return $id_ugb = $id_da_ugb[0];
    }

    function exibeProjetos($id_funcionario) {
        ?>
        <table class="table table-hover" style="width: 100%;">
            <tr style="background: #cfcfcf; color: #01669F; font-size:1.6em; height: 70px; "><td>Projeto</td><td>Veiculo</td></tr>
            <?php
            $id_da_ugb = $this->getIdUgb($id_funcionario);
            $tela_vazia = 0;
            if ($id_da_ugb > 3) {
                $sql = "select projeto_executa.nome_projeto,projeto_executa.id_projeto_executa,projeto_executa.id_projeto,veiculos.nome_veiculo,veiculos.id_veiculo from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo)  where projeto_executa.status = 'open'";
            } else {
                $sql = "select projeto_executa.nome_projeto,projeto_executa.id_projeto_executa,projeto_executa.id_projeto,veiculos.nome_veiculo,veiculos.id_veiculo from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) join `funcionarios` on (projeto_executa.id_ugb = funcionarios.id_ugb) where projeto_executa.status = 'open' and funcionarios.id_funcionario = $id_funcionario and projeto_executa.id_ugb = $id_da_ugb";
            }
            $result_projeto = mysql_query($sql);
            while ($projetos = mysql_fetch_array($result_projeto)) {
                $id_projetos_executas = $projetos['id_projeto_executa'];
                $id = $projetos['id_projeto'];
                $nome = $projetos['nome_projeto'];
                $nome_veiculo = $projetos['nome_veiculo'];
                $id_veiculo = $projetos['id_veiculo'];
                $tela_vazia ++;
                ?>
                <tr style="height: 60px; font-size: 1.5em;">
                    <td><center><span><a href="telaPrincipal.php?t=visualiza_tarefas&id_projeto=<?php echo $id ?>&id_projeto_executa=<?php echo $id_projetos_executas ?>&id_veiculo=<?php echo $id_veiculo ?>"><?php echo $nome ?></a></span><center></td>
                        <td><center><?php echo $nome_veiculo ?></center></td>
                        </tr>
                        <?php
                    }
                    ?>  
                    </table><?php
                    if ($tela_vazia == 0) {
                        ?>
                        <div style="width: 100%; height: 200px;  ">
                            <div style="width: 400px; height: 30px; margin:7% 0% 0% 30%; font-size: 2em; color: #122b40;">Ainda nao tem projetos Criados</div>
                        </div>
                        <?php
                    }
                }

                function invertedata($data, $separar = "/", $juntar = "/") {
                    return implode($juntar, array_reverse(explode($separar, $data)));
                }

                function getSugestoesPendentes($dono_sugestao) {
                    $conexao_sugestao_pendente = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
                    mysqli_autocommit($conexao_sugestao_pendente, FALSE);
                    $result_sugestoes = "select sugestoes.id_sugestao,sugestoes.nome_sugestao,sugestoes.data_enviada from sugestoes where sugestoes.dono_da_sugestao = '$dono_sugestao' ";
                    $result_dados = mysqli_query($conexao_sugestao_pendente, $result_sugestoes);
                    if ($result_dados) {
                        while ($row = $result_dados->fetch_assoc()) {
                            ?>
                            <table class="table table-hover" style="width: 100%; background: white; font-size: 1.4em;">
                                <tr>
                                    <td style="width: 33%;"><?php echo $row['nome_sugestao']; ?></td>
                                    <td style="width: 33%;"><?php echo $data_enviada = $this->invertedata($row['data_enviada'], '-') ?></td>
                                    <td style="width: 33%;"><a href="telaPrincipal.php?t=sugestao/&s=add-sugestoes&a=editar_sugestao&id_sugestao=<?php echo $row['id_sugestao']; ?>"><img src="../img/8427_16x16.png"></a></td>
                                </tr>
                            </table>
                            <?php
                        }
                        $result_dados->free();
                    } else {
                        echo "Nenhuma informação foi retornada";
                    }
                }

                function getSugestoesImplantadas($dono_sugestao) {
                    $conexao_sugestao_implantada = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
                    mysqli_autocommit($conexao_sugestao_implantada, FALSE);
                    $result_sugestoes_implantada = "select sugestoes.nome_sugestao,sugestoes.data_status from sugestoes where sugestoes.dono_da_sugestao = '$dono_sugestao' and sugestoes.categoria_sugestao = 'implantada'";
                    $result_dados = mysqli_query($conexao_sugestao_implantada, $result_sugestoes_implantada);
                    if ($result_dados) {
                        while ($row = $result_dados->fetch_assoc()) {
                            ?>
                            <table class="table table-hover" style="width: 100%; background: white; font-size: 1.4em;">
                                <tr>
                                    <td style="width: 70%;"><?php echo $row['nome_sugestao']; ?></td>
                                    <td style="width: 70%;"><?php echo $data_da_sugestao = $this->invertedata($row['data_status'], '-') ?></td>
                                </tr>
                            </table>
                            <?php
                        }
                        $result_dados->free();
                    } else {
                        echo "Nenhuma informação foi retornada";
                    }
                }

                function getDadosSugestao($id_sugestao) {
                    $dados_sugestao = array();
                    $conexao_dados_sugestao = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
                    $conexao_dados_sugestao->set_charset("utf8");
                    $sql_getSugestao = "select sugestoes.nome_sugestao,sugestoes.como_e_hoje,sugestoes.como_deve_ser,sugestoes.img_como_e_hoje, sugestoes.img_como_deve_ser from sugestoes where sugestoes.id_sugestao =  $id_sugestao";
                    $result_select_dados = mysqli_query($conexao_dados_sugestao, $sql_getSugestao);
                    if ($result_select_dados) {
                        while ($row = $result_select_dados->fetch_assoc()) {
                            $dados_sugestao[] = $row['nome_sugestao'];
                            $dados_sugestao[] = $row['como_e_hoje'];
                            $dados_sugestao[] = $row['como_deve_ser'];
                            $dados_sugestao[] = $row['img_como_e_hoje'];
                            $dados_sugestao[] = $row['img_como_deve_ser'];
                        }
                        $result_select_dados->free();
                    }
                    return $dados_sugestao;
                }

            }
            