  $(function () {
                $('.login').submit(function () {
                    $.ajax({
                        type: 'POST',
                        url: 'control/verifica_usuario.php',
                        data: $('.login').serialize(),
                        success: function (data) {
                            if (data) {
                                $('.recebe_resposta').html(data);
                            }
                        }
                    });
                    return false;
                });
            });

