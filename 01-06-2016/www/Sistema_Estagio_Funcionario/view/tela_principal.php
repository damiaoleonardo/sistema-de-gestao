<?php
require('../model/Connection.class.php');
$conexao = Connection::getInstance();

session_start();
if ((!isset($_SESSION['login']) == true) and ( !isset($_SESSION['senha']) == true)) {
    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    header('location:../index.php');
}

$logado = $_SESSION['login'];
$usuario = $_GET['login'];
$sql_disponibilidade = "select funcionarios.disponibilidade,funcionarios.id_funcionario from funcionarios where login = '$usuario'";
$recebe = mysql_query($sql_disponibilidade);
while ($aux_disponibilidade = mysql_fetch_array($recebe)) {
    $id_funcionario = $aux_disponibilidade['id_funcionario'];
    $status_disponibilidade = $aux_disponibilidade['disponibilidade'];
}

$sql_status_funcionario = "select funcionarios.disponibilidade from funcionarios where funcionarios.id_funcionario = $id_funcionario";
$aux_status_funcionario = mysql_query($sql_status_funcionario);
$status_funcionario = mysql_fetch_row($aux_status_funcionario);
$status_do_funcionario = $status_funcionario[0];

function somarhoras_funcionario($times) {
    $seconds = 0;
    foreach ($times as $time) {
        list( $g, $i, $s ) = explode(':', $time);
        $seconds += $g * 3600;
        $seconds += $i * 60;
        $seconds += $s;
    }
    $hours = floor($seconds / 3600);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    if ($hours == 0 || $hours < 10) {
        $hours = "0" . $hours;
    }
    if ($minutes == 0 || $minutes < 10) {
        $minutes = "0" . $minutes;
    }
    if ($seconds == 0 || $seconds < 10) {
        $seconds = "0" . $seconds;
    }
    return "{$hours}:{$minutes}:{$seconds}";
}

$data_hj = date('Y-m-d');
$horas_concluidas_funcionario_por_dia = array();
$sql_horas_trabalhadas_funcionarios = "select funcionario_executa.horas_concluidas from funcionario_executa where funcionario_executa.id_funcionario = $id_funcionario and funcionario_executa.data_tarefa = '$data_hj'";
$horas_trabalhadas_funcionario = mysql_query($sql_horas_trabalhadas_funcionarios);
while ($aux_horas_trabalhadas_funcionarios = mysql_fetch_array($horas_trabalhadas_funcionario)) {
    $horas_trabalhada = $aux_horas_trabalhadas_funcionarios['horas_concluidas'];
    $horas_concluidas_funcionario_por_dia[] = $horas_trabalhada;
}
$horas_trabalhadas_pelo_funcionario = somarhoras_funcionario($horas_concluidas_funcionario_por_dia);

