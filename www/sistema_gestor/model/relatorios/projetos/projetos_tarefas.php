<?php

class projetos_tarefas {

    private $id_projeto;
    private $id_veiculo;
    private $id_tarefa;
    private $id_funcionario;
    private $id_tipo_veiculo;
    private $data_inicial;
    private $data_final;

    function getId_projeto() {
        return $this->id_projeto;
    }

    function getId_veiculo() {
        return $this->id_veiculo;
    }

    function getId_tarefa() {
        return $this->id_tarefa;
    }

    function getId_funcionario() {
        return $this->id_funcionario;
    }

    function getId_tipo_veiculo() {
        return $this->id_tipo_veiculo;
    }

    function getData_inicial() {
        return $this->data_inicial;
    }

    function getData_final() {
        return $this->data_final;
    }

    function setId_projeto($id_projeto) {
        $this->id_projeto = $id_projeto;
    }

    function setId_veiculo($id_veiculo) {
        $this->id_veiculo = $id_veiculo;
    }

    function setId_tarefa($id_tarefa) {
        $this->id_tarefa = $id_tarefa;
    }

    function setId_funcionario($id_funcionario) {
        $this->id_funcionario = $id_funcionario;
    }

    function setId_tipo_veiculo($id_tipo_veiculo) {
        $this->id_tipo_veiculo = $id_tipo_veiculo;
    }

    function setData_inicial($data_inicial) {
        $this->data_inicial = $data_inicial;
    }

    function setData_final($data_final) {
        $this->data_final = $data_final;
    }

    function MontaSelectTarefas(projetos_tarefas $obj) {
        $id_tarefa = $obj->getId_tarefa();
        $sql = "select tarefas.id_tarefa,tarefas.nome from tarefas where 1";
        $result = mysql_query($sql);
    }

    function preencheSelectSetor() {
        $select = "SELECT id, nome from setores";
        $sql = mysql_query($select);

        echo "<select name='setor[]'>
          <option selected>-- Escolha o setor do funcionário --</option>";
        while ($dados = mysql_fetch_array($sql)) {
            $id_setor = $dados['id'];
            $nome_setor = $dados['nome'];

            echo"                        
            <option>$nome_setor</option>";
        }
        echo "</select>";
    }

    function Projetos(Relatorios $obj) {
        $id_projeto = $obj->getId_projeto();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,"
                . "projeto_executa.status,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao,veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa "
                . "from veiculos join projeto_executa on (veiculos.id_veiculo = projeto_executa.id_veiculo) join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto "
                . "and projeto_executa.id_veiculo = tarefas_executa.id_veiculo) where projeto_executa.id_projeto = $id_projeto";
        return $sql;
    }

    function Projetos_data(Relatorios $obj) {
        $id_projeto = $obj->getId_projeto();
        $data_inicio = $obj->getData_inicial();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas, projeto_executa.duracao, veiculos.nome_veiculo, tarefas_executa.descricao_da_tarefa
FROM projeto_executa
JOIN funcionario_executa ON ( funcionario_executa.id_projeto_executa = projeto_executa.id_projeto_executa
AND funcionario_executa.id_projeto = projeto_executa.id_projeto
AND funcionario_executa.id_veiculo = projeto_executa.id_veiculo )
JOIN veiculos ON ( veiculos.id_veiculo = projeto_executa.id_veiculo )
JOIN tarefas_executa ON ( projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa
AND projeto_executa.id_projeto = tarefas_executa.id_projeto
AND projeto_executa.id_veiculo = tarefas_executa.id_veiculo )
WHERE projeto_executa.id_projeto = $id_projeto
AND funcionario_executa.data_tarefa = '$data_inicio'";
        return $sql;
    }

    function Projetos_intervalos_datas(Relatorios $obj) {
        $id_projeto = $obj->getId_projeto();
        $data_inicio = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas, projeto_executa.duracao, veiculos.nome_veiculo, tarefas_executa.descricao_da_tarefa
FROM projeto_executa
JOIN funcionario_executa ON ( funcionario_executa.id_projeto_executa = projeto_executa.id_projeto_executa
AND funcionario_executa.id_projeto = projeto_executa.id_projeto
AND funcionario_executa.id_veiculo = projeto_executa.id_veiculo )
JOIN veiculos ON ( veiculos.id_veiculo = projeto_executa.id_veiculo )
JOIN tarefas_executa ON ( projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa
AND projeto_executa.id_projeto = tarefas_executa.id_projeto
AND projeto_executa.id_veiculo = tarefas_executa.id_veiculo )
WHERE projeto_executa.id_projeto = $id_projeto
and funcionario_executa.data_tarefa >= '$data_inicio' and funcionario_executa.data_tarefa <= '$data_final'";
        return $sql;
    }

