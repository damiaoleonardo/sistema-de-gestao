               i = 0;
	      tempo = 20;
	      tamanho = 600; // tamanho da barra de rolagem  >> Ver arquivo Leiame.txt
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


