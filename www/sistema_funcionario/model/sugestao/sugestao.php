<?php
require('../../model/Conexao/Conexao.php');
class sugestao {

    private $nome_da_sugestao;
    private $id_funcionario;
    private $como_deve_ser;
    private $como_e_hoje;
    private $data_enviada;

    function getNome_da_sugestao() {
        return $this->nome_da_sugestao;
    }

    function getId_funcionario() {
        return $this->id_funcionario;
    }

    function getComo_deve_ser() {
        return $this->como_deve_ser;
    }

    function getComo_e_hoje() {
        return $this->como_e_hoje;
    }

    function getData_enviada() {
        return $this->data_enviada;
    }

    function setNome_da_sugestao($nome_da_sugestao) {
        $this->nome_da_sugestao = $nome_da_sugestao;
    }

    function setId_funcionario($id_funcionario) {
        $this->id_funcionario = $id_funcionario;
    }

    function setComo_deve_ser($como_deve_ser) {
        $this->como_deve_ser = $como_deve_ser;
    }

    function setComo_e_hoje($como_e_hoje) {
        $this->como_e_hoje = $como_e_hoje;
    }

    function setData_enviada($data_enviada) {
        $this->data_enviada = $data_enviada;
    }

    function getNomeFuncionario($id_funcionario) {
        $pdo = new Conexao();
        $resultado = $pdo->select("select funcionarios.sobrenome from funcionarios where funcionarios.id_funcionario= $id_funcionario");
        $pdo->desconectar();
        if (count($resultado)) {
            foreach ($resultado as $res) {
               return $nome_do_funcionario = $res['sobrenome'];
            }
        }else{
            echo "Nome da pessoa responsavel nao encontrado!";
        }     
    }

    function addSugestao(sugestao $obj) {
        $data_hj = date('Y-m-d');
        $id_do_funcionario = $obj->getId_funcionario();
        $dono_sugestao = $this->getNomeFuncionario($id_do_funcionario);
        $nome_da_sugestao = $obj->getNome_da_sugestao();
        $como_e_hoje = $obj->getComo_e_hoje();
        $como_deve_ser = $obj->getComo_deve_ser();
        $pdo_insert_sugestao = new Conexao();
        $pdo_insert_sugestao->select("insert into sugestoes (status,data_enviada,nome_sugestao,dono_da_sugestao,como_e_hoje,como_deve_ser) values('nao vista','$data_hj','$nome_da_sugestao','$dono_sugestao','$como_e_hoje','$como_deve_ser')");
        $pdo_insert_sugestao->desconectar();
    }

}
