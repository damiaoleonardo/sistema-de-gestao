<?php

class Projetos {

    private $id_projeto;
    private $nome_projeto;
    private $ugb;
    private $descricao;
    private $tarefas;

    function getId_projeto() {
        return $this->id_projeto;
    }

    function getNome_projeto() {
        return $this->nome_projeto;
    }

    function getUgb() {
        return $this->ugb;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getTarefas() {
        return $this->tarefas;
    }

    function setTarefas($tarefas) {
        $this->tarefas = $tarefas;
    }

    function setId_projeto($id_projeto) {
        $this->id_projeto = $id_projeto;
    }

    function somahora($hour1, $hour2) {
        $horas_somada = '00:00:00';
        for ($i = 0; $i < 3; $i++) {
            $hora1 = explode(":", $hour1);
            $hora2 = explode(":", $hour2);
            $mostre1[$i] = $hora1[$i];
            $mostre2[$i] = $hora2[$i];
        }
        $soma_hora = $mostre1[0] + $mostre2[0];
        $soma_min = $mostre1[1] + $mostre2[1];
        $soma_seg = $mostre1[2] + $mostre2[2];
        if ($soma_seg > 59) {
            $soma_min++;
            $soma_seg = $soma_seg - 60;
            if ($soma_min > 59)
                $soma_hora++;
            $soma_min = $soma_min - 60;
        } elseif ($soma_min > 59) {
            $soma_hora++;
            $soma_min = $soma_min - 60;
        }
        if ($soma_min <= 9)
            $soma_min = "0" . $soma_min;
        if ($soma_seg <= 9)
            $soma_seg = "0" . $soma_seg;
        if ($soma_hora <= 9)
            $soma_hora = "0" . $soma_hora;
        $horas_somada = $soma_hora . ":" . $soma_min . ":" . $soma_seg;
        return $horas_somada;
    }

    function getcheckboxProjeto($id_do_projeto, $id_da_tarefa) {
        $conexao_id_tarefas = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $sql_tarefas = "SELECT tarefas_projeto.id_tarefa FROM tarefas_projeto WHERE tarefas_projeto.id_projeto = $id_do_projeto";
        $result_select_id_tarefa = mysqli_query($conexao_id_tarefas, $sql_tarefas);
        if ($result_select_id_tarefa) {
            while ($aux_tarefas = $result_select_id_tarefa->fetch_assoc()) {
                $id_tarefa = $aux_tarefas['id_tarefa'];
                if ($id_tarefa == $id_da_tarefa) {
                    return 1;
                }
            }
            return 0;
        }
    }

    function getDadosProjeto($id_do_projeto) {
        $dados_projeto = array();
        $conexao_dados_projeto = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_dados_projeto->set_charset("utf8");
        $sql_getProjeto = "select projeto.nome,projeto.duracao,projeto.descricao,ugb.nome_ugb,ugb.id_ugb from projeto join ugb on (projeto.id_ugb = ugb.id_ugb) where projeto.id_projeto = $id_do_projeto ";
        $result_select_dados = mysqli_query($conexao_dados_projeto, $sql_getProjeto);
        if ($result_select_dados) {
            while ($row = $result_select_dados->fetch_assoc()) {
                $dados_projeto[] = $row['nome'];
                $dados_projeto[] = $row['nome_ugb'];
                $dados_projeto[] = $row['duracao'];
                $dados_projeto[] = $row['descricao'];
                $dados_projeto[] = $row['id_ugb'];
            }
            $result_select_dados->free();
        }
        return $dados_projeto;
    }

    function getTarefasProjeto($id_projeto) {
        $id_tarefa = array();
        $conexao_tarefa_projeto = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_tarefa_projeto->set_charset("utf8");
        $sql_tarefa_projeto = "select tarefas_projeto.id_tarefa from tarefas_projeto where tarefas_projeto.id_projeto = $id_projeto";
        $result_tarefas_projeto = mysqli_query($conexao_tarefa_projeto, $sql_tarefa_projeto);
        if ($result_tarefas_projeto) {
            while ($row = $result_tarefas_projeto->fetch_assoc()) {
                $id_tarefa[] = $row['id_tarefa']; 
            }
            $result_tarefas_projeto->free();   
            return  $id_tarefa;
        } else {
            throw new Exception('<script>alert("Ocorreu um erro na busca pelo nome da tarefa!")</script>');
        }
    }


    function getNomeDoProjeto($id_do_projeto) {
        $conexao_nome_projeto = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_nome_projeto->set_charset("utf8");
        $result_nome = "select projeto.nome from projeto where projeto.id_projeto= $id_do_projeto";
        $result_dados = mysqli_query($conexao_nome_projeto, $result_nome);
        if ($result_dados) {
            while ($row = $result_dados->fetch_assoc()) {
                $nome_projeto = $row['nome'];
            }
            $result_dados->free();
            return $nome_projeto;
        } else {
            throw new Exception('<script>alert("Ocorreu um erro na busca pelo nome da tarefa!")</script>');
        }
    }

    function setNome_projeto($nome_projeto, $flag_projeto) {
        if ($flag_projeto == 1) {
            $conexao_insert_nome_projeto = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
            mysqli_autocommit($conexao_insert_nome_projeto, FALSE);
            $result_adiciona_nome = "select projeto.nome from projeto where projeto.nome = '$nome_projeto'";
            $conexao_insert_nome_projeto->query($result_adiciona_nome);

            if ($conexao_insert_nome_projeto->affected_rows > 0) {
                throw new Exception('<script>alert("Nome ja existente, por favor tente outro!")</script>');
            } else {
                $this->nome_projeto = $nome_projeto;
            }
        } else if ($flag_projeto == 2) {
            $id_do_projeto = $this->getId_projeto();
            $nome_atual = $this->getNomeDoProjeto($id_do_projeto);

            if ($nome_atual == $nome_projeto) {
                $this->nome_projeto = $nome_projeto;
            } else {
                $conexao_atualiza_nome_projeto = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
                mysqli_autocommit($conexao_atualiza_nome_projeto, FALSE);
                $result_atualiza_nome = "select projeto.nome from projeto where projeto.nome = '$nome_projeto'";
                $conexao_atualiza_nome_projeto->query($result_atualiza_nome);

                if ($conexao_atualiza_nome_projeto->affected_rows > 0) {
                    throw new Exception('<script>alert("Nome ja existente, por favor tente outro!")</script>');
                } else {
                    $this->nome_projeto = $nome_projeto;
                }
            }
        }
    }

    function setUgb($ugb) {
        $this->ugb = $ugb;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function getProjetos($nome_busca) {
        $parametro = $nome_busca;
        $msg = "";
        $msg .="<table class='table table-hover'>";
        require_once('../../model/Conexao/Conexao.php');
        try {
            $pdo = new Conexao();
            $resultado = $pdo->select("SELECT * FROM projeto WHERE nome LIKE '$parametro%' ORDER BY projeto.id_projeto ");
            $pdo->desconectar();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (count($resultado)) {
            foreach ($resultado as $res) {

                $msg .="				<tr>";
                $msg .="					<td style = 'font-size:0.8em; text-align: left;'>" . $res['id_projeto'] . "</td>";
                $msg .="					<td style = 'font-size:0.8em; text-align: left;'><a href='telaPrincipal.php?t=projetos&c=view-projeto&id_projeto= " . $res['id_projeto'] . "' style='color:black;'>" . $res['nome'] . "</a></td>";
                $msg .="					<td style='font-size:0.8em;'>" . $res['duracao'] . "</td>";
                $msg .="                                        <td style = 'font-size:0.8em;  text-align: left;'><div>" . $res['descricao'] . "</div></td>";
                $msg .="                                        <td style='font-size:0.8em;'><a href='telaprincipal.php?t=projetos&c=edit-projeto&id_projeto= " . $res['id_projeto'] . "'><img src=\"../img/8427_16x16.png\"/></a></td>";
                $msg .="                                        <td style='font-size:0.8em;'><a href='telaprincipal.php?t=projetos&id_projeto= " . $res['id_projeto'] . "&flag_projeto=1' onClick=\"return confirm('Deseja realmente deletar o projeto:')\"><img src=\"../img/excluir.png\"/></a></td>";
                $msg .="				</tr>";
            }
        } else {
            $msg = "";
            $msg .="<center><p style='padding-top:4%;'>Nenhum Registro foi encontrado no Banco de Dados</p></center>";
        }
        $msg .="	</tbody>";
        $msg .="</table>";
        if (empty($msg)) {
            echo "<center><p style='padding-top:4%;'>Nenhum Registro foi encontrado no Banco de Dados</p></center>";
        } else {
            echo $msg;
        }
    }

    function Addprojeto(Projetos $obj) {
        $nome = $obj->getNome_projeto();
        $ugb = $obj->getUgb();
        $descricao_projeto = $obj->getDescricao();
        $tarefas = $obj->getTarefas();
        $conexao_adiciona_projeto = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        mysqli_autocommit($conexao_adiciona_projeto, FALSE);
        $erro_adiciona_projeto = 0;
        $cont_tarefa = 0;
        foreach ($tarefas as $id_da_tarefa) {
            $sql_duracao = "select  tarefas.duracao from tarefas where tarefas.id_tarefa = $id_da_tarefa";
            $query = mysqli_query($conexao_adiciona_projeto, $sql_duracao) or die(mysql_error());
            if (!$query) {
                $erro_adiciona_projeto++;
            }
            $duracao = mysqli_fetch_row($query);
            $duracao_projeto = $duracao[0];
            $duracao_total = $this->somahora($duracao_total, $duracao_projeto);
             $cont_tarefa ++;
        }
        if($cont_tarefa > 1){
             $sql_projeto = "insert into projeto (nome,duracao,descricao,id_ugb,flag_quant_tarefa) values ('$nome','$duracao_total','$descricao_projeto','$ugb','1')"; 
        }else{
            $sql_projeto = "insert into projeto (nome,duracao,descricao,id_ugb,flag_quant_tarefa) values ('$nome','$duracao_total','$descricao_projeto','$ugb','0')"; 
        }
        $query_insert_projeto = mysqli_query($conexao_adiciona_projeto, $sql_projeto) or die(mysql_error());
        if (!$query_insert_projeto) {
            $erro_adiciona_projeto++;
        }

        $id_projeto = mysqli_insert_id($conexao_adiciona_projeto);
        foreach ($tarefas as $tarefas_projeto) {
            $sql_tarefas_projeto = "insert into tarefas_projeto (id_projeto,id_tarefa) values ('$id_projeto','$tarefas_projeto')";
            if (!mysqli_query($conexao_adiciona_projeto, $sql_tarefas_projeto)) {
                $erro_adiciona_projeto++;
            }
        }

        if ($erro_adiciona_projeto == 0 && !empty($id_projeto)) {
            mysqli_commit($conexao_adiciona_projeto);
            return true;
        } else {
            mysqli_rollback($conexao_adiciona_projeto);
            return false;
        }
    }

    function getDuracaoProjeto($tarefas_do_projeto) {
        $conexao_get_duracao = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        mysqli_autocommit($conexao_get_duracao, FALSE);
        $erro_get_duracao = 0;
        foreach ($tarefas_do_projeto as $id_tarefa) {
            $sql_duracao = "select tarefas.duracao from tarefas where tarefas.id_tarefa = $id_tarefa";
            $query_duracao = mysqli_query($conexao_get_duracao, $sql_duracao) or die(mysql_error());
            if (!$query_duracao) {
                $erro_get_duracao++;
            } else {
                $duracao = mysqli_fetch_row($query_duracao);
                $duracao_projeto = $duracao[0];
                $duracao_total = $this->somahora($duracao_total, $duracao_projeto);
            }
        }
        if ($erro_get_duracao == 0) {
            mysqli_commit($conexao_get_duracao);
            return $duracao_total;
        } else {
            mysqli_rollback($conexao_get_duracao);
            return $duracao_total = "";
        }
    }

    function Atualizar_projeto(Projetos $obj) {
        $codigo_do_projeto = $obj->getId_projeto();
        $nome_do_projeto = $obj->getNome_projeto();
        $descricao_do_projeto = $obj->getDescricao();
        $tarefas_projetos = $obj->getTarefas();
        $ugb = $obj->getUgb();
        $duracao_projeto = $this->getDuracaoProjeto($tarefas_projetos);
      
            $conexao_atualiza_projeto = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
            mysqli_autocommit($conexao_atualiza_projeto, FALSE);
            $erro_atualiza_projeto = 0;
            $cont_tarefas_atualiza = 0;
            $sql_projeto = "update  projeto set nome='$nome_do_projeto' ,duracao='$duracao_projeto'  ,descricao ='$descricao_do_projeto',id_ugb = $ugb  where projeto.id_projeto = $codigo_do_projeto";
            if (!mysqli_query($conexao_atualiza_projeto, $sql_projeto)) {
                $erro_atualiza_projeto++;
            }

            $sql_delete = "delete from tarefas_projeto where tarefas_projeto.id_projeto = $codigo_do_projeto";
            if (!mysqli_query($conexao_atualiza_projeto, $sql_delete)) {
                $erro_atualiza_projeto++;
            }
            foreach ($tarefas_projetos as $tarefas_projeto) {
                $sql_tarefas_projeto = "insert into tarefas_projeto (id_projeto,id_tarefa) values ('$codigo_do_projeto','$tarefas_projeto')";
                $query_insert_tarefas_projeto = mysqli_query($conexao_atualiza_projeto, $sql_tarefas_projeto) or die(mysql_error());
                if (!$query_insert_tarefas_projeto) {
                    $erro_atualiza_projeto++;
                }
                $cont_tarefas_atualiza ++;
            }
            if($cont_tarefas_atualiza > 1){
                $atualiza_flag_tarefa_projeto = "update projeto set flag_quant_tarefa = 1 where projeto.id_projeto = $codigo_do_projeto";
            }else{
                $atualiza_flag_tarefa_projeto = "update projeto set flag_quant_tarefa = 0 where projeto.id_projeto = $codigo_do_projeto"; 
            }
            if (!mysqli_query($conexao_atualiza_projeto, $atualiza_flag_tarefa_projeto)) {
                $erro_atualiza_projeto++;
            }
            
            $atualiza_projeto = "update projeto_executa set nome_projeto='$nome_do_projeto' where projeto_executa.id_projeto = $codigo_do_projeto";
            if (!mysqli_query($conexao_atualiza_projeto, $atualiza_projeto)) {
                $erro_atualiza_projeto++;
            }

            if ($erro_atualiza_projeto == 0) {
                mysqli_commit($conexao_atualiza_projeto);
                return true;
            } else {
               mysqli_rollback($conexao_atualiza_projeto);
                return false;
            }
    }

}
