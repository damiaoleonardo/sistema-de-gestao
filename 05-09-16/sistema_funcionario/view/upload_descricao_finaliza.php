<?php

require '../model/Conexao/Conexao.php';

class MultiploUploadFinaliza {

    public $diretorio = "../../sistema_gestor/descricao_das_tarefas/";

    function FinalizaTarefa($nomeArquivo_finaliza, $tmp_nome_finaliza, $id_projeto_finaliza, $id_veiculo_finaliza, $id_tarefa_finaliza, $id_funcionario_finaliza, $id_executa_finaliza, $hora_recebida) {
        //recebe a hora atual, o nome do projeto,veiculo,tarefa e funcionario
        $horas_concluidas_tarefa = array();
        $horas_concluidas_funcionario = array();
        $horas_concluidas_projeto = array();

        $sql_consulta_finaliza = new Conexao();
        $data_de_hoje_finaliza = date('Y-m-d');
        $result_hora_finaliza = $sql_consulta_finaliza->selectoneelement("SELECT DATE_FORMAT(now(),'%H:%i:%s')");
        foreach ($result_hora_finaliza as $res_hora_finaliza) {
         $hora_atual_finaliza = $res_hora_finaliza. "<br>";
        }

        $result_tarefa_executa_codigo_finaliza = $sql_consulta_finaliza->select("select tarefas_executa.id_tarefa_executa from tarefas_executa where tarefas_executa.id_projeto_executa = $id_executa_finaliza and tarefas_executa.id_projeto = $id_projeto_finaliza and tarefas_executa.id_veiculo= $id_veiculo_finaliza and tarefas_executa.id_tarefa= $id_tarefa_finaliza and tarefas_executa.status = 'open'");
        foreach ($result_tarefa_executa_codigo_finaliza as $codigo_tarefa_executa_finaliza) {
            $id_tarefa_executa = $codigo_tarefa_executa_finaliza['id_tarefa_executa'];
        }

        $result_horas_concluidas_tarefa = $sql_consulta_finaliza->select("select tarefas_executa.horas_concluidas from tarefas_executa where tarefas_executa.id_projeto_executa = $id_executa_finaliza and tarefas_executa.id_projeto = $id_projeto_finaliza and tarefas_executa.id_veiculo= $id_veiculo_finaliza and tarefas_executa.id_tarefa= $id_tarefa_finaliza and tarefas_executa.status = 'open'");
        foreach ($result_horas_concluidas_tarefa as $horas_concluidas_tarefa) {
           $horas_concluidas_da_tarefa = $horas_concluidas_tarefa['horas_concluidas'];
        }

        $result_horas_concluidas_funcionario_executa = $sql_consulta_finaliza->select("select funcionario_executa.horas_concluidas from funcionario_executa where funcionario_executa.id_projeto_executa = $id_executa_finaliza and funcionario_executa.id_projeto = $id_projeto_finaliza and funcionario_executa.id_veiculo= $id_veiculo_finaliza and funcionario_executa.id_tarefa= $id_tarefa_finaliza and funcionario_executa.status_funcionario_tarefa = 'ativo'");
        foreach ($result_horas_concluidas_funcionario_executa as $horas_concluidas_funcionario_executa){
          $horas_concluidas_do_funcionario_executa = $horas_concluidas_funcionario_executa['horas_concluidas'];
        }
       $result_horas_concluidas_projeto_executa = $sql_consulta_finaliza->select("select projeto_executa.horas_concluidas from projeto_executa where  projeto_executa.id_projeto_executa = $id_executa_finaliza and projeto_executa.id_projeto = $id_projeto_finaliza and projeto_executa.id_veiculo = $id_veiculo_finaliza and projeto_executa.status != 'concluido'");
        foreach ($result_horas_concluidas_projeto_executa as $horas_concluidas_projeto_executa){
          $horas_concluidas_do_projeto_executa = $horas_concluidas_projeto_executa['horas_concluidas'];
        }

        $sql_consulta_finaliza->desconectar();

        
        $intervalo_entre_horas = $this->calculaTempo($hora_recebida, $hora_atual_finaliza);
        $horas_concluidas_tarefas[] = $horas_concluidas_da_tarefa;
        $horas_concluidas_tarefas[] = $intervalo_entre_horas;
        $hora_concluidas_tarefa = $this->somarhoras($horas_concluidas_tarefas);
        $horas_concluidas_funcionario[] = $horas_concluidas_do_funcionario_executa;
        $horas_concluidas_funcionario[] = $intervalo_entre_horas;
        $hora_concluidas_funcionario = $this->somarhoras($horas_concluidas_funcionario);
        $horas_concluidas_projeto[] = $horas_concluidas_do_projeto_executa;
        $horas_concluidas_projeto[] = $intervalo_entre_horas;
        $hora_concluidas_projeto_executa = $this->somarhoras($horas_concluidas_projeto);


        if ($result_tarefa_executa_codigo_finaliza && $result_horas_concluidas_tarefa && $result_horas_concluidas_funcionario_executa){
            //conexao via mysqli com o banco de dados
            $conexao_select_pause_finaliza = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
            mysqli_autocommit($conexao_select_pause_finaliza, FALSE);
            $erro_pause_finaliza = 0;
            if (!is_dir('/' . $data_de_hoje_finaliza . '/')) {
                if (!empty($tmp_nome_finaliza)) {
                    mkdir('../../sistema_gestor/descricao_das_tarefas/' . $data_de_hoje_finaliza);
                    $uploadfile_finaliza = "../../sistema_gestor/descricao_das_tarefas/" . $data_de_hoje_finaliza;
                    $contador_finaliza = count($nomeArquivo_finaliza);
                    for ($i = 0; $i <= $contador_finaliza - 1; $i++) {
                        if (!move_uploaded_file($tmp_nome_finaliza[$i], $this->diretorio . $data_de_hoje_finaliza . "/" . '+' . $nomeArquivo_finaliza[$i])) {
                            $erro_pause_finaliza ++;
                        }
                        $sql_insere_descricao_finaliza = "insert into descricao_tarefa (id_tarefa_executa,id_projeto_executa,id_projeto,id_veiculo,id_tarefa,descricao)"
                                . "values ('$id_tarefa_executa','$id_executa_finaliza','$id_projeto_finaliza','$id_veiculo_finaliza','$id_tarefa_finaliza','$nomeArquivo_finaliza[$i]')";

                        if (!mysqli_query($conexao_select_pause_finaliza, $sql_insere_descricao_finaliza)) {
                            $erro_pause_finaliza++;
                        }
                    }
                    $atualiza_tarefas_finaliza = "UPDATE tarefas_executa SET horas_concluidas = '$hora_concluidas_tarefa', status = 'concluida', horas_final = '$hora_atual_finaliza', data_final= '$data_de_hoje_finaliza' where tarefas_executa.id_projeto_executa = $id_executa_finaliza and tarefas_executa.id_projeto = $id_projeto_finaliza and tarefas_executa.id_veiculo= $id_veiculo_finaliza and tarefas_executa.id_tarefa = $id_tarefa_finaliza and tarefas_executa.conclusao_projeto = 'nao concluido'";
                    if (!mysqli_query($conexao_select_pause_finaliza, $atualiza_tarefas_finaliza)) {
                        $erro_pause_finaliza++;
                    }

                    $atualiza_funcionario_finaliza = "UPDATE funcionarios SET disponibilidade = 'inativo' where funcionarios.id_funcionario = $id_funcionario_finaliza";

                    if (!mysqli_query($conexao_select_pause_finaliza, $atualiza_funcionario_finaliza)) {
                        $erro_pause_finaliza++;
                    }
                    $atualiza_funcionario_executa_finaliza = "UPDATE funcionario_executa SET horas_concluidas = '$hora_concluidas_funcionario', hora_final = '$hora_atual_finaliza', status_funcionario_tarefa = 'nao ativo',status_tarefa= 'concluida',flag_tarefa_aberta = 0,flag_tarefa_relatorio = 0 where funcionario_executa.id_projeto_executa = $id_executa_finaliza and funcionario_executa.id_projeto=$id_projeto_finaliza and funcionario_executa.id_veiculo= $id_veiculo_finaliza and funcionario_executa.id_tarefa= $id_tarefa_finaliza and funcionario_executa.id_funcionario= $id_funcionario_finaliza and funcionario_executa.status_funcionario_tarefa = 'ativo' and funcionario_executa.status_tarefa != 'concluida'";

                    if (!mysqli_query($conexao_select_pause_finaliza, $atualiza_funcionario_executa_finaliza)) {
                        $erro_pause_finaliza++;
                    }

                    $atualiza_as_tarefas = "UPDATE tarefas_executa SET status = 'concluida' where tarefas_executa.id_projeto_executa = $id_executa_finaliza and tarefas_executa.id_projeto = $id_projeto_finaliza and tarefas_executa.id_veiculo= $id_veiculo_finaliza and tarefas_executa.status != 'concluida'";
                    $atualiza_status_tarefas = "UPDATE tarefas_executa SET conclusao_projeto = 'concluido' where tarefas_executa.id_projeto_executa = $id_executa_finaliza and tarefas_executa.id_projeto = $id_projeto_finaliza and tarefas_executa.id_veiculo= $id_veiculo_finaliza";
                    $atualiza_funcionario_executa = "UPDATE funcionario_executa SET status_tarefa = 'concluida' where funcionario_executa.id_projeto_executa = $id_executa_finaliza and funcionario_executa.id_projeto = $id_projeto_finaliza and funcionario_executa.id_veiculo = $id_veiculo_finaliza and funcionario_executa.status_tarefa != 'concluida'";
                    $atualiza_tarefas_executa_status = "UPDATE tarefas_executa SET status = 'concluida', horas_final = '$hora_atual_finaliza', data_final= '$data_de_hoje_finaliza' where tarefas_executa.id_projeto_executa = $id_executa_finaliza and tarefas_executa.id_projeto = $id_projeto_finaliza and tarefas_executa.id_veiculo= $id_veiculo_finaliza and tarefas_executa.id_tarefa = $id_tarefa_finaliza and tarefas_executa.conclusao_projeto = 'nao concluido'";
                    $atualiza_projeto = "UPDATE projeto_executa SET horas_concluidas = '$hora_concluidas_projeto_executa',status ='concluido',horas_final = '$hora_atual_finaliza',data_final = '$data_de_hoje_finaliza' where projeto_executa.id_projeto_executa = $id_executa_finaliza and projeto_executa.id_projeto = $id_projeto_finaliza and projeto_executa.id_veiculo = $id_veiculo_finaliza and projeto_executa.status != 'concluido'";

                    if (!mysqli_query($conexao_select_pause_finaliza, $atualiza_as_tarefas)) {
                        $erro_pause_finaliza++;
                    }
                    if (!mysqli_query($conexao_select_pause_finaliza, $atualiza_status_tarefas)) {
                        $erro_pause_finaliza++;
                    }

                    if (!mysqli_query($conexao_select_pause_finaliza, $atualiza_funcionario_executa)) {
                        $erro_pause_finaliza++;
                    }
                    if (!mysqli_query($conexao_select_pause_finaliza, $atualiza_tarefas_executa_status)) {
                        $erro_pause_finaliza++;
                    }

                    if (!mysqli_query($conexao_select_pause_finaliza, $atualiza_projeto)){
                            $erro_pause_finaliza++;
                        }
                        if ($erro_pause_finaliza == 0) {
                            mysqli_commit($conexao_select_pause_finaliza);
                            echo "<center><p style='font-size:2em;'>Tarefa finalizada com sucesso</p></center>";
                        } else {
                           mysqli_rollback($conexao_select_pause_finaliza);
                            echo "Ocorreu um erro!";
                        }
                      } else {
                        echo "Por favor insira pelo menos uma descricao!";
                    }
                } else {
                    echo "O endereço nao é um diretorio valido!";
                }
            } else {
                echo "Operação ocorreu falha. Tente novamente";
            }
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

    function calculaTempo($hora_inicial, $hora_final) {
        $i = 1;
        $tempos = array($hora_final, $hora_inicial);
        foreach ($tempos as $tempo) {

            $segundos = 0;
            list ($h, $m, $s) = explode(':', $tempo);

            $segundos += $h * 3600;
            $segundos += $m * 60;
            $segundos += $s;
            $tempo_total [$i] = $segundos;
            $i++;
        }
        $segundos = $tempo_total[1] - $tempo_total[2];
        $horas = floor($segundos / 3600);
        $segundos -= $horas * 3600;
        $minutos = str_pad((floor($segundos / 60)), 2, '0', STR_PAD_LEFT);
        $segundos -= $minutos * 60;
        $segundos = str_pad($segundos, 2, '0', STR_PAD_LEFT);

        if ($horas < 10 || $horas == 0) {
            $hora = "0" . $horas;
        } else {
            $hora = $horas;
        }
        return "$hora:$minutos:$segundos";
    }
        
        
        
        
    }
    ?>


