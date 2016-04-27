<?php

session_start();
require('../model/Connection.class.php');
$conexao = Connection::getInstance();
$nome_usuario = $_POST['usuario'];
$senha = $_POST['senha'];

if (empty($nome_usuario) || empty($senha)) {
    echo "<script>alert('Por Favor preencha todos os campos necessarios!')</script>";
} else {
    
    
    // A vriavel $result pega as varias $login e $senha, faz uma pesquisa na tabela de usuarios
$result = mysql_query("SELECT funcionarios.login,funcionarios.senha FROM `funcionarios` WHERE `login` = '$nome_usuario' AND `senha`= '$senha' and tipo= 'Funcionario'");
/* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */
if (mysql_num_rows($result) > 0) {
    $_SESSION['login'] = $nome_usuario;
    $_SESSION['senha'] = $senha;
    
    if ($nome_usuario == "admin") {
            echo "<script>location.href='view/tela_principal_admin.php'</script>";
        } else {
            echo "<script>location.href='view/tela_principal.php?login=$nome_usuario'</script>";
        }
} else {
    unset($_SESSION['usuario']);
    unset($_SESSION['senha']);
    echo "<script>alert('Nome de Usuario ou Senha incorretos!')</script>";
}
    
    
    /*
    $sql = "select Funcionarios.login,Funcionarios.senha from Funcionarios where Funcionarios.login = '$nome_usuario'";
    $result = mysql_query($sql);
    while ($pega_nome = mysql_fetch_array($result)) {
        $nome = $pega_nome['login'];
        $senha_funcionario = $pega_nome['senha'];
    }

    if (strcmp($nome, $nome_usuario) == 0 && strcmp($senha_funcionario, $senha) == 0 || $nome_usuario == "admin" && $senha == "leo96529373") {
        if ($nome_usuario == "admin") {
            echo "<script>location.href='view/tela_principal_admin.php'</script>";
        } else {
            echo "<script>location.href='view/tela_principal.php?login=$nome_usuario'</script>";
        }
    } else {
        echo "<script>alert('Nome de Usuario ou Senha incorretos!')</script>";
    }*/
    
    
}
?>


