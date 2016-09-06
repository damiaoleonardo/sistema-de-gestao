function finaliza_tarefa(status_tarefa, id_projeto_executa, id_tarefa, id_projeto, id_veiculo, id_funcionario, id_projeto_funcionario_ativo, id_veiculo_funcionario_ativo, id_tarefa_funcionario_ativo) {
    if (status_tarefa == "concluida") {
        alert("Tarefa ja se encontra concluida");
      } else {
        if (id_projeto_funcionario_ativo === id_projeto && id_veiculo_funcionario_ativo === id_veiculo && id_tarefa_funcionario_ativo === id_tarefa) {
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else { 
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.open("GET", "../control/finaliza_tarefa/finaliza_tarefa.php?id_projeto_executa=" + id_projeto_executa +"&id_projeto=" + id_projeto + "&id_veiculo=" + id_veiculo + "&id_tarefa=" + id_tarefa + "&id_funcionario=" + id_funcionario, true);
            xmlhttp.send();
            alert("Tarefa finalizada com sucesso");
          } else {
            alert("Voce não se encontra executando esta atividade");
        }
    }
}





