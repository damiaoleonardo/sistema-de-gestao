  $(function () {
                $('.form_relatorio_sugestao').submit(function () { 
                    $.ajax({
                        type: 'POST',
                        url: '../control/relatorio/sugestao/sugestao_controller.php',
                        data: $('.form_relatorio_sugestao').serialize(),
                        success: function (data) {
                            if (data) {
                                $('.conteudo_dinamico').html(data);
                            }
                        }
                    });
                    return false;
                    
                });
            });




