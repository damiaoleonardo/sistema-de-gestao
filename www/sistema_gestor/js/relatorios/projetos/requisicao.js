  $(function () {
                $('.form_relatorio_projeto').submit(function () {
                    $.ajax({
                        type: 'POST',
                        url: '../control/relatorio/projetos/projetos_controller.php',
                        data: $('.form_relatorio_projeto').serialize(),
                        success: function (data) {
                            if (data) {
                                $('.recebe_resposta').html(data);
                            }
                        }
                    });
                    return false;
                });
            });




