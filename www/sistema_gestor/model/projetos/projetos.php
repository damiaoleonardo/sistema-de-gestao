<?php

class projetos {

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

    function setNome_projeto($nome_projeto, $flag_projeto) {
        if ($flag_projeto == 1) {
            $result_adiciona = mysql_query("select projeto.nome from projeto where projeto.nome = '$nome_projeto'");
            if (mysql_num_rows($result_adiciona)) {
                throw new Exception('<script>alert("Nome ja existente, por favor tente outro!")</script>');
            } else {
                $this->nome_projeto = $nome_projeto;
            }
        } else if ($flag_projeto == 2) {
            session_start("nome_projeto");
            $nome_projeto_atual = $_SESSION['nome_do_projeto'];
            if ($nome_projeto_atual == $nome_projeto) {
                $this->nome_projeto = $nome_projeto;
            } else {
                $result_atualiza = mysql_query("select projeto.nome from projeto where projeto.nome = '$nome_projeto'");
                if (mysql_num_rows($result_atualiza)) {
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
                $msg .="					<td style = 'font-size:0.8em; text-align: left;'><a href='telaprincipal.php?t=/vprojetos&&id= " . $res['id_projeto'] . "' style='color:black;'>" . $res['nome'] . "</a></td>";
                $msg .="					<td style='font-size:0.8em;'>" . $res['duracao'] . "</td>";
                $msg .="                                        <td style = 'font-size:0.8em; text-align: left;'>" . $res['descricao'] . "</td>";
                $msg .="                                        <td style='font-size:0.8em;'><a href='telaprincipal.php?t=/eprojeto&id= " . $res['id_projeto'] . "'><img src=\"../img/8427_16x16.png\"/></a></td>";
                $msg .="                                        <td style='font-size:0.8em;'><a href='telaprincipal.php?t=/cprojeto&id= " . $res['id_projeto'] . "&flag=1' onClick=\"return confirm('Deseja realmente deletar o produto:')\"><img src=\"../img/excluir.png\"/></a></td>";
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

        foreach ($tarefas as $id_da_tarefa) {
            $sql_duracao = "select  tarefas.duracao from tarefas where tarefas.id_tarefa = $id_da_tarefa";
            $query = mysqli_query($conexao_adiciona_projeto, $sql_duracao) or die(mysql_error());
            if (!$query) {
                $erro_adiciona_projeto++;
            }
            $duracao = mysqli_fetch_row($query);
            $duracao_projeto = $duracao[0];
            $duracao_total = $this->somahora($duracao_total, $duracao_projeto);
        }

        $sql_projeto = "insert into projeto (nome,duracao,descricao) values ('$nome','$duracao_total','$descricao_projeto')";
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

    function Atualizar_projeto(Projetos $obj) {
        $codigo_do_projeto = $obj->getId_projeto();
        $nome_do_projeto = $obj->getNome_projeto();
        $duracao_do_projeto = $obj->getDuracao();
        $descricao_do_projeto = $obj->getDescricao();
        $tarefas_projetos = $obj->getTarefas();
        $sql_projeto = "update  projeto set nome='$nome_do_projeto' ,duracao='$duracao_do_projeto'  ,descricao ='$descricao_do_projeto' where projeto.id_projeto = $codigo_do_projeto";
        mysql_query($sql_projeto);
        mysql_query("delete from tarefas_projeto where tarefas_projeto.id_projeto = $codigo_do_projeto");
        foreach ($tarefas_projetos as $tarefas_projeto) {
            $sql_tarefas_projeto = "insert into tarefas_projeto (id_projeto,id_tarefa) values ('$codigo_do_projeto','$tarefas_projeto')";
            mysql_query($sql_tarefas_projeto);
        }
        mysql_query("update projeto_executa set nome_projeto='$nome_do_projeto' where projeto_executa.id_projeto = $codigo_do_projeto");
    }

}
