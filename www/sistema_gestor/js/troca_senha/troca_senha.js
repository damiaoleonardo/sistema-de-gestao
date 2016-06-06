  $(function () {
                $('.troca_senha_do_user').submit(function () { 
                    alert("ola");
                    $.ajax({
                        type: 'POST',
                        url: '../control/troca_senha/troca_senha_usuarioController.php',
                        data: $('.troca_senha_do_user').serialize(),
                        success: function (data) {
                            
                            if (data) {
                                $('.retorno_senha').html(data);
                            }
                        }
                    });
                    return false;
                    
                });
            });






