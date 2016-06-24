function reabre_tarefa(disponibilidade, status_tarefa, id_tarefa, id_projeto_executa, id_projeto, id_veiculo, id_funcionario, id_projeto_funcionario_ativo, id_veiculo_funcionario_ativo, id_tarefa_funcionario_ativo) {
    if (disponibilidade === "inativo") {
        if (id_projeto_funcionario_ativo === id_projeto && id_veiculo_funcionario_ativo === id_veiculo && id_tarefa_funcionario_ativo === id_tarefa || id_projeto_funcionario_ativo != undefined && id_veiculo_funcionario_ativo != undefined && id_tarefa_funcionario_ativo != undefined) {
            if (status_tarefa === "open") {
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.open("GET", "../control/iniciar_tarefa/tarefa_abre.php?id_projeto_executa=" + id_projeto_executa + "&id_tarefa=" + id_tarefa + "&id_projeto=" + id_projeto + "&id_veiculo=" + id_veiculo + "&id_funcionario=" + id_funcionario, true);
                xmlhttp.send(null);
                /* xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        alert(xmlhttp.responseText);
                    }
                }*/
                alert("Tarefa iniciada com sucesso");
            } else if (status_tarefa === "pause") {
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.open("GET", "../control/iniciar_tarefa/reabre_tarefa.php?id_projeto_executa=" + id_projeto_executa + "&id_tarefa=" + id_tarefa + "&id_projeto=" + id_projeto + "&id_veiculo=" + id_veiculo + "&id_funcionario=" + id_funcionario, true);
                xmlhttp.send(null);
                alert("Tarefa retornada com sucesso!");
            }
          } else {
            alert("Voce não se encontra executando esta atividade");
        }
    } else if (disponibilidade === "ativo") {
        alert("Funcionario ja se encontra ativo");
    }
}



