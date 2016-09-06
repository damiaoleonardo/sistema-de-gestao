<?php

class tabelaHoras {

    private $id_funcionario;
    private $data_inicio;
    private $data_final;

    function getId_funcionario() {
        return $this->id_funcionario;
    }

    function getData_inicio() {
        return $this->data_inicio;
    }

    function getData_final() {
        return $this->data_final;
    }

    function setId_funcionario($id_funcionario) {
        $this->id_funcionario = $id_funcionario;
    }

    function setData_inicio($data_inicio) {
        $this->data_inicio = $data_inicio;
    }

    function setData_final($data_final) {
        $this->data_final = $data_final;
    }

    function getTabelaHorasDia(tabelaHoras $obj) {
        $id_funcionario = $obj->getId_funcionario();
        $data_inicio = $obj->getData_inicio();
        $conexao_tabela_hora = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_tabela_hora->set_charset("utf8");
        $tabela_horas = "select projeto.nome from projeto where projeto.id_projeto= $id_do_projeto";
        $result_tabela_horas = mysqli_query($conexao_tabela_hora, $tabela_horas);
        if ($result_tabela_horas) {
            while ($row = $result_tabela_horas->fetch_assoc()) {
               // $nome_projeto = $row['nome'];
            }
            $result_tabela_horas->free();
        } else {
            throw new Exception('<script>alert("Ocorreu um erro na busca pela tabela de horas!")</script>');
        }
    }

    function getTabelaHorasPeriodo(tabelaHoras $obj) {
        $id_funcionario = $obj->getId_funcionario();
        $data_inicio = $obj->getData_inicio();
        $data_final = $obj->getData_final();
    }

}
