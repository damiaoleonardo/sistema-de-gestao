  $(function () {
                $('.form_edite_viagem').submit(function () {
                    $.ajax({
                        type: 'POST',
                        url: '../control/programacao_semanal/adiciona_viagem.php',
                        data: $('.form_edite_viagem').serialize(),
                        success: function (data) {
                            if (data) {
                                $('.recebe_resposta').html(data);
                            }
                        }
                    });
                    return false;
                });
            });




