<?php
require('../model/Conexao/Connection.class.php');
$conexao = Connection::getInstance();
session_start("login");
if ((!isset($_SESSION['login']) == true) and ( !isset($_SESSION['senha']) == true)) {
    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    header('location:../index.php');
}
$logado = $_SESSION['login'];
$sql_disponibilidade = "select funcionarios.disponibilidade,funcionarios.id_funcionario from funcionarios where login = '$logado'";
$recebe = mysql_query($sql_disponibilidade);
while ($aux_disponibilidade = mysql_fetch_array($recebe)) {
    $id_funcionario = $aux_disponibilidade['id_funcionario'];
    $status_disponibilidade = $aux_disponibilidade['disponibilidade'];
}
session_start("id_funcionario");
$_SESSION['id_do_funcionario'] = $id_funcionario;
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
if ($pagina_atual == "visualiza_tarefas" || $pagina_atual == "visualiza_projeto") {
    ?>
    <meta http-equiv="refresh" content="7">
    <?php
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistema-Funcionario</title>
        <link rel="stylesheet" href="../style/principal/tela_principal.css" type="text/css">
        <link rel="stylesheet" href="../style/bootstrap/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="../style/bootstrap/class_table.css" type="text/css">
        <link rel="stylesheet" href="../style/modal/janela_modal.css" type="text/css">
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery-1.12.0.js"></script>
        <script src="../js/iniciar_tarefa/inicia_tarefa.js"></script>
        <script src="../js/pausa_tarefa/pausa_tarefa.js"></script>
        <script src="../js/iniciar_tarefa/reabre_tarefa.js"></script>
        <script src="../js/finaliza_tarefa/finaliza_tarefa.js"></script>
        <script src="../js/finaliza_tarefa/finaliza_tarefa_liberada.js"></script>
        <script src="../js/modal/janela_modal.js"></script>
        <script src="../js/adiciona_tarefa/adiciona_tarefa.js"></script>
        <script src="../js/adiciona_sugestao/adiciona_sugestao.js"></script>
        <script src="../js/flag_tarefa/flag_tarefa.js"></script>
        <script src="../js/jquery_da_tarefa.js"></script>
        <script src="../js/adiciona_button_form.js"></script>
    </head>
    <body>
        <div class="recebe_resposta"></div>
        <div class="tela_principal">
            <div class="row">
                <div id="header">
                    <div id="logo" class="col-sm-2 col-md-2 col-xs-2">
                        <div class="col-sm-12 col-md-12 col-xs-12">Sitio Barreiras</div>
                    </div>
                    <div id="informacoes" class="col-sm-3 col-md-3 col-xs-3">
                        <div class="col-sm-12 col-md-12 col-xs-12" style=" font-size: 1.2em;">Login:<span style=" margin-left:10px; color: #a94442; font-size: 1em;"><?php echo $logado ?></span></div>
                        <div class="col-sm-12 col-md-12 col-xs-12" style=" font-size: 1.2em;">Status:<span style="  margin-left:10px;  color: #a94442; font-size: 1em;"><?php echo $status_do_funcionario ?></span></div>
                        <div class="col-sm-12 col-md-12 col-xs-12" style=" font-size: 1.2em;">Horas:<span style="  margin-left:10px;  color: #a94442; font-size: 1em;"><?php echo $horas_trabalhadas_pelo_funcionario ?></span></div>
                    </div>
                    <div id="sair_sistema" class="col-sm-3 col-md-3 col-xs-3">
                        <div id="botao_sair"><a href="../index.php"><span>Sair do Sistema</span></a></div>
                    </div>
                    <div id="imagem" class="col-sm-2 col-md-2 col-xs-2">
                        <?php
                        $pagina = $_GET['t'];
                        if ($pagina == "visualiza_tarefas" || $pagina == "finaliza_tarefa") {
                            ?>
                            <div></div>
                            <?php
                        } else {
                            ?>
                            <div><a href="telaPrincipal.php?t=adiciona_tarefa"><img style="border-radius: 9px;" src="../img/new.jpg" class="img-responsive"></a></div>
                            <?php
                        }
                        ?>
                    </div>
                    <div id="imagem" class="col-sm-2 col-md-2 col-xs-2">
                        <?php
                        $pagina = $_GET['t'];
                        if ($pagina == "visualiza_tarefas" || $pagina == "finaliza_tarefa") {
                            ?>
                            <div></div>
                            <?php
                        } else {
                            ?>
                            <div><a href="telaPrincipal.php?t=sugestao/"><img style="border-radius: 9px;" src="../img/sugestão.jpg" class="img-responsive"></a></div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div id="conteudo" class="col-md-12 col-sm-12 col-xs-12">
                    <?php
                    $tabela = $_REQUEST["t"];
                    if ($tabela == 'visualiza_projeto') {
                        ?><div class="projetos"><?php require '../control/tela_principal/getProjetos.php'; ?></div><?php
                    } else if ($tabela == 'visualiza_tarefas') {

                        function pegaflagtarefasabertas($id_do_projeto_executa, $id_do_projeto, $id_do_veiculo, $id_do_funcionario) {
                            $flag_tarefa_aberta = "select funcionario_executa.flag_tarefa_aberta from funcionario_executa where funcionario_executa.id_projeto_executa = $id_do_projeto_executa and funcionario_executa.id_projeto = $id_do_projeto and funcionario_executa.id_veiculo = $id_do_veiculo  and funcionario_executa.id_funcionario=$id_do_funcionario and funcionario_executa.status_funcionario_tarefa = 'ativo'";
                            $aux_flag_tarefa_aberta = mysql_query($flag_tarefa_aberta);
                            $flag_tarefa = mysql_fetch_row($aux_flag_tarefa_aberta);
                            return $flga_da_tarefa = $flag_tarefa[0];
                        }

                        $id_do_projeto = $_GET['id_projeto'];
                        $id_do_projeto_executa = $_GET['id_projeto_executa'];
                        $id_do_veiculo = $_GET['id_veiculo'];
                        $flag_tarefas_abertas = pegaflagtarefasabertas($id_do_projeto_executa, $id_do_projeto, $id_do_veiculo, $id_funcionario);
                        ?>
                        <div class="col-md-12 col-sm-12 col-xs-12" style="background: white; height: 80px;"><a href="#" onclick="flag_tarefa_aberta('<?php echo $flag_tarefas_abertas ?>');"><div id="volta"><center><img style="margin-top:20px;" src="../img/6148_32x32.png"></center></div></a></div>
                        <div class="col-md-12 col-sm-12 col-xs-12" id="tarefas"><?php require '../control/tela_principal/getTarefas.php'; ?></div>
                        <?php
                    } else if ($tabela == 'adiciona_tarefa') {
                        ?>
                        <div class="col-md-12 col-sm-12 col-xs-12" id="adiciona_tarefa">
                            <form method="post" class="adiciona_tarefa">
                                <div class="col-md-12 col-sm-12 col-xs-12" id="tela_campos" style="height: 80%; ">
                                    <div class="col-md-12 col-sm-12 col-xs-12" style=" height: 30%; margin-top:5%;">
                                        <div id="projeto" class="col-sm-12 col-md-12 col-xs-12">
                                            <label class="label" style="font-size: 2em; color:black;">Projeto</label>
                                            <select class="selectpicker"  name="campo_select_projeto" style="height: 80px; font-size: 1.5em;">
                                                <option value="0" selected="selected" ></option>
                                                <?php
                                                $q_op = "SELECT projeto.id_projeto,projeto.nome from `projeto` join `funcionarios` on (projeto.id_ugb = funcionarios.id_ugb ) where funcionarios.login = '$logado' ";
                                                $op = mysql_query($q_op);
                                                while ($aux_projeto = mysql_fetch_array($op)) {
                                                    $nome_projeto = $aux_projeto['nome'];
                                                    $id_projeto = $aux_projeto['id_projeto'];
                                                    ?>
                                                    <option value="<?php echo $id_projeto; ?>" style="color:black;"> <?php echo $nome_projeto; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12" style=" height: 30%;">
                                        <div id="veiculo" class="col-sm-12 col-md-12 col-xs-12">
                                            <label class="label" style="font-size: 2em; color:black;">Veiculo</label>
                                            <select class="selectpicker"  name="campo_select_veiculo" style="height: 80px; font-size: 1.5em;" >
                                                <option value="0" selected="selected" ></option>
                                                <?php
                                                $q_veiculos = "SELECT veiculos.id_veiculo,veiculos.nome_veiculo from veiculos where 1";
                                                $op_veiculos = mysql_query($q_veiculos);
                                                while ($aux_veiculo = mysql_fetch_array($op_veiculos)) {
                                                    $nome_veiculo = $aux_veiculo['nome_veiculo'];
                                                    $id_veiculo = $aux_veiculo['id_veiculo'];
                                                    ?>
                                                    <option value="<?php echo $id_veiculo; ?>" style="color:black;"> <?php echo $nome_veiculo; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12" style=" height: 30%; ">
                                        <div id="campo_button" class="col-sm-12 col-md-12 col-xs-12">
                                            <button type="button" onclick="location.href = 'telaPrincipal.php?t=visualiza_projeto'" id="button" class="btn btn-default">Voltar</button>
                                            <button id="button" type="submit"  class="btn btn-default">Adicionar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php
                    } else if ($tabela == 'finaliza_tarefa') {
                        $acao = $_GET['acao'];
                        $id_do_projeto = $_GET['id_projeto'];
                        $id_do_veiculo = $_GET['id_veiculo'];
                        $id_da_tarefa = $_GET['id_tarefa'];
                        $id_do_funcionario = $_GET['id_funcionario'];
                        $id_executa = $_GET['id_executa'];
                        ?>
                        <div class="finaliza_tarefa">                          
                            <?php
                            if ($_POST['submit'] == "Enviar") {
                                if ($acao == "pausa") {
                                    include('./upload_descricao_pausa.php');
                                    $multiploUploadPausa = new MultiploUploadPausa();
                                    $multiploUploadPausa->PausaTarefa($_FILES['files']['name'], $_FILES['files']['tmp_name'], $id_do_projeto, $id_do_veiculo, $id_da_tarefa, $id_do_funcionario, $id_executa);
                                      echo "<script>alert(ola)</script>";
                                    header("location:telaPrincipal.php?t=visualiza_tarefas&id_projeto=$id_do_projeto&id_projeto_executa=$id_executa&id_veiculo=$id_do_veiculo");
                                } else if ($acao == "finaliza") {
                                    include('./upload_descricao_finaliza.php');
                                    $multiploUploaFinaliza = new MultiploUploadFinaliza();
                                    $multiploUploaFinaliza->FinalizaTarefa($_FILES['files']['name'], $_FILES['files']['tmp_name'], $id_do_projeto, $id_do_veiculo, $id_da_tarefa, $id_do_funcionario, $id_executa);
                                    
                                    header("location:telaPrincipal.php?t=visualiza_tarefas&id_projeto=$id_do_projeto&id_projeto_executa=$id_executa&id_veiculo=$id_do_veiculo");
                                    echo "<script>alert(ola)</script>";
                                    }
                            }
                            ?>
                            <div class="tela_finaliza_tarefa">
                                <div class="descricao_button"><input type="button" id="add" value="Adicionar descricao"></div>
                                <div class="formulario_finaliza_tarefa">
                                    <form method="POST" enctype="multipart/form-data" action="telaPrincipal.php?t=finaliza_tarefa&id_projeto=<?php echo $id_do_projeto ?>&id_veiculo=<?php echo $id_do_veiculo ?>&id_tarefa=<?php echo $id_da_tarefa ?>&id_funcionario=<?php echo $id_do_funcionario ?>&id_executa=<?php echo $id_executa ?>&acao=<?php echo $acao ?>">
                                        <input id="enviar" type="submit" value="Enviar" name="submit"/>
                                        <input id="seleciona_arquivo" type="file" name="files[]" id="files[]"/>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else if ($tabela == 'sugestao/') {
                        ?>
                        <div class="sugestao"> 
                            <div class="col-md-12 col-sm-12 col-xs-12" id="tela_sugestao">
                                <div class="logo_com_titulo" class="col-md-12 col-sm-12 col-xs-12">
                                    <div id="imagem_logo" class="col-md-2 col-sm-2 col-xs-2"><img style="border-radius: 9px;" src="../img/sistema de sugestão.jpg" class="img-responsive"></div>
                                    <div id="titulo_logo" class="col-md-3 col-sm-3 col-xs-3"><div id="titulo"><label>Sistema de Sugestão</label></div></div>
                                    <a href="telaPrincipal.php?t=sugestao/&s=sugestoes" class="btn btn-primary btn-lg active" role="button">Suas sugestoes</a>
                                    <a href="telaPrincipal.php?t=sugestao/&s=sugestoes-pendentes" class="btn btn-primary btn-lg active" role="button">Sugestões Pendentes</a>
                                    <a href="telaPrincipal.php?t=sugestao/&s=add-sugestoes" class="btn btn-primary btn-lg active" role="button">Adicionar Sugestão</a>
                                </div>
                                <hr>
                                <div class="conteudo_sugestao">
                                    <?php
                                    $tela_sugestoes = $_REQUEST['s'];
                                    if ($tela_sugestoes == "sugestoes") {
                                        echo "tela de sugestoes";
                                    } else if ($tela_sugestoes == "sugestoes-pendentes") {
                                        echo " sugestoes pendentes";
                                    } else if ($tela_sugestoes == "add-sugestoes") {
                                        ?>
                                        <form method="post" class="form_sugestao" enctype="multipart/form-data">
                                            <div class="nome_da_sugestao">
                                                <div><label style="font-size: 1.5em; ">Nome da sugestão:</label></div>
                                                <div><input style="width: 250px;height: 30px;" type="text" name="nome_da_sugestao"> </div>
                                            </div>
                                            <div class="como_e_hoje">
                                                <div><label style="font-size: 1.5em;">Como é Hoje:</label></div>
                                                <div><textarea  name="como_e_hoje" rows="4" cols="100"></textarea></div>
                                                <input id="seleciona_arquivo" type="file" name="file" />

                                            </div>
                                            <div class="como_deve_ser">
                                                <div><label style="font-size: 1.5em;">Como deve ser:</label></div>
                                                <div><textarea name="como_deve_ser" rows="4" cols="100"></textarea></div>
                                            </div>
                                            <div class="button_salva_sugestao">
                                                <div id="campo_button" class="col-sm-12 col-md-12 col-xs-12">
                                                    <button type="button" onclick="location.href = 'telaPrincipal.php?t=visualiza_projeto'" id="button" class="btn btn-default">Voltar</button>
                                                    <button id="button" type="submit"  class="btn btn-default">Enviar Sugestão</button>
                                                </div>
                                            </div>
                                        </form>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                      } else {
                        ?><div class="projetos"><?php require '../control/tela_principal/getProjetos.php'; ?></div><?php
                    }
                    ?>
                </div>
            </div>         
        </div>
    </body>
</html>
