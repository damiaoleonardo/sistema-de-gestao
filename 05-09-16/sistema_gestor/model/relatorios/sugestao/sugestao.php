<?php

class sugestao {

    private $funcionario;
    private $data_inicial;
    private $data_final;

    function getFuncionario() {
        return $this->funcionario;
    }

    function getData_inicial() {
        return $this->data_inicial;
    }

    function getData_final() {
        return $this->data_final;
    }

    function setFuncionario($funcionario) {
        $this->funcionario = $funcionario;
    }

    function setData_inicial($data_inicial) {
        $this->data_inicial = $data_inicial;
    }

    function setData_final($data_final) {
        $this->data_final = $data_final;
    }

    function montatabela($sql) {
        $conexao_select_dados_sugestao = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_select_dados_sugestao->set_charset("utf8");
        $conexao_select_dados_sugestao->query($sql);
        if ($conexao_select_dados_sugestao->affected_rows == 0) {
            echo "<center><p style='margin-top:70px; font-size:1.5em;'>Nenhum resultado foi encontrado</p></center>";
        } else {
            $query_select_dados = mysqli_query($conexao_select_dados_sugestao, $sql);
            ?>
            <table class='table table-hover'>
                <?php
                while ($row = $query_select_dados->fetch_assoc()) {
                    $id_sugestao = $row['id_sugestao'];
                    $dono_sugestao = $row['dono_da_sugestao'];
                    $nome_sugestao = $row['nome_sugestao'];
                    $categoria_sugestao = $row['categoria_sugestao'];
                    $data_enviada = $row['data_enviada'];
                    $data_vista = $row['data_vista'];
                    $comoehj = $row['como_e_hoje'];
                    $comodeveser = $row['como_deve_ser'];
                    $img_comoehj = $row['img_como_e_hoje'];
                    $img_comodeveser = $row['img_como_deve_ser'];
                    ?>
                    <tr style="font-size:0.9em;">
                        <td style="width:10%; border-right: 1px solid #E8E8E8;"><?php echo $dono_sugestao ?></td>
                        <td style="width:10%; border-right: 1px solid #E8E8E8;"><?php echo $nome_sugestao ?></td>
                        <td style="width:10%; border-right: 1px solid #E8E8E8;"><?php echo $data_enviada ?></td>
                        <td style="width:10%; border-right: 1px solid #E8E8E8;"><?php echo $data_vista ?></td>
                        <td style="width:20%; border-right: 1px solid #E8E8E8;"><?php echo $comoehj ?></td>
                        <?php if (empty($img_comoehj)) { ?>
                            <td style="width:3%; border-right: 1px solid #E8E8E8;"></td>
                            <?php
                        } else {
                            ?>
                            <td style = "width:3%; border-right: 1px solid #E8E8E8;"><a href = "http://192.168.0.109/sistema_gestor/sugestoes/<?php echo $data_enviada ?>/+<?php echo $img_comoehj ?>" target = "_blank"><img title = "FRASE" alt = "Foto" src = ""/></a></td>
                        <?php }
                        ?>
                        <td style = "width:20%; border-right: 1px solid #E8E8E8;"><?php echo $comodeveser
                        ?></td>
                        <?php if (empty($img_comodeveser)) { ?>
                            <td style="width:3%; border-right: 1px solid #E8E8E8;"></td>
                            <?php
                        } else {
                            ?>
                            <td style="width:2%; border-right: 1px solid #E8E8E8;"><a href="http://192.168.0.109/sistema_gestor/sugestoes/<?php echo $data_enviada ?>/+<?php echo $img_comodeveser ?>" target="_blank"><img title="FRASE" alt="Foto" src=""/></a></td>
                        <?php
                        }
                        if ($categoria_sugestao == "nao implantada") {
                            ?>
                            <td style="width:8%; border-right: 1px solid #E8E8E8;"><input type="button" onclick="implantarSugestao('<?php echo $id_sugestao ?>');" value="Implantar"></td>
                            <td style="width:7%;"><input type="button" onclick="descartarSugestao('<?php echo $id_sugestao ?>');" value="Descartar"></td>
                            <?php   
                        } else if ($categoria_sugestao == "implantada") {
                              ?>
                            <td colspan="2" style="width:15%; border-right: 1px solid #E8E8E8;">Implantada</td>
                            <?php  
                        } else if ($categoria_sugestao == "descartada") {
                              ?>
                            <td colspan="2" style="width:15%; border-right: 1px solid #E8E8E8;">Descartada</td>
                            <?php  
                        }
                            ?>    
                    </tr> <?php
                  }
                ?>
            </table>
            <?php
        }
    }

    function funcionarios(sugestao $obj) {
        $sobrenome = $obj->getFuncionario();
        $sql = "select sugestoes.categoria_sugestao,sugestoes.id_sugestao,sugestoes.data_enviada,sugestoes.data_vista, sugestoes.nome_sugestao,sugestoes.dono_da_sugestao,sugestoes.como_e_hoje,sugestoes.como_deve_ser, sugestoes.img_como_e_hoje,sugestoes.img_como_deve_ser from sugestoes where sugestoes.dono_da_sugestao = '$sobrenome' ";
        return $sql;
    }

    function funcionariosDataInicial(sugestao $obj) {
        $sobrenome = $obj->getFuncionario();
        $data_inicial = $obj->getData_inicial();
        $sql = "select sugestoes.categoria_sugestao,sugestoes.id_sugestao,sugestoes.data_enviada,sugestoes.data_vista, sugestoes.nome_sugestao,sugestoes.dono_da_sugestao,sugestoes.como_e_hoje,sugestoes.como_deve_ser, sugestoes.img_como_e_hoje,sugestoes.img_como_deve_ser from sugestoes where sugestoes.dono_da_sugestao = '$sobrenome' and sugestoes.data_enviada = '$data_inicial'";
        return $sql;
    }

    function funcionariosDatas(sugestao $obj) {
        $sobrenome = $obj->getFuncionario();
        $data_inicial = $obj->getData_inicial();
        $data_final = $obj->getData_final();
        $sql = "select sugestoes.categoria_sugestao,sugestoes.id_sugestao,sugestoes.data_enviada,sugestoes.data_vista, sugestoes.nome_sugestao,sugestoes.dono_da_sugestao,sugestoes.como_e_hoje,sugestoes.como_deve_ser, sugestoes.img_como_e_hoje,sugestoes.img_como_deve_ser from sugestoes where sugestoes.dono_da_sugestao = '$sobrenome' and sugestoes.data_enviada >= '$data_inicial' and sugestoes.data_enviada <= '$data_final'";
        return $sql;
    }

}
