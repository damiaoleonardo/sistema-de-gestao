<?php



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

?>







































<?php
/*
if (isset($_POST['submit'])) {

                                        $allowedExts = array("jpg", "jpeg", "gif", "png", "mp3", "mp4", "wma");
                                        //echo $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                                        $fileName = $_FILES['file']['name'];
                                        $extension = substr($fileName, strrpos($fileName, '.') + 1); // getting the info about the image to get its extension
*/
                                        /* if ((($_FILES["file"]["type"] == "video/mp4")|| ($_FILES["file"]["type"] == "audio/mp3")|| ($_FILES["file"]["type"] == "audio/wma")|| ($_FILES["file"]["type"] == "image/pjpeg")|| ($_FILES["file"]["type"] == "image/gif")|| ($_FILES["file"]["type"] == "image/jpeg")) && ($_FILES["file"]["size"] < 200000) && in_array($extension, $allowedExts)) */

                                      /*  if (in_array($extension, $allowedExts)) {
                                            echo "verifica";
                                            if ($_FILES["file"]["error"] > 0) {
                                                echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
                                            } else {
                                                echo "Upload: " . $_FILES["file"]["name"] . "<br />";
                                                echo "Type: " . $_FILES["file"]["type"] . "<br />";
                                                echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
                                                echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

                                                if (file_exists("musicas/" . $_FILES["file"]["name"])) {
                                                    echo $_FILES["file"]["name"] . " already exists. ";
                                                } else {
                                                    echo "move";
                                                    move_uploaded_file($_FILES["file"]["tmp_name"], "musicas/" . $_FILES["file"]["name"]);
                                                    echo "<scritp>alert('Audio salvo com sucesso!')</script>";

                                                    // echo "Stored in: " . "musicas/" . $_FILES["file"]["name"];
                                                    // echo  $audio =$_FILES["file"]["name"];
                                                    //  $sql = "INSERT INTO `audio`(`nome_audio`) VALUES ('$audio')";
                                                    // mysql_query($sql);
                                                }
                                            }
                                        } else {
                                            echo "Invalid file";
                                        }
                                    }
                                    ?>
      <form method="post"  enctype="multipart/form-data" >
                                        <label for="file"><span>Filename:</span></label>
                                        <input type="file" name="file" id="file" /> 
                                        <br/>
                                        <input type="submit" name="submit" value="salvar audio"/>
                                    </form>
                                    
                                    
<?php
   
        $path = "musicas/";
        $diretorio = dir($path);

        echo "Lista de Arquivos do diretório '<strong>" . $path . "</strong>':<br />";
        while ($arquivo = $diretorio->read()) {
            echo "<a href='" . $path . $arquivo . "'>" . $arquivo . "</a><br />";
        }
        $diretorio->close();
        ?>
*/