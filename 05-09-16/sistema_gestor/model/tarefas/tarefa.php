<?php

class Tarefa {

    private $nome_tarefa;
    private $nome_atualiza;
    private $duracao;
    private $pessoa_certificador;
    private $descricao;
    private $id_tarefa;

    function getNome_atualiza() {
        return $this->nome_atualiza;
    }

    function setNome_atualiza($nome_atualiza) {
        $this->nome_atualiza = $nome_atualiza;
    }

    function getId_tarefa() {
        return $this->id_tarefa;
    }

    function setId_tarefa($id_tarefa) {
        $this->id_tarefa = $id_tarefa;
    }

    function getNome() {
        return $this->nome_tarefa;
    }

    function getDuracao() {
        return $this->duracao;
    }

    function getCertificador() {
        return $this->pessoa_certificador;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getNomeTarefa($id_tarefa) {
        $conexao_nome_tarefa = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_nome_tarefa->set_charset("utf8");
        $result_nome = "select tarefas.nome from tarefas where tarefas.id_tarefa= $id_tarefa";
        $result_dados = mysqli_query($conexao_nome_tarefa, $result_nome);
        if ($result_dados) {
            while ($row = $result_dados->fetch_assoc()) {
                $nome_tarefas = $row['nome'];
            }
            $result_dados->free();
            return $nome_tarefas;
        } else {
            throw new Exception('<script>alert("Ocorreu um erro na busca pelo nome da tarefa!")</script>');
        }
    }

    function setNome($nome, $flag_tarefa) {
        if ($flag_tarefa == 1) {
            $conexao_insert_nome_tarefa = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
            mysqli_autocommit($conexao_insert_nome_tarefa, FALSE);
            $result_adiciona_nome = "select tarefas.nome from tarefas where tarefas.nome= '$nome'";
            $conexao_insert_nome_tarefa->query($result_adiciona_nome);

            if ($conexao_insert_nome_tarefa->affected_rows > 0) {
                throw new Exception('<script>alert("Nome ja existente, por favor tente outro!")</script>');
            } else {
                $this->nome_tarefa = $nome;
            }
        } else if ($flag_tarefa == 2) {
            $id_da_tarefa = $this->getId_tarefa();
            $nome_atual = $this->getNomeTarefa($id_da_tarefa);
            if ($nome_atual == $nome) {
                $this->nome_tarefa = $nome;
            } else {
                $conexao_atualiza_nome_tarefa = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
                $result_atualiza_nome = "select tarefas.nome from tarefas where tarefas.nome= '$nome'";
                $conexao_atualiza_nome_tarefa->query($result_atualiza_nome);

                if ($conexao_atualiza_nome_tarefa->affected_rows > 0) {
                    throw new Exception('<script>alert("Nome ja existente, por favor tente outro!")</script>');
                } else {
                    $this->nome_tarefa = $nome;
                }
            }
        }
    }

    function setDuracao($duracao) {
        $this->duracao = $duracao;
    }

    function setCertificador($certificador) {
        $this->pessoa_certificador = $certificador;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function getcheckbox($id_da_tarefa, $id_do_funcionario) {
        $conexao_id_funcionario = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $sql_certificacoes = "select certificacoes.id_funcionario from certificacoes where certificacoes.id_tarefa = $id_da_tarefa";
        $result_select_id_funcionario = mysqli_query($conexao_id_funcionario, $sql_certificacoes);
        if ($result_select_id_funcionario) {
            while ($aux_certificacoes = $result_select_id_funcionario->fetch_assoc()) {
                $id_funci = $aux_certificacoes['id_funcionario'];
                if ($id_funci == $id_do_funcionario) {
                    return 1;
                }
            }
            return 0;
        }
    }

    function getDadosTarefas($id_tarefa) {
        $dados_tarefas = array();
        $conexao_dados_tarefa = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_dados_tarefa->set_charset("utf8");
        $sql_getTarefas = "select tarefas.nome,tarefas.duracao,tarefas.descricao  from tarefas where tarefas.id_tarefa = $id_tarefa";
        $result_select_dados = mysqli_query($conexao_dados_tarefa, $sql_getTarefas);
        if ($result_select_dados) {
            while ($row = $result_select_dados->fetch_assoc()) {
                $dados_tarefas[] = $row['nome'];
                $dados_tarefas[] = $row['duracao'];
                $dados_tarefas[] = $row['descricao'];
            }
            $result_select_dados->free();
        }
        return $dados_tarefas;
    }

    function getTarefas($nome_busca) {
        $parametro = $nome_busca;
        $msg = "";
        $msg .="<table class='table table-hover'>";
        require_once('../../model/Conexao/Conexao.php');
        try {
            $pdo = new Conexao();
            $resultado = $pdo->select("SELECT * FROM tarefas WHERE nome LIKE '$parametro%' ORDER BY tarefas.id_tarefa ");
            $pdo->desconectar();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (count($resultado)) {
            foreach ($resultado as $res) {

                $msg .="				<tr>";
                $msg .="					<td style = ' font-size:0.8em; text-align: left;'>" . $res['id_tarefa'] . "</td>";
                $msg .="					<td style = ' font-size:0.8em; text-align: left;'>" . $res['nome'] . "</td>";
                $msg .="					<td style='font-size:0.8em;'>" . $res['duracao'] . "</td>";
                $msg .="                                        <td style = ' font-size:0.8em; text-align: left;'>" . $res['descricao'] . "</td>";
                $msg .="                                        <td style='font-size:0.8em;'><a href='telaPrincipal.php?t=tarefas&ta=edit-tarefa&id= " . $res['id_tarefa'] . "'><img src=\"../img/8427_16x16.png\"/></a></td>";
                $msg .="                                        <td style='font-size:0.8em;'><a href='telaprincipal.php?t=tarefas&id_tarefa= " . $res['id_tarefa'] . "&flag_tarefa=1' onClick=\"return confirm('Deseja realmente deletar o produto:')\"><img src=\"../img/excluir.png\"/></a></td>";
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

    function addTarefa(Tarefa $obj) {
        $nome = $obj->getNome();
        $duracao = $obj->getDuracao();
        $certificador = $obj->getCertificador();
        $descricao_tarefa = $obj->getDescricao();
        $conexao_adiciona_tarefa = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        mysqli_autocommit($conexao_adiciona_tarefa, FALSE);
        $erro_adiciona_tarefa = 0;
        $sql_insert = "insert into tarefas (nome,duracao,descricao) values('$nome','$duracao','$descricao_tarefa')";
        if (!mysqli_query($conexao_adiciona_tarefa, $sql_insert)) {
            $erro_adiciona_tarefa++;
        }
        $id_tarefa = mysqli_insert_id($conexao_adiciona_tarefa);
        foreach ($certificador as $certificador_tarefa) {
            $sql_certificacoes = "insert into certificacoes (id_tarefa,id_funcionario) values ('$id_tarefa','$certificador_tarefa')";
            if (!mysqli_query($conexao_adiciona_tarefa, $sql_certificacoes)) {
                $erro_adiciona_tarefa++;
            }
        }
        if ($erro_adiciona_tarefa == 0) {
            mysqli_commit($conexao_adiciona_tarefa);
            return true;
        } else {
            mysqli_rollback($conexao_adiciona_tarefa);
            return false;
        }
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

    function atualizaTarefa(Tarefa $obj) {
        $id_tarefa = $obj->getId_tarefa();
        $nome_tarefa = $obj->getNome();
        $duracao = $obj->getDuracao();
        $certificador = $obj->getCertificador();
        $descricao_tarefa = $obj->getDescricao();

        $conexao_atualiza_tarefa = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        mysqli_autocommit($conexao_atualiza_tarefa, FALSE);
        $erro_atualiza_tarefa = 0;
        $sql_atualiza_tarefa = "update tarefas set nome='$nome_tarefa',duracao='$duracao',descricao='$descricao_tarefa' where tarefas.id_tarefa = $id_tarefa";
        if (!mysqli_query($conexao_atualiza_tarefa, $sql_atualiza_tarefa)) {
            $erro_atualiza_tarefa++;
        }
        $sql_delete = "delete from certificacoes where id_tarefa= $id_tarefa";
        if (!mysqli_query($conexao_atualiza_tarefa, $sql_delete)) {
            $erro_atualiza_tarefa++;
        }
        foreach ($certificador as $certificador_tarefa) {
            $sql_certificacoes = "insert into certificacoes (id_tarefa,id_funcionario) values ('$id_tarefa','$certificador_tarefa')";
            if (!mysqli_query($conexao_atualiza_tarefa, $sql_certificacoes)) {
                $erro_atualiza_tarefa++;
            }
        }


        $duracao_total = "00:00:00";
        $sql_id_do_projeto = "select tarefas_projeto.id_projeto from tarefas_projeto where tarefas_projeto.id_tarefa = $id_tarefa";
        $result_select_id_projeto = mysqli_query($conexao_atualiza_tarefa, $sql_id_do_projeto);

        if (!$result_select_id_projeto) {
            $erro_atualiza_tarefa++;
        }
        $id_do_projeto = mysqli_fetch_row($result_select_id_projeto);
        $id_projeto = $id_do_projeto[0];

        if (!empty($id_projeto)) {
            $sql_tarefas_do_projeto = "select tarefas_projeto.id_tarefa from tarefas_projeto where tarefas_projeto.id_projeto = $id_projeto";
            $result_select_id_tarefa = mysqli_query($conexao_atualiza_tarefa, $sql_tarefas_do_projeto);
            if (!$result_select_id_tarefa) {
                $erro_atualiza_tarefa++;
            }

            while ($aux_tarefas_do_projeto = $result_select_id_tarefa->fetch_assoc()) {
                $id_da_tarefa_especifica = $aux_tarefas_do_projeto['id_tarefa'];

                $sql_duracao_da_tarefa = "select tarefas.duracao from tarefas where tarefas.id_tarefa = $id_da_tarefa_especifica";

                $result_select_duracao = mysqli_query($conexao_atualiza_tarefa, $sql_duracao_da_tarefa);
                if (!$result_select_duracao) {
                    $erro_atualiza_tarefa++;
                }
                $duracao_da_tarefa = mysqli_fetch_row($result_select_duracao);
                $duracao_tarefa = $duracao_da_tarefa[0];
                $duracao_total = $this->somahora($duracao_total, $duracao_tarefa);
            }

            $atualiza_projeto = "update projeto set duracao = '$duracao_total' where projeto.id_projeto = $id_projeto";
            if (!mysqli_query($conexao_atualiza_tarefa, $atualiza_projeto)) {
                $erro_atualiza_tarefa++;
            }
        }

        if ($erro_atualiza_tarefa == 0) {
            mysqli_commit($conexao_atualiza_tarefa);
            return true;
        } else {
            mysqli_rollback($conexao_atualiza_tarefa);
            return false;
        }
    }

}
