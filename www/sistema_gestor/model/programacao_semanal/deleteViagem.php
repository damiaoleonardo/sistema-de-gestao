<?php
$mysqli = new mysqli('localhost', 'root', '', 'sistema_de_gestao');
if (mysqli_connect_errno()) {
    die('Não foi possível conectar-se ao banco de dados: ' . mysqli_connect_error());
    exit();
} else {
  // $query = " delete from programacao_semanal where id_diasemana =  x and id_motoristaA = x and id_motoristaB = x and id_rota = x and id_veiculo = x";
    if (mysqli_query($mysqli, $query)) {
        mysqli_commit($mysqli);
    } else {
        mysqli_rollback($mysqli);
    }
  }

?>


