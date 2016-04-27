function pausa_tarefa(disponibilidade, id_tarefa, status_tarefa, id_projeto_executa, id_projeto, id_veiculo, id_funcionario, id_projeto_funcionario_ativo, id_veiculo_funcionario_ativo, id_tarefa_funcionario_ativo) {
    if (disponibilidade == "ativo") {
        if (id_projeto_funcionario_ativo == id_projeto && id_veiculo_funcionario_ativo == id_veiculo && id_tarefa_funcionario_ativo == id_tarefa) {
            if (status_tarefa == "open") {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                 } else { // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.open("GET", "../control/pausa_tarefa/pausa_tarefa.php?id=" + id_tarefa + "&id_projeto_executa=" + id_projeto_executa + "&id_projeto=" + id_projeto + "&id_veiculo=" + id_veiculo + "&id_funcionario=" + id_funcionario, true);
                xmlhttp.send(null);
                alert("Tarefa pausada com sucesso");
            } else if (status_tarefa == "pause") {
                alert("Tarefa ja se encontra pausado");
            }
        } else {
            alert("Voce não se encontra executando esta atividade");
        }
    } else if (disponibilidade == "inativo") {
        alert("Funcionario ainda nao se encontra executando nenhuma atividade");
    }
}



