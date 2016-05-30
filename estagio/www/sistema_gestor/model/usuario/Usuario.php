<?php
require('../../model/Conexao/Connection.class.php');
$conexao = Connection::getInstance();
class Usuario {

    private $login;
    private $senha;

    function getLogin() {
        return $this->login;
    }

    function getSenha() {
        return $this->senha;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function autenticaUsuario(Usuario $obj) {
         $login = $obj->getLogin();
         $senha = $obj->getSenha();
        $result = mysql_query("SELECT funcionarios.login,funcionarios.senha FROM `funcionarios` WHERE `login` = '$login' AND `senha`= '$senha' and `tipo`= 'Administrador'");
        if (mysql_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

}
