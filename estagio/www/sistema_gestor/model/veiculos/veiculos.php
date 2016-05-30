<?php

require('../../model/Conexao/Connection.class.php');
$conexao = Connection::getInstance();

class veiculos {

    private $placa;
    private $nome_veiculo;
    private $tipo;
    private $id;

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getPlaca() {
        return $this->placa;
    }

    function getNome() {
        return $this->nome_veiculo;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setPlaca($placa) {
        if (preg_match('/^[a-z A-Z]{3}\-[0-9]{4}$/', $placa)) {
            $this->placa = $placa;
        } else {
            throw new Exception("Placa do veiculo esta incorreta");
        }
    }

    function getVeiculos($busca_veiculo) {
        $parametro = $busca_veiculo;
        $msg = "";
        $msg .="<table class='table table-hover'>";
        require_once('../../model/Conexao/Conexao.php');
        try {
            $pdo = new Conexao();
            $resultado = $pdo->select("SELECT veiculos.id_veiculo, veiculos.nome_veiculo, veiculos.placa, tipo_veiculo.tipo,tipo_veiculo.id_tipo FROM `veiculos`
JOIN `tipo_veiculo` ON ( veiculos.id_tipo = tipo_veiculo.id_tipo )
WHERE veiculos.id_veiculo > 0 and veiculos.nome_veiculo LIKE '$parametro%' ORDER BY veiculos.id_veiculo");
            $pdo->desconectar();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (count($resultado)) {
            foreach ($resultado as $res) {

                $msg .="				<tr>";
                $msg .="					<td style = 'font-size:0.8em; text-align: left;'>" . $res['id_veiculo'] . "</td>";
                $msg .="					<td style='font-size:0.8em;'>" . $res['nome_veiculo'] . "</td>";
                $msg .="					<td style='font-size:0.8em;'>" . $res['placa'] . "</td>";
                $msg .="                                        <td style='font-size:0.8em;'>" . $res['tipo'] . "</td>";
                $msg .="                                        <td style='font-size:0.8em;'><a href='telaPrincipal.php?t=veiculos&v=edit-veiculo&id= " . $res['id_veiculo'] . "&nome=" . $res['nome_veiculo'] . "&placa=" . $res['placa'] . "&tipo=" . $res['id_tipo'] . "'><img src=\"../img/8427_16x16.png\"/></a></td>";
                $msg .="                                        <td style='font-size:0.8em;'><a href='telaPrincipal.php?t=veiculos&id= " . $res['id_veiculo'] . "&flag=1' onClick=\"return confirm('Deseja realmente deletar o veiculo:')\" ><img src=\"../img/excluir.png\"/></a></td>";
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

    function setNome($nome_veiculo, $flag_veiculo) {
        if ($flag_veiculo == 1) {
            $result_adiciona = mysql_query("select veiculos.nome from veiculos where veiculos.nome= '$nome_veiculo'");
            if (mysql_num_rows($result_adiciona)) {
                throw new Exception('<script>alert("Nome ja existente, por favor tente outro!")</script>');
            } else {
                $this->nome_veiculo = $nome_veiculo;
            }
        } else if ($flag_veiculo == 2) {
            session_start("nome_veiculo");
            $nome_veiculo_atual = $_SESSION['nome_do_veiculo'];
            if ($nome_veiculo_atual == $nome_veiculo) {
                $this->nome_veiculo = $nome_veiculo;
            } else {
                $result_atualiza = mysql_query("select veiculos.nome from veiculos where veiculos.nome = '$nome_veiculo'");
                if (mysql_num_rows($result_atualiza)) {
                    throw new Exception('<script>alert("Nome ja existente, por favor tente outro!")</script>');
                } else {
                    $this->nome_veiculo = $nome_veiculo;
                }
            }
        }
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function AddVeiculos(Veiculos $obj) {
        $nome = $obj->getNome();
        $placa = $obj->getPlaca();
        $tipo = $obj->getTipo();
        $query = "insert into veiculos (nome_veiculo,placa,id_tipo) values ('$nome','$placa','$tipo')";
        mysql_query($query);
    }

    function AtualizaDados(Veiculos $obj) {
        $veiculo_atualiza = $obj->getNome();
        $placa_atualiza = $obj->getPlaca();
        $tipo_atualiza = $obj->getTipo();
        $id_do_veiculos_atualiza = $obj->getId();
        $query_atualiza = "UPDATE veiculos SET nome_veiculo='$veiculo_atualiza', placa='$placa_atualiza',id_tipo='$tipo_atualiza' where veiculos.id_veiculo= $id_do_veiculos_atualiza";
        mysql_query($query_atualiza);
    }

}
