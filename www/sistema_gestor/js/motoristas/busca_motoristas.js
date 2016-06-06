$(document).ready(function () {
                function loading_show() {
                    $('#loading').html("<img src='../img/loading.gif'/>").fadeIn('fast');
                }
                function loading_hide() {
                    $('#loading').fadeOut('fast');
                }
                function load_dados(valores, page, div) {
                    $.ajax({
                                type: 'POST',
                                dataType: 'html',
                                url: page,
                                beforeSend: function () {//Chama o loading antes do carregamento
                                    loading_show();
                                },
                                data: valores,
                                success: function (msg){
                                    loading_hide();
                                    var data = msg;
                                    $(div).html(data).fadeIn();
                                }
                            });
                }
                load_dados(null, '../control/motoristas/busca_motoristas.php', '#MostraPesq');
                $('#pesquisaCliente').keyup(function () {
                    var valores = $('#form_pesquisa').serialize()//o serialize retorna uma string pronta para ser enviada
                    var $parametro = $(this).val();
                    if ($parametro.length >= 1) {
                        load_dados(valores, '../control/motoristas/busca_motoristas.php', '#MostraPesq');
                    } else{
                        load_dados(null, '../control/motoristas/busca_motoristas.php', '#MostraPesq');
                    }
                });
            });

