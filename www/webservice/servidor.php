<?php

include('lib/nusoap.php');
$servidor = new nusoap_server();
$servidor->configureWSDL('urn:Servidor');
$servidor->wsdl->schemaTargetNamespace = 'urn:Servidor';
$servidor->wsdl->addComplexType('veiculos',
        'complexType',
        'struct',
        'all',
        '',
        array('veiculos' => array('id_veiculo' => 'xsd:int', 'nome_veiculo' => 'xsd:string')));

function exemplo($nome, $idade) {
    return($nome . ' -> ' . $idade);
}

function getIdade($idade) {
    return ($idade + 20);
}

function getVeiculos() {
      $conn = mysqli_connect ("localhost","root","","sistema_de_gestao");
            $sql = "select veiculos.id_veiculo,veiculos.nome_veiculo from veiculos where id_veiculo > 55";
            $result = mysqli_query ($conn, $sql);
            $arrayToReturn=array();
            while ($row = mysqli_fetch_assoc($result)){
                    $arrayToReturn[] = array('id_veiculo' => $row["id_veiculo"], 'nome_veiculo'=> $row["nome_veiculo"]);
            }
        mysqli_close ($conn);
    return array('veiculos'=>$arrayToReturn);
}


$servidor->register("getVeiculos", array(), array('return' => 'tns:veiculos'), 'urn:getVeiculos', // namespace
        'urn:getVeiculos.getVeiculos', // soapaction
        'rpc', // style
        'encoded', // use 
        'Says hello to the caller');

$servidor->register( 'exemplo', array('nome' => 'xsd:string',
    'idade' => 'xsd:int'), array('retorno' => 'xsd:string'), 'urn:getVeiculos.exemplo', 'urn:Servidor.exmeplo', 'rpc', 'encoded', 'Apenas um exemplo utilizando o NuSOAP PHP.'
);


$servidor->register('getIdade', array('idade' => 'xsd:int'), array('retorno' => 'xsd:int'), 'urn:Servidor.getIdade', 'urn:Servidor.getIdade', 'rpc', 'encoded', 'Apenas um exemplo utilizando o NuSOAP PHP.');


$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$servidor->service($HTTP_RAW_POST_DATA);

?>