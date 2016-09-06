  $(function () {
                $('.form_relatorio_tarefa').submit(function () { 
                    $.ajax({
                        type: 'POST',
                        url: '../control/relatorio/tarefas/tarefas_controller.php',
                        data: $('.form_relatorio_tarefa').serialize(),
                        success: function (data) {
                            
                            if (data) {
                                $('.conteudo_dinamico_tarefa').html(data);
                            }
                        }
                    });
                    return false;
                    
                });
            });




