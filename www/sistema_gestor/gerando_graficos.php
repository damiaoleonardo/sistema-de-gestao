<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8"/>
    <title>Exemplo de gráfico</title>

    <!-- Carregar a API do google -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   
   
    <!-- Preparar a geracao do grafico -->
    <script type="text/javascript">
/*
      // Carregar a API de visualizacao e os pacotes necessarios.
      google.load('visualization', '1.0', {'packages':['corechart']});
      // Especificar um callback para ser executado quando a API for carregada.
      google.setOnLoadCallback(desenharGrafico);

    
      function desenharGrafico() {
        // Montar os dados usados pelo grafico
        var dados = new google.visualization.DataTable();
        dados.addColumn('string', 'Gênero');
        dados.addColumn('time', 'Quantidades');
        dados.addRows([
          ['Masculino', 00:01:00],
          ['Feminino', 00:01:00]
        ]);

        // Configuracoes do grafico
        var config = {
            'title':'Quantidade de alunos por gênero',
            'width':400,
            'height':300
        };

        // Instanciar o objeto de geracao de graficos de pizza,
        // informando o elemento HTML onde o grafico sera desenhado.
        var chart = new google.visualization.PieChart(document.getElementById('area_grafico'));

        // Desenhar o grafico (usando os dados e as configuracoes criadas)
        chart.draw(dados, config);
      }
      
      */
      
      
      google.charts.load('current', {'packages':['timeline']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Activity', 'Start Time', 'End Time'],
        ['Manutenção geral',
         new Date(2014, 10, 15, 7, 00),
         new Date(2014, 10, 15, 8, 00)],
        ['Inativo',
         new Date(2014, 10, 15, 8, 00),
         new Date(2014, 10, 15, 8, 20)],
        ['Troca de oleo',
         new Date(2014, 10, 15, 8, 20),
         new Date(2014, 10, 15, 9,00)],
        ['Regulagem de freio',
         new Date(2014, 10, 15, 9, 20),
         new Date(2014, 10, 15, 11, 00)],
        ['check eletrico',
         new Date(2014, 10, 15, 12, 30),
         new Date(2014, 10, 15, 15, 30)],
        ['Troca do filtro de ar',
         new Date(2014, 10, 15, 15, 30),
         new Date(2014, 10, 15, 17)]
      ]);

      var options = {
        height: 500,
        width: 600
      };

      var chart = new google.visualization.Timeline(document.getElementById('area_grafico'));

      chart.draw(data, options);
    }
      
      
    </script>
  </head>

  <body>

    <div id="area_grafico"></div>
  </body>
</html>