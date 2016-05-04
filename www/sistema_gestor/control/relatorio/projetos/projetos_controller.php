<?php

 require '../../../model/relatorios/projetos/projetos_tarefas.php';
 $id_projeto = $_POST['campo_select_projeto'];
 $id_veiculo = $_POST['campo_select_veiculo'];
 $id_funcionario = $_POST['campo_select_funcionario'];
 $id_tipo = $_POST['campo_select_tipo'];
 $data_inicio = $_POST['data_inicio'];
 $data_final = $_POST['data_final'];
 
 
/*
if (empty($id_tarefa) and empty($id_veiculo) and empty($id_funcionario) and empty($data_final) and empty($tipo_veiculo)) {
    $relatorio->setData_inicial($data_inicio);
    $sql_projeto = $relatorio->Data($relatorio);
} else if (empty($id_tarefa) and empty($id_veiculo) and empty($id_funcionario) and empty($tipo_veiculo)) {

    $relatorio->setData_inicial($data_inicio);
    $relatorio->setData_final($data_final);
    $sql_projeto = $relatorio->Data($relatorio);
} else if (empty($id_tarefa) and empty($id_veiculo) and empty($tipo_veiculo)) {

    $relatorio->setId_funcionario($id_funcionario);

    if (empty($data_inicio) and empty($data_final)) {
        $sql_projeto = $relatorio->Funcionario($relatorio);
    } else if (empty($data_final)) {

        $relatorio->setData_inicial($data_inicio);
        $sql_projeto = $relatorio->Funcionario_data($relatorio);
    } else {

        $relatorio->setData_inicial($data_inicio);
        $relatorio->setData_final($data_final);
        $sql_projeto = $relatorio->Funcionario_Intervalo_data($relatorio);
    }
} else if (empty($id_tarefa) and empty($id_funcionario) and empty($tipo_veiculo)) {
    if (empty($data_inicio) and empty($data_final)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.status,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao,veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa from veiculos join projeto_executa on (veiculos.id_veiculo = projeto_executa.id_veiculo)join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo) where projeto_executa.id_veiculo = $id_veiculo";
    } else if (empty($data_final)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.status,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao,veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa from veiculos join projeto_executa on (veiculos.id_veiculo = projeto_executa.id_veiculo)join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo) where  projeto_executa.id_veiculo = $id_veiculo and  projeto_executa.data_inicio = '$data_inicio'";
    } else if (empty($data_inicio)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.status,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao,veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa from veiculos join projeto_executa on (veiculos.id_veiculo = projeto_executa.id_veiculo)join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo) where projeto_executa.id_veiculo = $id_veiculo and  projeto_executa.data_inicio = '$data_final'";
    } else {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa,projeto_executa.id_projeto,projeto_executa.id_veiculo,projeto_executa.nome_projeto,projeto_executa.status,projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao,veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa from veiculos join projeto_executa on (veiculos.id_veiculo = projeto_executa.id_veiculo)join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo) where projeto_executa.id_veiculo = $id_veiculo and  projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final'";
    }
} else if (empty($id_funcionario) and empty($id_veiculo) and empty($tipo_veiculo)) {

    $relatorio->setId_projeto($id_tarefa);

    if (empty($data_inicio) and empty($data_final)) {
        $sql_projeto = $relatorio->Projetos($relatorio);
    } else if (empty($data_final)) {
        $relatorio->setData_inicial($data_inicio);
        $sql_projeto = $relatorio->Projetos_data($relatorio);
    } else {
        $relatorio->setData_inicial($data_inicio);
        $relatorio->setData_final($data_final);
        $sql_projeto = $relatorio->Projetos_intervalos_datas($relatorio);
    }
} else if (empty($id_funcionario) and empty($id_veiculo) and empty($id_tarefa)) {
    if (empty($data_inicio) and empty($data_final)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas, projeto_executa.duracao, veiculos.nome_veiculo, tarefas_executa.descricao_da_tarefa
                   FROM veiculos
                   JOIN tipo_veiculo ON ( veiculos.id_tipo = tipo_veiculo.id_tipo )
                   JOIN projeto_executa ON ( veiculos.id_veiculo = projeto_executa.id_veiculo )
                   JOIN tarefas_executa ON ( projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa
                   AND projeto_executa.id_projeto = tarefas_executa.id_projeto
                   AND projeto_executa.id_veiculo = tarefas_executa.id_veiculo )
                   WHERE veiculos.id_tipo = $tipo_veiculo order by data_inicio ASC";
    } else if (empty($data_final)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas, projeto_executa.duracao, veiculos.nome_veiculo, tarefas_executa.descricao_da_tarefa
                   FROM veiculos
                   JOIN projeto_executa ON ( veiculos.id_veiculo = projeto_executa.id_veiculo )
                   JOIN tarefas_executa ON ( projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa
                   AND projeto_executa.id_projeto = tarefas_executa.id_projeto
                   AND projeto_executa.id_veiculo = tarefas_executa.id_veiculo )
join funcionario_executa on (funcionario_executa.id_veiculo = veiculos.id_veiculo and funcionario_executa.id_projeto = projeto_executa.id_projeto and funcionario_executa.id_projeto_executa = projeto_executa.id_projeto_executa)
                   WHERE veiculos.id_tipo = $tipo_veiculo and funcionario_executa.data_tarefa = '$data_inicio' order by data_inicio ASC";
    } else {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas, projeto_executa.duracao, veiculos.nome_veiculo, tarefas_executa.descricao_da_tarefa
                   FROM veiculos
                   JOIN projeto_executa ON ( veiculos.id_veiculo = projeto_executa.id_veiculo )
                   JOIN tarefas_executa ON ( projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa
                   AND projeto_executa.id_projeto = tarefas_executa.id_projeto
                   AND projeto_executa.id_veiculo = tarefas_executa.id_veiculo )
join funcionario_executa on (funcionario_executa.id_veiculo = veiculos.id_veiculo and funcionario_executa.id_projeto = projeto_executa.id_projeto and funcionario_executa.id_projeto_executa = projeto_executa.id_projeto_executa)
                   WHERE veiculos.id_tipo = $tipo_veiculo and funcionario_executa.data_tarefa <= '$data_inicio' and funcionario_executa.data_tarefa = '$data_final' order by data_inicio ASC";
    }
} else if (!empty($id_tarefa) and ! empty($tipo_veiculo) and ! empty($id_funcionario)) {
    if (empty($data_inicio) and empty($data_final)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas, projeto_executa.duracao, veiculos.nome_veiculo, tarefas_executa.descricao_da_tarefa
                   FROM veiculos
                   JOIN projeto_executa ON ( veiculos.id_veiculo = projeto_executa.id_veiculo )
                   JOIN tarefas_executa ON ( projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa
                   AND projeto_executa.id_projeto = tarefas_executa.id_projeto
                   AND projeto_executa.id_veiculo = tarefas_executa.id_veiculo )
join funcionario_executa on (funcionario_executa.id_veiculo = veiculos.id_veiculo and funcionario_executa.id_projeto = projeto_executa.id_projeto and funcionario_executa.id_projeto_executa = projeto_executa.id_projeto_executa)
                   WHERE veiculos.id_tipo = $tipo_veiculo and funcionario_executa.id_funcionario = $id_funcionario and projeto_executa.id_projeto = $id_projeto  order by data_inicio ASC";
    } else if (empty($data_final)) {
        $nome .= "%";
        $sql_projeto = "";
    } else {
        $nome .= "%";
        $sql_projeto = "";
    }
} else if (!empty($id_funcionario) and ! empty($id_tarefa) and empty($id_veiculo)) {

    if (empty($data_inicio) and empty($data_final)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas,projeto_executa.duracao, veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa
                    FROM projeto_executa
                    JOIN funcionario_executa ON ( projeto_executa.id_veiculo = funcionario_executa.id_veiculo
                    AND projeto_executa.id_projeto = funcionario_executa.id_projeto
                    AND projeto_executa.id_projeto_executa = funcionario_executa.id_projeto_executa )
                    JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo)
                    WHERE funcionario_executa.id_funcionario =$id_funcionario
                    AND projeto_executa.id_projeto = $id_tarefa";
    } else if (empty($data_final)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas,projeto_executa.duracao, veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa
                    FROM projeto_executa
                    JOIN funcionario_executa ON ( projeto_executa.id_veiculo = funcionario_executa.id_veiculo
                    AND projeto_executa.id_projeto = funcionario_executa.id_projeto
                    AND projeto_executa.id_projeto_executa = funcionario_executa.id_projeto_executa )
                    JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo)
                    WHERE funcionario_executa.id_funcionario = $id_funcionario
                    AND projeto_executa.id_projeto =$id_tarefa and projeto_executa.data_inicio = '$data_inicio'";
    } else if (empty($data_inicio)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao, veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa
                    FROM projeto_executa
                    JOIN funcionario_executa ON ( projeto_executa.id_veiculo = funcionario_executa.id_veiculo
                    AND projeto_executa.id_projeto = funcionario_executa.id_projeto
                    AND projeto_executa.id_projeto_executa = funcionario_executa.id_projeto_executa )
                    JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo)
                    WHERE funcionario_executa.id_funcionario = $id_funcionario
                    AND projeto_executa.id_projeto = $id_tarefa and projeto_executa.data_final = '$data_final'";
    } else {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas,projeto_executa.duracao, veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa
                    FROM projeto_executa
                    JOIN funcionario_executa ON ( projeto_executa.id_veiculo = funcionario_executa.id_veiculo
                    AND projeto_executa.id_projeto = funcionario_executa.id_projeto
                    AND projeto_executa.id_projeto_executa = funcionario_executa.id_projeto_executa )
                    JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo)
                    WHERE funcionario_executa.id_funcionario = $id_funcionario
                    AND projeto_executa.id_projeto = $id_tarefa and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' ";
    }
} else if (!empty($id_funcionario) and ! empty($id_veiculo) and empty($id_tarefa)) {
    if (empty($data_inicio) and empty($data_final)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas,projeto_executa.duracao, veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa
                    FROM projeto_executa
                    JOIN funcionario_executa ON ( projeto_executa.id_veiculo = funcionario_executa.id_veiculo
                    AND projeto_executa.id_projeto = funcionario_executa.id_projeto
                    AND projeto_executa.id_projeto_executa = funcionario_executa.id_projeto_executa )
                    JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo)
                    WHERE funcionario_executa.id_funcionario =$id_funcionario
                    AND projeto_executa.id_veiculo =$id_veiculo";
    } else if (empty($data_final)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas,projeto_executa.duracao, veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa
                    FROM projeto_executa
                    JOIN funcionario_executa ON ( projeto_executa.id_veiculo = funcionario_executa.id_veiculo
                    AND projeto_executa.id_projeto = funcionario_executa.id_projeto
                    AND projeto_executa.id_projeto_executa = funcionario_executa.id_projeto_executa )
                    JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo)
                    WHERE funcionario_executa.id_funcionario =$id_funcionario
                    AND projeto_executa.id_veiculo =$id_veiculo and projeto_executa.data_inicio = '$data_inicio'";
    } else if (empty($data_inicio)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao, veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa
                    FROM projeto_executa
                    JOIN funcionario_executa ON ( projeto_executa.id_veiculo = funcionario_executa.id_veiculo 
                    AND projeto_executa.id_projeto = funcionario_executa.id_projeto
                    AND projeto_executa.id_projeto_executa = funcionario_executa.id_projeto_executa )
                    JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo)
                    WHERE funcionario_executa.id_funcionario =$id_funcionario
                    AND projeto_executa.id_veiculo =$id_veiculo and projeto_executa.data_final = '$data_final'";
    } else {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao, veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa
                    FROM projeto_executa
                    JOIN funcionario_executa ON ( projeto_executa.id_veiculo = funcionario_executa.id_veiculo
                    AND projeto_executa.id_projeto = funcionario_executa.id_projeto
                    AND projeto_executa.id_projeto_executa = funcionario_executa.id_projeto_executa )
                    JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo)
                    WHERE funcionario_executa.id_funcionario =$id_funcionario
                    AND projeto_executa.id_veiculo =$id_veiculo and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' and ";
    }
} else if (!empty($id_tarefa) and ! empty($id_veiculo) and empty($id_funcionario)) {
    if (empty($data_inicio) and empty($data_final)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas,projeto_executa.duracao, veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa
                    FROM projeto_executa
                    JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo)
                    WHERE projeto_executa.id_veiculo =$id_veiculo and  projeto_executa.id_projeto= $id_tarefa";
    } else if (empty($data_final)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas,projeto_executa.duracao, veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa
                    FROM projeto_executa
                    JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo)
                    WHERE projeto_executa.id_veiculo =$id_veiculo and  projeto_executa.id_projeto= $id_tarefa and projeto_executa.data_inicio = '$data_inicio'";
    } else if (empty($data_inicio)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas,projeto_executa.duracao, veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa
                    FROM projeto_executa
                    JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo)
                    WHERE projeto_executa.id_veiculo =$id_veiculo and  projeto_executa.id_projeto= $id_tarefa and projeto_executa.data_final = '$data_final'";
    } else {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas,projeto_executa.duracao, veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa
                    FROM projeto_executa
                    JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo)
                    WHERE projeto_executa.id_veiculo =$id_veiculo and  projeto_executa.id_projeto= $id_tarefa and projeto_executa.data_inicio >= '$data_inicio' and projeto_executa.data_final <= '$data_final' ";
    }
} else if (!empty($id_tarefa) and ! empty($tipo_veiculo) and empty($id_funcionario)) {
    if (empty($data_inicio) and empty($data_final)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas, projeto_executa.duracao, veiculos.nome_veiculo, tarefas_executa.descricao_da_tarefa
                   FROM veiculos
                   JOIN projeto_executa ON ( veiculos.id_veiculo = projeto_executa.id_veiculo )
                   JOIN tarefas_executa ON ( projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa
                   AND projeto_executa.id_projeto = tarefas_executa.id_projeto
                   AND projeto_executa.id_veiculo = tarefas_executa.id_veiculo )
join funcionario_executa on (funcionario_executa.id_veiculo = veiculos.id_veiculo and funcionario_executa.id_projeto = projeto_executa.id_projeto and funcionario_executa.id_projeto_executa = projeto_executa.id_projeto_executa)
                   WHERE veiculos.id_tipo = $tipo_veiculo and projeto_executa.id_projeto = $id_tarefa order by data_inicio ASC";
    } else if (empty($data_final)) {
        $nome .= "%";
        $sql_projeto = " SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas, projeto_executa.duracao, veiculos.nome_veiculo, tarefas_executa.descricao_da_tarefa
                   FROM veiculos
                   JOIN projeto_executa ON ( veiculos.id_veiculo = projeto_executa.id_veiculo )
                   JOIN tarefas_executa ON ( projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa
                   AND projeto_executa.id_projeto = tarefas_executa.id_projeto
                   AND projeto_executa.id_veiculo = tarefas_executa.id_veiculo )
join funcionario_executa on (funcionario_executa.id_veiculo = veiculos.id_veiculo and funcionario_executa.id_projeto = projeto_executa.id_projeto and funcionario_executa.id_projeto_executa = projeto_executa.id_projeto_executa)
                   WHERE veiculos.id_tipo = $tipo_veiculo and projeto_executa.id_projeto = $id_tarefa and funcionario_executa.data_tarefa = '$data_inicio'";
    } else {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas, projeto_executa.duracao, veiculos.nome_veiculo, tarefas_executa.descricao_da_tarefa
                   FROM veiculos
                   JOIN projeto_executa ON ( veiculos.id_veiculo = projeto_executa.id_veiculo )
                   JOIN tarefas_executa ON ( projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa
                   AND projeto_executa.id_projeto = tarefas_executa.id_projeto
                   AND projeto_executa.id_veiculo = tarefas_executa.id_veiculo )
join funcionario_executa on (funcionario_executa.id_veiculo = veiculos.id_veiculo and funcionario_executa.id_projeto = projeto_executa.id_projeto and funcionario_executa.id_projeto_executa = projeto_executa.id_projeto_executa)
                   WHERE veiculos.id_tipo = $tipo_veiculo and projeto_executa.id_projeto = $id_tarefa and funcionario_executa.data_tarefa <= '$data_inicio' and funcionario_executa.data_tarefa >= '$data_final'";
    }
} else if (empty($id_tarefa) and ! empty($tipo_veiculo) and ! empty($id_funcionario)) {
    if (empty($data_inicio) and empty($data_final)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas, projeto_executa.duracao, veiculos.nome_veiculo, tarefas_executa.descricao_da_tarefa
                   FROM veiculos
                   JOIN projeto_executa ON ( veiculos.id_veiculo = projeto_executa.id_veiculo )
                   JOIN tarefas_executa ON ( projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa
                   AND projeto_executa.id_projeto = tarefas_executa.id_projeto
                   AND projeto_executa.id_veiculo = tarefas_executa.id_veiculo )
join funcionario_executa on (funcionario_executa.id_veiculo = veiculos.id_veiculo and funcionario_executa.id_projeto = projeto_executa.id_projeto and funcionario_executa.id_projeto_executa = projeto_executa.id_projeto_executa)
                   WHERE veiculos.id_tipo = $tipo_veiculo and funcionario_executa.id_funcionario = $id_funcionario order by data_inicio ASC";
    } else if (empty($data_final)) {
        $nome .= "%";
        $sql_projeto = " SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas, projeto_executa.duracao, veiculos.nome_veiculo, tarefas_executa.descricao_da_tarefa
                   FROM veiculos
                   JOIN projeto_executa ON ( veiculos.id_veiculo = projeto_executa.id_veiculo )
                   JOIN tarefas_executa ON ( projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa
                   AND projeto_executa.id_projeto = tarefas_executa.id_projeto
                   AND projeto_executa.id_veiculo = tarefas_executa.id_veiculo )
join funcionario_executa on (funcionario_executa.id_veiculo = veiculos.id_veiculo and funcionario_executa.id_projeto = projeto_executa.id_projeto and funcionario_executa.id_projeto_executa = projeto_executa.id_projeto_executa)
                   WHERE veiculos.id_tipo = $tipo_veiculo and projeto_executa.id_projeto = $id_tarefa and funcionario_executa.data_tarefa = '$data_inicio'";
    } else {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas, projeto_executa.duracao, veiculos.nome_veiculo, tarefas_executa.descricao_da_tarefa
                   FROM veiculos
                   JOIN projeto_executa ON ( veiculos.id_veiculo = projeto_executa.id_veiculo )
                   JOIN tarefas_executa ON ( projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa
                   AND projeto_executa.id_projeto = tarefas_executa.id_projeto
                   AND projeto_executa.id_veiculo = tarefas_executa.id_veiculo )
join funcionario_executa on (funcionario_executa.id_veiculo = veiculos.id_veiculo and funcionario_executa.id_projeto = projeto_executa.id_projeto and funcionario_executa.id_projeto_executa = projeto_executa.id_projeto_executa)
                   WHERE veiculos.id_tipo = $tipo_veiculo and projeto_executa.id_projeto = $id_tarefa and funcionario_executa.data_tarefa <= '$data_inicio' and funcionario_executa.data_tarefa >= '$data_final'";
    }
} else {
    if (empty($data_inicio) and empty($data_final)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao, veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa
                    FROM projeto_executa
                    JOIN funcionario_executa ON ( projeto_executa.id_veiculo = funcionario_executa.id_veiculo
                    AND projeto_executa.id_projeto = funcionario_executa.id_projeto
                    AND projeto_executa.id_projeto_executa = funcionario_executa.id_projeto_executa )
                    JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo)
                    WHERE funcionario_executa.id_funcionario =$id_funcionario
                    AND projeto_executa.id_projeto =$id_tarefa
                    AND projeto_executa.id_veiculo =$id_veiculo";
    } else if (empty($data_final)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas,projeto_executa.duracao, veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa
                    FROM projeto_executa
                    JOIN funcionario_executa ON ( projeto_executa.id_veiculo = funcionario_executa.id_veiculo
                    AND projeto_executa.id_projeto = funcionario_executa.id_projeto
                    AND projeto_executa.id_projeto_executa = funcionario_executa.id_projeto_executa )
                    JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo)
                    WHERE funcionario_executa.id_funcionario =$id_funcionario
                    AND projeto_executa.id_projeto =$id_tarefa
                    AND projeto_executa.id_veiculo =$id_veiculo and projeto_executa.data_inicio = '$data_inicio'";
    } else if (empty($data_inicio)) {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio,projeto_executa.horas_concluidas,projeto_executa.duracao, veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa
                    FROM projeto_executa
                    JOIN funcionario_executa ON ( projeto_executa.id_veiculo = funcionario_executa.id_veiculo
                    AND projeto_executa.id_projeto = funcionario_executa.id_projeto
                    AND projeto_executa.id_projeto_executa = funcionario_executa.id_projeto_executa )
                    JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo)
                    WHERE funcionario_executa.id_funcionario =$id_funcionario
                    AND projeto_executa.id_projeto =$id_tarefa
                    AND projeto_executa.id_veiculo =$id_veiculo and projeto_executa.data_final = '$data_final'";
    } else {
        $nome .= "%";
        $sql_projeto = "SELECT DISTINCT projeto_executa.id_projeto_executa, projeto_executa.id_projeto, projeto_executa.id_veiculo, projeto_executa.nome_projeto, projeto_executa.status, projeto_executa.data_inicio, projeto_executa.horas_concluidas,projeto_executa.duracao, veiculos.nome_veiculo,tarefas_executa.descricao_da_tarefa
                    FROM projeto_executa
                    JOIN funcionario_executa ON ( projeto_executa.id_veiculo = funcionario_executa.id_veiculo
                    AND projeto_executa.id_projeto = funcionario_executa.id_projeto
                    AND projeto_executa.id_projeto_executa = funcionario_executa.id_projeto_executa )
                    JOIN veiculos ON ( projeto_executa.id_veiculo = veiculos.id_veiculo )join tarefas_executa on (projeto_executa.id_projeto_executa = tarefas_executa.id_projeto_executa and projeto_executa.id_projeto = tarefas_executa.id_projeto and projeto_executa.id_veiculo = tarefas_executa.id_veiculo)
                    WHERE funcionario_executa.id_funcionario =$id_funcionario
                    AND projeto_executa.id_projeto =$id_tarefa
                    AND projeto_executa.id_veiculo =$id_veiculo and projeto_executa.data_inicio >= '$data_inicio' and and projeto_executa.data_final <= '$data_final'";
    }
}




// $relatorios = new projetos_tarefas();
// $relatorios->MontaSelectTarefas($relatorios);*/
?>


