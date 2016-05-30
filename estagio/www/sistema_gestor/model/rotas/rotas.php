<?php

class rotas {
    private $codigo;
    private $nome_rota;
    private $cor;

    function getCodigo() {
        return $this->codigo;
    }

    function getNome_rota() {
        return $this->nome_rota;
    }

    function getCor() {
        return $this->cor;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNome_rota($nome_rota) {
        $this->nome_rota = $nome_rota;
    }

    function setCor($cor) {
        $this->cor = $cor;
    }

    function getRotas($busca_rotas) {
        $parametro = $busca_rotas;
        $msg = "";
        $msg .="<table class='table table-hover'>";
        require_once('../../model/Conexao/Conexao.php');
        try {
            $pdo = new Conexao();
            $resultado = $pdo->select("SELECT rotas.id_rota,rotas.nome_rota,rotas.cor from rotas
WHERE rotas.id_rota > 0 and rotas.nome_rota LIKE '$parametro%' ORDER BY rotas.nome_rota ASC");
            $pdo->desconectar();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (count($resultado)) {
            foreach ($resultado as $res) {

                $msg .="				<tr>";
                $msg .="					<td style = 'font-size:0.9em; text-align: left;'>" . $res['id_rota'] . "</td>";
                $msg .="					<td style='font-size:0.9em; text-align: left;'>" . $res['nome_rota'] . "</td>";
                $msg .="					<td style='font-size:0.9em;'>" . $res['cor'] . "</td>";
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
    
    function addRota(rotas $obj){
        
    }
    function updateRota(rotas $obj){
        
    }

}
