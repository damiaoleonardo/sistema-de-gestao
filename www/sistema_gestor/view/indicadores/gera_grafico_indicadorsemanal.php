<?php
include('../../grafico/phplot-5.0.4/phplot.php');
session_start("monta_grafico");
$data = $_SESSION["array"];
$meta = 80;
session_destroy();
$graph = & new PHPlot(800, 500);
$graph->SetImageBorderType('plain');
$graph->SetDataValues($data);
$graph->SetTitle('Atividade Semanal Meta = '.$meta); // seta o nome do grafico
$graph->SetPlotType('bars'); // essa função serve para escolher o tipo do grafico que pode ser: bars, lines, linepoints, area, points e pie.
$graph->SetDataType("text-data"); // nescessario usar esse parametro no grafico com barras
$graph->SetVertTickIncrement(5); // espaçamento entre os pontos na regua vertical
$graph->SetHorizTickIncrement(53); // espaçamento entre os pontos na regua horizontal
$graph->SetBackgroundColor('white'); // muda a cor de fundo do grafico
$graph->SetXLabelFontSize(2);
$graph->SetAxisFontSize(2);
$graph->SetYDataLabelPos('plotin');
$graph->DrawGraph(); // gera o gráfico.
?>