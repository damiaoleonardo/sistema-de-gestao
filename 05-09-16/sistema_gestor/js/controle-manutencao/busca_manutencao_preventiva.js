  $(function () {
                $('.form_manutencao_preventiva').submit(function () { 
                    $.ajax({
                        type: 'POST',
                        url: '../control/controle-manutencao/controlecontroller.php',
                        data: $('.form_manutencao_preventiva').serialize(),
                        success: function (data) {
                            
                            if (data) {
                                $('#container').html(data);
                            }
                        }
                    });
                    return false;
                    
                });
            });




