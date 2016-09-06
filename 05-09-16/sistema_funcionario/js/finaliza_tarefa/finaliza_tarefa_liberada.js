function finaliza_tarefa_liberada(status_funcionario, id_projeto, id_veiculo, id_executa, id_tarefa, id_funcionario, id_projeto_funcionario_ativo, id_veiculo_funcionario_ativo, id_tarefa_funcionario_ativo, quantidade_executores) {
    if (status_funcionario === "ativo") {
        if (quantidade_executores == 1) {
            if (id_projeto_funcionario_ativo === id_projeto && id_veiculo_funcionario_ativo === id_veiculo && id_tarefa_funcionario_ativo === id_tarefa) {
                location.href = "telaPrincipal.php?t=finaliza_tarefa&id_projeto=" + id_projeto + "&id_veiculo=" + id_veiculo + "&id_executa=" + id_executa + "&id_tarefa=" + id_tarefa + "&id_funcionario=" + id_funcionario;
            } else {
                alert("Voce não se encontra executando esta atividade");
            }
        } else {
            if (id_projeto_funcionario_ativo === id_projeto && id_veiculo_funcionario_ativo === id_veiculo && id_tarefa_funcionario_ativo === id_tarefa) {
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.open("GET", "../control/finaliza_tarefa/finaliza_tarefa.php?id_projeto_executa=" + id_executa + "&id_projeto=" + id_projeto + "&id_veiculo=" + id_veiculo + "&id_tarefa=" + id_tarefa + "&id_funcionario=" + id_funcionario, true);
                xmlhttp.send();
                alert("Tarefa finalizada com sucesso");
            } else {
                alert("Voce não se encontra executando esta atividade");
            }
        }
      } else if (status_funcionario === "inativo") {
        alert("Funcionario se encontra inativo!");
    }
}






