function finaliza_tarefa_liberada(status_funcionario, acao, id_projeto, id_veiculo, id_executa, id_tarefa, id_funcionario, id_projeto_funcionario_ativo, id_veiculo_funcionario_ativo, id_tarefa_funcionario_ativo, quantidade_executores) {
alert(quantidade_executores);

    if (status_funcionario === "ativo") {
        if (quantidade_executores == 1) {
            if (id_projeto_funcionario_ativo === id_projeto && id_veiculo_funcionario_ativo === id_veiculo && id_tarefa_funcionario_ativo === id_tarefa) {
                location.href = "telaPrincipal.php?t=finaliza_tarefa&acao=" + acao + "&id_projeto=" + id_projeto + "&id_veiculo=" + id_veiculo + "&id_executa=" + id_executa + "&id_tarefa=" + id_tarefa + "&id_funcionario=" + id_funcionario;
            } else {
                alert("Voce não se encontra executando esta atividade");
            }
        } else {
            alert("quantidade executores acima de 1");
        }
    } else if (status_funcionario === "inativo") {
        alert("Funcionario se encontra inativo!");
    }
}






