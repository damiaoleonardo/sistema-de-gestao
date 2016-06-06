 function openModal_projeto(id_projeto,id_veiculo,id_executa,idModal) {
                var dialog = document.getElementById(idModal);
                dialog.style.opacity = 1;
                dialog.style.pointerEvents = "auto";
                loadContent('projeto_detalhes', "../control/relatorio/projetos/tarefasProjetos_controllertelaPrincipal.php?id_projeto="+id_projeto+"&id_veiculo="+id_veiculo+"&id_executa="+id_executa);
            }
              function loadContent(idElement, urlDest) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (xhttp.readyState === 4 && xhttp.status === 200) {
                        document.getElementById(idElement).innerHTML = xhttp.responseText;
                    }
                };
                xhttp.open("GET", urlDest, true);
                xhttp.send();
            }
            function fecha_modal_projeto(idModal) {
                var dialog = document.getElementById(idModal);
                dialog.style.opacity = 0;
                dialog.style.pointerEvents = "none";
            }

