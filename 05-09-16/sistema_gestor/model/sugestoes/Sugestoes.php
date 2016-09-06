<?php

class Sugestoes {

    function getSugestoes() {
        $conexao_get_sugestao = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_get_sugestao->set_charset("utf8");
        $sql_sugestoes = "select sugestoes.nome_sugestao,sugestoes.id_sugestao,sugestoes.dono_da_sugestao,sugestoes.data_enviada,sugestoes.como_e_hoje,sugestoes.como_deve_ser,sugestoes.img_como_e_hoje,sugestoes.img_como_deve_ser from sugestoes where sugestoes.status= 'nao vista'  ";
        $result_get_sugestao = mysqli_query($conexao_get_sugestao, $sql_sugestoes);
        if($conexao_get_sugestao->affected_rows == 0){
            echo "<p style='margin:100px 0px 0px 500px; font-size:1.5em;'>Nenhuma sugestão foi inserida!</p>";
        }else{
        ?>
        <table class="table table-hover" style="font-size: 1em; background: white; width: 100%;">
            <?php
            while ($row = $result_get_sugestao->fetch_assoc()) {
                $id_da_sugestao = $row['id_sugestao'];
                $dono_da_sugestao = $row['dono_da_sugestao'];
                $nome_da_sugestao = $row['nome_sugestao'];
                $data_enviada = $row['data_enviada'];
                $como_e_hoje = $row['como_e_hoje'];
                $como_deve_ser = $row['como_deve_ser'];
                $img_como_e_hoje = $row['img_como_e_hoje'];
                $img_como_deve_ser = $row['img_como_deve_ser'];
                ?>
                <tr>
                    <td style="width: 10%;border-right: 1px solid #dddddd;"><?php echo $dono_da_sugestao ?></td>
                    <td style="width: 10%;border-right: 1px solid #dddddd;"><?php echo $nome_da_sugestao ?></td> 
                    <td style="width: 10%;"><?php echo $data_enviada ?></td> 
                    <td style="width: 29%; border-left: 1px solid #dddddd; border-right: 1px solid #dddddd;"><?php echo $como_e_hoje ?></td>
                    <?php
                    if(empty($img_como_e_hoje)){
                        ?>
                          <td style="width: 2%; border-right: 1px solid #dddddd;"></td><?php
                    }else{
                    ?>
                    <td style="width: 2%; border-right: 1px solid #dddddd;"><a href="http://192.168.0.130/sistema_gestor/sugestoes/<?php echo $data_enviada ?>/+<?php echo $img_como_e_hoje ?>" target="_blank"><img title="FRASE" alt="Foto" src=""/></a></td>
                   <?php } ?>
                    <td style="width: 28%; border-right: 1px solid #dddddd;"><?php echo $como_deve_ser ?></td>
                    <?php
                    if(empty($img_como_deve_ser)){
                        ?>
                       <td style="width: 2%; border-right: 1px solid #dddddd;"></td><?php
                    }else{
                    ?>
                    <td style="width: 2%; border-right: 1px solid #dddddd;"><a href="http://192.168.0.130/sistema_gestor/sugestoes/<?php echo $data_enviada ?>/+<?php echo $img_como_deve_ser ?>" target="_blank"> <img title="FRASE" alt="Foto" src=""/></a></td>
                    <?php } ?>
                    <td style="width: 10%;"><input type="button" onclick="verSugestao('<?php echo $id_da_sugestao ?>');" value="Vista"></td>
                </tr>
                <?php
             }
            ?>
        </table>
        <?php
        }
    }

    function setSugestaoVista($id_sugestao) {
        $mysqli = new mysqli('localhost', 'root', '', 'sistema_de_gestao');
        $data_de_hj = date('Y-m-d');
        $sql_atualiza_sugestao = "UPDATE sugestoes SET status= 'vista',data_vista= '$data_de_hj' where sugestoes.id_sugestao = $id_sugestao";
        $mysqli->query($sql_atualiza_sugestao); 
    }
    function setSugestaoDescartada($id_sugestao) {
        $mysqli = new mysqli('localhost', 'root', '', 'sistema_de_gestao');
        $data_de_hj = date('Y-m-d');
        $sql_atualiza_sugestao = "UPDATE sugestoes SET categoria_sugestao = 'descartada',data_status= '$data_de_hj' where sugestoes.id_sugestao = $id_sugestao";
        $mysqli->query($sql_atualiza_sugestao); 
    }
     function setSugestaoImplantada($id_sugestao) {
        $mysqli = new mysqli('localhost', 'root', '', 'sistema_de_gestao');
        $data_de_hj = date('Y-m-d');
        $sql_atualiza_sugestao = "UPDATE sugestoes SET categoria_sugestao = 'implantada',data_status= '$data_de_hj' where sugestoes.id_sugestao = $id_sugestao";
        $mysqli->query($sql_atualiza_sugestao); 
    }

}
