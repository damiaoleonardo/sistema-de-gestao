 $(function () {
                $('.adiciona_tarefa').submit(function () {
                    $.ajax({
                        type: 'POST',
                        url: '../control/adiciona_tarefa/adicionar_tarefa.php',
                        data: $('.adiciona_tarefa').serialize(),
                        success: function (data) {
                            if (data) {
                                $('.recebe_resposta').html(data);
                             }
                        }
                    });
             return false;
        });
 });

     