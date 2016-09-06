function inicia_tarefa(disponibilidade, id_projeto_executa, id_tarefa, id_projeto, id_veiculo, id_funcionario) {
    if (disponibilidade === "inativo") {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.open("GET", "../control/iniciar_tarefa/inicia_tarefa.php?id_projeto_executa=" + id_projeto_executa + "&id_tarefa=" + id_tarefa + "&id_projeto=" + id_projeto + "&id_veiculo=" + id_veiculo + "&id_funcionario=" + id_funcionario, true);
        xmlhttp.send(null);
         /*xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        alert(xmlhttp.responseText);
                    
                    }
                }*/
        alert("Tarefa iniciada com sucesso");
    } else if (disponibilidade === "ativo") {
        alert("Funcionario ja se encontra ativo");
    }
}


