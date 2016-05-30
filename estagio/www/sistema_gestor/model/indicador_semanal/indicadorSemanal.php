<?php

class indicadorSemanal {

    private $meta;
    private $semana;
    private $inicio;
    private $final;
    private $veiculos = array();

    function getVeiculos() {
        return $this->veiculos;
    }

    function setVeiculos($veiculos) {
        $this->veiculos = $veiculos;
    }

    function getmeta() {
        return $this->meta;
    }

    function getSemana() {
        return $this->semana;
    }

    function getInicio() {
        return $this->inicio;
    }

    function getFinal() {
        return $this->final;
    }

    function setmeta($meta) {
        $this->meta = $meta;
    }

    function setSemana($semana) {
        $this->semana = $semana;
    }

    function setInicio($inicio) {
        $this->inicio = $inicio;
    }

    function setFinal($final) {
        $this->final = $final;
    }

    function porcentagemAtingida(indicadorSemanal $obj) {
        $semana = $obj->getSemana();
        $meta = $obj->getmeta();
        $inicio_per = $obj->getInicio();
        $final_per = $obj->getFinal();
        $veiculos = $obj->getVeiculos();
        $total_de_veiculos = 0;
        $veiculos_trabalhados = 0;
        $data = array();
        foreach ($veiculos as $id_veiculo) {
            $sql_veiculo = "SELECT projeto_executa.id_veiculo from `projeto_executa` WHERE projeto_executa.data_inicio >= '$inicio_per' "
                    . "and projeto_executa.data_final <= '$final_per' and projeto_executa.id_projeto = 2 and projeto_executa.id_veiculo = $id_veiculo "
                    . "and projeto_executa.status = 'concluido' ";
            $result_veiculo = mysql_query($sql_veiculo);
            $retorno = mysql_fetch_row($result_veiculo);
            $valor_retornado = $retorno[0];
            if ($valor_retornado > 0) {
                 $veiculos_trabalhados ++;
            }
             $total_de_veiculos ++;
        }
        if ($veiculos_trabalhados == $total_de_veiculos) {
            $semana_anterioes = 3;
            $ano_atual = date('Y');
            while ($semana_anterioes > 0) {
                $valor_da_semana = $semana - $semana_anterioes;
                $sql_semanaanterior = "select indicador_semanal.semana,indicador_semanal.porcentual_atingido from indicador_semanal where indicador_semanal.ano = $ano_atual and indicador_semanal.semana = $valor_da_semana";
                $result_semana = mysql_query($sql_semanaanterior);
                while ($aux_semana = mysql_fetch_array($result_semana)) {
                    $semana_retornada = $aux_semana['semana'];
                    $porcentagem_atingida = $aux_semana['porcentual_atingido'];
                    if(!empty($semana_retornada) and !empty($porcentagem_atingida)){
                          $data[] = array($semana_retornada, $porcentagem_atingida);
                     }  
                 }
               $semana_anterioes --;
            }
            $data[] = array($semana, $meta);
            session_start("monta_grafico");
            $_SESSION['array'] = $data;
        } else if ($veiculos_trabalhados > $total_de_veiculos) {
            echo "passou da meta";
        } else {
            echo "nao bateu a meta";
        }
    }

}
