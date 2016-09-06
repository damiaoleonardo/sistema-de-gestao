<?php
//incluir o arquivo do phpplot
include('../phplot-5.0.4/phplot.php');
session_start("array");
$data = $_SESSION["lista"];
session_destroy();
$plot = new PHPlot(800, 510); //defini as dimensões do grafico
$plot->SetTitleColor('#404040'); // Cor do titulo do grafico
#$plot->SetTitle(""); // titulo do Grafico
#$plot->SetFileFormat('png'); //seleciona o formato de saida do grafico
$plot->SetImageBorderType('plain');
$plot->SetBackgroundColor('YellowGreen'); // Define a cor de fundo do grafico
$plot->SetPlotType('pie'); // Seleciona o tipo do grafico, pode ser PIE, BARS, LINES e etc
$plot->SetShading(1); 
$plot->SetDataType('text-data-single');
$plot->SetPlotAreaPixels(100, 110, 1000, 460);
$plot->SetLegendPixels(0,0); 
//$plot->SetMarginsPixels(0, 0, 0,0);
//$plot->SetLegendPixels(280, 10);
$plot->SetShading(0);
//$plot->SetLabelScalePosition(0.3);
$plot->SetLegendStyle('left','left');
$plot->SetDataValues($data);

foreach ($data as $row) {
    $plot->SetDataColors(array('red', 'green', 'blue','DarkGreen','purple','salmon','gold','violet','SkyBlue','peru','aquamarine1',
        'magenta','orange','#814b15','#0fa8ce','#777'));
    $plot->SetLegend($row[0]);
}

$plot->DrawGraph(); //gera o grafico 




?>