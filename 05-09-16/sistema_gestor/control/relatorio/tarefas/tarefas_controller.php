<?php
require '../../../model/relatorios/tarefas/tarefas.php';
$relatorios_tarefas = new tarefas();
$id_tarefa = $_POST['campo_select_tarefa'];
$id_veiculo = $_POST['campo_select_veiculo'];
$id_tipo = $_POST['campo_select_tipo'];
$status = $_POST['campo_select_status'];
$id_funcionario = $_POST['campo_select_funcionario'];
$data_inicio = $_POST['data_inicio'];
$data_final = $_POST['data_final'];
if (empty($id_tarefa) and empty($id_veiculo) and empty($id_funcionario) and empty($id_tipo) and empty($data_inicio) and empty($data_final) and empty($status)) {
    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Todos os campos estão vazios!</p>";
} else {
    if (!empty($status)) {
        if ($status == "open" || $status == "concluida") {
            if (empty($id_veiculo) and empty($id_tipo) and empty($id_funcionario) and ! empty($id_tarefa)) {
                if (empty($data_inicio) and empty($data_final)) {
                  $relatorios_tarefas->setId_tarefa($id_tarefa);
                  $relatorios_tarefas->setStatus_tarefa($status);
                  $sql_tarefa = $relatorios_tarefas->tarefa($relatorios_tarefas);
                  $relatorios_tarefas->montaTabelaTarefa($sql_tarefa,$status);
                } else if (!empty($data_inicio) and ! empty($data_final)) {
                    $relatorios_tarefas->setId_tarefa($id_tarefa);
                    $relatorios_tarefas->setStatus_tarefa($status);
                    $relatorios_tarefas->setData_inicial($data_inicio);
                    $relatorios_tarefas->setData_final($data_final);
                    $sql = $relatorios_tarefas->tarefasDatas($relatorios_tarefas);
                    $relatorios_tarefas->montaTabelaTarefa($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            } else if (! empty($id_tarefa) and empty($id_tipo) and empty($id_funcionario) and ! empty($id_veiculo)) {
                if (empty($data_inicio) and empty($data_final)) {
                  $relatorios_tarefas->setId_veiculo($id_veiculo);
                  $relatorios_tarefas->setId_tarefa($id_tarefa);
                  $relatorios_tarefas->setStatus_tarefa($status);
                  $sql_tarefa = $relatorios_tarefas->tarefasveiculo($relatorios_tarefas);
                  $relatorios_tarefas->montaTabelaTarefa($sql_tarefa,$status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_tarefas->setId_veiculo($id_veiculo);
                    $relatorios_tarefas->setId_tarefa($id_tarefa);
                    $relatorios_tarefas->setStatus_tarefa($status);
                    $relatorios_tarefas->setData_inicial($data_inicio);
                    $relatorios_tarefas->setData_final($data_final);
                    $sql = $relatorios_tarefas->tarefasveiculoDatas($relatorios_tarefas);
                    $relatorios_tarefas->montaTabelaTarefa($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            } else if (!empty($id_tarefa) and empty($id_veiculo) and empty($id_funcionario) and ! empty($id_tipo)) {
                if (empty($data_inicio) and empty($data_final)) {
                  $relatorios_tarefas->setId_tipo_veiculo($id_tipo);
                  $relatorios_tarefas->setId_tarefa($id_tarefa);
                  $relatorios_tarefas->setStatus_tarefa($status);
                  $sql_tarefa = $relatorios_tarefas->tarefastipoVeiculo($relatorios_tarefas);
                  $relatorios_tarefas->montaTabelaTarefa($sql_tarefa,$status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_tarefas->setId_tipo_veiculo($id_tipo);
                    $relatorios_tarefas->setStatus_tarefa($status);
                    $relatorios_tarefas->setData_inicial($data_inicio);
                    $relatorios_tarefas->setData_final($data_final);
                    $sql = $relatorios_tarefas->tipoVeiculoDatas($relatorios_tarefas);
                    $relatorios_tarefas->montaTabelaTarefa($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (!empty($id_tarefa) and empty($id_veiculo) and empty($id_tipo) and ! empty($id_funcionario)) {
               if (empty($data_inicio) and empty($data_final)) {
                  $relatorios_tarefas->setId_funcionario($id_funcionario);
                  $relatorios_tarefas->setId_tarefa($id_tarefa);
                  $relatorios_tarefas->setStatus_tarefa($status);
                  $sql_tarefa = $relatorios_tarefas->tarefasfuncionario($relatorios_tarefas);
                  $relatorios_tarefas->montaTabelaTarefa($sql_tarefa,$status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_tarefas->setId_funcionario($id_funcionario);
                    $relatorios_tarefas->setId_tarefa($id_tarefa);
                    $relatorios_tarefas->setStatus_tarefa($status);
                    $relatorios_tarefas->setData_inicial($data_inicio);
                    $relatorios_tarefas->setData_final($data_final);
                    $sql = $relatorios_tarefas->tarefasfuncionarioDatas($relatorios_tarefas);
                    $relatorios_tarefas->montaTabelaTarefa($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (!empty($id_tarefa) and empty(!$id_veiculo) and empty($id_tipo) and ! empty($id_funcionario)) {
                if (empty($data_inicio) and empty($data_final)) {
                  $relatorios_tarefas->setId_funcionario($id_funcionario);
                  $relatorios_tarefas->setId_tarefa($id_tarefa);
                  $relatorios_tarefas->setId_veiculo($id_veiculo);
                  $relatorios_tarefas->setStatus_tarefa($status);
                  $sql_tarefa = $relatorios_tarefas->tarefasveiculofuncionario($relatorios_tarefas);
                  $relatorios_tarefas->montaTabelaTarefa($sql_tarefa,$status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_tarefas->setId_funcionario($id_funcionario);
                    $relatorios_tarefas->setId_tarefa($id_tarefa);
                    $relatorios_tarefas->setId_veiculo($id_veiculo);
                    $relatorios_tarefas->setStatus_tarefa($status);
                    $relatorios_tarefas->setData_inicial($data_inicio);
                    $relatorios_tarefas->setData_final($data_final);
                    $sql = $relatorios_tarefas->tarefasveiculofuncionarioDatas($relatorios_tarefas);
                    $relatorios_tarefas->montaTabelaTarefa($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (!empty($id_tarefa) and empty($id_veiculo) and !empty($id_tipo) and ! empty($id_funcionario)) {
                 if (empty($data_inicio) and empty($data_final)) {
                  $relatorios_tarefas->setId_funcionario($id_funcionario);
                  $relatorios_tarefas->setId_tarefa($id_tarefa);
                  $relatorios_tarefas->setId_tipo_veiculo($id_tipo);
                  $relatorios_tarefas->setStatus_tarefa($status);
                  $sql_tarefa = $relatorios_tarefas->tarefastipoveiculofuncionario($relatorios_tarefas);
                  $relatorios_tarefas->montaTabelaTarefa($sql_tarefa,$status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_tarefas->setId_funcionario($id_funcionario);
                    $relatorios_tarefas->setId_tarefa($id_tarefa);
                    $relatorios_tarefas->setId_tipo_veiculo($id_tipo);
                    $relatorios_tarefas->setStatus_tarefa($status);
                    $relatorios_tarefas->setData_inicial($data_inicio);
                    $relatorios_tarefas->setData_final($data_final);
                    $sql = $relatorios_tarefas->tarefastipoveiculofuncionarioDatas($relatorios_tarefas);
                    $relatorios_tarefas->montaTabelaTarefa($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else{
                  echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
            }
        } else {
           // tarefas concluidas e as abertas 
            if (empty($id_veiculo) and empty($id_tipo) and empty($id_funcionario) and ! empty($id_tarefa)) {
                if (empty($data_inicio) and empty($data_final)) {
                  $relatorios_tarefas->setId_tarefa($id_tarefa);
                  $relatorios_tarefas->setStatus_tarefa($status);
                  $sql_tarefa = $relatorios_tarefas->tarefatodos($relatorios_tarefas);
                  $relatorios_tarefas->montaTabelaTarefa($sql_tarefa,$status);
                } else if (!empty($data_inicio) and ! empty($data_final)) {
                    $relatorios_tarefas->setId_tarefa($id_tarefa);
                    $relatorios_tarefas->setStatus_tarefa($status);
                    $relatorios_tarefas->setData_inicial($data_inicio);
                    $relatorios_tarefas->setData_final($data_final);
                    $sql = $relatorios_tarefas->tarefasDatastodos($relatorios_tarefas);
                    $relatorios_tarefas->montaTabelaTarefa($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            } else if (! empty($id_tarefa) and empty($id_tipo) and empty($id_funcionario) and ! empty($id_veiculo)) {
                if (empty($data_inicio) and empty($data_final)) {
                  $relatorios_tarefas->setId_veiculo($id_veiculo);
                  $relatorios_tarefas->setId_tarefa($id_tarefa);
                  $relatorios_tarefas->setStatus_tarefa($status);
                  $sql_tarefa = $relatorios_tarefas->tarefasveiculotodos($relatorios_tarefas);
                  $relatorios_tarefas->montaTabelaTarefa($sql_tarefa,$status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_tarefas->setId_veiculo($id_veiculo);
                    $relatorios_tarefas->setId_tarefa($id_tarefa);
                    $relatorios_tarefas->setStatus_tarefa($status);
                    $relatorios_tarefas->setData_inicial($data_inicio);
                    $relatorios_tarefas->setData_final($data_final);
                    $sql = $relatorios_tarefas->tarefasveiculoDatastodos($relatorios_tarefas);
                    $relatorios_tarefas->montaTabelaTarefa($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            } else if (!empty($id_tarefa) and empty($id_veiculo) and empty($id_funcionario) and ! empty($id_tipo)) {
                if (empty($data_inicio) and empty($data_final)) {
                  $relatorios_tarefas->setId_tipo_veiculo($id_tipo);
                  $relatorios_tarefas->setId_tarefa($id_tarefa);
                  $relatorios_tarefas->setStatus_tarefa($status);
                  $sql_tarefa = $relatorios_tarefas->tarefastipoVeiculotodos($relatorios_tarefas);
                  $relatorios_tarefas->montaTabelaTarefa($sql_tarefa,$status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_tarefas->setId_tipo_veiculo($id_tipo);
                    $relatorios_tarefas->setStatus_tarefa($status);
                    $relatorios_tarefas->setData_inicial($data_inicio);
                    $relatorios_tarefas->setData_final($data_final);
                    $sql = $relatorios_tarefas->tipoVeiculoDatastodos($relatorios_tarefas);
                    $relatorios_tarefas->montaTabelaTarefa($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (!empty($id_tarefa) and empty($id_veiculo) and empty($id_tipo) and ! empty($id_funcionario)) {
               if (empty($data_inicio) and empty($data_final)) {
                  $relatorios_tarefas->setId_funcionario($id_funcionario);
                  $relatorios_tarefas->setId_tarefa($id_tarefa);
                  $relatorios_tarefas->setStatus_tarefa($status);
                  $sql_tarefa = $relatorios_tarefas->tarefasfuncionariotodos($relatorios_tarefas);
                  $relatorios_tarefas->montaTabelaTarefa($sql_tarefa,$status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_tarefas->setId_funcionario($id_funcionario);
                    $relatorios_tarefas->setId_tarefa($id_tarefa);
                    $relatorios_tarefas->setStatus_tarefa($status);
                    $relatorios_tarefas->setData_inicial($data_inicio);
                    $relatorios_tarefas->setData_final($data_final);
                    $sql = $relatorios_tarefas->tarefasfuncionarioDatastodos($relatorios_tarefas);
                    $relatorios_tarefas->montaTabelaTarefa($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (!empty($id_tarefa) and empty(!$id_veiculo) and empty($id_tipo) and ! empty($id_funcionario)) {
                if (empty($data_inicio) and empty($data_final)) {
                  $relatorios_tarefas->setId_funcionario($id_funcionario);
                  $relatorios_tarefas->setId_tarefa($id_tarefa);
                  $relatorios_tarefas->setId_veiculo($id_veiculo);
                  $relatorios_tarefas->setStatus_tarefa($status);
                  $sql_tarefa = $relatorios_tarefas->tarefasveiculofuncionariotodos($relatorios_tarefas);
                  $relatorios_tarefas->montaTabelaTarefa($sql_tarefa,$status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_tarefas->setId_funcionario($id_funcionario);
                    $relatorios_tarefas->setId_tarefa($id_tarefa);
                    $relatorios_tarefas->setId_veiculo($id_veiculo);
                    $relatorios_tarefas->setStatus_tarefa($status);
                    $relatorios_tarefas->setData_inicial($data_inicio);
                    $relatorios_tarefas->setData_final($data_final);
                    $sql = $relatorios_tarefas->tarefasveiculofuncionarioDatastodos($relatorios_tarefas);
                    $relatorios_tarefas->montaTabelaTarefa($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else if (!empty($id_tarefa) and empty($id_veiculo) and !empty($id_tipo) and ! empty($id_funcionario)) {
                 if (empty($data_inicio) and empty($data_final)) {
                  $relatorios_tarefas->setId_funcionario($id_funcionario);
                  $relatorios_tarefas->setId_tarefa($id_tarefa);
                  $relatorios_tarefas->setId_tipo_veiculo($id_tipo);
                  $relatorios_tarefas->setStatus_tarefa($status);
                  $sql_tarefa = $relatorios_tarefas->tarefastipoveiculofuncionariotodos($relatorios_tarefas);
                  $relatorios_tarefas->montaTabelaTarefa($sql_tarefa,$status);
                } else if (!empty($data_inicio)and ! empty($data_final)) {
                    $relatorios_tarefas->setId_funcionario($id_funcionario);
                    $relatorios_tarefas->setId_tarefa($id_tarefa);
                    $relatorios_tarefas->setId_tipo_veiculo($id_tipo);
                    $relatorios_tarefas->setStatus_tarefa($status);
                    $relatorios_tarefas->setData_inicial($data_inicio);
                    $relatorios_tarefas->setData_final($data_final);
                    $sql = $relatorios_tarefas->tarefastipoveiculofuncionarioDatastodos($relatorios_tarefas);
                    $relatorios_tarefas->montaTabelaTarefa($sql, $status);
                } else {
                    echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
                }
            }else{
                  echo "<p style='margin: 100px 0px 0px 500px; font-size:1.2em;'>Consulta Invalida!</p>";
            }
            
            
            
            
        }
    } else {
        echo "<p style='margin: 100px 0px 0px 450px; font-size:1.2em;'>E necessario o preenchimento do Campo STATUS!</p>";
    }
}
?>

