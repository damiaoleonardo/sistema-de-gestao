  $(function () {
                $('.form_rotas').submit(function () {
                    $.ajax({
                        type: 'POST',
                        url: '../control/programacao_semanal/adiciona_viagem.php',
                        data: $('.form_rotas').serialize(),
                        success: function (data) {
                            if (data) {
                                $('.recebe_resposta').html(data);
                            }
                        }
                    });
                    return false;
                });
            });


