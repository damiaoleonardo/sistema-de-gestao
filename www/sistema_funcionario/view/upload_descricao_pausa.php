<?php

require '../model/Conexao/Conexao.php';

class MultiploUploadPausa {

    public $diretorio = "../../sistema_gestor/descricao_das_tarefas/";

    function PausaTarefa($nomeArquivo, $tmp_nome, $id_projeto, $id_veiculo, $id_tarefa, $id_funcionario, $id_executa) {
        //recebe a hora atual, o nome do projeto,veiculo,tarefa e funcionario
        $sql_consulta = new Conexao();
        $data_de_hoje = date('Y-m-d');
        $result_hora = $sql_consulta->selectoneelement("SELECT DATE_FORMAT(now(),'%H:%i:%s')");
        foreach ($result_hora as $res_hora) {
            $hora_atual = $res_hora;
        }
        $result_projeto = $sql_consulta->select("select projeto.nome from projeto where projeto.id_projeto = $id_projeto");
        foreach ($result_projeto as $res_projeto) {
            $nome_do_projeto = $res_projeto['nome'];
        }

        $result_veiculo = $sql_consulta->select("select veiculos.nome_veiculo from veiculos where veiculos.id_veiculo = $id_veiculo");
        foreach ($result_veiculo as $res_veiculo) {
            $nome_do_veiculo = $res_veiculo['nome_veiculo'];
        }

        $result_tarefa = $sql_consulta->select("select tarefas.nome from tarefas where tarefas.id_tarefa = $id_tarefa");
        foreach ($result_tarefa as $res_tarefa) {
            $nome_da_tarefa = $res_tarefa['nome'];
        }

        $result_funcionario = $sql_consulta->select("select funcionarios.sobrenome from funcionarios where funcionarios.id_funcionario = $id_funcionario");
        foreach ($result_funcionario as $res_funcionario) {
            $nome_do_funcionario = $res_funcionario['sobrenome'];
        }

        $result_funcionario_executa_codigo = $sql_consulta->select("select funcionario_executa.codigo from funcionario_executa where funcionario_executa.id_projeto_executa = $id_executa and funcionario_executa.id_projeto = $id_projeto and funcionario_executa.id_veiculo=$id_veiculo and funcionario_executa.id_tarefa=$id_tarefa and funcionario_executa.id_funcionario = $id_funcionario and funcionario_executa.status_funcionario_tarefa = 'ativo'");
        foreach ($result_funcionario_executa_codigo as $codigo_funcionario_executa) {
            $funcionario_executa_codigo = $codigo_funcionario_executa['codigo'];
        }


        $result_quantidade = $sql_consulta->select("SELECT funcionario_executa.id_funcionario FROM funcionario_executa WHERE funcionario_executa.status_funcionario_tarefa = 'ativo' and funcionario_executa.id_projeto_executa = $id_executa and funcionario_executa.id_projeto = $id_projeto and funcionario_executa.id_veiculo = $id_veiculo and funcionario_executa.id_tarefa = $id_tarefa");
        $quantidades_executores = count($result_quantidade);
        $sql_consulta->desconectar();

        if ($result_projeto && $result_veiculo && $result_tarefa && $result_funcionario && $result_quantidade && $result_funcionario_executa_codigo) {
            //conexao via mysqli com o banco de dados
            $conexao_select_pause = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
            mysqli_autocommit($conexao_select_pause, FALSE);
            $erro_pause = 0;

            if (!is_dir('/' . $data_de_hoje . '/')) {
                if (!empty($tmp_nome)) {
                    mkdir('../../sistema_gestor/descricao_das_tarefas/' . $data_de_hoje);
                    $uploadfile = "../../sistema_gestor/descricao_das_tarefas/" . $data_de_hoje;
                    $contador = count($nomeArquivo);
                    for ($i = 0; $i <= $contador - 1; $i++) {
                        if (!move_uploaded_file($tmp_nome[$i], $this->diretorio . $data_de_hoje . "/" . '+' . $nomeArquivo[$i])) {
                            $erro_pause ++;
                        }
                        $sql_insere_descricao = "insert into descricao_tarefa (id_codigo_funcionario,id_projeto_executa,id_projeto,id_veiculo,id_tarefa,id_funcionario,descricao)"
                                . "values ('$funcionario_executa_codigo','$id_executa','$id_projeto','$id_veiculo','$id_tarefa','$id_funcionario','$nomeArquivo[$i]')";

                        if (!mysqli_query($conexao_select_pause, $sql_insere_descricao)) {
                            $erro_pause++;
                        }
                    }
                    if ($quantidades_executores == 1) {
                        $atualiza_tarefas = "UPDATE tarefas_executa SET status = 'pause' where tarefas_executa.id_projeto_executa = $id_executa and tarefas_executa.id_tarefa = $id_tarefa and tarefas_executa.id_projeto = $id_projeto and tarefas_executa.id_veiculo= $id_veiculo and tarefas_executa.conclusao_projeto = 'nao concluido'";
                        if (!mysqli_query($conexao_select_pause, $atualiza_tarefas)) {
                            $erro_pause++;
                        }
                    }

                    $atualiza_funcionario = "UPDATE funcionarios SET disponibilidade = 'inativo' where funcionarios.id_funcionario = $id_funcionario";

                    if (!mysqli_query($conexao_select_pause, $atualiza_funcionario)) {
                        $erro_pause++;
                    }
                    $atualiza_funcionario_executa = "UPDATE funcionario_executa SET hora_final = '$hora_atual', status_funcionario_tarefa = 'nao ativo',status_tarefa= 'concluida',flag_tarefa_aberta = 0,flag_tarefa_relatorio = 0 where funcionario_executa.id_projeto_executa = $id_executa and funcionario_executa.id_projeto=$id_projeto and funcionario_executa.id_veiculo= $id_veiculo and funcionario_executa.id_tarefa= $id_tarefa and funcionario_executa.id_funcionario= $id_funcionario and funcionario_executa.status_funcionario_tarefa = 'ativo' and funcionario_executa.status_tarefa != 'concluida'";

                    if (!mysqli_query($conexao_select_pause, $atualiza_funcionario_executa)) {
                        $erro_pause++;
                    }
                    $insere_funcionario = "INSERT INTO funcionario_executa (id_projeto_executa,id_projeto,id_veiculo,id_tarefa,id_funcionario,nome_do_projeto,nome_do_veiculo,nome_da_tarefa,nome_do_funcionario,data_tarefa,status_funcionario_tarefa,status_tarefa,flag_tarefa_aberta,flag_tarefa_relatorio) VALUES ('$id_executa','$id_projeto','$id_veiculo','$id_tarefa','$id_funcionario','$nome_do_projeto','$nome_do_veiculo','$nome_da_tarefa','$nome_do_funcionario','$data_de_hoje',' nao ativo','pause','0','1')";

                    if (!mysqli_query($conexao_select_pause, $insere_funcionario)) {
                        $erro_pause++;
                    }
                    if ($erro_pause == 0) {
                        mysqli_commit($conexao_select_pause);
                         echo "<center><p style='font-size:2em;'>Tarefa pausada com sucesso</p></center>";
                    } else {
                        mysqli_rollback($conexao_select_pause); echo "Ocorreu um erro!";
                    }
                } else {
                  //  echo "Por favor insira pelo menos uma descricao!";
                }
            } else {
               // echo "O endereço nao é um diretorio valido!"; 
            }
        } else {
            //echo "Operação ocorreu falha. Tente novamente"; 
        }
    }

}
?>


