<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <a id="btnClose" href="#" title="Close" class="close" onclick="fecha_modal('tarefasProjeto')">X</a>
        <?php
        require '../../../model/relatorios/projetos/projetos_tarefas.php';
        $tarefas_projetos = new projetos_tarefas();
         $id_projeto = $_GET['id_projeto'];
         $id_veiculo = $_GET['id_veiculo'];
         $id_executa = $_GET['id_executa'];
        try {
            $tarefas_projetos->setId_projeto($id_projeto);
            $tarefas_projetos->setId_veiculo($id_veiculo);
            $tarefas_projetos->setId_executa($id_executa);
            $tarefas_projetos->montaTabelaTarefas($tarefas_projetos);
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        ?>
    </body>
</html>