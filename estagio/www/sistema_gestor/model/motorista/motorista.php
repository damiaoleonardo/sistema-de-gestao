<?php


class motorista {

    private $codigo;
    private $nome_motorista;

    function getCodigo() {
        return $this->codigo;
    }

    function getNome_motorista() {
        return $this->nome_motorista;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNome_motorista($nome_motorista) {
        $this->nome_motorista = $nome_motorista;
    }

    function getMotorista($busca_motorista) {
        $parametro = $busca_motorista;
        $msg = "";
        $msg .="<table class='table table-hover'>";
        require_once('../../model/Conexao/Conexao.php');
        try {
            $pdo = new Conexao();
            $resultado = $pdo->select("SELECT motoristas.id_motorista,motoristas.nome_motorista from motoristas
WHERE motoristas.id_motorista > 0 and motoristas.nome_motorista LIKE '$parametro%' ORDER BY motoristas.nome_motorista ASC");
            $pdo->desconectar();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (count($resultado)) {
            foreach ($resultado as $res) {
                $msg .="				<tr>";
                $msg .="					<td style = 'font-size:0.9em; text-align: left;'>" . $res['id_motorista'] . "</td>";
                $msg .="					<td style='font-size:0.9em; text-align: left;'>" . $res['nome_motorista'] . "</td>";
                $msg .="                                        <td style='font-size:0.9em;'><a href='telaPrincipal.php?t=veiculos&v=edit-veiculo&id= " . $res['id_veiculo'] . "&nome=" . $res['nome_veiculo'] . "&placa=" . $res['placa'] . "&tipo=" . $res['id_tipo'] . "'><img src=\"../img/8427_16x16.png\"/></a></td>";
                $msg .="                                        <td style='font-size:0.9em;'><a href='telaPrincipal.php?t=veiculos&id= " . $res['id_veiculo'] . "&flag=1' onClick=\"return confirm('Deseja realmente deletar o veiculo:')\" ><img src=\"../img/excluir.png\"/></a></td>";
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

    function addMotorista(motorista $obj) {
        
    }

    function updateMotorista(motorista $obj) {
        
    }

}
