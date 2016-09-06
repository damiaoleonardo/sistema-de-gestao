<?php

require '../model/Conexao/Conexao.php';

class upload_sugestao {

    public $diretorio = "../../sistema_gestor/sugestoes/";

    function addSugestao($nomeArquivo, $tmp_nome_finaliza, $nome_sugestao, $como_deve_ser, $como_e_hj, $dono_sugestao) {
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

                $sql_insere_sugestao = "insert into sugestoes (status,categoria_sugestao,data_enviada,dono_da_sugestao,nome_sugestao,como_e_hoje,como_deve_ser,img_como_e_hoje,img_como_deve_ser) values('nao vista','nao implantada','$data_de_hoje_finaliza','$dono_sugestao','$nome_sugestao','$como_e_hj','$como_deve_ser','$nomeArquivo[0]','$nomeArquivo[1]')";

                if (!mysqli_query($conexao_insere_sugestao, $sql_insere_sugestao)) {
                    $erro_add_sugestao++;
                }
                if ($erro_add_sugestao == 0) {
                    mysqli_commit($conexao_insere_sugestao);
                    echo "<center><p style='font-size:2em;'>Sugestão Inserida com sucesso!</p></center>";
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
