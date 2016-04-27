<?php
      require '../model/tela_principal/getInformacoes.php';  
      $exibe_projeto = new getInformacoes();
      $exibe_projeto->exibeProjetos();
?>