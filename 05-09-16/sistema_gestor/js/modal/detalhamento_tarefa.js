 function openModalTarefa(data_tarefa,id_projeto,id_projeto_executa,tipo_tarefa,id_tarefa,id_veiculo,id_tarefa_executa,idModal) {
                var dialog = document.getElementById(idModal);
                dialog.style.opacity = 1;
                dialog.style.pointerEvents = "auto";
                loadContent('tarefa_detalhes', "../control/relatorio/tarefas/tarefasFuncionarios_controller.php?data_tarefa="+data_tarefa+"&id_projeto="+id_projeto+"&id_projeto_executa="+id_projeto_executa+"&tipo_tarefa="+tipo_tarefa+"&id_tarefa="+id_tarefa+"&id_veiculo="+id_veiculo+"&id_tarefa_executa="+id_tarefa_executa);
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
            function fecha_modal(idModal) {
                var dialog = document.getElementById(idModal);
                dialog.style.opacity = 0;
                dialog.style.pointerEvents = "none";
            }