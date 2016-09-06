<?php

class ControleManutencao {

    function monta_tabela_controle_preventiva() {
        ?>
        <table class="table table-hover" style="font-size: 1em; background: white;">
            <?php
            $sql_id_veiculo = "select veiculos.id_veiculo,veiculos.nome_veiculo,veiculos.placa from veiculos where veiculos.id_tipo != 5 and veiculos.id_tipo != 8";
            $result = mysql_query($sql_id_veiculo);
            while ($id_do_veiculo = mysql_fetch_array($result)) {
                $id_veiculo = $id_do_veiculo['id_veiculo'];
                $veiculo = $id_do_veiculo['nome_veiculo'];
                $placa_veiculo = $id_do_veiculo['placa'];
                //$aux_id_veiculo = $id_veiculo;
                ?>

                <tr>
                    <td style="width: 10%; "><?php echo $veiculo ?></td>
                    <td style="width: 10%;"><?php echo $placa_veiculo ?></td>
                    <?php
                    $sql_tarefas = "select veiculos.nome_veiculo,veiculos.placa,tarefas.nome,controle_manutencao.km,controle_manutencao.semana from `controle_manutencao` join `veiculos` on (controle_manutencao.id_veiculo_controle = veiculos.id_veiculo ) join `tarefas` on (tarefas.id_tarefa = controle_manutencao.id_tarefa_controle) where id_veiculo_controle = $id_veiculo ";
                    $result_tarefas = mysql_query($sql_tarefas);
                    while ($informaçoes_manutencao = mysql_fetch_array($result_tarefas)) {
                        $tarefa = $informaçoes_manutencao['nome'];
                        $km = $informaçoes_manutencao['km'];
                        $semana = $informaçoes_manutencao['semana'];
                        ?>
                        <td style="width: 20%; ">
                            <table  class="table table-hover">
                                <tr>
                                    <td style="color: royalblue; width: 50%;"><?php echo $km ?></td>
                                    <td style="color: royalblue; width: 50%;"><?php echo $semana ?></td>
                                </tr>
                            </table>
                        </td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
            }
            ?>

        </table>
        <?php
    }

    function tabelaVeiculoControle($id_veiculo) {
        $conexao_dados_veiculos = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_dados_veiculos->set_charset("utf8");
        $sql_dado_veiculo = "select veiculos.id_veiculo,veiculos.nome_veiculo,veiculos.placa,tarefas.nome,controle_manutencao.id_tarefa_controle from veiculos join controle_manutencao on (controle_manutencao.id_veiculo_controle = veiculos.id_veiculo) join tarefas on(controle_manutencao.id_tarefa_controle = tarefas.id_tarefa) where veiculos.id_veiculo = $id_veiculo and controle_manutencao.tipo_tarefa = 'preventiva'";
        $result_select_dados = mysqli_query($conexao_dados_veiculos, $sql_dado_veiculo);
        if ($result_select_dados) {
            session_start("identificador_veiculo");
            $_SESSION['id_veiculo'] = $id_veiculo;
            ?>
            <table class="table table-hover">
                <tr>
                    <td colspan="4">TABELA DAS TAREFAS</td>
                    <td><a href="#" onclick="openModal_adiciona_atividade('adiciona_atividade')" style="background: #0077b3; color:white;" type="submit"  class="btn btn-default">Adicionar Tarefa</a></td>
                </tr>
                <tr style="height: 20px;"></tr>
                <?php
                while ($row = $result_select_dados->fetch_assoc()) {
                    $id_veiculo = $row['id_veiculo'];
                    $nome_veiculo = $row['nome_veiculo'];
                    $placa = $row['placa'];
                    $id_tarefa = $row['id_tarefa_controle'];
                    $nome_tarefa = $row['nome'];
                    ?>
                    <tr>
                        <td style="width: 100px; "><?php echo $nome_veiculo ?></td>
                        <td style="width: 80px;  "><?php echo $placa ?></td>
                        <td style="width: 200px;"><?php echo $nome_tarefa ?></td>
                        <td style="width: 40px;"></td>
                        <td style="width: 40px;"><a href="" ><img src="../img/excluir.png" ></a></td>  
                    </tr>
                    <?php
                }
                $result_select_dados->free();
            }
            ?>
        </table>
        <?php
    }

    function tabelaVeiculoControle_inspecao($id_veiculo) {
        $conexao_dados_veiculos = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_dados_veiculos->set_charset("utf8");
        $sql_dado_veiculo = "select veiculos.id_veiculo,veiculos.nome_veiculo,veiculos.placa,tarefas.nome,controle_manutencao.id_tarefa_controle from veiculos join controle_manutencao on (controle_manutencao.id_veiculo_controle = veiculos.id_veiculo) join tarefas on(controle_manutencao.id_tarefa_controle = tarefas.id_tarefa) where veiculos.id_veiculo = $id_veiculo and controle_manutencao.tipo_tarefa = 'inspecao'";
        $result_select_dados = mysqli_query($conexao_dados_veiculos, $sql_dado_veiculo);
        if ($result_select_dados) {
            session_start("identificador_veiculo");
            $_SESSION['id_veiculo'] = $id_veiculo;
            ?>
            <table class="table table-hover">
                <tr>
                    <td colspan="4">TABELA DAS TAREFAS</td>
                    <td><a href="#" onclick="openModal_adiciona_atividade('adiciona_atividade')" style="background: #0077b3; color:white;" type="submit"  class="btn btn-default">Adicionar Tarefa</a></td>
                </tr>
                <tr style="height: 20px;"></tr>
                <?php
                while ($row = $result_select_dados->fetch_assoc()) {
                    $id_veiculo = $row['id_veiculo'];
                    $nome_veiculo = $row['nome_veiculo'];
                    $placa = $row['placa'];
                    $id_tarefa = $row['id_tarefa_controle'];
                    $nome_tarefa = $row['nome'];
                    ?>
                    <tr>
                        <td style="width: 100px; "><?php echo $nome_veiculo ?></td>
                        <td style="width: 80px;  "><?php echo $placa ?></td>
                        <td style="width: 200px;"><?php echo $nome_tarefa ?></td>
                        <td style="width: 40px;"></td>
                        <td style="width: 40px;"><a href="" ><img src="../img/excluir.png" ></a></td>  
                    </tr>
                    <?php
                }
                $result_select_dados->free();
            }
            ?>
        </table>
        <?php
    }

    function buscaAtividades($busca_atividades) {
        $parametro = $busca_atividades;
        $msg = "";
        $msg .="<table class='table table-hover'>";
        require_once('../../model/Conexao/Conexao.php');
        try {
            $pdo = new Conexao();
            $resultado = $pdo->select("SELECT atividades_controle.id_atividade_controle,atividades_controle.nome_atividade,atividades_controle.tipo_atividade from atividades_controle
WHERE atividades_controle.id_atividade_controle > 0 and atividades_controle.nome_atividade LIKE '$parametro%' ORDER BY atividades_controle.nome_atividade ASC");
            $pdo->desconectar();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (count($resultado)) {
            foreach ($resultado as $res) {

                $msg .="				<tr>";
                $msg .="					<td style='font-size:0.9em; width:10%; text-align: left;'>" . $res['id_atividade_controle'] . "</td>";
                $msg .="					<td style='font-size:0.9em; width:60%; text-align: left;'>" . $res['nome_atividade'] . "</td>";
                $msg .="					<td style='font-size:0.9em;width:10%; '>" . $res['tipo_atividade'] . "</td>";
                $msg .="                                        <td style='font-size:0.9em;width:10%; '><a href='telaPrincipal.php?t=atividades-controle&a=atualiza_atividade&id_atividade_controle= " . $res['id_atividade_controle'] . "'><img src=\"../img/8427_16x16.png\"/></a></td>";
                $msg .="                                        <td style='font-size:0.9em;width:10%;'><a href='telaPrincipal.php?t=atividades-controle&id_atividade_controle= " . $res['id_atividade_controle'] . "&flag_atividade=1' onClick=\"return confirm('Deseja realmente deletar o veiculo:')\" ><img src=\"../img/excluir.png\"/></a></td>";
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

    function verificaNome($nome, $flag_tarefa) {
        if ($flag_tarefa == 1) {
            $conexao_insert_nome_atividade = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
            mysqli_autocommit($conexao_insert_nome_atividade, FALSE);
            $result_adiciona_nome = "select atividades_controle.nome_atividade from atividades_controle where atividades_controle.nome_atividade= '$nome'";
            $conexao_insert_nome_atividade->query($result_adiciona_nome);
            if ($conexao_insert_nome_atividade->affected_rows > 0) {
                throw new Exception('<script>alert("Nome ja existente, por favor tente outro!")</script>');
            } else {
                return true;
            }
        } else if ($flag_tarefa == 2) {
            session_start("nome_atividade");
            $nome_atual = $_SESSION['nome_da_atividade'];
            $id_atividade = $_SESSION['id_atividade'];

            if ($nome_atual == $nome) {
                return $id_atividade;
            } else {
                $conexao_atualiza_nome_atividade = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
                $result_atualiza_nome = "select atividades_controle.nome_atividade from atividades_controle where atividades_controle.nome_atividade= '$nome'";
                $conexao_atualiza_nome_atividade->query($result_atualiza_nome);
                if ($conexao_atualiza_nome_atividade->affected_rows > 0) {
                    throw new Exception('<script>alert("Nome ja existente, por favor tente outro!")</script>');
                } else {
                    return $id_atividade;
                }
            }
        }
    }

    function getTipoTarefa($id_atividade) {
        $conexao_tipo_tarefa = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_tipo_tarefa->set_charset("utf8");
        $result_nome = "select atividades_controle.tipo_atividade from atividades_controle where atividades_controle.id_atividade_controle = $id_atividade";
        $result_dados = mysqli_query($conexao_tipo_tarefa, $result_nome);
        if ($result_dados) {
            while ($row = $result_dados->fetch_assoc()) {
                $tipo_atividade = $row['tipo_atividade'];
            }
            $result_dados->free();
            return $tipo_atividade;
        } else {
            throw new Exception('<script>alert("Ocorreu um erro na busca pelo nome da tarefa!")</script>');
        }
    }

    function addAtividade_controle($id_veiculo, $id_atividade) {
        $tipo_atividade = $this->getTipoTarefa($id_atividade);
        $conexao_adiciona_atividade_controle = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_adiciona_atividade_controle->set_charset("utf8");
        mysqli_autocommit($conexao_adiciona_atividade_controle, FALSE);
        $erro_adiciona_atividade_controle = 0;
        $sql_insert = "insert into controle_manutencao (id_veiculo_controle,id_tarefa_controle,tipo_tarefa) values('$id_veiculo','$id_atividade','$tipo_atividade')";
        if (!mysqli_query($conexao_adiciona_atividade_controle, $sql_insert)) {
            $erro_adiciona_atividade_controle++;
        }
        if ($erro_adiciona_atividade_controle == 0) {
            mysqli_commit($conexao_adiciona_atividade_controle);
            return true;
        } else {
            mysqli_rollback($conexao_adiciona_atividade_controle);
            return false;
        }
    }

    function addAtividade($id_tarefa, $tipo) {
        $nome_atividade = $this->getNomeDaTarefa($id_tarefa);
        $conexao_adiciona_atividade = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_adiciona_atividade->set_charset("utf8");
        mysqli_autocommit($conexao_adiciona_atividade, FALSE);
        $erro_adiciona_atividade = 0;
        if ($this->verificaNome($nome_atividade, 1)) {
            $sql_insert = "insert into atividades_controle (id_atividade_controle,nome_atividade,tipo_atividade) values('$id_tarefa','$nome_atividade','$tipo')";
            if (!mysqli_query($conexao_adiciona_atividade, $sql_insert)) {
                $erro_adiciona_atividade++;
            }
            if ($erro_adiciona_atividade == 0) {
                mysqli_commit($conexao_adiciona_atividade);
                return true;
            } else {
                mysqli_rollback($conexao_adiciona_atividade);
                return false;
            }
        }
    }

    function updateAtividade($id_tarefa, $tipo) {
        $nome_atividade = $this->getNomeDaTarefa($id_tarefa);
        $conexao_update_atividade = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_update_atividade->set_charset("utf8");
        mysqli_autocommit($conexao_update_atividade, FALSE);
        $erro_update_atividade = 0;
        $id_atividade = $this->verificaNome($nome_atividade, 2);
        if ($id_atividade > 0) {
            $sql_update = "update atividades_controle set id_atividade_controle = $id_tarefa, nome_atividade = '$nome_atividade',tipo_atividade = '$tipo' where atividades_controle.id_atividade_controle = $id_atividade ";
            if (!mysqli_query($conexao_update_atividade, $sql_update)) {
                $erro_update_atividade++;
            }
            if ($erro_update_atividade == 0) {
                mysqli_commit($conexao_update_atividade);
                return true;
            } else {
                mysqli_rollback($conexao_update_atividade);
                return false;
            }
        }
    }

    function getNomeDaTarefa($id_da_tarefa) {
        $conexao_nome_projeto = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_nome_projeto->set_charset("utf8");
        $result_nome = "select tarefas.nome from tarefas where tarefas.id_tarefa= $id_da_tarefa";
        $result_dados = mysqli_query($conexao_nome_projeto, $result_nome);
        if ($result_dados) {
            while ($row = $result_dados->fetch_assoc()) {
                $nome_projeto = $row['nome'];
            }
            $result_dados->free();
            return $nome_projeto;
        } else {
            throw new Exception('<script>alert("Ocorreu um erro na busca pelo nome da tarefa!")</script>');
        }
    }

    function getDadosAtividades($id_atividade) {
        $dados_atividade = array();
        $conexao_dados_atividade = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_dados_atividade->set_charset("utf8");
        $sql_getAtividade = "select atividades_controle.nome_atividade,atividades_controle.tipo_atividade  from atividades_controle where atividades_controle.id_atividade_controle = $id_atividade";
        $result_select_dados = mysqli_query($conexao_dados_atividade, $sql_getAtividade);
        if ($result_select_dados) {
            while ($row = $result_select_dados->fetch_assoc()) {
                $dados_atividade[] = $row['nome_atividade'];
                $dados_atividade[] = $row['tipo_atividade'];
            }
            $result_select_dados->free();
        }
        return $dados_atividade;
    }

    function getDadosTarefas(){
        $dados_projetos = array();
        $conexao_dados_projetos = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_dados_projetos->set_charset("utf8");
        $sql_getprojetos = "select tarefas.id_tarefa,tarefas.nome from tarefas where 1";
        $result_select_dados = mysqli_query($conexao_dados_projetos, $sql_getprojetos);
        if ($result_select_dados) {
            while ($row = $result_select_dados->fetch_assoc()) {
                $dados_projetos[] = $row['id_tarefa'];
                $dados_projetos[] = $row['nome'];
            }
            $result_select_dados->free();
        }
        return $dados_projetos;
    }

}
