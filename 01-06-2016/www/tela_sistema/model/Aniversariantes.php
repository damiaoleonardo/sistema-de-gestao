<?php

class Aniversariantes {

    private $nome;
    private $data;

    function getNome() {
        return $this->nome;
    }

    function getData() {
        return $this->data;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setData($data) {
        $this->data = $data;
    }
    
    function invertedata($data, $separar="/", $juntar="/") {
        return implode($juntar, array_reverse(explode($separar, $data)));
    }


    function exibeAniversariantes() {
        ?>
        <table class="table table-hover">
            <tr>
                <td colspan="2" style="height: 80px; background: #255625;color:white; font-size:1.5em; ">Aniversariantes do mês</td>
            </tr>
            <?php
            $sql = "select funcionarios.sobrenome,funcionarios.data_nascimento from funcionarios where MONTH(data_nascimento) = MONTH(NOW())";
            $result_aniversariantes = mysql_query($sql);
            while ($aux_aniversariantes = mysql_fetch_array($result_aniversariantes)) {
                $nome_funcionario = $aux_aniversariantes['sobrenome'];
                $data = $aux_aniversariantes['data_nascimento'];
                $data_niver = $this->invertedata($data,"-", "/");
            ?>
            <tr style="height: 60px; font-size:1.2em;">
                <td><?php echo $nome_funcionario?></td>
                <td><?php echo $data_niver ?></td>
            </tr>
            <?php
            }
            ?>
        </table>

        <?php
    }

}
