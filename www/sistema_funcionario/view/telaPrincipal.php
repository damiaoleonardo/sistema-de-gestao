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
    <meta http-equiv="refresh" content="20">
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
        <script type="text/javascript" src="../js/jquery-1.12.0.js"></script>
        <script src="../js/iniciar_tarefa/inicia_tarefa.js"></script>
        <script src="../js/pausa_tarefa/pausa_tarefa.js"></script>
        <script src="../js/iniciar_tarefa/reabre_tarefa.js"></script>
        <script src="../js/finaliza_tarefa/finaliza_tarefa.js"></script>
        <script src="../js/finaliza_tarefa/finaliza_tarefa_liberada.js"></script>
        <script src="../js/modal/janela_modal.js"></script>
        <script src="../js/adiciona_tarefa/adiciona_tarefa.js"></script>
    </head>
    <body>
        <div class="recebe_resposta"></div>
        <div class="tela_principal">
            <div class="row">
                <div id="header">
                    <div id="logo" class="col-sm-3 col-md-3 col-xs-3">
                        <div class="col-sm-12 col-md-12 col-xs-12">Sitio Barreiras</div>
                    </div>
                    <div id="informacoes" class="col-sm-4 col-md-4 col-xs-4">
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
                        if ($pagina == "visualiza_tarefas") {
                            ?>
                            <div></div>
                            <?php
                        } else {
                            ?>
                            <div><a href="telaPrincipal.php?t=adiciona_tarefa"><img src="../img/new.jpg" class="img-responsive"></a></div>
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
                        ?>
                        <div class="col-md-12 col-sm-12 col-xs-12" style="background: white; height: 80px;"><a href="#" onclick="flag_tarefa_aberta('<?php echo $flag_tarefas_abertas ?>', '<?php echo $login ?>');"><div id="volta"><center><img style="margin-top:20px;" src="../img/6148_32x32.png"></center></div></a></div>
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
                                            <button onclick="location.href = 'telaPrincipal.php?t=visualiza_projeto'" id="button" class="btn btn-default">Voltar</button>
                                            <button id="button" type="submit"  class="btn btn-default">Adicionar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php
                    } else if ($tabela == 'finaliza_tarefa') {
                        ?>
                        <div class="finaliza_tarefa"><?php require './finaliza_tarefa_liberada.php'; ?></div>
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
