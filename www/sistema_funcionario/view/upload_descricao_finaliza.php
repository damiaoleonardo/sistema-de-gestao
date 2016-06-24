<?php

require '../model/Conexao/Conexao.php';

class MultiploUploadFinaliza {

    public $diretorio = "../../sistema_gestor/descricao_das_tarefas/";

    function FinalizaTarefa($nomeArquivo_finaliza, $tmp_nome_finaliza, $id_projeto_finaliza, $id_veiculo_finaliza, $id_tarefa_finaliza, $id_funcionario_finaliza, $id_executa_finaliza) {
             
//recebe a hora atual, o nome do projeto,veiculo,tarefa e funcionario
        $sql_consulta_finaliza = new Conexao();
        $data_de_hoje_finaliza = date('Y-m-d');
        $result_hora_finaliza = $sql_consulta_finaliza->selectoneelement("SELECT DATE_FORMAT(now(),'%H:%i:%s')");
        foreach ($result_hora_finaliza as $res_hora_finaliza) {
            $hora_atual_finaliza = $res_hora_finaliza;
        }

        $result_funcionario_executa_codigo_finaliza = $sql_consulta_finaliza->select("select funcionario_executa.codigo from funcionario_executa where funcionario_executa.id_projeto_executa = $id_executa_finaliza and funcionario_executa.id_projeto = $id_projeto_finaliza and funcionario_executa.id_veiculo=$id_veiculo_finaliza and funcionario_executa.id_tarefa=$id_tarefa_finaliza and funcionario_executa.id_funcionario = $id_funcionario_finaliza and funcionario_executa.status_funcionario_tarefa = 'ativo'");
        foreach ($result_funcionario_executa_codigo_finaliza as $codigo_funcionario_executa_finaliza) {
            $funcionario_executa_codigo_finaliza = $codigo_funcionario_executa_finaliza['codigo'];
        }
        $result_quantidade_finaliza = $sql_consulta_finaliza->select("SELECT funcionario_executa.id_funcionario FROM funcionario_executa WHERE funcionario_executa.status_funcionario_tarefa = 'ativo' and funcionario_executa.id_projeto_executa = $id_executa_finaliza and funcionario_executa.id_projeto = $id_projeto_finaliza and funcionario_executa.id_veiculo = $id_veiculo_finaliza and funcionario_executa.id_tarefa = $id_tarefa_finaliza");
        $quantidades_executores_finaliza = count($result_quantidade_finaliza);
       
        
        $result_quantidade_finaliza_projeto = $sql_consulta_finaliza->select("select tarefas_executa.id_tarefa from tarefas_executa where tarefas_executa.id_projeto_executa = $id_executa_finaliza and tarefas_executa.id_projeto = $id_projeto_finaliza and tarefas_executa.id_veiculo = $id_veiculo_finaliza and tarefas_executa.status != 'concluida'");
        $quantidades_executores_finaliza_projeto = count($result_quantidade_finaliza_projeto);
        $sql_consulta_finaliza->desconectar();
        
        if ($result_quantidade_finaliza && $result_funcionario_executa_codigo_finaliza && $result_quantidade_finaliza_projeto) {
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
                        $sql_insere_descricao_finaliza = "insert into descricao_tarefa (id_codigo_funcionario,id_projeto_executa,id_projeto,id_veiculo,id_tarefa,id_funcionario,descricao)"
                                . "values ('$funcionario_executa_codigo_finaliza','$id_executa_finaliza','$id_projeto_finaliza','$id_veiculo_finaliza','$id_tarefa_finaliza','$id_funcionario_finaliza','$nomeArquivo_finaliza[$i]')";

                        if (!mysqli_query($conexao_select_pause_finaliza, $sql_insere_descricao_finaliza)) {
                            $erro_pause_finaliza++;
                        }
                    }
                    if ($quantidades_executores_finaliza == 1) {
                        $atualiza_tarefas_finaliza = "UPDATE tarefas_executa SET status = 'concluida', horas_final = '$hora_atual_finaliza', data_final= '$data_de_hoje_finaliza',status_finalizado = 'funcionario' where tarefas_executa.id_projeto_executa = $id_executa_finaliza and tarefas_executa.id_projeto = $id_projeto_finaliza and tarefas_executa.id_veiculo= $id_veiculo_finaliza and tarefas_executa.id_tarefa = $id_tarefa_finaliza and tarefas_executa.conclusao_projeto = 'nao concluido'";
                        if (!mysqli_query($conexao_select_pause_finaliza, $atualiza_tarefas_finaliza)) {
                            $erro_pause_finaliza++;
                        }
                    }

                    $atualiza_funcionario_finaliza = "UPDATE funcionarios SET disponibilidade = 'inativo' where funcionarios.id_funcionario = $id_funcionario_finaliza";

                    if (!mysqli_query($conexao_select_pause_finaliza, $atualiza_funcionario_finaliza)) {
                        $erro_pause_finaliza++;
                    }
                    $atualiza_funcionario_executa_finaliza = "UPDATE funcionario_executa SET hora_final = '$hora_atual_finaliza', status_funcionario_tarefa = 'nao ativo',status_tarefa= 'concluida',flag_tarefa_aberta = 0,flag_tarefa_relatorio = 0 where funcionario_executa.id_projeto_executa = $id_executa_finaliza and funcionario_executa.id_projeto=$id_projeto_finaliza and funcionario_executa.id_veiculo= $id_veiculo_finaliza and funcionario_executa.id_tarefa= $id_tarefa_finaliza and funcionario_executa.id_funcionario= $id_funcionario_finaliza and funcionario_executa.status_funcionario_tarefa = 'ativo' and funcionario_executa.status_tarefa != 'concluida'";

                    if (!mysqli_query($conexao_select_pause_finaliza, $atualiza_funcionario_executa_finaliza)) {
                        $erro_pause_finaliza++;
                    }


                    if ($quantidades_executores_finaliza_projeto == 1 && $quantidades_executores_finaliza == 1) {
                        $atualiza_projeto = "UPDATE projeto_executa SET status ='concluido',horas_final = '$hora_atual_finaliza',data_final = '$data_de_hoje_finaliza' where projeto_executa.id_projeto_executa = $id_executa_finaliza and projeto_executa.id_projeto = $id_projeto_finaliza and projeto_executa.id_veiculo = $id_veiculo_finaliza and projeto_executa.status != 'concluido'";
                        $atualiza_as_tarefas = "UPDATE tarefas_executa SET status = 'concluida' where tarefas_executa.id_projeto_executa = $id_executa_finaliza and tarefas_executa.id_projeto = $id_projeto_finaliza and tarefas_executa.id_veiculo= $id_veiculo_finaliza and tarefas_executa.status != 'concluida'";
                        $atualiza_status_tarefas = "UPDATE tarefas_executa SET conclusao_projeto = 'concluido' where tarefas_executa.id_projeto_executa = $id_executa_finaliza and tarefas_executa.id_projeto = $id_projeto_finaliza and tarefas_executa.id_veiculo= $id_veiculo_finaliza";
                        $atualiza_status_tarefas_executa = "UPDATE tarefas_executa SET status_finalizado = 'gestor' where tarefas_executa.status_finalizado != 'funcionario'";
                        $atualiza_funcionario_executa = "UPDATE funcionario_executa SET status_tarefa = 'concluida' where funcionario_executa.id_projeto_executa = $id_executa_finaliza and funcionario_executa.id_projeto = $id_projeto_finaliza and funcionario_executa.id_veiculo = $id_veiculo_finaliza and funcionario_executa.status_tarefa != 'concluida'";
                        $atualiza_tarefas_executa_status = "UPDATE tarefas_executa SET status = 'concluida', horas_final = '$hora_atual_finaliza', data_final= '$data_de_hoje_finaliza',status_finalizado = 'funcionario' where tarefas_executa.id_projeto_executa = $id_executa_finaliza and tarefas_executa.id_projeto = $id_projeto_finaliza and tarefas_executa.id_veiculo= $id_veiculo_finaliza and tarefas_executa.id_tarefa = $id_tarefa_finaliza and tarefas_executa.conclusao_projeto = 'nao concluido'";

                        if (!mysqli_query($conexao_select_pause_finaliza, $atualiza_projeto)) {
                            $erro_pause_finaliza++;
                        }
                        if (!mysqli_query($conexao_select_pause_finaliza, $atualiza_as_tarefas)) {
                            $erro_pause_finaliza++;
                        }
                        if (!mysqli_query($conexao_select_pause_finaliza, $atualiza_status_tarefas)) {
                            $erro_pause_finaliza++;
                        }
                        if (!mysqli_query($conexao_select_pause_finaliza, $atualiza_status_tarefas_executa)) {
                            $erro_pause_finaliza++;
                        }
                        if (!mysqli_query($conexao_select_pause_finaliza, $atualiza_funcionario_executa)) {
                            $erro_pause_finaliza++;
                        }
                        if (!mysqli_query($conexao_select_pause_finaliza, $atualiza_tarefas_executa_status)) {
                            $erro_pause_finaliza++;
                        }
                    }




                    if ($erro_pause_finaliza == 0) {
                        mysqli_commit($conexao_select_pause_finaliza);
                        echo "<center><p style='font-size:2em;'>Tarefa pausada com sucesso</p></center>";
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

}
?>