$pagina_atual = $_GET['t'];
if($pagina_atual == "visualiza_tarefas" || $pagina_atual == "visualiza_projeto"){
 ?>
 <meta http-equiv="refresh" content="20">
 <?php
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Funcionario</title>
        
        <link rel="stylesheet" href="../style/Funcionario.css" type="text/css"/>
        <link rel="stylesheet" href="../style/class_table.css" type="text/css"/>
        <script src="../js/play_tarefa.js"></script>
        <script src="../js/play_notopen.js"></script>
        <script src="../js/stop_notopen.js"></script>
        <script src="../js/stop_tarefa.js"></script>
        <script src="../js/pause_notopen.js"></script>
        <script src="../js/pause_tarefa.js"></script>
        <script src="../js/pausa_tarefa_pausada.js"></script>       
        <script src="../js/compatibilidade_html5.js"></script>
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery.waiting.js"></script>
        <script>
            $(document).ready(function () {
                //Esconde preloader
                $(window).load(function () {
                    $('.div_waiting').fadeOut(2000);//1500 é a duração do efeito (1.5 seg)
                });
            });
        </script>

        <script>
        </script>
        <script type="text/javascript">
            $(function () {
                $('.finaliza_tarefa').submit(function () {
                    $.ajax({
                        type: 'POST',
                        url: '../control/finaliza_tarefa.php',
                        data: $('.finaliza_tarefa').serialize(),
                        success: function (data) {
                            if (data) {
                                $('#recebe_resposta').html(data);
                            }
                        }
                    });
                    return false;
                });
            });

        </script> 
        <script type="text/javascript">
            $(function () {
                $('.add_tarefa').submit(function () {
                    $.ajax({
                        type: 'POST',
                        url: '../control/adiciona_projeto_execucao.php',
                        data: $('.add_tarefa').serialize(),
                        success: function (data) {
                            if (data) {
                                $('#recebe_resposta').html(data);
                            }
                        }
                    });
                    return false;
                });
            });

        </script> 
        <script>
            function abre_janela(quantidade_executores, login, id_tarefa, id_projeto, id_veiculo, id_funcionario, id_projeto_funcionario_ativo, id_veiculo_funcionario_ativo, id_tarefa_funcionario_ativo) {
                if (id_projeto_funcionario_ativo == id_projeto && id_veiculo_funcionario_ativo == id_veiculo && id_tarefa_funcionario_ativo == id_tarefa) {
                    window.open('tela_principal.php?t=finaliza_tarefa&executores=' + quantidade_executores + '&login=' + login + '&id_projeto=' + id_projeto + '&id_tarefa=' + id_tarefa + '&id_funcionario=' + id_funcionario + '&id_veiculo=' + id_veiculo, '_blank');
                } else {
                    alert("Voce não se encontra executando esta atividade");
                }
            }
        </script>
        <script type="text/javascript">
            function voltar(login) {
                window.location.href = 'tela_principal.php?t=visualiza_projeto&login=' + login;
            }
        </script>
        <script>
            function flag_tarefa_aberta(flag_tarefa, usuario) {
                if (flag_tarefa == 1) {
                    alert("Existe tarefas em aberto!");
                } else {
                    window.location.href = 'tela_principal.php?t=visualiza_projeto&login=' + usuario;
                }
            }
        </script>

    </head>
    <body>
     
        <div class="div_waiting">Aguarde enquanto esta carregando...</div>  
        <div id="recebe_resposta"></div>
        <div class="geral_funcionario">
            <div id="header_tela_funcionario">  
                <div id="logo"><p>Sitio Barreiras</p></div> 
                <div id="sair_do_sistema"><a href="../index.php" >Sair do Sistema</a></div>
                <div id="quadro_informacoes">
                    <div id="login_funcio"><p id="titulo">LOGIN DO USUARIO -></p><p id="valor"><?php echo $usuario ?></p></div>
                    <div id="status_funcionario"><p id="titulo">STATUS -></p><p id="valor"><?php echo $status_do_funcionario ?></p></div>
                    <div id="horas_trabalhadas"><p id="titulo">HORAS  -></p><p id="valor"><?php echo $horas_trabalhadas_pelo_funcionario ?></p></div>
                </div>
                <?php
                $pagina = $_GET['t'];
                if ($pagina == "visualiza_tarefas") {
                    ?>
                    <div id="add_tarefa"></div>
                    <?php
                } else {
                    ?>
                    <div id="add_tarefa"><a href="tela_principal.php?t=add_tarefa&login=<?php echo $usuario ?>"><img src="../img/new.jpg" height="90" width="95"></a></div>  
                    <?php
                }
                ?>
            </div>
            <?php
            $tabela = $_REQUEST["t"];
            if ($tabela == 'add_tarefa') {
                $login_usuario = $_GET['login'];
                session_start("usuario_funcionario");
                $_SESSION['usuario'] = $login_usuario;
                ?>

                <div id="tela_add_tarefa">
                    <form action="" method="post"  class="add_tarefa">
                        <div id="tarefas">
                            <label id="nome_input_tarefa">Projeto</label>
                            <select id="tarefas_select" name="projeto">
                                <option value="0" selected="selected" >selecione o Projeto</option>
                                <?php
                                $q_op = "SELECT * FROM projeto order by nome ASC";
                                $op = mysql_query($q_op);
                                while ($opiniao_projeto = mysql_fetch_array($op)) {
                                    $nome_projeto = $opiniao_projeto['nome'];
                                    $id_projeto = $opiniao_projeto['id_projeto'];
                                    ?>
                                    <option value="<?php echo $id_projeto; ?>"> <?php echo $nome_projeto; ?></option><br/>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div id="veiculo">
                            <label id="nome_input_veiculo">Veiculo</label>
                     
                                <select id="veiculos" name="veiculo">
                                <option value="0" selected="selected" >selecione o veiculo</option>
                                <?php
                                $q_op_veiculo = "SELECT * FROM veiculos order by nome_veiculo ASC";
                                $op_veiculo = mysql_query($q_op_veiculo);
                                while ($opiniao_veiculo = mysql_fetch_array($op_veiculo)) {
                                    $nome_veiculo = $opiniao_veiculo['nome_veiculo'];
                                    $id_veiculo = $opiniao_veiculo['id_veiculo'];
                                    ?>
                                    <option value="<?php echo $id_veiculo; ?>"> <?php echo $nome_veiculo; ?></option><br/>
                                    <?php
                                }
                                ?>
                                  </select>
                        </div>

                        <div id="botao_add_tarefa" >     
                            <input type="button" onclick="voltar('<?php echo $login_usuario ?>')" id="button_volta_tarefas" value="Voltar"/>
                            <input type="submit"  id="button_add_tarefas"  value="Adicionar"/>
                        </div>
                    </form> 
                </div>

                <?php
            } else if ($tabela == 'finaliza_tarefa') {
                
                $sql_hora_atual = "SELECT DATE_FORMAT(now(),'%H:%i:%s')";
                $result_hora_atual = mysql_query($sql_hora_atual);
                $hora_inicio = mysql_fetch_row($result_hora_atual);
                $horainicio_tarefa = $hora_inicio[0];

                $quantidade_de_executores = $_GET['executores'];
                $login_usuario = $_GET['login'];
                $id_projetos = $_GET['id_projeto'];
                $id_tarefas = $_GET['id_tarefa'];
                $id_funcionarios = $_GET['id_funcionario'];
                $id_veiculos = $_GET['id_veiculo'];
                session_start("dados_tarefas_finaliza");
                $_SESSION['projeto'] = $id_projetos;
                $_SESSION['tarefa'] = $id_tarefas;
                $_SESSION['funcionario'] = $id_funcionarios;
                $_SESSION['veiculo'] = $id_veiculos;
                $_SESSION['login'] = $login_usuario;

                if ($quantidade_de_executores > 1) {
                    $quantidade_de_executores --;

                    mysql_query("UPDATE tarefas_executa SET quantidade_executores = '$quantidade_de_executores' where tarefas_executa.id_projeto = $id_projetos and tarefas_executa.id_veiculo= $id_veiculos and tarefas_executa.id_tarefa = $id_tarefas and tarefas_executa.conclusao_projeto = 'nao concluido'");
                    mysql_query("UPDATE funcionario_executa SET hora_final= '$horainicio_tarefa',status_funcionario_tarefa = 'nao ativo',status_tarefa = 'concluida',flag_tarefa_aberta = 0 where funcionario_executa.id_projeto = $id_projetos and funcionario_executa.id_veiculo = $id_veiculos and funcionario_executa.id_tarefa = $id_tarefas and funcionario_executa.id_funcionario= $id_funcionarios and funcionario_executa.status_tarefa != 'concluida'");
                    mysql_query("UPDATE funcionarios SET disponibilidade = 'inativo' where funcionarios.id_funcionario = $id_funcionarios");

                    echo "<script>alert('tarefa finalizada com sucesso!'); </script>";
                    echo "<script>location.href='../view/tela_principal.php?t=visualiza_tarefas&login=$login_usuario&id=$id_projetos&veiculo=$id_veiculos'</script>";
                } else {
                    ?>
                    <div id="finaliza_tarefa">
                        <form action="" method="post" class="finaliza_tarefa">
                            <div class="container">   
                                <section class="main-content">                               
                                    <div id="imagem_tirada"><img name="imagem" src="about:blank" alt="" id="show-picture" ></div>
                                    <div id="titulo_da_imagem"><input type="file"  id="take-picture"   accept="image/*"></div>
                                    <p id="error"></p>
                                </section>
                                <script src="../js/imagem.js"></script>
                            </div>
                            <div id="descricao">   
                                <div id="text_area">
                                    <textarea name="texto" ></textarea>
                                </div>
                            </div>

                            <div id="botao_salvar_foto_audio" >     
                                <input type="button" onclick="voltar('<?php echo $login_usuario ?>')" id="button_volta_finaliza_tarefa" value="Cancelar"/>
                                <input type="submit"  id="button_add_finaliza_tarefa"  value="Finaliza Tarefa"/>
                            </div>

                        </form> 
                    </div>

                    <?php
                }
            } else if ($tabela == 'visualiza_projeto') {
                ?>
                <div id="tela_funcionario"> 
                    <table class="table table-hover">
                        <tr>
                            <td style="background: #cfcfcf; color: #01669F;">Projeto</td>
                            <td style="background: #cfcfcf; color: #01669F;">Veiculo</td>
                        </tr>
                        <?php
                        $login_tela_projeto = $_GET['login'];
                        $sql = "select projeto_executa.nome_projeto,projeto_executa.id_projeto_executa,projeto_executa.id_projeto,veiculos.nome_veiculo,veiculos.id_veiculo from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) where projeto_executa.status = 'open'";
                        $result = mysql_query($sql);
                        while ($aux_projetos = mysql_fetch_array($result)) {
                            $id_projetos_executas = $aux_projetos['id_projeto_executa'];
                            $id = $aux_projetos['id_projeto'];
                            $nome = $aux_projetos['nome_projeto'];
                            $nome_veiculo = $aux_projetos['nome_veiculo'];
                            $id_veiculo = $aux_projetos['id_veiculo'];
                            ?>
                            <tr>
                                <td onclick="location.href = 'tela_principal.php?t=visualiza_tarefas&id=<?php echo $id ?>&id_projeto=<?php echo $id_projetos_executas ?>&veiculo=<?php echo $id_veiculo ?>&login=<?php echo $login_tela_projeto ?>';" style="cursor: hand;"><center><span><?php echo $nome; ?></span></center></td>
                            <td><center><?php echo $nome_veiculo ?> </center></td>
                            </tr>
                            <?php
                        }
                        if ($id == null && $nome == null) {
                            ?>
                            <div id="projetosinexistentes"> 
                                <p id="titulo_tela_funcionario">Ainda nao tem Projetos Iniciados</p>
                            </div><?php
                        }
                        ?>
                    </table>
                </div>
                <?php
            } else if ($tabela == 'visualiza_tarefas') {
                ?>
                <div id="visualiza_tarefas"><?php

                    function pegaquantidadeexecutores($id_do_projeto, $id_do_veiculo) {
                        $query_quantidade_executores = "select projeto_executa.quantidades_executores from projeto_executa where projeto_executa.id_projeto = $id_do_projeto and projeto_executa.id_veiculo = $id_do_veiculo and projeto_executa.status != 'concluido'";
                        $aux_consulta_executores = mysql_query($query_quantidade_executores);
                        $quantidades_exe = mysql_fetch_row($aux_consulta_executores);
                        return $executores = $quantidades_exe[0];
                      }

                    function pegaquantidadeexecutorestarefa($id_do_projeto, $id_do_veiculo, $id_da_tarefa) {
                        $query_quantidade_executores_tarefa = "select tarefas_executa.quantidade_executores from tarefas_executa where tarefas_executa.id_projeto = $id_do_projeto and tarefas_executa.id_veiculo = $id_do_veiculo and tarefas_executa.id_tarefa = $id_da_tarefa and tarefas_executa.conclusao_projeto = 'nao concluido'";
                        $aux_consulta_executores_tarefa = mysql_query($query_quantidade_executores_tarefa);
                        $quantidades_exe_tarefa = mysql_fetch_row($aux_consulta_executores_tarefa);
                        return $executores_tarefa = $quantidades_exe_tarefa[0];
                    }

                    function transformahoraemminuto($hora) {
                        $quebraHora = explode(":", $hora); //retorna um array onde cada elemento é separado por ":"
                        $minutos = $quebraHora[0];
                        $minutos = $minutos * 60;
                        $minutos = $minutos + $quebraHora[1];
                        return $minutos;
                    }

                    function horadobanco() {
                        $sql_hora = "SELECT DATE_FORMAT(now(),'%H:%i:%s')";
                        $result_hora = mysql_query($sql_hora);
                        $hora_inicio = mysql_fetch_row($result_hora);
                        $horainicio_tarefa = $hora_inicio[0];
                        return $horainicio_tarefa;
                    }

                    function pegahorasconcluidasprojeto($id_do_projeto, $id_do_veiculo) {
                        $sql_horas_projeto = "select projeto_executa.horas_concluidas from projeto_executa where projeto_executa.id_projeto = $id_do_projeto and projeto_executa.id_veiculo = $id_do_veiculo and projeto_executa.status !='concluido'";
                        $result_horas_concluida = mysql_query($sql_horas_projeto);
                        $result_horas_concluidas = mysql_fetch_row($result_horas_concluida);
                        return $horas_do_projeto = $result_horas_concluidas[0];
                    }

                    function pegaultimaatualizacao($id_do_projeto, $id_do_veiculo) {
                        $sql_atualiza_projeto = "select projeto_executa.ultima_atualizacao from projeto_executa where projeto_executa.id_projeto = $id_do_projeto and projeto_executa.id_veiculo = $id_do_veiculo and projeto_executa.status !='concluido'";
                        $result_atualiza_projeto = mysql_query($sql_atualiza_projeto);
                        $result_atualiza = mysql_fetch_row($result_atualiza_projeto);
                        return $atualiza_projeto = $result_atualiza[0];
                    }

                    function pegaduracaoprojeto($id_do_projeto, $id_do_veiculo) {
                        $sql_projeto = "select projeto_executa.duracao from projeto_executa where projeto_executa.id_projeto = $id_do_projeto and projeto_executa.id_veiculo = $id_do_veiculo and projeto_executa.status !='concluido'";
                        $result_duracao = mysql_query($sql_projeto);
                        $duracao_projeto = mysql_fetch_row($result_duracao);
                        return $duracao_do_projetos = $duracao_projeto[0];
                    }

                    function pegaporcentagemprojeto($id_do_projeto, $id_do_veiculo) {
                        $sql_projeto_porcentagem = "select projeto_executa.porcentagem_concluida from projeto_executa where projeto_executa.id_projeto = $id_do_projeto and projeto_executa.id_veiculo = $id_do_veiculo and projeto_executa.status !='concluido'";
                        $result_porcentagem = mysql_query($sql_projeto_porcentagem);
                        $porcentagem_projeto = mysql_fetch_row($result_porcentagem);
                        return $porcentagem_do_projetos = $porcentagem_projeto[0];
                    }

                    function pegahorainicialtarefa($id_do_projeto, $id_do_veiculo, $id_da_tarefa) {
                        $query = "select tarefas_executa.horas_inicio from tarefas_executa where tarefas_executa.id_projeto = $id_do_projeto and tarefas_executa.id_veiculo= $id_do_veiculo and tarefas_executa.id_tarefa = $id_da_tarefa and tarefas_executa.conclusao_projeto = 'nao concluido'";
                        $aux_consulta = mysql_query($query);
                        $hora_inicial_tarefa = mysql_fetch_row($aux_consulta);
                        return $hora_inicial_da_tarefa = $hora_inicial_tarefa[0];
                    }

                    function calculadiferencaentrehoras($inicio, $fim) {
                        $hora_inicio = DateTime::createFromFormat('H:i:s', $inicio);
                        $horai_fim = DateTime::createFromFormat('H:i:s', $fim);
                        $intervalo_entre_horas = $hora_inicio->diff($horai_fim);
                        return $intervalo_horas = $intervalo_entre_horas->format('%H:%I:%S');
                    }

                    function pegaporcentagemconcluidatarefa($id_do_projeto, $id_do_veiculo, $id_da_tarefa) {
                        $query_porcentagem_tarefa = "select tarefas_executa.porcentagem_concluida from tarefas_executa where tarefas_executa.id_projeto = $id_do_projeto and tarefas_executa.id_veiculo=$id_do_veiculo and tarefas_executa.id_tarefa = $id_da_tarefa and tarefas_executa.conclusao_projeto = 'nao concluido'";
                        $aux_porcentagem_tarefa = mysql_query($query_porcentagem_tarefa);
                        $porcentagem_conluida_tarefa = mysql_fetch_row($aux_porcentagem_tarefa);
                        return $porcentagem_da_tarefa = $porcentagem_conluida_tarefa[0];
                    }

                    function pegastatustarefa($id_do_projeto, $id_do_veiculo, $id_da_tarefa) {
                        $query_status_tarefa = "select tarefas_executa.status from tarefas_executa where tarefas_executa.id_projeto = $id_do_projeto and tarefas_executa.id_veiculo=$id_do_veiculo and tarefas_executa.id_tarefa = $id_da_tarefa and tarefas_executa.conclusao_projeto = 'nao concluido'";
                        $aux_status_tarefa = mysql_query($query_status_tarefa);
                        $status_tarefa = mysql_fetch_row($aux_status_tarefa);
                        return $status_da_tarefa = $status_tarefa[0];
                    }

                    function pegahorasconluidatarefa($id_do_projeto, $id_do_veiculo, $id_da_tarefa) {
                        $query_horas_concluida_tarefa = "select tarefas_executa.horas_concluidas from tarefas_executa where tarefas_executa.id_projeto = $id_do_projeto and tarefas_executa.id_veiculo= $id_do_veiculo and tarefas_executa.id_tarefa = $id_da_tarefa and tarefas_executa.conclusao_projeto = 'nao concluido'";
                        $aux_concluidas_horas_tarefa = mysql_query($query_horas_concluida_tarefa);
                        $horass_conluida_tarefas = mysql_fetch_row($aux_concluidas_horas_tarefa);
                        return $tempo_concluido_da_tarefa = $horass_conluida_tarefas[0];
                    }

                    function pegahorasconluidofuncionario($id_do_projeto, $id_do_veiculo, $id_da_tarefa, $id_do_funcionario) {
                        $query_horas_concluida_funcionario = "select funcionario_executa.horas_concluidas from funcionario_executa where funcionario_executa.id_projeto = $id_do_projeto and funcionario_executa.id_veiculo = $id_do_veiculo and funcionario_executa.id_tarefa = $id_da_tarefa and funcionario_executa.id_funcionario=$id_do_funcionario and funcionario_executa.status_funcionario_tarefa = 'ativo'";
                        $aux_concluidas_horas_tarefa = mysql_query($query_horas_concluida_funcionario);
                        $horass_conluida_funcionario = mysql_fetch_row($aux_concluidas_horas_tarefa);
                        return $tempo_concluido_do_funcionario = $horass_conluida_funcionario[0];
                    }

                    function pegaidprojetofuncionario($id_do_funcionario) {
                        $query_id_projeto = "select funcionario_executa.id_projeto from funcionario_executa where funcionario_executa.id_funcionario = $id_do_funcionario and funcionario_executa.status_funcionario_tarefa = 'ativo'";
                        $aux_id_projeto_funcionario_tarefa = mysql_query($query_id_projeto);
                        $funcionario_id_projeto = mysql_fetch_row($aux_id_projeto_funcionario_tarefa);
                        return $id_projeto_funcionario_tarefa = $funcionario_id_projeto[0];
                    }

                    function pegaidveiculofuncionario($id_do_funcionario) {
                        $query_id_veiculo = "select funcionario_executa.id_veiculo from funcionario_executa where funcionario_executa.id_funcionario = $id_do_funcionario and funcionario_executa.status_funcionario_tarefa = 'ativo'";
                        $aux_id_veiculo_funcionario_tarefa = mysql_query($query_id_veiculo);
                        $funcionario_id_veiculo = mysql_fetch_row($aux_id_veiculo_funcionario_tarefa);
                        return $id_veiculo_funcionario_tarefa = $funcionario_id_veiculo[0];
                    }

                    function pegaidtarefafuncionario($id_do_funcionario) {
                        $query_id_tarefa = "select funcionario_executa.id_tarefa from funcionario_executa where funcionario_executa.id_funcionario = $id_do_funcionario and funcionario_executa.status_funcionario_tarefa = 'ativo'";
                        $aux_id_tarefa_funcionario_tarefa = mysql_query($query_id_tarefa);
                        $funcionario_id_tarefa = mysql_fetch_row($aux_id_tarefa_funcionario_tarefa);
                        return $id_tarefa_funcionario_tarefa = $funcionario_id_tarefa[0];
                    }

                    function pegaflagtarefasabertas($id_do_projeto, $id_do_veiculo, $id_do_funcionario) {
                        $flag_tarefa_aberta = "select funcionario_executa.flag_tarefa_aberta from funcionario_executa where funcionario_executa.id_projeto = $id_do_projeto and funcionario_executa.id_veiculo = $id_do_veiculo  and funcionario_executa.id_funcionario=$id_do_funcionario and funcionario_executa.status_funcionario_tarefa = 'ativo'";
                        $aux_flag_tarefa_aberta = mysql_query($flag_tarefa_aberta);
                        $flag_tarefa = mysql_fetch_row($aux_flag_tarefa_aberta);
                        return $flga_da_tarefa = $flag_tarefa[0];
                    }

                    function pegaflagtipotarefa($id_do_projeto, $id_do_veiculo, $id_da_tarefa) {
                        $flag_tipo_tarefa = "select tarefas_executa.tipo_tarefa from tarefas_executa where tarefas_executa.id_projeto = $id_do_projeto and tarefas_executa.id_veiculo = $id_do_veiculo  and tarefas_executa.id_tarefa= $id_da_tarefa and tarefas_executa.status != 'concluida'";
                        $aux_flag_tipo_tarefa = mysql_query($flag_tipo_tarefa);
                        $flag_tarefa_tipo = mysql_fetch_row($aux_flag_tipo_tarefa);
                        return $flga_do_tipo_tarefa = $flag_tarefa_tipo[0];
                    }

                    function pegahorasconluidastarefas($id_do_projeto, $id_do_veiculo) {
                        $array = array();
                        $query_tarefas = "select tarefas_executa.horas_concluidas from tarefas_executa where tarefas_executa.id_projeto=$id_do_projeto and tarefas_executa.id_veiculo = $id_do_veiculo and (tarefas_executa.status ='open' or tarefas_executa.status ='pause' or tarefas_executa.status = 'concluida') and tarefas_executa.conclusao_projeto = 'nao concluido'";
                        $aux_horas_tarefas = mysql_query($query_tarefas);
                        while ($aux_horas = mysql_fetch_array($aux_horas_tarefas)) {
                            $horas_tarefas = $aux_horas['horas_concluidas'];
                            $array[] = $horas_tarefas;
                        }
                        return $array;
                    }

                    function sethorasconcluidasfuncionario($intervalo_concluido, $id_do_projeto, $id_do_veiculo, $id_da_tarefa) {
                        $array_set_horas_funcionario = array();
                        $sql_set_horas = "select funcionario_executa.horas_concluidas,funcionario_executa.id_funcionario from funcionario_executa where funcionario_executa.id_projeto = '$id_do_projeto' and funcionario_executa.id_veiculo = '$id_do_veiculo' and funcionario_executa.id_tarefa = '$id_da_tarefa' and funcionario_executa.status_funcionario_tarefa = 'ativo' and funcionario_executa.status_tarefa = 'open'";
                        $result_set_horas = mysql_query($sql_set_horas);
                        while ($aux_set_horas = mysql_fetch_array($result_set_horas)) {
                            $ids_dos_funcionarios = $aux_set_horas['id_funcionario'] . "<br>";
                            $horas_concluidas_do_funcionario = $aux_set_horas['horas_concluidas'] . "<br>";
                            $array_set_horas_funcionario[] = $intervalo_concluido;
                            $array_set_horas_funcionario[] = $horas_concluidas_do_funcionario;
                            $array_das_horas_do_funcionario = array($intervalo_concluido, $horas_concluidas_do_funcionario);
                            $hora_somada_do_funcionario = somarhoras($array_das_horas_do_funcionario);
                            mysql_query("UPDATE funcionario_executa SET horas_concluidas = '$hora_somada_do_funcionario' where funcionario_executa.id_projeto = '$id_do_projeto' and funcionario_executa.id_veiculo= '$id_do_veiculo' and funcionario_executa.id_tarefa = '$id_da_tarefa' and funcionario_executa.id_funcionario='$ids_dos_funcionarios' and funcionario_executa.status_funcionario_tarefa = 'ativo' and funcionario_executa.status_tarefa != 'concluida' and funcionario_executa.status_tarefa != 'pause'");
                            unset($array_set_horas_funcionario);
                        }
                    }

                    function preenchearrayparavariosexecutores($time_tarefas, $x) {
                        $array_executores = array();
                        for ($i = 0; $i < $x; $i++) {
                            $array_executores[] = $time_tarefas;
                        }
                        return $array_executores;
                    }

                    function somarhoras($times) {
                        $seconds = 0;

                        foreach ($times as $time) {
                            list( $g, $i, $s ) = explode(':', $time);
                            $seconds += $g * 3600;
                            $seconds += $i * 60;
                            $seconds += $s;
                        }

                        $hours = floor($seconds / 3600);
                        $seconds -= $hours * 3600;
                        $minutes = floor($seconds / 60);
                        $seconds -= $minutes * 60;
                        if ($hours == 0 || $hours < 10) {
                            $hours = "0" . $hours;
                        }
                        if ($minutes == 0 || $minutes < 10) {
                            $minutes = "0" . $minutes;
                        }
                        if ($seconds == 0 || $seconds < 10) {
                            $seconds = "0" . $seconds;
                        }

                        return "{$hours}:{$minutes}:{$seconds}";
                    }

                    function transformarminutosemhoras($mins) {
                        // Se os minutos estiverem negativos
                        if ($mins < 0)
                            $min = abs($mins);
                        else
                            $min = $mins;

                        // Arredonda a hora
                        $h = floor($min / 60);
                        $m = ($min - ($h * 60)) / 100;
                        $horas = $h + $m;

                        // Matemática da quinta série
                        // Detalhe: Aqui também pode se usar o abs()
                        if ($mins < 0)
                            $horas *= -1;

                        // Separa a hora dos minutos
                        $sep = explode('.', $horas);
                        $h = $sep[0];
                        if (empty($sep[1]))
                            $sep[1] = 00;

                        $m = $sep[1];

                        // Aqui um pequeno artifício pra colocar um zero no final
                        if (strlen($m) < 2)
                            $m = $m . 0;

                        return sprintf('%02d:%02d:00', $h, $m);
                    }

                    $id_projeto = $_GET['id'];
                    $id_projetos_executas = $_GET['id_projeto'];
                    $id_veiculo = $_GET['veiculo'];
                    $login = $_GET['login'];
                    $id_projeto_funcionario_ativo = pegaidprojetofuncionario($id_funcionario);
                    $id_veiculo_funcionario_ativo = pegaidveiculofuncionario($id_funcionario);
                    $id_tarefa_funcionario_ativo = pegaidtarefafuncionario($id_funcionario);
                    $flag_tarefas_abertas = pegaflagtarefasabertas($id_projeto, $id_veiculo, $id_funcionario);
                    //javascript:doSomething();
                    //tela_principal.php?t=visualiza_projeto&login=<?php echo $usuario 
                    ?> 

                    <a href="#" onclick="flag_tarefa_aberta('<?php echo $flag_tarefas_abertas ?>', '<?php echo $login ?>');"><div id="volta"><center><img src="../img/6148_32x32.png"></center></div></a>
                    <table class="table table-hover">
                        <?php
                        $sql = "select tarefas_projeto.id_tarefa from tarefas_projeto where tarefas_projeto.id_projeto = $id_projeto";
                        $result = mysql_query($sql);
                        while ($aux_tarefas = mysql_fetch_array($result)) {
                            $id_tarefa = $aux_tarefas['id_tarefa'];
                            $sql_juncao = "select tarefas.nome,tarefas.duracao from tarefas where tarefas.id_tarefa = $id_tarefa";
                            $result_juncao = mysql_query($sql_juncao);
                            while ($aux_juncao = mysql_fetch_array($result_juncao)) {
                                $nome_tarefa = $aux_juncao['nome'];
                                $duracao_tarefa = $aux_juncao['duracao'];
                                $aux_duracao_hora = date('h', strtotime($duracao_tarefa));
                                $aux_duracao_minuto = date('i', strtotime($duracao_tarefa));
                                $duracao_geral = $aux_duracao_hora . "." . $aux_duracao_minuto;

                                $status_tarefa = pegastatustarefa($id_projeto, $id_veiculo, $id_tarefa);

                                if ($status_tarefa == "notopen") {
                                    ?> 
                                    <tr>
                                        <td id="primeira_coluna"><?php echo $nome_tarefa ?></td> 
                                        <td id="segunda_coluna">
                                            <div id="tarefa" ><center><span>Nao iniciada</span></center>
                                            </div>
                                        </td>
                                        <td id="terceira_coluna">
                                            <a href="" onclick="play_notopen('<?php echo $status_disponibilidade ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>')"><img src="../img/1430175909_StepForwardHot.png"/></a>
                                            <a href="" onclick="pause_notopen()"><img src="../img/1430175773_PauseHot.png"/></a>
                                            <a href="" onclick="stop_notopen()"><img src="../img/1430175354_Stop1Pressed.png"/></a>
                                        </td>
                                    </tr>
                                    <?php
                                } else if ($status_tarefa == "open") {

                                    $tipo_tarefa = pegaflagtipotarefa($id_projeto, $id_veiculo, $id_tarefa);
                                    if ($tipo_tarefa == "liberada") {

                                        $quantidade_de_executores_da_tarefa = pegaquantidadeexecutorestarefa($id_projeto, $id_veiculo, $id_tarefa);

                                        if ($quantidade_de_executores_da_tarefa == 1) {

                                            if ($id_projeto_funcionario_ativo == $id_projeto && $id_veiculo_funcionario_ativo == $id_veiculo && $id_tarefa_funcionario_ativo == $id_tarefa) {


                                                $horainicio_da_tarefa = horadobanco();
                                                $hora_inicio_da_tarefa = pegahorainicialtarefa($id_projeto, $id_veiculo, $id_tarefa);
                                                $horas_concluidas_do_banco = pegahorasconluidatarefa($id_projeto, $id_veiculo, $id_tarefa);
                                                $hora_inicial = DateTime::createFromFormat('H:i:s', $hora_inicio_da_tarefa);
                                                $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $horainicio_da_tarefa);
                                                $intervalo = $hora_inicial->diff($horainicio_da_tarefas);
                                                $hora_concluidas = $intervalo->format('%H:%I:%S');
                                                $array_tempo = array($hora_concluidas, $horas_concluidas_do_banco);
                                                $tempo_somado = somarhoras($array_tempo);


                                                $hora_inicial_intervalo = DateTime::createFromFormat('H:i:s', $tempo_somado);
                                                $duracao_parcial = date('H:i:s', strtotime('+60 minute', strtotime($tempo_somado)));

                                                $hora_final = DateTime::createFromFormat('H:i:s', $duracao_parcial);
                                                $intervalo_entre_duracao_horasconcluida = $hora_inicial_intervalo->diff($hora_final);
                                                $duracao_restante = $intervalo_entre_duracao_horasconcluida->format('%H:%I:%S');
                                                //echo "horas concluida tarefa : " . $hora_concluidas . "<br>";
                                                //echo "duracao restante tarefa: " . $duracao_restante . "<br>";
                                                $hora_ja_concluida = transformahoraemminuto($tempo_somado);
                                                $duracao_geral_tarefa = transformahoraemminuto($duracao_parcial);
                                                $pintadiv = $hora_ja_concluida / $duracao_geral_tarefa;
                                                $porcentagem_concluida = $pintadiv * 100;
                                                $tamanho = $pintadiv * 100 . "%";
                                                // echo "porcentagem tarefa" . $tamanho . "<br>";
                                                mysql_query("UPDATE tarefas_executa SET horas_concluidas = '$tempo_somado',horas_inicio='$horainicio_da_tarefa',horas_restante = '$duracao_restante', porcentagem_concluida = '$porcentagem_concluida' where tarefas_executa.id_projeto = $id_projeto and tarefas_executa.id_veiculo= $id_veiculo and tarefas_executa.id_tarefa = $id_tarefa and tarefas_executa.conclusao_projeto = 'nao concluido'");

                                                $horas_concluidas_funcionario = pegahorasconluidofuncionario($id_projeto, $id_veiculo, $id_tarefa, $id_funcionario);
                                                $array_tempo_funcionario = array($hora_concluidas, $horas_concluidas_funcionario);
                                                $tempo_somado_funcionario = somarhoras($array_tempo_funcionario);


                                                mysql_query("UPDATE funcionario_executa SET horas_concluidas = '$tempo_somado_funcionario' where funcionario_executa.id_projeto = $id_projeto and funcionario_executa.id_veiculo= $id_veiculo and funcionario_executa.id_tarefa = $id_tarefa and funcionario_executa.id_funcionario=$id_funcionario and funcionario_executa.status_funcionario_tarefa = 'ativo' and funcionario_executa.status_tarefa != 'concluida' and funcionario_executa.status_tarefa != 'pause'");

                                                $horas_das_tarefas = pegahorasconluidastarefas($id_projeto, $id_veiculo);
                                                $horas_conluidas_das_tarefas = somarhoras($horas_das_tarefas);
                                                $aux_da_porcentagem_projeto = transformahoraemminuto($horas_conluidas_das_tarefas);

                                                $horas_concluidas_projeto = pegahorasconcluidasprojeto($id_projeto, $id_veiculo);
                                                $horas_concluidas_projeto_minutos = transformahoraemminuto($horas_concluidas_projeto);

                                                mysql_query("UPDATE projeto_executa SET horas_concluidas = '$horas_conluidas_das_tarefas',ultima_atualizacao = '$horainicio_da_tarefa' where projeto_executa.id_projeto=$id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.status != 'concluido'");
                                                $duracao_do_projeto = pegaduracaoprojeto($id_projeto, $id_veiculo);
                                                $duracao_do_projeto_minutos = transformahoraemminuto($duracao_do_projeto);

                                                $porcentagem_do_projeto_concluida = $aux_da_porcentagem_projeto / $duracao_do_projeto_minutos * 100 . "%";

                                                //echo  "porcentagem a ser inserida". $porcentagem_do_projeto_concluida."<br>";
                                                mysql_query("UPDATE projeto_executa SET porcentagem_concluida = '$porcentagem_do_projeto_concluida' where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.status != 'concluido' ");
                                                $hora_concluidas = "";
                                                $duracao_restante = "";
                                                $porcentagem_concluida = "";
                                                $porcentagem_do_projeto_concluida = "";
                                                $horas_concluidas_projeto = "";
                                                $horas_concluidas_projeto_minutos = "";
                                                $aux_horas_conluidas_projeto = "";
                                                $duracao_do_projeto_minutos = "";
                                                //$horas_concluidas_funcionario = "";
                                                // $tempo_somado_funcionario = "";
                                                $array_tempo_funcionario = "";
                                                $hora_inicio_da_tarefa = "";
                                                // $id_projeto = "";
                                                // $id_veiculo = "";
                                            } else {
                                                $tamanho = pegaporcentagemconcluidatarefa($id_projeto, $id_veiculo, $id_tarefa) . "%";
                                            }
                                        } else {

                                            if ($id_projeto_funcionario_ativo == $id_projeto && $id_veiculo_funcionario_ativo == $id_veiculo && $id_tarefa_funcionario_ativo == $id_tarefa) {


                                                $horainicio_da_tarefa_2 = horadobanco();
                                                $hora_inicio_da_tarefa_2 = pegahorainicialtarefa($id_projeto, $id_veiculo, $id_tarefa);
                                                $horas_concluidas_do_banco_2 = pegahorasconluidatarefa($id_projeto, $id_veiculo, $id_tarefa);
                                                $hora_inicial_2 = DateTime::createFromFormat('H:i:s', $hora_inicio_da_tarefa_2);
                                                $horainicio_da_tarefas_2 = DateTime::createFromFormat('H:i:s', $horainicio_da_tarefa_2);
                                                $intervalo_2 = $hora_inicial_2->diff($horainicio_da_tarefas_2);
                                                $hora_concluidas_2 = $intervalo_2->format('%H:%I:%S');
                                                $array_preenchido = preenchearrayparavariosexecutores($hora_concluidas_2, $quantidade_de_executores_da_tarefa);
                                                $horas_feitas_da_tarefa = somarhoras($array_preenchido);


                                                $array_tempo_2 = array($horas_feitas_da_tarefa, $horas_concluidas_do_banco_2);
                                                $tempo_somado_2 = somarhoras($array_tempo_2);


                                                $hora_inicial_intervalo_2 = DateTime::createFromFormat('H:i:s', $tempo_somado_2);
                                                $duracao_parcial_2 = date('H:i:s', strtotime('+60 minute', strtotime($tempo_somado_2)));
                                                $hora_final_2 = DateTime::createFromFormat('H:i:s', $duracao_parcial_2);
                                                $intervalo_entre_duracao_horasconcluida_2 = $hora_inicial_intervalo_2->diff($hora_final_2);
                                                $duracao_restante_2 = $intervalo_entre_duracao_horasconcluida_2->format('%H:%I:%S');
                                                //echo "horas concluida tarefa : " . $hora_concluidas . "<br>";
                                                //echo "duracao restante tarefa: " . $duracao_restante . "<br>";
                                                $hora_ja_concluida_2 = transformahoraemminuto($tempo_somado_2);
                                                $duracao_geral_tarefa_2 = transformahoraemminuto($duracao_parcial_2);
                                                $pintadiv_2 = $hora_ja_concluida_2 / $duracao_geral_tarefa_2;
                                                $porcentagem_concluida_2 = $pintadiv_2 * 100;
                                                $tamanho = $pintadiv_2 * 100 . "%";
                                                // echo "porcentagem tarefa" . $tamanho . "<br>";
                                                mysql_query("UPDATE tarefas_executa SET horas_concluidas = '$tempo_somado_2',horas_inicio='$horainicio_da_tarefa_2',horas_restante = '$duracao_restante_2', porcentagem_concluida = '$porcentagem_concluida_2' where tarefas_executa.id_projeto = $id_projeto and tarefas_executa.id_veiculo= $id_veiculo and tarefas_executa.id_tarefa = $id_tarefa and tarefas_executa.conclusao_projeto = 'nao concluido'");


                                                // echo $horas_concluidas_funcionario_2 = pegahorasconluidofuncionario($id_projeto, $id_veiculo, $id_tarefa, $id_funcionario);
                                                // $array_tempo_funcionario_2 = array($hora_concluidas_2, $horas_concluidas_funcionario_2);
                                                // echo $tempo_somado_funcionario_2 = somarhoras($array_tempo_funcionario_2);
                                                //  mysql_query("UPDATE Funcionario_executa SET horas_concluidas = '$tempo_somado_funcionario_2' where Funcionario_executa.id_projeto = $id_projeto and Funcionario_executa.id_veiculo= $id_veiculo and Funcionario_executa.id_tarefa = $id_tarefa and Funcionario_executa.id_funcionario=$id_funcionario and Funcionario_executa.status_funcionario_tarefa = 'ativo' and Funcionario_executa.status_tarefa != 'concluida' and Funcionario_executa.status_tarefa != 'pause'");
                                                sethorasconcluidasfuncionario($hora_concluidas_2, $id_projeto, $id_veiculo, $id_tarefa);



                                                $horas_das_tarefas_2 = pegahorasconluidastarefas($id_projeto, $id_veiculo);
                                                $horas_conluidas_das_tarefas_2 = somarhoras($horas_das_tarefas_2);
                                                $aux_da_porcentagem_projeto_2 = transformahoraemminuto($horas_conluidas_das_tarefas_2);

                                                $horas_concluidas_projeto_2 = pegahorasconcluidasprojeto($id_projeto, $id_veiculo);
                                                $horas_concluidas_projeto_minutos_2 = transformahoraemminuto($horas_concluidas_projeto_2);

                                                mysql_query("UPDATE projeto_executa SET horas_concluidas = '$horas_conluidas_das_tarefas_2',ultima_atualizacao = '$horainicio_da_tarefa_2' where projeto_executa.id_projeto=$id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.status != 'concluido'");
                                                $duracao_do_projeto_2 = pegaduracaoprojeto($id_projeto, $id_veiculo);
                                                $duracao_do_projeto_minutos_2 = transformahoraemminuto($duracao_do_projeto_2);

                                                $porcentagem_do_projeto_concluida_2 = $aux_da_porcentagem_projeto_2 / $duracao_do_projeto_minutos_2 * 100 . "%";

                                                //echo  "porcentagem a ser inserida". $porcentagem_do_projeto_concluida."<br>";
                                                mysql_query("UPDATE projeto_executa SET porcentagem_concluida = '$porcentagem_do_projeto_concluida_2' where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.status != 'concluido' ");
                                                $hora_concluidas_2 = "";
                                                $duracao_restante_2 = "";
                                                $porcentagem_concluida_2 = "";
                                                $porcentagem_do_projeto_concluida_2 = "";
                                                $horas_concluidas_projeto_2 = "";
                                                $horas_concluidas_projeto_minutos_2 = "";
                                                $aux_horas_conluidas_projeto_2 = "";
                                                $duracao_do_projeto_minutos_2 = "";
                                                //$horas_concluidas_funcionario = "";
                                                // $tempo_somado_funcionario = "";
                                                $array_tempo_funcionario_2 = "";
                                                $hora_inicio_da_tarefa_2 = "";
                                                // $id_projeto = "";
                                                // $id_veiculo = "";
                                            } else {
                                                $tamanho = pegaporcentagemconcluidatarefa($id_projeto, $id_veiculo, $id_tarefa) . "%";
                                            }
                                        }



                                        //aumento de uma hora na duracao da tarefa
                                        // $duracao_parcial = date('H:i:s', strtotime('+60 minute', strtotime($tempo_somado)));
                                        ?>  
                                        <tr>
                                            <td id="primeira_coluna"><?php echo $nome_tarefa ?></td> 
                                            <?php
                                            if ($tamanho > 100) {

                                                $aux_tamanho_limite = $tamanho - 100 . "%";
                                                ?>
                                                <td id="segunda_coluna">
                                                    <div id="tarefa" >
                                                        <div id="execucao" style="width: <?php echo $tamanho ?>; float:left; background:#01669F; ">
                                                            <div style="height: 100%; width: <?php echo $aux_tamanho_limite ?>; background: red; float:right;"></div>
                                                        </div>
                                                    </div>
                                                </td> 
                                                <?php
                                            } else {
                                                ?>
                                                <td id="segunda_coluna">
                                                    <div id="tarefa" >
                                                        <div id="execucao" style="width: <?php echo $tamanho ?>; background:#01669F;; ">
                                                        </div>
                                                    </div>
                                                </td>
                                            <?php }
                                            ?>
                                            <td id="terceira_coluna">
                                                <a href="" onclick="play_tarefa('<?php echo $status_disponibilidade ?>', '<?php echo $id_tarefa ?>', '<?php echo $status_tarefa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>')"><img src="../img/1430175909_StepForwardHot.png"/></a>
                                                <a href="" onclick="pause_tarefa('<?php echo $status_disponibilidade ?>', '<?php echo $id_tarefa ?>', '<?php echo $status_tarefa ?>', '<?php echo $id_projetos_executas ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>')"><img src="../img/1430175773_PauseHot.png"/></a>
                                            <!--<a href="" onclick="stop_tarefa('<?php echo $id_tarefa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>')"><img src="../img/1430175354_Stop1Pressed.png"/></a>-->
                                                <a href="" onclick="abre_janela('<?php echo $quantidade_de_executores_da_tarefa ?>', '<?php echo $login ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>')"><img src="../img/1430175354_Stop1Pressed.png"/></a>
                                            </td>
                                        </tr>
                                        <?php
                                    } else {

                                        // parte das tarefas nao liberdas
                                        
                                        
                                        
                                        
                                        //sdbnWS
                                        
                                        

                                        $quantidade_de_executores_da_tarefa = pegaquantidadeexecutorestarefa($id_projeto, $id_veiculo, $id_tarefa);
                                        if ($quantidade_de_executores_da_tarefa == 1) {
                                           
                                            
                                            if ($id_projeto_funcionario_ativo == $id_projeto && $id_veiculo_funcionario_ativo == $id_veiculo && $id_tarefa_funcionario_ativo == $id_tarefa) {

                                                $horainicio_da_tarefa = horadobanco();
                                                $hora_inicio_da_tarefa = pegahorainicialtarefa($id_projeto, $id_veiculo, $id_tarefa);
                                                $horas_concluidas_do_banco = pegahorasconluidatarefa($id_projeto, $id_veiculo, $id_tarefa);
                                                $hora_inicial = DateTime::createFromFormat('H:i:s', $hora_inicio_da_tarefa);
                                                $horainicio_da_tarefas = DateTime::createFromFormat('H:i:s', $horainicio_da_tarefa);
                                                $intervalo = $hora_inicial->diff($horainicio_da_tarefas);
                                                $hora_concluidas = $intervalo->format('%H:%I:%S');
                                                $array_tempo = array($hora_concluidas, $horas_concluidas_do_banco);
                                                $tempo_somado = somarhoras($array_tempo);


                                                $hora_inicial_intervalo = DateTime::createFromFormat('H:i:s', $tempo_somado);
                                                $hora_final = DateTime::createFromFormat('H:i:s', $duracao_tarefa);
                                                $intervalo_entre_duracao_horasconcluida = $hora_inicial_intervalo->diff($hora_final);
                                                $duracao_restante = $intervalo_entre_duracao_horasconcluida->format('%H:%I:%S');
                                                //echo "horas concluida tarefa : " . $hora_concluidas . "<br>";
                                                //echo "duracao restante tarefa: " . $duracao_restante . "<br>";
                                                $hora_ja_concluida = transformahoraemminuto($tempo_somado);
                                                $duracao_geral_tarefa = transformahoraemminuto($duracao_tarefa);
                                                $pintadiv = $hora_ja_concluida / $duracao_geral_tarefa;
                                                $porcentagem_concluida = $pintadiv * 100;
                                                $tamanho = $pintadiv * 100 . "%";
                                                // echo "porcentagem tarefa" . $tamanho . "<br>";
                                                mysql_query("UPDATE tarefas_executa SET horas_concluidas = '$tempo_somado',horas_inicio='$horainicio_da_tarefa',horas_restante = '$duracao_restante', porcentagem_concluida = '$porcentagem_concluida' where tarefas_executa.id_projeto = $id_projeto and tarefas_executa.id_veiculo= $id_veiculo and tarefas_executa.id_tarefa = $id_tarefa and tarefas_executa.conclusao_projeto = 'nao concluido'");

                                                $horas_concluidas_funcionario = pegahorasconluidofuncionario($id_projeto, $id_veiculo, $id_tarefa, $id_funcionario);
                                                $array_tempo_funcionario = array($hora_concluidas, $horas_concluidas_funcionario);
                                                $tempo_somado_funcionario = somarhoras($array_tempo_funcionario);


                                                mysql_query("UPDATE funcionario_executa SET horas_concluidas = '$tempo_somado_funcionario' where funcionario_executa.id_projeto = $id_projeto and funcionario_executa.id_veiculo= $id_veiculo and funcionario_executa.id_tarefa = $id_tarefa and funcionario_executa.id_funcionario=$id_funcionario and funcionario_executa.status_funcionario_tarefa = 'ativo' and funcionario_executa.status_tarefa != 'concluida' and funcionario_executa.status_tarefa != 'pause'");

                                                $horas_das_tarefas = pegahorasconluidastarefas($id_projeto, $id_veiculo);
                                                $horas_conluidas_das_tarefas = somarhoras($horas_das_tarefas);
                                                $aux_da_porcentagem_projeto = transformahoraemminuto($horas_conluidas_das_tarefas);

                                                $horas_concluidas_projeto = pegahorasconcluidasprojeto($id_projeto, $id_veiculo);
                                                $horas_concluidas_projeto_minutos = transformahoraemminuto($horas_concluidas_projeto);

                                                mysql_query("UPDATE projeto_executa SET horas_concluidas = '$horas_conluidas_das_tarefas',ultima_atualizacao = '$horainicio_da_tarefa' where projeto_executa.id_projeto=$id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.status != 'concluido'");
                                                $duracao_do_projeto = pegaduracaoprojeto($id_projeto, $id_veiculo);
                                                $duracao_do_projeto_minutos = transformahoraemminuto($duracao_do_projeto);

                                              echo  $porcentagem_do_projeto_concluida = $aux_da_porcentagem_projeto / $duracao_do_projeto_minutos * 100 . "%";

                                                //echo  "porcentagem a ser inserida". $porcentagem_do_projeto_concluida."<br>";
                                                mysql_query("UPDATE projeto_executa SET porcentagem_concluida = '$porcentagem_do_projeto_concluida' where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.status != 'concluido' ");
                                                $hora_concluidas = "";
                                                $duracao_restante = "";
                                                $porcentagem_concluida = "";
                                                $porcentagem_do_projeto_concluida = "";
                                                $horas_concluidas_projeto = "";
                                                $horas_concluidas_projeto_minutos = "";
                                                $aux_horas_conluidas_projeto = "";
                                                $duracao_do_projeto_minutos = "";
                                                //$horas_concluidas_funcionario = "";
                                                // $tempo_somado_funcionario = "";
                                                $array_tempo_funcionario = "";
                                                $hora_inicio_da_tarefa = "";
                                                // $id_projeto = "";
                                                // $id_veiculo = "";
                                            } else {
                                                $tamanho = pegaporcentagemconcluidatarefa($id_projeto, $id_veiculo, $id_tarefa) . "%";
                                            }
                                        } else {

                                            if ($id_projeto_funcionario_ativo == $id_projeto && $id_veiculo_funcionario_ativo == $id_veiculo && $id_tarefa_funcionario_ativo == $id_tarefa) {


                                                $horainicio_da_tarefa_2 = horadobanco();
                                                $hora_inicio_da_tarefa_2 = pegahorainicialtarefa($id_projeto, $id_veiculo, $id_tarefa);
                                                $horas_concluidas_do_banco_2 = pegahorasconluidatarefa($id_projeto, $id_veiculo, $id_tarefa);
                                                $hora_inicial_2 = DateTime::createFromFormat('H:i:s', $hora_inicio_da_tarefa_2);
                                                $horainicio_da_tarefas_2 = DateTime::createFromFormat('H:i:s', $horainicio_da_tarefa_2);
                                                $intervalo_2 = $hora_inicial_2->diff($horainicio_da_tarefas_2);
                                                $hora_concluidas_2 = $intervalo_2->format('%H:%I:%S');
                                                $array_preenchido = preenchearrayparavariosexecutores($hora_concluidas_2, $quantidade_de_executores_da_tarefa);
                                                $horas_feitas_da_tarefa = somarhoras($array_preenchido);


                                                $array_tempo_2 = array($horas_feitas_da_tarefa, $horas_concluidas_do_banco_2);
                                                $tempo_somado_2 = somarhoras($array_tempo_2);


                                                $hora_inicial_intervalo_2 = DateTime::createFromFormat('H:i:s', $tempo_somado_2);
                                                $hora_final_2 = DateTime::createFromFormat('H:i:s', $duracao_tarefa);
                                                $intervalo_entre_duracao_horasconcluida_2 = $hora_inicial_intervalo_2->diff($hora_final_2);
                                                $duracao_restante_2 = $intervalo_entre_duracao_horasconcluida_2->format('%H:%I:%S');
                                                //echo "horas concluida tarefa : " . $hora_concluidas . "<br>";
                                                //echo "duracao restante tarefa: " . $duracao_restante . "<br>";
                                                $hora_ja_concluida_2 = transformahoraemminuto($tempo_somado_2);
                                                $duracao_geral_tarefa_2 = transformahoraemminuto($duracao_tarefa);
                                                $pintadiv_2 = $hora_ja_concluida_2 / $duracao_geral_tarefa_2;
                                                $porcentagem_concluida_2 = $pintadiv_2 * 100;
                                                $tamanho = $pintadiv_2 * 100 . "%";
                                                // echo "porcentagem tarefa" . $tamanho . "<br>";
                                                mysql_query("UPDATE tarefas_executa SET horas_concluidas = '$tempo_somado_2',horas_inicio='$horainicio_da_tarefa_2',horas_restante = '$duracao_restante_2', porcentagem_concluida = '$porcentagem_concluida_2' where tarefas_executa.id_projeto = $id_projeto and tarefas_executa.id_veiculo= $id_veiculo and tarefas_executa.id_tarefa = $id_tarefa and tarefas_executa.conclusao_projeto = 'nao concluido'");


                                                // echo $horas_concluidas_funcionario_2 = pegahorasconluidofuncionario($id_projeto, $id_veiculo, $id_tarefa, $id_funcionario);
                                                // $array_tempo_funcionario_2 = array($hora_concluidas_2, $horas_concluidas_funcionario_2);
                                                // echo $tempo_somado_funcionario_2 = somarhoras($array_tempo_funcionario_2);
                                                //  mysql_query("UPDATE Funcionario_executa SET horas_concluidas = '$tempo_somado_funcionario_2' where Funcionario_executa.id_projeto = $id_projeto and Funcionario_executa.id_veiculo= $id_veiculo and Funcionario_executa.id_tarefa = $id_tarefa and Funcionario_executa.id_funcionario=$id_funcionario and Funcionario_executa.status_funcionario_tarefa = 'ativo' and Funcionario_executa.status_tarefa != 'concluida' and Funcionario_executa.status_tarefa != 'pause'");
                                                sethorasconcluidasfuncionario($hora_concluidas_2, $id_projeto, $id_veiculo, $id_tarefa);



                                                $horas_das_tarefas_2 = pegahorasconluidastarefas($id_projeto, $id_veiculo);
                                                $horas_conluidas_das_tarefas_2 = somarhoras($horas_das_tarefas_2);
                                                $aux_da_porcentagem_projeto_2 = transformahoraemminuto($horas_conluidas_das_tarefas_2);

                                                $horas_concluidas_projeto_2 = pegahorasconcluidasprojeto($id_projeto, $id_veiculo);
                                                $horas_concluidas_projeto_minutos_2 = transformahoraemminuto($horas_concluidas_projeto_2);

                                                mysql_query("UPDATE projeto_executa SET horas_concluidas = '$horas_conluidas_das_tarefas_2',ultima_atualizacao = '$horainicio_da_tarefa_2' where projeto_executa.id_projeto=$id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.status != 'concluido'");
                                                $duracao_do_projeto_2 = pegaduracaoprojeto($id_projeto, $id_veiculo);
                                                $duracao_do_projeto_minutos_2 = transformahoraemminuto($duracao_do_projeto_2);

                                                $porcentagem_do_projeto_concluida_2 = $aux_da_porcentagem_projeto_2 / $duracao_do_projeto_minutos_2 * 100 . "%";

                                                //echo  "porcentagem a ser inserida". $porcentagem_do_projeto_concluida."<br>";
                                                mysql_query("UPDATE projeto_executa SET porcentagem_concluida = '$porcentagem_do_projeto_concluida_2' where projeto_executa.id_projeto = $id_projeto and projeto_executa.id_veiculo = $id_veiculo and projeto_executa.status != 'concluido' ");
                                                
                                                $hora_concluidas_2 = "";
                                                $duracao_restante_2 = "";
                                                $porcentagem_concluida_2 = "";
                                                $porcentagem_do_projeto_concluida_2 = "";
                                                $horas_concluidas_projeto_2 = "";
                                                $horas_concluidas_projeto_minutos_2 = "";
                                                $aux_horas_conluidas_projeto_2 = "";
                                                $duracao_do_projeto_minutos_2 = "";
                                                //$horas_concluidas_funcionario = "";
                                                // $tempo_somado_funcionario = "";
                                                $array_tempo_funcionario_2 = "";
                                                $hora_inicio_da_tarefa_2 = "";
                                                // $id_projeto = "";
                                                // $id_veiculo = "";
                                            } else {
                                                $tamanho = pegaporcentagemconcluidatarefa($id_projeto, $id_veiculo, $id_tarefa) . "%";
                                            }
                                        }
                                        ?>  
                                        <tr>
                                            <td id="primeira_coluna"><?php echo $nome_tarefa ?></td> 
                                            <?php
                                            if ($tamanho > 100) {
                                                $aux_tamanho_limite = $tamanho - 100 . "%";
                                                ?>
                                                <td id="segunda_coluna">
                                                    <div id="tarefa" >
                                                        <div id="execucao" style="width: <?php echo $tamanho ?>; float:left; background:#01669F; ">
                                                            <div style="height: 100%; width: <?php echo $aux_tamanho_limite ?>; background: firebrick; float:right;"></div>
                                                        </div>
                                                    </div>
                                                </td> 
                                                <?php
                                            } else {
                                                ?>
                                                <td id="segunda_coluna">
                                                    <div id="tarefa" >
                                                        <div id="execucao" style="width: <?php echo $tamanho ?>; background:#01669F;; ">
                                                        </div>
                                                    </div>
                                                </td>
                                            <?php }
                                            ?>
                                            <td id="terceira_coluna">
                                                <a href="" onclick="play_tarefa('<?php echo $status_disponibilidade ?>', '<?php echo $id_tarefa ?>', '<?php echo $status_tarefa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>')"><img src="../img/1430175909_StepForwardHot.png"/></a>
                                                <a href="" onclick="pause_tarefa('<?php echo $status_disponibilidade ?>', '<?php echo $id_tarefa ?>', '<?php echo $status_tarefa ?>', '<?php echo $id_projetos_executas ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>')"><img src="../img/1430175773_PauseHot.png"/></a>
                                                <a href="" onclick="stop_tarefa('<?php echo $id_tarefa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>')"><img src="../img/1430175354_Stop1Pressed.png"/></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else if ($status_tarefa == "pause") {
                                    $tamanho_tarefa_pausada = pegaporcentagemconcluidatarefa($id_projeto, $id_veiculo, $id_tarefa) . "%";
                                    ?>  
                                    <tr>
                                        <td id="primeira_coluna"><?php echo $nome_tarefa ?></td> 
                                        <td id="segunda_coluna">
                                            <div id="tarefa">
                                                <div id="execucao" style="width:<?php echo $tamanho_tarefa_pausada
                                    ?>; background:#ff7f24; ">
                                                </div>
                                            </div>
                                        </td>
                                        <td id="terceira_coluna">
                                            <a href="" onclick="play_tarefa('<?php echo $status_disponibilidade ?>', '<?php echo $id_tarefa ?>', '<?php echo $status_tarefa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>')"><img src="../img/1430175909_StepForwardHot.png"/></a>
                                            <a href="" onclick="pausa_tarefa_pausada()"><img src="../img/1430175773_PauseHot.png"/></a>
                                            <a href="" onclick="stop_tarefa('<?php echo $id_tarefa ?>', '<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_projeto_funcionario_ativo ?>', '<?php echo $id_veiculo_funcionario_ativo ?>', '<?php echo $id_tarefa_funcionario_ativo ?>')"><img src="../img/1430175354_Stop1Pressed.png"/></a>
                                        </td>
                                    </tr>
                                    <?php
                                } else if ($status_tarefa == "concluida") {
                                    $tamanho_tarefa_pausada = pegaporcentagemconcluidatarefa($id_projeto, $id_veiculo, $id_tarefa) . "%";
                                    ?>  
                                    <tr>
                                        <td id="primeira_coluna"><?php echo $nome_tarefa ?></td> 
                                        <td id="segunda_coluna">
                                            <div id="tarefa">
                                                <div id="execucao" style="width:<?php echo $tamanho_tarefa_pausada
                                    ?>; background: darkgreen;">
                                                </div>
                                            </div>
                                        </td>
                                        <td id="terceira_coluna">
                                            <a href="" ><img src="../img/1430175909_StepForwardHot.png"/></a>
                                            <a href="" ><img src="../img/1430175773_PauseHot.png"/></a>
                                            <a href="" ><img src="../img/1430175354_Stop1Pressed.png"/></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </table> 
                </div>
                <?php
            } else {
                ?>
                <div id="tela_funcionario"> 
                    <table class="table table-hover">
                        <tr>
                            <td style="background: #cfcfcf; color: #01669F;">Projeto</td>
                            <td style="background: #cfcfcf; color: #01669F;">Veiculo</td>
                        </tr>
                        <?php
                        $sql = "select projeto_executa.nome_projeto,projeto_executa.id_projeto_executa,projeto_executa.id_projeto,veiculos.nome_veiculo,veiculos.id_veiculo  from `projeto_executa` join `veiculos` on (projeto_executa.id_veiculo = veiculos.id_veiculo) where projeto_executa.status = 'open'";
                        $result = mysql_query($sql);
                        while ($aux_projetos = mysql_fetch_array($result)) {
                            $id_projetos_executas = $aux_projetos['id_projeto_executa'];
                            $id = $aux_projetos['id_projeto'];
                            $nome = $aux_projetos['nome_projeto'];
                            $nome_veiculo = $aux_projetos['nome_veiculo'];
                            $id_veiculo = $aux_projetos['id_veiculo'];
                            ?>
                            <tr>
                                <td><center><span><a href="tela_principal.php?t=visualiza_tarefas&id=<?php echo $id ?>&id_projeto=<?php echo $id_projetos_executas ?>&veiculo=<?php echo $id_veiculo ?>&login=<?php echo $usuario ?>"><?php echo $nome ?></a></span><center></td>
                                    <td><center><?php echo $nome_veiculo ?></center></td>
                                    </tr>
                                    <?php
                                }
                                if ($id == null && $nome == null) {
                                    ?>
                                    <div id="projetosinexistentes"> 
                                        <p id="titulo_tela_funcionario">Ainda nao tem Projetos Iniciados</p>
                                    </div><?php
                                }
                                ?>
                                </table>
                                </div>
                                <?php
                            }
                            ?>
                            </div>
                            </body>
                            </html>
