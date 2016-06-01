function play_tarefa(disponibilidade, id_tarefa, status_tarefa, id_projeto, id_veiculo, id_funcionario, id_projeto_funcionario_ativo, id_veiculo_funcionario_ativo, id_tarefa_funcionario_ativo) {

    if (disponibilidade == "inativo") {

        if (id_projeto_funcionario_ativo == id_projeto && id_veiculo_funcionario_ativo == id_veiculo && id_tarefa_funcionario_ativo == id_tarefa || id_projeto_funcionario_ativo != undefined && id_veiculo_funcionario_ativo != undefined && id_tarefa_funcionario_ativo != undefined) {
            if (status_tarefa == "open") {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else { // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.open("GET", "../control/tarefa_abre.php?id=" + id_tarefa + "&id_projeto=" + id_projeto + "&veiculo=" + id_veiculo + "&id_funcionario=" + id_funcionario, true);
                xmlhttp.send(null);
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                       // alert(xmlhttp.responseText);
                    
                    }
                }
                  alert("Tarefa iniciada com sucesso");
            } else if (status_tarefa == "notopen") {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else { // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.open("GET", "../control/play.php?id=" + id_tarefa + "&id_projeto=" + id_projeto + "&veiculo=" + id_veiculo + "&id_funcionario=" + id_funcionario, true);
                xmlhttp.send(null);

                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                       // alert(xmlhttp.responseText);
                     
                    }
                }
                  alert("Tarefa iniciada com sucesso");
                
            } else if (status_tarefa == "pause") {

                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else { // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.open("GET", "../control/reabre.php?id=" + id_tarefa + "&id_projeto=" + id_projeto + "&veiculo=" + id_veiculo + "&id_funcionario=" + id_funcionario, true);

                xmlhttp.send(null);

                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                      //  alert(xmlhttp.responseText);
                    
                    }
                }
                  alert("Tarefa retornada com sucesso");
          
            }
        } else {
            alert("Voce não se encontra executando esta atividade");
        }

    } else if (disponibilidade == "ativo") {
        alert("Funcionario ja se encontra ativo");
    }
}

