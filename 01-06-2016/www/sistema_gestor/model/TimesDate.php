<?php

class TimesDate {

    function horadobanco() {
        $sql_hora = "SELECT DATE_FORMAT(now(),'%H:%i:%s')";
        $result_hora = mysql_query($sql_hora);
        $hora_inicio = mysql_fetch_row($result_hora);
        $horainicio_tarefa = $hora_inicio[0];
        return $horainicio_tarefa;
    }

    function diasemana($var) {
        switch ($diasemana) {

            case"5": $dia_semana = 5;
                break;
         }
        return $dia_semana;
    }

}
