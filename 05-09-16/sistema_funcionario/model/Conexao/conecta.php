<?php
      $host="localhost";
      $user="root";
      $pass="96529373";
      $banco="Sistema de Gerenciamento";
      $conexao=mysql_connect($host,$user,$pass)or die(mysql_error());
      $bd = mysql_select_db($banco,$conexao)or die(mysql_error());        
?>
   
