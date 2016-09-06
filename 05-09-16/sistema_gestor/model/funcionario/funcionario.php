<?php

class funcionario {

    private $id_funcionario;
    private $nome;
    private $login;
    private $senha;
    private $sobrenome;
    private $endereco;
    private $data_nascimento;
    private $bairro;
    private $cep;
    private $cidade;
    private $rg;
    private $cpf;
    private $tipo;
    private $uf;
    private $celular;

    function getEndereco() {
        return $this->endereco;
    }

    function getData_nascimento() {
        return $this->data_nascimento;
    }

    function getRg() {
        return $this->rg;
    }

    function getCpf() {
        return $this->cpf;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setData_nascimento($data_nascimento) {
        $this->data_nascimento = $data_nascimento;
    }

    function setRg($rg) {
        $this->rg = $rg;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function getSobrenome() {
        return $this->sobrenome;
    }

    function setSobrenome($sobrenome) {
        $this->sobrenome = $sobrenome;
    }

    function getId_funcionario() {
        return $this->id_funcionario;
    }

    function setId_funcionario($id_funcionario) {
        $this->id_funcionario = $id_funcionario;
    }

    function getNome() {
        return $this->nome;
    }

    function getLogin() {
        return $this->login;
    }

    function getSenha() {
        return $this->senha;
    }

    function setNome($nome, $flag_funcionario) {
        if ($flag_funcionario == 1) {
            $query_nome = "select funcionarios.nome from funcionarios where nome = '$nome'";
            $nome_invalido = mysql_query($query_nome);
            while ($aux = mysql_fetch_array($nome_invalido)) {
                $nome_funcionario = $aux['nome'];
            }
            if (empty($nome_funcionario)) {
                $Caracteres_normais = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZÓÁÉÚÍÊêôÔóáéíú "; //67
                $cont = 0;
                for ($i = 0; $i < strlen($nome); $i++) {
                    for ($j = 0; $j < strlen($Caracteres_normais); $j++) {
                        if ($nome[$i] != $Caracteres_normais[$j]) {
                            $aux_cont ++;
                            if ($aux_cont >= 81) {
                                $cont++;
                            }
                        }
                    }
                    $aux_cont = 0;
                }
                if ($cont > 0) {
                    throw new Exception('<script>alert("o nome esta incorreto,verifique se nao tem nenhum carater especial no mesmo!")</script>');
                } else {
                    $this->nome = $nome;
                }
            } else {
                throw new Exception('<script>alert("Nome ja existente, por favor tente outro!")</script>');
            }
        } else if ($flag_funcionario == 2) {
            session_start("nome_atualiza");
            $nome_atual = $_SESSION['nome'];
            if ($nome == $nome_atual) {
                $this->nome = $nome;
            } else {
                $query_nome = "select funcionarios.nome from funcionarios where nome = '$nome'";
                $nome_invalido = mysql_query($query_nome);
                while ($aux = mysql_fetch_array($nome_invalido)) {
                    $nome_funcionario = $aux['nome'];
                }
                if (empty($nome_funcionario)) {
                    $Caracteres_normais = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZÓÁÉÚÍÊêôÔóáéíú "; //67
                    $cont = 0;
                    for ($i = 0; $i < strlen($nome); $i++) {
                        for ($j = 0; $j < strlen($Caracteres_normais); $j++) {
                            if ($nome[$i] != $Caracteres_normais[$j]) {
                                $aux_cont ++;
                                if ($aux_cont >= 81) {
                                    $cont++;
                                }
                            }
                        }
                        $aux_cont = 0;
                    }
                    if ($cont > 0) {
                        throw new Exception('<script>alert("o nome esta incorreto,verifique se nao tem nenhum carater especial no mesmo!")</script>');
                    } else {
                        $this->nome = $nome;
                    }
                } else {
                    throw new Exception('<script>alert("Nome ja existente, por favor tente outro!")</script>');
                }
            }
        }
    }

    function setLogin($login, $flag_login) {
        if ($flag_login == 1) {
            $query_login = "select funcionarios.login from funcionarios where login = '$login'";
            $login_invalido = mysql_query($query_login);
            while ($aux = mysql_fetch_array($login_invalido)) {
                $login_funcionario = $aux['login'];
            }
            if (empty($login_funcionario)) {
                $this->login = $login;
            } else {
                throw new Exception('<script>alert("Login ja existente, por favor tente outro!")</script>');
            }
        } else if ($flag_login == 2) {
            session_start("login_atualiza");
            $login_atual = $_SESSION['login'];
            if ($login == $login_atual) {
                $this->login = $login;
            } else {
                $query_login_atualiza = "select funcionarios.login from funcionarios where login = '$login'";
                $login_invalido_atualiza = mysql_query($query_login_atualiza);
                while ($aux = mysql_fetch_array($login_invalido_atualiza)) {
                    $login_funcionario = $aux['login'];
                }
                if (empty($login_funcionario)) {
                    $this->login = $login;
                } else {
                    throw new Exception('<script>alert("Login ja existente, por favor tente outro!")</script>');
                }
            }
        }
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function getBairro() {
        return $this->bairro;
    }

    function getCep() {
        return $this->cep;
    }

    function getCidade() {
        return $this->cidade;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    function setCep($cep) {
        $this->cep = $cep;
    }

    function getCelular() {
        return $this->celular;
    }

    function setCelular($celular) {
        $this->celular = $celular;
    }

    function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function getUf() {
        return $this->uf;
    }

    function setUf($uf) {
        $this->uf = $uf;
    }

    function getFuncionario($nome_busca) {
     $parametro = $nome_busca;
        $msg = "";
        $msg .="<table class='table table-hover' style='font-size:1.1em;'>";
        require_once('../../model/Conexao/Conexao.php');
        try {
            $pdo = new Conexao();
            $resultado = $pdo->select("SELECT * FROM funcionarios WHERE nome LIKE '$parametro%' ORDER BY funcionarios.id_funcionario ");
            $pdo->desconectar();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (count($resultado)) {
            foreach ($resultado as $res) {

                $msg .="				<tr>";
                $msg .="					<td style = ' width: 10%; text-align: left;'>" . $res['id_funcionario'] . "</td>";
                $msg .="					<td style =' width: 25%; text-align: left;'><a href='telaprincipal.php?t=/vfuncionario&&id= " . $res['id_funcionario'] . "' style='color:black;'>" . $res['nome'] . "</a></td>";
                $msg .="					<td style=' width: 20%; '>" . $res['sobrenome'] . "</td>";
                $msg .="                                        <td style=' width: 15%;'>" . $res['tipo'] . "</td>";
                $msg .="                                        <td>" . $res['disponibilidade'] . "</td>";
                $msg .="                                        <td><a href='telaprincipal.php?t=/edfuncionario&id= " . $res['id_funcionario'] . "'><img src=\"../img/8427_16x16.png\"/></a></td>";
                $msg .="                                        <td><a href='telaprincipal.php?t=/funcionarios&id= " . $res['id_funcionario'] . "&flag=1' onClick=\"return confirm('Deseja realmente deletar o produto:')\"><img src=\"../img/excluir.png\"/></a></td>";
                $msg .="				</tr>";
            }
        } else {
            $msg = "";
            $msg .="<center><p style='padding-top:4%;'>Nenhum Registro foi encontrado no Banco de Dados</p></center>";
        }
        $msg .="	</tbody>";
        $msg .="</table>";
        if (empty($msg)) {
            echo "<center><p style='padding-top:4%;'>Nenhum Registro foi encontrado no Banco de Dados</p></center>";
        } else {
            echo $msg;
        }
    }

    function AddFuncionario(funcionario $obj) {
        $login = $obj->getLogin();
        $senha = $obj->getSenha();
        $nome = $obj->getNome();
        $sobrenome = $obj->getSobrenome();
        $endereco = $obj->getEndereco();
        $data_nascimento = $obj->getData_nascimento();
        $bairro = $obj->getBairro();
        $cep = $obj->getCep();
        $cidade = $obj->getCidade();
        $rg = $obj->getRg();
        $cpf = $obj->getCpf();
        $tipo = $obj->getTipo();
        $uf = $obj->getUf();
        $celular = $obj->getCelular();
        if ($tipo == "Funcionario") {
            $disponibilidade = "inativo";
        } else {
            $disponibilidade = "---";
        }
        $query = "insert into funcionarios (nome,sobrenome,endereco,data_nascimento,bairro,municipio,uf,cep,rg,cpf,celular,disponibilidade,tipo,login,senha) "
                . "values ('$nome','$sobrenome','$endereco','$data_nascimento','$bairro','$cidade','$uf','$cep','$rg','$cpf','$celular','$disponibilidade','$tipo','$login','$senha')";
        mysql_query($query);
    }

    function AtualizaDados(funcionario $obj) {
        $id = $obj->getId_funcionario();
        $login = $obj->getLogin();
        $senha = $obj->getSenha();
        $nome = $obj->getNome();
        $sobrenome = $obj->getSobrenome();
        $endereco = $obj->getEndereco();
        $data_nascimento = $obj->getData_nascimento();
        $bairro = $obj->getBairro();
        $cep = $obj->getCep();
        $cidade = $obj->getCidade();
        $rg = $obj->getRg();
        $cpf = $obj->getCpf();
        $tipo = $obj->getTipo();
        $uf = $obj->getUf();
        $celular = $obj->getCelular();
        $query_atualiza = "update funcionarios set nome='$nome', sobrenome='$sobrenome', endereco='$endereco', data_nascimento='$data_nascimento', cep='$cep', municipio='$cidade', uf='$uf', bairro='$bairro', celular='$celular', rg='$rg', cpf='$cpf', tipo='$tipo', login='$login', senha='$senha' where id_funcionario = $id";
        mysql_query($query_atualiza);
    }

}
