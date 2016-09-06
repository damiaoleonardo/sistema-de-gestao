<?php
include "../libchart/classes/libchart.php";
$teste = 40.5;
$teste1 = 2.67;
$teste2 = 4.8;
$teste3 = 30.2;
$teste4 = 21.83;
$chart = new PieChart();
$dataSet = new XYDataSet();
$dataSet->addPoint(new Point("manutenção geral $teste", $teste));
$dataSet->addPoint(new Point("Konqueror ($teste1)", $teste1));
$dataSet->addPoint(new Point("Opera ($teste2)", $teste2));
$dataSet->addPoint(new Point("Safari ($teste3)", $teste3));
$dataSet->addPoint(new Point("Dillo ($teste4)", $teste4));

//$dataSet->addPoint(new Point("Other (10)", 10));
//$dataSet->addPoint(new Point("Other (10)", 10));
//$dataSet->addPoint(new Point("Other (10)", 10));
//$dataSet->addPoint(new Point($data[0], $data[1]));
//$dataSet->addPoint(new Point($data[2], $data[3]));
//$dataSet->addPoint(new Point($data[4], $data[5]));
$chart->setDataSet($dataSet);
$chart->setTitle("Relatorio do dia do funcionario");
$chart->render("generated/demo3.png");
?>
<html>
    <head>
        <title>Libchart pie chart demonstration </title>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15"/>
    </head>
    <body>
        <img alt="Pie chart"  src="generated/demo3.png" style="border: 1px solid gray;"/>
    </body>
</html>
