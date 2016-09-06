  $(function () {
                $('.form_manutencao_inspecao').submit(function (){ 
                    $.ajax({
                        type: 'POST',
                        url: '../control/controle-manutencao/controleController_inspecao.php',
                        data: $('.form_manutencao_inspecao').serialize(),
                        success: function (data) {
                            
                            if (data) {
                                $('#container_inspecao').html(data);
                            }
                        }
                    });
                    return false;
                    
                });
            });




