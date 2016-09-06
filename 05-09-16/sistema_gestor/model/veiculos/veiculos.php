<?php

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
                $msg .="                                        <td style='font-size:0.8em;'><a href='telaPrincipal.php?t=veiculos&id_veiculo= " . $res['id_veiculo'] . "&flag_veiculo=1' onClick=\"return confirm('Deseja realmente deletar o veiculo:')\" ><img src=\"../img/excluir.png\"/></a></td>";
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
    
    function getNomeVeiculo($id_veiculo){
        $conexao_nome_veiculo = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_nome_veiculo->set_charset("utf8");
        $result_nome_veiculo = "select veiculos.nome_veiculo from veiculos where veiculos.id_veiculo= $id_veiculo";
        $result_dados = mysqli_query($conexao_nome_veiculo, $result_nome_veiculo);
        if ($result_dados) {
            while ($row = $result_dados->fetch_assoc()) {
                $nome_veiculos = $row['nome_veiculo'];
            }
            $result_dados->free();
            return $nome_veiculos;
        } else {
            throw new Exception('<script>alert("Ocorreu um erro na busca pelo nome do veiculo!")</script>');
        } 
    }
    

    function setNome($nome_veiculo, $flag_veiculo) {
        if ($flag_veiculo == 1) {
            $conexao_insert_nome = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
            mysqli_autocommit($conexao_insert_nome, FALSE);
            $result_adiciona = "select veiculos.nome_veiculo from veiculos where veiculos.nome_veiculo='$nome_veiculo'";
            $conexao_insert_nome->query($result_adiciona);

            if ($conexao_insert_nome->affected_rows > 0) {
                throw new Exception('<script>alert("Nome ja existente, por favor tente outro!")</script>');
            } else {
                $this->nome_veiculo = $nome_veiculo;
            }
        } else if ($flag_veiculo == 2) {
            $id_do_veiculo = $this->getId();
            $nome_atual = $this->getNomeVeiculo($id_do_veiculo);
            if ($nome_atual == $nome_veiculo) {
                $this->nome_veiculo = $nome_veiculo;
            } else {
                $conexao_atualiza_nome = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
                mysqli_autocommit($conexao_atualiza_nome, FALSE);
                $result_atualiza = "select veiculos.nome_veiculo from veiculos where veiculos.nome_veiculo='$nome_veiculo'";
                $conexao_atualiza_nome->query($result_atualiza);
                if ($conexao_atualiza_nome->affected_rows > 0) {
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
        $conexao_adiciona_veiculo = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        mysqli_autocommit($conexao_adiciona_veiculo, FALSE);
        $erro_adiciona_veiculo = 0;
        $sql_insert_veiculo = "insert into veiculos (nome_veiculo,placa,id_tipo) values ('$nome','$placa','$tipo')";
        $query_insert_veiculo = mysqli_query($conexao_adiciona_veiculo, $sql_insert_veiculo) or die(mysql_error());
        if (!$query_insert_veiculo) {
            $erro_adiciona_veiculo++;
        }
        if ($erro_adiciona_veiculo == 0) {
            mysqli_commit($conexao_adiciona_veiculo);
            return true;
        } else {
            mysqli_rollback($conexao_adiciona_veiculo);
            return false;
        }
    }

    function AtualizaDados(veiculos $obj) {
        $veiculo_atualiza = $obj->getNome();
       $placa_atualiza = $obj->getPlaca();
        $tipo_atualiza = $obj->getTipo();
        $id_do_veiculos_atualiza = $obj->getId();
      
        $conexao_atualiza_veiculo = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        mysqli_autocommit($conexao_atualiza_veiculo, FALSE);
        $erro_atualiza_veiculo = 0;
        $sql_atualiza_veiculo = "UPDATE veiculos SET nome_veiculo='$veiculo_atualiza', placa='$placa_atualiza',id_tipo='$tipo_atualiza' where veiculos.id_veiculo= $id_do_veiculos_atualiza";
        $query_atualiza_veiculo = mysqli_query($conexao_atualiza_veiculo, $sql_atualiza_veiculo) or die(mysql_error());
        if (!$query_atualiza_veiculo) {
            $erro_atualiza_veiculo++;
        }
        if ($erro_atualiza_veiculo == 0) {
            mysqli_commit($conexao_atualiza_veiculo);
            return true;
        } else {
            mysqli_rollback($conexao_atualiza_veiculo);
            return false;
        }
    }

}
