--- visualiza_imagem_foto.php  -----

<?php
$host = "localhost";
        $user = "root";
        $pass = "";
        $banco = "sistema_de_gestao";
        $conexao = mysql_connect($host, $user, $pass)or die(mysql_error());
        $bd = mysql_select_db($banco, $conexao)or die(mysql_error());

$id = $_GET['id'];

// Executa a query, trazendo os dados do banco
$query = "SELECT * FROM ugb_mes  where id_ugbmes = $id";
$resultado = mysql_query($query);

$foto = mysql_result($resultado, 0, "foto");
header("Content-type: $tipo");
print $foto;
?>