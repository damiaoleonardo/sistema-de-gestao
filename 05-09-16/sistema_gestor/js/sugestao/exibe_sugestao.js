  function verSugestao(id_da_sugestao) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (xhttp.readyState === 4 && xhttp.status === 200) {
                        alert(xhttp.responseText);location.reload();
                    }
                };
                xhttp.open("GET",'../control/sugestoes/sugestaoVistaController.php?id_sugestao=' + id_da_sugestao, true);
                xhttp.send();
            }