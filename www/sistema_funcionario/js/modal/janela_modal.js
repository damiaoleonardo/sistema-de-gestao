  function openModal(id_projeto, id_veiculo, id_projeto_executa, idModal) {
                var dialog = document.getElementById(idModal);
                dialog.style.opacity = 1;
                dialog.style.pointerEvents = "auto";
                loadContent('recebe_dados', "../control/tela_principal/teste.php");
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
