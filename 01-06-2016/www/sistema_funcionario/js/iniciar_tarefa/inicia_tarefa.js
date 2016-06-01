function inicia_tarefa(disponibilidade, id_tarefa, id_projeto, id_veiculo, id_funcionario) {
  //  alert(disponibilidade); alert(id_tarefa); alert(id_projeto); alert(id_veiculo); alert(id_funcionario);
    if (disponibilidade == "inativo") {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else { 
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.open("GET", "../control/iniciar_tarefa/inicia_tarefa.php?id=" + id_tarefa + "&id_projeto=" + id_projeto + "&veiculo=" + id_veiculo + "&id_funcionario=" + id_funcionario, true);
        xmlhttp.send(null);
       alert("Tarefa iniciada com sucesso");
    } else if (disponibilidade == "ativo") {
       alert("Funcionario ja se encontra ativo");
    }
}


