<?php
      $host="localhost";
      $user="root";
      $pass="";
      $banco="sistema de gerenciamento";
      $conexao=mysql_connect($host,$user,$pass)or die(mysql_error());
      $bd = mysql_select_db($banco,$conexao)or die(mysql_error());        
?>
   
