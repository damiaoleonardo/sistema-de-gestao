<?php

require('../model/Connection.class.php');
$conexao = Connection::getInstance();

class Tarefa {

    private $nome_tarefa;
    private $duracao;
    private $pessoa_certificador;
    private $descricao;
    private $id_tarefa;

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

    function setNome($nome, $flag_tarefa) {
        if ($flag_tarefa == 1) {
            $result = mysql_query("select tarefas.nome from tarefas where tarefas.nome= '$nome'");
            if (mysql_num_rows($result)) {
                throw new Exception('<script>alert("Nome ja existente, por favor tente outro!")</script>');
            } else {
                $this->nome_tarefa = $nome;
            }
        } else if ($flag_tarefa == 2) {
            session_start("nome_tarefa");
            $nome_tarefa_atual = $_SESSION['nome_da_tarefa'];
            if ($nome_tarefa_atual == $nome) {
                $this->nome_tarefa = $nome;
            } else {
                $result_atualiza = mysql_query("select tarefas.nome from tarefas where tarefas.nome = '$nome'");
                if (mysql_num_rows($result_atualiza)) {
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

    function addTarefa(Tarefa $obj) {
        $nome = $obj->getNome();
        $duracao = $obj->getDuracao();
        $certificador = $obj->getCertificador();
        $descricao_tarefa = $obj->getDescricao();
        $sql = "insert into tarefas (nome,duracao,descricao) values('$nome','$duracao','$descricao_tarefa')";
        mysql_query($sql);
        $id_tarefa = mysql_insert_id();
        foreach ($certificador as $certificador_tarefa) {
            $sql_certificacoes = "insert into certificacoes (id_tarefa,id_funcionario) values ('$id_tarefa','$certificador_tarefa')";
            mysql_query($sql_certificacoes);
        }
    }

    function AtualizaTarefa(Tarefa $obj) {
        $id_tarefa = $obj->getId_tarefa();
        $nome = $obj->getNome();
        $duracao = $obj->getDuracao();
        $certificador = $obj->getCertificador();
        $descricao_tarefa = $obj->getDescricao();
        $sql = "update tarefas set nome='$nome',duracao='$duracao',descricao='$descricao_tarefa' where id_tarefa = $id_tarefa";
        mysql_query($sql);
        $sql_delete = "delete from certificacoes where id_tarefa= $id_tarefa";
        mysql_query($sql_delete);
        foreach ($certificador as $certificador_tarefa) {
            $sql_certificacoes = "insert into certificacoes (id_tarefa,id_funcionario) values ('$id_tarefa','$certificador_tarefa')";
            mysql_query($sql_certificacoes);
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
        $duracao_total = "00:00:00";
        $sql_id_do_projeto = "select tarefas_projeto.id_projeto from tarefas_projeto where tarefas_projeto.id_tarefa = $id_tarefa";
        $result_id_do_projeto = mysql_query($sql_id_do_projeto);
        $id_do_projeto = mysql_fetch_row($result_id_do_projeto);
        $id_projeto = $id_do_projeto[0];      
        $sql_tarefas_do_projeto = "select tarefas_projeto.id_tarefa from tarefas_projeto where tarefas_projeto.id_projeto = $id_projeto";
        $result_das_tarefas = mysql_query($sql_tarefas_do_projeto);
        while ($aux_tarefas_do_projeto = mysql_fetch_array($result_das_tarefas)) {
            $id_da_tarefa_especifica = $aux_tarefas_do_projeto['id_tarefa'];
      
            $sql_duracao_da_tarefa = "select tarefas.duracao from tarefas where tarefas.id_tarefa = $id_da_tarefa_especifica";
            $result_duracao_da_tarefa = mysql_query($sql_duracao_da_tarefa);
            $duracao_da_tarefa = mysql_fetch_row($result_duracao_da_tarefa);
            $duracao_tarefa = $duracao_da_tarefa[0];
            $duracao_total = somahora($duracao_total, $duracao_tarefa); 
        }
 
         mysql_query("update projeto set duracao = '$duracao_total' where projeto.id_projeto = $id_projeto");
        
    }
}
