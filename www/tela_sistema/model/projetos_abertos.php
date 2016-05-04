<?php

class projetos_abertos {

    private $id_projeto;

    function projetosAberto() {
        ?>
        <table class='table table-hover'>
            <tr><td colspan="5" style="background:#449d44; color:white;">Projetos Abertos <td></tr>
            <tr  style="font-size: 0.9em; background: #adadad; color:white;">
                <td>Funcionario</td>
                <td>Projeto</td>
                <td>Veiculo</td>
            </tr>
            <?php
            $sql_projetos_abertos = "select projeto_executa.nome_projeto, projeto_executa.nome_veiculo , funcionarios.sobrenome from `projeto_executa` join `funcionarios` on(projeto_executa.id_funcionario = funcionarios.id_funcionario) where projeto_executa.status = 'open' ";
            $result = mysql_query($sql_projetos_abertos);
            while ($dados_ativos = mysql_fetch_array($result)) {
                $nome_funcionario = $dados_ativos['sobrenome'];
                $nome_projeto = $dados_ativos['nome_projeto'];
                $nome_veiculo = $dados_ativos['nome_veiculo'];
                
                ?>
            <tr>
                <td><?php echo $nome_funcionario ?></td>
                <td><?php echo $nome_projeto ?></td>
                <td><?php echo $nome_veiculo ?></td>
            </tr>
            <?php  
            }
            ?>
            <tr style="height: 70px;">
                <td></td>
                 <td></td>
                  <td></td>
            </tr>
            <tr style="height: 70px;">
                <td></td>
                 <td></td>
                  <td></td>
            </tr>
            
        </table>
        <?php

    }

}
