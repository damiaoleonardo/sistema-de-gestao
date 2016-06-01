 $(function () {
                $('.form_relatorio_projeto').submit(function () {
                    $.ajax({
                        type: 'POST',
                        url: '../control/relatorio/projetos_controller.php',
                        data: $('.form_relatorio_projeto').serialize(),
                        success: function (data) {
                            if (data) {
                                $('.row_conteudo-controle-manutencao').html(data);
                            }
                        }
                    });
                    return false;
                });
            });



