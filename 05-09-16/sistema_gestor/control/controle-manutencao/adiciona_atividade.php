<?php
  include '../../model/controle-manutencao/ControleManutencao.php';
  $controle = new ControleManutencao();
  $id_projeto = $_POST['projeto'];
  $tipo_atividade = $_POST['campo_select_tipo'];
  
  if (empty($id_projeto) || empty($tipo_atividade)) {
    echo "<script>alert('Prencha todos os campos');</script>";
 } else {
    try {
      if($controle->addAtividade($id_projeto, $tipo_atividade)){
          echo "<script>alert('Atividade salva com sucesso');</script>";
          echo "<script>location.href='telaPrincipal.php?t=atividades-controle'</script>";
       }else{
           echo "<script>alert('Ocorreu algum problema ao inserir a atividade');</script>"; 
       }
     } catch (Exception $ex) {
        echo $ex->getMessage(); 
    }
}
?>
