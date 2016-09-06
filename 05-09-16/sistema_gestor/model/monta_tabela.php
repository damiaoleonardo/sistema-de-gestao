<?php

class monta_tabela {
    
    function  geraSql(){
    }           
   function geraTabela($rs, $headers){
      $s = "<table class='table table-hover' >";
	  $s .= "<tr class='titulo'>";
	  foreach ($headers as $header)	  {
		  $s .=  "<td class='titulocelula'>$header</td>";
	   }
	  $s .= "</tr>";		  
	  while ($row = mysql_fetch_object($rs)){
		  $s .= "<tr  class='linha'>";
		  foreach ($row as $data){
			  $s .=  "<td  class='linhacelula'>$data</td>";
		  }		  
		  $s .= "</tr>";		  		  
	  }
	  $s .= "</table>";	  
	  echo $s;
   }

}
