  $(function () {
                $('.form_relatorio_tabela_horas').submit(function (){ 
                    $.ajax({
                        type: 'POST',
                        url: '../control/tabela_horas/tabela_hora_controller.php',
                        data: $('.form_relatorio_tabela_horas').serialize(),
                        success: function (data) {
                            if (data) {
                                $('.conteudo_dinamico').html(data);
                            }
                        }
                    });
                    return false;
                    
                });
            });




