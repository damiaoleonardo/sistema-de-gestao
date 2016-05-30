function flag_tarefa_aberta(flag_tarefa) {
                if (flag_tarefa == 1) {
                    alert("Existe tarefas em aberto!");
                } else {
                    window.location.href = 'telaPrincipal.php?t=visualiza_projeto';
                }
            }