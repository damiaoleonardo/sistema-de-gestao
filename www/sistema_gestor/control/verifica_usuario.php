<?php
    require('../model/Conexao/Connection.class.php');
    $conexao = Connection::getInstance();  
     $nome_usuario = $_POST['usuario'];
     $senha = $_POST['senha'];
if (empty($nome_usuario) || empty($senha)) {
    echo "<script>alert('Por Favor preencha todos os campos necessarios!')</script>";
} else {
        // A vriavel $result pega as varias $login e $senha, faz uma pesquisa na tabela de usuarios
$result = mysql_query("SELECT funcionarios.login,funcionarios.senha FROM `funcionarios` WHERE `login` = '$nome_usuario' AND `senha`= '$senha' and `tipo`= 'Administrador'");
/* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */
if (mysql_num_rows($result) > 0) {
    $_SESSION['login'] = $nome_usuario;
    $_SESSION['senha'] = $senha;
    echo "<script>location.href='view/telaprincipal.php?t=home'</script>";
} else {
    unset($_SESSION['usuario']);
    unset($_SESSION['senha']);
    echo "<script>alert('Nome de Usuario ou Senha incorretos!')</script>";
}    
}
?>
  
