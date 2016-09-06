<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <a id="btnClose" href="#" title="Close" class="close" onclick="fecha_modal('tarefas_detalhes')">X</a>
        <?php
        require '../../../model/relatorios/tarefas/tarefas.php';
        $tarefas_detalhes = new tarefas();
        $id_tarefa = $_GET['id_tarefa'];
        $id_veiculo = $_GET['id_veiculo'];
        $id_tarefa_executa = $_GET['id_tarefa_executa'];
        $id_projeto_executa = $_GET['id_projeto_executa'];
        $tipo_tarefa = $_GET['tipo_tarefa'];
        $id_projeto = $_GET['id_projeto'];
        $data_tarefa = $_GET['data_tarefa'];
        try {
            $tarefas_detalhes->setId_projeto($id_projeto);
            $tarefas_detalhes->setId_projeto_executa($id_projeto_executa);
            $tarefas_detalhes->setTipo_tarefa($tipo_tarefa);
            $tarefas_detalhes->setId_tarefa($id_tarefa);
            $tarefas_detalhes->setId_veiculo($id_veiculo);
            $tarefas_detalhes->setData_final($data_tarefa);
            $tarefas_detalhes->setId_tarefa_executa($id_tarefa_executa);
            $tarefas_detalhes->montaDetalhesTarefas($tarefas_detalhes);
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        ?>
    </body>
</html>