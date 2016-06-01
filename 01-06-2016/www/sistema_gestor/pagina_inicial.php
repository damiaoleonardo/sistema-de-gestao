<html>
    <head>
        <meta name="viewport" content="width:device-width">
        <title>Login - Teste</title>
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="style/principal/pagina_inicial.css" type="text/css"> 
        <script src="js/jquery.js"></script>
        <script src="js/verifica_usuario/requisicoes_js.js" ></script>
        <style>
            *{margin:0px;padding: 0px;}
.geral_login{width: 100%; height: 100%; background: white;;}
.geral_login .login_tela{
    border:1px solid black;
    width: 50%;
    background: white;
    margin-top:5%;
    margin-left:25%; border-bottom-left-radius: 25px;border-top-right-radius: 25px;
}

.geral_login .login_tela #logo_empresa{
  height: 30%;
  width: 70%;
  margin-left:15%;
}
.geral_login .login_tela #divlogin{
    width: 90%;
    margin:auto;
}
.geral_login .login_tela #divlogin #login{
    width: 60%;
    margin:8% 0% 0% 10%;
}
.geral_login .login_tela #divlogin #login .login{
    font-size: 1em; font-family: Arial,cursive,verdana; color: #01669F;
}
.geral_login .login_tela #divlogin #login .login input{
    width: 95%; height:20px; margin-top:2%; border-radius:4px;
}
.geral_login .login_tela #divlogin #footer{
    width: 85%;
    margin:20% 0% 0% 10%;
    padding-bottom: 5%;
}
.geral_login .login_tela #divlogin #login #botao_enviar{
color: #FFF;
font-family: arial;
font-weight: bold;
font-size: 15px;
margin: 19px 0px 0px;
width: 80px;
height: 30px;
line-height: 36px;
background: none repeat scroll 0% 0% #2891CC;
display: block;
text-align: center;
border-radius: 5px;
float: left;
border: 1px solid #01669F; 
}

@media (min-width: 1025px) {
  .geral_login .login_tela #divlogin #footer{
    margin:20% 0% 0% 3%;
    width: 95%;
    font-size:1.2em;
  }
.geral_login .login_tela #divlogin #login{
    width: 50%;
    margin:8% 0% 0% 15%;
}
}

@media (min-height: 900px) {
.geral_login .login_tela{   
    margin-top:20%;
}   
}
@media (min-height: 1000px)  {
 
.geral_login .login_tela{   
    margin-top:30%;
}   
}

@media (min-height: 1200px)  {
.geral_login .login_tela{ 
    margin-top:40%;
} 
}

@media (min-height: 1400px) and (max-width: 1300px) {
 
.geral_login .login_tela{
    zoom: 1.5;
-ms-zoom: 1.5;
-webkit-zoom: 1.5;
-moz-transform:  scale(1.5,1.5);
-moz-transform-origin: left center;
  margin-top:50%;
   width: 50%;
}
    
}
@media (min-height: 1600px)  {
 
.geral_login .login_tela{
      zoom: 1.5;
-ms-zoom: 1.5;
-webkit-zoom: 1.5;
-moz-transform:  scale(1.5,1.5);
-moz-transform-origin: left center;
    margin-top:60%;
    width: 50%;
}
    
}
            
        </style>
    </head>
    <body class="geral_login">      
        <div class="recebe_resposta"></div>
        <div class="login_tela">
            <div id="logo_empresa"><img src="sitio_barreiras.jpg" class="img-responsive"></div>
            <div id="divlogin">
                <div id="login">
                    <form class="login" method="post" action="">
                        <label>Usuario</label><input  type="text" name="usuario">
                        <label>Senha</label><input  type="password" name="senha">
                        <input  id="botao_enviar"  type="submit" value="Acessar" >  
                    </form>
                </div>
                <div id="footer"><p style="font-size: 0.7em;">&copy;Todos os Direitos Reservados | Sistema Desenvolvimento por Damiao Leonardo</p></div>
            </div>
        </div>
    </body>
</html>