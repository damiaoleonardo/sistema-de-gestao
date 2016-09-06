<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style/troca_senha/troca_senha.css" type="text/css">
        <script>
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
        </script>
        <script src="../../js/jquery.js"></script>
    </head>
    <body>
        <a id="btnClose" href="#" title="Close" class="close" onclick="fecha_modal('troca_senha_usuario')">X</a>
        <div id="retorno_senha"></div>
        <div class="row" id="troca_senha_user" class="col-md-12 col-sm-12 col-xs-12">
            <form action="" method="post" class="troca_senha_do_user">
                <div id="usuario" class="col-md-12 col-sm-12 col-xs-12"><?php ?></div>
                <div id="senha_antiga" class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label  class="col-md-6 control-label">Senha Antiga</label>
                        <div class="col-md-6">
                            <input class="form-control" type="password"  placeholder="senha_antiga" type="text">
                        </div>
                    </div>
                </div>
                <div id="nova_senha" class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label  class="col-md-6 control-label">Nova Senha</label>
                        <div class="col-md-6">
                            <input class="form-control" type="password"  placeholder="senha_nova" type="text">
                        </div>
                    </div>
                </div>
                <div id="button_altera" class="col-md-12 col-sm-12 col-xs-12">
                    <button type="submit"  class="btn btn-default">Alterar</button>
                </div>
            </form>
        </div>
    </body>
</html>
