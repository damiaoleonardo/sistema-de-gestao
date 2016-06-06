<?php

class Sugestoes {
    function getSugestoes() {
        $sql_sugestoes = "select motoristas.nome_motorista,sugestoes.data_enviada,sugestoes.como_e_hoje,sugestoes.como_deve_ser from motoristas join sugestoes on(motoristas.id_motorista = sugestoes.id_motorista) where sugestoes.status= 'nao vista'";
        $result_sugestoes = mysql_query($sql_sugestoes);
        ?>
        <table class="table table-hover" style="font-size: 1em; background: white;">
            <?php
            while ($aux_sugestao = mysql_fetch_array($result_sugestoes)) {
                $nome_motorista = $aux_sugestao['nome_motorista'];
                $data_enviada = $aux_sugestao['data_enviada'];
                $como_e_hoje = $aux_sugestao['como_e_hoje'];
                $como_deve_ser = $aux_sugestao['como_deve_ser'];
                ?>
                <tr>
                    <td style="width: 10%;border-right: 1px solid #dddddd;"><?php echo $nome_motorista ?></td>
                    <td style="width: 10%;"><?php echo $data_enviada ?></td> 
                    <td style="width: 35%; border-left: 1px solid #dddddd; border-right: 1px solid #dddddd;"><?php echo $como_e_hoje ?></td>
                    <td style="width: 35%; border-right: 1px solid #dddddd;"><?php echo $como_deve_ser ?></td>
                    <td style="width: 10%;"><input type="button" value="Sugestão Vista"></td>
                </tr>
            <?php
          }
        ?>
        </table>
        <?php
    }

}
