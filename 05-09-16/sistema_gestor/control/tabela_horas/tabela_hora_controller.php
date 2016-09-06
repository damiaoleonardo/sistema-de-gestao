<?php
require ('../../model/tabela_horas/tabelaHoras.php');
$tabela_horas = new tabelaHoras();
$id_funcionario = $_POST['campo_select_funcionario'];
$data_inicio = $_POST['data_inicio'];
$data_final = $_POST['data_final'];

if (empty($sobrenome) || empty($data_inicio)){
    echo "<p style='margin: 100px 0px 0px 400px; font-size:1.2em;'>E necessario o preenchimento do campo funcionario ou do campo Data Inicio</p>";
} else {
   if(empty($data_final)){
       $tabela_horas->setId_funcionario($id_funcionario);
       $tabela_horas->setData_inicio($data_inicio);
       $tabela_horas->getTabelaHorasDia($tabela_horas);
   }else{
       $tabela_horas->setId_funcionario($id_funcionario);
       $tabela_horas->setData_inicio($data_inicio);
       $tabela_horas->setData_final($data_final);
       $tabela_horas->getTabelaHorasPeriodo($tabela_horas);
   } 
}
?>
