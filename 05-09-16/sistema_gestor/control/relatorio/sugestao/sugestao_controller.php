<?php
require ('../../../model/relatorios/sugestao/sugestao.php');
$sugestao = new sugestao();
$sobrenome = $_POST['campo_select_funcionario'];
$data_inicio = $_POST['data_inicio'];
$data_final = $_POST['data_final'];

if (empty($sobrenome)) {
    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>E necessario o preenchimento do campo funcionario</p>";
}else {
   if(empty($data_inicio) and empty($data_final)){
        $sugestao->setFuncionario($sobrenome);
        $sql_sugestao = $sugestao->funcionarios($sugestao);
        $sugestao->montatabela($sql_sugestao);
    }else if(!empty($data_inicio) and empty($data_final)){
        $sugestao->setFuncionario($sobrenome);
        $sugestao->setData_inicial($data_inicio);
        $sql_sugestao = $sugestao->funcionariosDataInicial($sugestao);
        $sugestao->montatabela($sql_sugestao);
    }else if(!empty($data_inicio) and !empty($data_final)){
        $sugestao->setFuncionario($sobrenome);
        $sugestao->setData_inicial($data_inicio);
        $sugestao->setData_final($data_final);
        $sql_sugestao = $sugestao->funcionariosDatas($sugestao);
        $sugestao->montatabela($sql_sugestao);
    }else{
      echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";  
    }
}

?>
