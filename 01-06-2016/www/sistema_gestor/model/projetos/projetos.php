<?php

class projetos {

    private $id_projeto;
    private $nome_projeto;
    private $duracao;
    private $descricao;
    private $tarefas;

    function getId_projeto() {
        return $this->id_projeto;
    }

    function getNome_projeto() {
        return $this->nome_projeto;
    }

    function getDuracao() {
        return $this->duracao;
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

    function setDuracao($duracao) {
        $this->duracao = $duracao;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
        }

        function getProjetos($nome_busca){
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
$duracao_projeto = $obj->getDuracao();
$descricao_projeto = $obj->getDescricao();
$tarefas = $obj->getTarefas();
$sql_projeto = "insert into projeto (nome,duracao,descricao) values ('$nome','$duracao_projeto','$descricao_projeto')";
mysql_query($sql_projeto);
$id_projeto = mysql_insert_id();
foreach ($tarefas as $tarefas_projeto) {
$sql_tarefas_projeto = "insert into tarefas_projeto (id_projeto,id_tarefa) values ('$id_projeto','$tarefas_projeto')";
mysql_query($sql_tarefas_projeto);
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
