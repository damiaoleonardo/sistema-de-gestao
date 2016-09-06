<?php

require '../model/Conexao/Conexao.php';

class update_sugestao {

    public $diretorio = "../../sistema_gestor/sugestoes/";

    function updateSugestao($nomeArquivo, $tmp_nome_finaliza, $nome_sugestao, $como_deve_ser, $como_e_hj, $como_e_hoje, $como_deve_se, $id_sugestao) {
        $conexao_insere_sugestao = mysqli_connect("localhost", "root", "", "sistema_de_gestao");
        $conexao_insere_sugestao->set_charset("utf8");
        mysqli_autocommit($conexao_insere_sugestao, FALSE);
        $erro_add_sugestao = 0;
        $data_de_hoje_finaliza = date('Y-m-d');
        if (!is_dir('/' . $data_de_hoje_finaliza . '/')) {
            if (!empty($tmp_nome_finaliza)) {
                mkdir('../../sistema_gestor/sugestoes/' . $data_de_hoje_finaliza);
                if (!empty($nomeArquivo[0])) {
                    if (!move_uploaded_file($tmp_nome_finaliza[0], $this->diretorio . $data_de_hoje_finaliza . "/" . '+' . $nomeArquivo[0])) {
                        $erro_add_sugestao++;
                    }
                }
                if (!empty($nomeArquivo[1])) {
                    if (!move_uploaded_file($tmp_nome_finaliza[1], $this->diretorio . $data_de_hoje_finaliza . "/" . '+' . $nomeArquivo[1])) {
                        $erro_add_sugestao++;
                    }
                }
                if (!empty($nomeArquivo[0]) && empty($nomeArquivo[1])) {
                    $sql_update_sugestao = "update sugestoes set nome_sugestao= '$nome_sugestao', como_e_hoje = '$como_e_hj', como_deve_ser = '$como_deve_ser', img_como_e_hoje = '$nomeArquivo[0]'   where sugestoes.id_sugestao = $id_sugestao";
                } else if (empty($nomeArquivo[0]) && !empty($nomeArquivo[1])) {
                    $sql_update_sugestao = "update sugestoes set nome_sugestao= '$nome_sugestao', como_e_hoje = '$como_e_hj', como_deve_ser = '$como_deve_ser', img_como_deve_ser = '$nomeArquivo[1]'  where sugestoes.id_sugestao = $id_sugestao";
                } else {
                    $sql_update_sugestao = "update sugestoes set nome_sugestao= '$nome_sugestao', como_e_hoje = '$como_e_hj', como_deve_ser = '$como_deve_ser', img_como_e_hoje = '$nomeArquivo[0]' ,img_como_deve_ser = '$nomeArquivo[1]'  where sugestoes.id_sugestao = $id_sugestao";
                }
                if (!mysqli_query($conexao_insere_sugestao, $sql_update_sugestao)) {
                    $erro_add_sugestao++;
                }
                if ($erro_add_sugestao == 0) {
                    mysqli_commit($conexao_insere_sugestao);
                    echo "<center><p style='font-size:2em;'>Sugestão Alterada com sucesso!</p></center>";
                    if (!empty($nomeArquivo[0])) {
                        unlink($this->diretorio . $data_de_hoje_finaliza . "/" . '+' . $como_e_hoje);
                    }
                    if (!empty($nomeArquivo[1])) {
                        unlink($this->diretorio . $data_de_hoje_finaliza . "/" . '+' . $como_deve_se);
                    }
                } else {
                    mysqli_rollback($conexao_insere_sugestao);
                    unlink($this->diretorio . $data_de_hoje_finaliza . "/" . '+' . $nomeArquivo[0]);
                    unlink($this->diretorio . $data_de_hoje_finaliza . "/" . '+' . $nomeArquivo[1]);
                    echo "Ocorreu um erro!";
                }
            } else {
                echo "O endereço nao é um diretorio valido!";
            }
        }
    }

}
