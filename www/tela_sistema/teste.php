    <html  xml:lang="pt-br" lang="pt-br">
      <head>
        <title>DIV com rolagem automática: anuncie notícias e novidades</title>
        <meta name="author" content="Gabriel Barros | www.gabrielbarros.com.br" />
     
        <script type="text/javascript">
          <!--
          i = 0;
          tempo = 50;
          tamanho = 826; // tamanho da barra de rolagem  >> Ver arquivo Leiame.txt
     
          function Rolar() {
            document.getElementById('painel').scrollTop = i;
            i++;
            t = setTimeout("Rolar()", tempo);
            if (i == tamanho) {
              i = 0;
            }
          }
          function Parar() {
            clearTimeout(t);
          }
        
        </script>
      </head>
     
      <body onload="Rolar()">
        <div id="painel" style="font: 15px Tahoma; cursor: default; height: 200px; width: 200px; overflow: hidden; background-color: #DFEDFE; padding-left: 10px;  padding-right: 10px" onmouseover="Parar()" onmouseout="Rolar()">
          <!-- INÍCIO DO CONTEÚDO DA DIV -->
          <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
          Acesse regularmente o site CodigoFonte.net e fique por dentro do há de melhor no mundo da programação web. Por conta própria você pode conseguir algumas apostilas na Internet e, como complemento para seus estudos, use os scripts para aguçar sua imaginação e aprimorar seus conhecimentos. Comece estudando html. Não precisa ter pressa. É uma linguagem fácil de se aprender, basta ter dedicação e força de vontade. Depois de algum tempo, entre para o maravilhoso mundo do javascript. Vá com calma nesta parte, pois você pode se entusiasmar com os resultados iniciais e acabar tendo problemas logo mais tarde. Eu aconselho você, quando chegar na parte de funções, a baixar scripts de jogos e tentar entender o funcionamento deles. Bons estudos e boa sorte. Lembre-se: o CodigoFonte.net está sempre atualizado e esperando pela sua visita. Eu já aprendi muito (e continuo aprendendo) com esse site.
          <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
          <!-- FIM DO CONTEÚDO DA DIV -->
        </div>
      </body>
    </html>