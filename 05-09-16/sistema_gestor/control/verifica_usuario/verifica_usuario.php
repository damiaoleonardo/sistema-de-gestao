<?php
include '../../model/usuario/Usuario.php';
 $login_usuario = $_POST['usuario'];
 $senha_usuario = $_POST['senha'];
if (empty($login_usuario) || empty($senha_usuario)) {
    echo "<script>alert('Por Favor preencha todos os campos necessarios!')</script>";
} else {
    $usuario = new Usuario();
    $usuario->setLogin($login_usuario);
    $usuario->setSenha($senha_usuario);
    $autenticacao = $usuario->autenticaUsuario($usuario);
    if ($autenticacao) {
        session_start("usuario");
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
