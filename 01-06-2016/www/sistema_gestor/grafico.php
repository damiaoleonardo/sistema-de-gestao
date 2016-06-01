
<?php

// Estrutura basica do grafico
$grafico = array(
    'dados' => array(
        'cols' => array(
            array('type' => 'string', 'label' => 'Gênero'),
            array('type' => 'number', 'label' => 'Quantidade')
        ),
        'rows' => array()
    ),
    'config' => array(
        'title' => 'Quantidade de alunos por gênero',
        'width' => 400,
        'height' => 300
    )
);

// Consultar dados no BD

$pdo = new PDO('mysql:host=localhost;dbname=sistema_de_gestao', 'root', '');
$sql = 'select funcionarios.id_funcionario,funcionarios.login from funcionarios where 1';
$stmt = $pdo->query($sql);
while ($obj = $stmt->fetchObject()) {
    $grafico['dados']['rows'][] = array('c' => array(
            array('v' => $obj->login),
            array('v' => (int) $obj->id_funcionario)
    ));
}

// Enviar dados na forma de JSON
header('Content-Type: application/json; charset=UTF-8');
echo json_encode($grafico);
exit(0);
?>
