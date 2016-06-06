<?php

include('lib/nusoap.php');
$cliente = new nusoap_client('http://localhost/webservice/servidor.php?wsdl');
$parametros = array('nome' => 'Teste', 'idade' => 52);
$resultado = $cliente->call('exemplo', $parametros);
echo utf8_encode($resultado);

$parametros2 = array('idade' => '10');
$resultado_idade = $cliente->call('getIdade', $parametros2);
echo utf8_encode('<br>' . $resultado_idade);




$result = $cliente->call('getVeiculos');
echo '<pre>';
print_r($result);
echo '</pre>';
echo "<table border='1' ";
foreach ($result as $chave) {
    foreach ($chave as $valor) {
        echo "<tr>";
        foreach ($valor as $key => $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }
}
echo "</table>";
?>