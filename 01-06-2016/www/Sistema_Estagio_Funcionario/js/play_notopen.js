function play_notopen(disponibilidade, id_tarefa, id_projeto, id_veiculo, id_funcionario) {

    if (disponibilidade == "inativo") {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.open("GET", "../control/play.php?id=" + id_tarefa + "&id_projeto=" + id_projeto + "&veiculo=" + id_veiculo + "&id_funcionario=" + id_funcionario, true);
        xmlhttp.send(null);

        xmlhttp.onreadystatechange = function () {
                if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                   // alert(xmlhttp.responseText);
                }
        }
          alert("Tarefa iniciada com sucesso");
    } else if (disponibilidade == "ativo") {
        alert("Funcionario ja se encontra ativo");
    }
}