    function Data(Relatorios $obj) {
        $data_inicial = $obj->getData_inicial();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas, projeto_executa.duracao, veiculos.nome_veiculo, tarefas_executa.descricao_da_tarefa
FROM projeto_executa
JOIN funcionario_executa ON ( funcionario_executa.id_projeto_executa = projeto_executa.id_projeto_executa
AND funcionario_executa.id_projeto = projeto_executa.id_projeto
AND funcionario_executa.id_veiculo = projeto_executa.id_veiculo )
JOIN veiculos ON ( veiculos.id_veiculo = projeto_executa.id_veiculo )
JOIN tarefas_executa ON ( projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa
AND projeto_executa.id_projeto = tarefas_executa.id_projeto
AND projeto_executa.id_veiculo = tarefas_executa.id_veiculo )
WHERE funcionario_executa.data_tarefa = '$data_inicial'";
        return $sql;
    }

    function Intervalos_data(Relatorios $obj) {
        $data_inicial = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas, projeto_executa.duracao, veiculos.nome_veiculo, tarefas_executa.descricao_da_tarefa
FROM projeto_executa
JOIN funcionario_executa ON ( funcionario_executa.id_projeto_executa = projeto_executa.id_projeto_executa
AND funcionario_executa.id_projeto = projeto_executa.id_projeto
AND funcionario_executa.id_veiculo = projeto_executa.id_veiculo )
JOIN veiculos ON ( veiculos.id_veiculo = projeto_executa.id_veiculo )
JOIN tarefas_executa ON ( projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa
AND projeto_executa.id_projeto = tarefas_executa.id_projeto
AND projeto_executa.id_veiculo = tarefas_executa.id_veiculo )
WHERE funcionario_executa.data_tarefa >= '$data_inicial' and funcionario_executa.data_tarefa <= '$data_final'";
        return $sql;
    }

    function Funcionario(Relatorios $obj) {
        $id_funcionario = $obj->getId_funcionario();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas,projeto_executa.duracao, veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa
                    FROM projeto_executa
                    JOIN funcionario_executa ON ( projeto_executa.id_veiculo = funcionario_executa.id_veiculo
                    AND projeto_executa.id_projeto = funcionario_executa.id_projeto
                    AND projeto_executa.id_projeto_executa = funcionario_executa.id_projeto_executa )
                    JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo)
                    WHERE funcionario_executa.id_funcionario = $id_funcionario";
        return $sql;
    }

    function Funcionario_data(Relatorios $obj) {
        $id_funcionario = $obj->getId_funcionario();
        $data_inicial = $obj->getData_inicial();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas,projeto_executa.duracao, veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa
                    FROM projeto_executa
                    JOIN funcionario_executa ON ( projeto_executa.id_veiculo = funcionario_executa.id_veiculo
                    AND projeto_executa.id_projeto = funcionario_executa.id_projeto
                    AND projeto_executa.id_projeto_executa = funcionario_executa.id_projeto_executa )
                    JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo)
                    WHERE funcionario_executa.id_funcionario = $id_funcionario and  funcionario_executa.data_tarefa = '$data_inicial'";
        return $sql;
    }

    function Funcionario_Intervalo_data(Relatorios $obj) {
        $id_funcionario = $obj->getId_funcionario();
        $data_inicial = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas,projeto_executa.duracao, veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa
                    FROM projeto_executa
                    JOIN funcionario_executa ON ( projeto_executa.id_veiculo = funcionario_executa.id_veiculo
                    AND projeto_executa.id_projeto = funcionario_executa.id_projeto
                    AND projeto_executa.id_projeto_executa = funcionario_executa.id_projeto_executa )
                    JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo)
                    WHERE funcionario_executa.id_funcionario = $id_funcionario and  funcionario_executa.data_tarefa >= '$data_inicial' and funcionario_executa.data_tarefa <= '$data_final'";
        return $sql;
    }

}
