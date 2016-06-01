<?php

class projeto {
    private $id_projeto;
    private $id_veiculo;
    private $id_funcionario;

    function getId_funcionario() {
        return $this->id_funcionario;
    }

    function setId_funcionario($id_funcionario) {
        $this->id_funcionario = $id_funcionario;
    }

        function getId_projeto() {
        return $this->id_projeto;
    }

    function getId_veiculo() {
        return $this->id_veiculo;
    }

    function setId_projeto($id_projeto) {
        $this->id_projeto = $id_projeto;
    }

    function setId_veiculo($id_veiculo) {
        $this->id_veiculo = $id_veiculo;
    }

    

function add_projeto(projeto $obj){
 $id_do_veiculo = $obj->getId_veiculo();
 $id_do_projeto = $obj->getId_projeto();
$id_do_funcionario = $obj->getId_funcionario();
$conecta = mysql_connect("localhost", "root", "") or print (mysql_error()); 
mysql_select_db("sistema_de_gestao", $conecta) or print(mysql_error()); 
$cont_veiculos_iguais = 0;
$sql_consulta_de_veiculo = "select projeto_executa.id_veiculo from projeto_executa where projeto_executa.id_projeto = $id_do_projeto and projeto_executa.status != 'concluido'";
$result_consulta_veiculo = mysql_query($sql_consulta_de_veiculo);
while ($aux_consulta_veiculo = mysql_fetch_array($result_consulta_veiculo)) {
    $id_veiculo = $aux_consulta_veiculo['id_veiculo'];
    if ($id_veiculo == $id_do_veiculo) {
        $cont_veiculos_iguais ++;
    }
}
if ($cont_veiculos_iguais > 0) {
    echo "<script>alert('Ja existe um veiculo vinculado a esta atividade');</script>";
} else {
    $sql_recebe_nome_projeto = "select projeto.nome,projeto.duracao,projeto.id_ugb,veiculos.nome_veiculo from projeto join veiculos on(veiculos.id_veiculo = $id_do_veiculo ) where projeto.id_projeto = $id_do_projeto ";
    $result_nome = mysql_query($sql_recebe_nome_projeto);
    while ($aux_recebe_nome = mysql_fetch_array($result_nome)) {
        $nome_projeto = $aux_recebe_nome['nome'];
        $id_ugb = $aux_recebe_nome['id_ugb'];
        $nome_veiculo = $aux_recebe_nome['nome_veiculo'];
        $duracao_projeto = $aux_recebe_nome['duracao'];
    }
    $sql_query_insert = "insert projeto_executa (nome_projeto,nome_veiculo,status,duracao,id_projeto,id_veiculo,id_funcionario,id_ugb)"
            . "values('$nome_projeto','$nome_veiculo','notopen','$duracao_projeto','$id_do_projeto','$id_do_veiculo','$id_do_funcionario','$id_ugb')";
    mysql_query($sql_query_insert);
    $sql_duracao_projeto_executa = "select projeto_executa.duracao from projeto_executa where projeto_executa.id_projeto = $id_do_projeto and projeto_executa.id_veiculo = $id_do_veiculo and projeto_executa.status !='concluido'";
    $result_duracao_projeto_executa = mysql_query($sql_duracao_projeto_executa);
    $id_projeto_duracao = mysql_fetch_row($result_duracao_projeto_executa);
    $id_projetos_duracao = $id_projeto_duracao[0];
    $sql_id_projeto_executa = "select projeto_executa.id_projeto_executa from projeto_executa where projeto_executa.id_projeto = $id_do_projeto and projeto_executa.id_veiculo = $id_do_veiculo and projeto_executa.status !='concluido'";
    $result_id_projeto_executa = mysql_query($sql_id_projeto_executa);
    $id_projeto_executa = mysql_fetch_row($result_id_projeto_executa);
    $id_projetos_executa = $id_projeto_executa[0];

    $sql_query_tarefas = "select tarefas_projeto.id_tarefa,tarefas.duracao from tarefas_projeto left join tarefas on (tarefas.id_tarefa = tarefas_projeto.id_tarefa) where id_projeto = $id_do_projeto";
    $result_tarefa = mysql_query($sql_query_tarefas);
    while ($aux_recebe_tarefas = mysql_fetch_array($result_tarefa)) {
        $id_tarefa = $aux_recebe_tarefas['id_tarefa'];
        $duracao_da_tarefa = $aux_recebe_tarefas['duracao'];
        if ($id_projetos_duracao == "00:00:00") {
            mysql_query("insert into tarefas_executa (id_projeto_executa,id_projeto,id_veiculo,id_tarefa,status,duracao,conclusao_projeto,tipo_tarefa) values ('$id_projetos_executa','$id_do_projeto','$id_do_veiculo','$id_tarefa','notopen','$duracao_da_tarefa','nao concluido','liberada')");
        } else {
            mysql_query("insert into tarefas_executa (id_projeto_executa,id_projeto,id_veiculo,id_tarefa,status,duracao,conclusao_projeto,tipo_tarefa) values ('$id_projetos_executa','$id_do_projeto','$id_do_veiculo','$id_tarefa','notopen','$duracao_da_tarefa','nao concluido','nao liberada')");
        }
    }
    mysql_query("UPDATE projeto_executa SET status = 'open' where projeto_executa.id_projeto = $id_do_projeto and projeto_executa.id_veiculo=$id_do_veiculo and projeto_executa.status != 'concluido'");
    unset($id_do_veiculo);
    unset($id_do_projeto);
    unset($id_do_funcionario);
    echo "<script>alert('projeto adicionado com sucesso!');</script>";
    echo "<script>location.href='../view/telaPrincipal.php?t=visualiza_projeto'</script>";
  }
      
  
}

}




