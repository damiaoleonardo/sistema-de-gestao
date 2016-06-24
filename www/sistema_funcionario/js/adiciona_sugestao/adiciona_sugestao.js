 $(function (){
                $('.form_sugestao').submit(function () {
                    $.ajax({
                        type: 'POST',
                        url: '../control/adiciona_sugestao/adiciona_sugestao.php',
                        data: $('.form_sugestao').serialize(),
                        success: function (data) {
                            if (data) {
                                $('.recebe_resposta').html(data);
                             }
                        }
                    });
             return false;
        });
 });

     