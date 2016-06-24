<?php

class Sugestoes {

    function getSugestoes() {
        $sql_sugestoes = "select sugestoes.id_sugestao,sugestoes.dono_da_sugestao,sugestoes.data_enviada,sugestoes.como_e_hoje,sugestoes.como_deve_ser from sugestoes where sugestoes.status= 'nao vista'  ";
        $result_sugestoes = mysql_query($sql_sugestoes);
        ?>
        <table class="table table-hover" style="font-size: 1em; background: white;">
            <?php
            while ($aux_sugestao = mysql_fetch_array($result_sugestoes)) {
                $id_da_sugestao = $aux_sugestao['id_sugestao'];
                $dono_da_sugestao = $aux_sugestao['dono_da_sugestao'];
                $data_enviada = $aux_sugestao['data_enviada'];
                $como_e_hoje = $aux_sugestao['como_e_hoje'];
                $como_deve_ser = $aux_sugestao['como_deve_ser'];
                ?>
                <tr>
                    <td style="width: 20%;border-right: 1px solid #dddddd;"><?php echo $dono_da_sugestao ?></td>
                    <td style="width: 10%;"><?php echo $data_enviada ?></td> 
                    <td style="width: 30%; border-left: 1px solid #dddddd; border-right: 1px solid #dddddd;"><?php echo $como_e_hoje ?></td>
                    <td style="width: 30%; border-right: 1px solid #dddddd;"><?php echo $como_deve_ser ?></td>
                    <td style="width: 10%;"><input type="button" onclick="verSugestao('<?php echo $id_da_sugestao ?>');" value="Sugestão Vista"></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    }

    function setSugestaoVista($id_sugestao) {
        $mysqli = new mysqli('localhost', 'root', '', 'sistema_de_gestao');
        $data_de_hj = date('Y-m-d');
        $sql_atualiza_sugestao = "UPDATE sugestoes SET status= 'vista',data_vista= '$data_de_hj' where sugestoes.id_sugestao = $id_sugestao";
        $mysqli->query($sql_atualiza_sugestao); 
    }

}
