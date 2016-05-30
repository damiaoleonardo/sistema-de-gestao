            $(function () {
                $('.form_relatorio_funcionario_periodo').submit(function () {
                    $.ajax({
                        type: 'POST',
                        url: '../control/relatorio/funcionario/funcionario_controller.php',
                        data: $('.form_relatorio_funcionario_periodo').serialize(),
                        success: function (data) {
                            if (data) {
                                $('.tabela_funcionario').html(data);
                            }
                        }
                    });
                    return false;
                });
            });



