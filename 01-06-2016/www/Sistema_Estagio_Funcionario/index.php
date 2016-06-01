<html>
    <head>
        <meta name="viewport" content="width:device-width">
        <title>Login - Sitio Barreiras</title>
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon"/>
        <link rel="stylesheet" href="style/pagina_inicial.css" type="text/css"> 
        <script src="js/jquery.js"></script>
        <script type="text/javascript">
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
        </script>
    </head>
    <body class="geral_login">
         <script>
                        //alert(document.body.clientHeight);
                       // alert(document.body.clientWidth);
                        </script>
       <div class="recebe_resposta"></div>
       <div class="login_tela">
            <div id="divlogin">
                <div id="text_header">
                   <center><label style="font-size: 1.3em; font-family: Arial,cursive,verdana; color: #3a87ad;">Sitio Barreiras | Frutas de Qualidade</label></center>
                </div> 
                <div id="login">
                    <form class="login" method="post" action="">
                        <label style="font-size: 1em; font-family: Arial,cursive,verdana; color: #01669F;">Usuario</label><input style=" width: 95%; height:20px; margin-top:2%; border-radius:4px;" type="text" name="usuario">
                        <label style="font-size: 1em; font-family: Arial,cursive,verdana; color: #01669F; margin-top:1%;">Senha</label><input style=" width: 95%; height:20px; margin-top:2%;border-radius:4px;" type="password" name="senha">
                        <input  id="botao_enviar"  type="submit" value="Acessar" >  
                    </form>
                </div>
                <div id="footer"><p style="font-size: 0.7em;">&copy;Todos os Direitos Reservados | Sistema Desenvolvimento por Damiao Leonardo</p></div>
            </div>
        </div>
    </body>
</html>