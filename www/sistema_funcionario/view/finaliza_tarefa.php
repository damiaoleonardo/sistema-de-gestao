<?php
$id_projeto = $_GET['id_projeto'];
$id_veiculo = $_GET['id_veiculo'];
$id_tarefa = $_GET['id_tarefa'];
$id_executa = $_GET['id_executa'];
$id_funcionario = $_GET['id_funcionario'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="teste.css" type="text/css">
        <script src="../js/jquery.js"></script>
        <script>
            function salva_descricao(id_projeto, id_veiculo, id_tarefa, id_funcionario, id_executa) {
                alert("ola");
                // loadContent('recebe_dados', "teste.php?id_projeto=" + id_projeto + "&id_veiculo=" + id_veiculo + "&id_executa=" + id_executa + "&id_funcionario="+id_funcionario+"&id_tarefa="+id_tarefa);
            }

        </script>
        <script>
            $(function () {
                $('.imagem').submit(function () {
                    var nome = $("#nome").val();
                    $.ajax({
                        type: 'POST',
                        url: 'move_imagem.php?nome=' + nome,
                        data: $('.leo').serialize(),
                        success: function (data) {
                            if (data) {
                                $('#recebe_imagem').html(data);
                            }
                        }
                    });
                    return false;
                });
            });
        </script>
        <script>
            $(function () {
                $('.audio').submit(function () {
                   
                     
                    var nome = $("#audio").val();
                    $.ajax({
                        type: 'POST',
                        url: 'move_audio.php?nome=' + nome,
                        data: $('.leo2').serialize(),
                        success: function (data) {
                            if (data) {
                                $('#recebe_audio').html(data);
                            }
                        }
                    });
                    return false;
                });
            });


        </script>
    </head>
    <body>
        <div class="tela_finaliza_tarefa" >
            <div class="col-md-6 col-sm-6 col-xs-6" style="height: 100%; border-right:1px solid black;">
                <div class="col-md-12 col-sm-12 col-xs-12" style="height: 25%; border-bottom: 1px solid black;">
                    <form class="imagem"  method="post" enctype="multipart/form-data">
                        <input type="file" name="arquivo" id="nome" style="width: 400px; margin-top:15px; height: 55px; font-size: 1.5em;"/>
                        <input type="submit" name="imagem" value="Salvar imagem" style="width: 150px; margin-top:15px; height: 40px;"/>
                    </form>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12" style="height: 75%; " id="recebe_imagem">
                    <?php
                    /*  if (isset($_POST['imagem'])) {
                      $pasta = "images";
                      if ($_FILES['arquivo']['tmp_name']) {
                      $nome = $_FILES['arquivo']['name'];
                      if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $pasta . "/" . $nome)) {

                      } else {
                      echo "Falha ao mover arquivo";
                      }
                      }
                      }
                      $files = glob("images/*.*");
                      for ($i = 1; $i < count($files); $i++) {
                      $nome_imagem = "images/" . $nome;
                      if ($files[$i] == $nome_imagem) {
                      $num = $files[$i];
                      echo ' <li--><img style="width:90%px; height:70%;" alt="random image" src="' . $num . '" />';
                      }
                      }

                      $sql_imagem = ""; */
                    ?>  
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6" style="height: 100%; ">
                <div class="col-md-12 col-sm-12 col-xs-12" style="height: 49%; border-bottom: 1px solid black;">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="height: 49%; border-bottom: 1px solid black; ">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="height: 25%;">
                            <form class="audio" method="post"  enctype="multipart/form-data">
                                <input type="file" name="file" id="audio" style="width: 400px; margin-top:15px; height: 40px; font-size: 1.5em; "/> 
                                <input type="submit" name="submit" value="salvar audio"  style="width: 180px; margin-top:15px; height: 40px; font-size: 1.2em;   "/>
                            </form>

                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" style="height: 49%;">
<?php
/*  if (isset($_POST['submit'])) {
  $allowedExts = array("jpg", "jpeg", "gif", "png", "mp3", "mp4", "wma");
  $fileName = $_FILES['file']['name'];
  $extension = substr($fileName, strrpos($fileName, '.') + 1); // getting the info about the image to get its extension
  if ((($_FILES["file"]["type"] == "video/mp4") || ($_FILES["file"]["type"] == "audio/mp3") || ($_FILES["file"]["type"] == "audio/wma") || ($_FILES["file"]["type"] == "image/pjpeg") || ($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg")) && ($_FILES["file"]["size"] < 500000) && in_array($extension, $allowedExts)) {
  if (in_array($extension, $allowedExts)) {
  if ($_FILES["file"]["error"] > 0) {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
  } else {
  if (file_exists("audio/" . $_FILES["file"]["name"])) {
  echo $_FILES["file"]["name"] . " already exists. ";
  } else {
  move_uploaded_file($_FILES["file"]["tmp_name"], "audio/" . $_FILES["file"]["name"]);
  // echo "Stored in: " . "musicas/" . $_FILES["file"]["name"];
  // echo  $audio =$_FILES["file"]["name"];
  //$sql = "INSERT INTO `audio`(`nome_audio`) VALUES ('$audio')";
  // mysql_query($sql);
  }
  }
  } else {
  echo "Invalid file";
  }
  }
  } */
?>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12" style="height: 49%;" id="recebe_audio">
<?php
/*  $path = "audio/";
  $diretorio = dir($path);
  //  echo "Lista de Arquivos do diretório '<strong>" . $path . "</strong>':<br />";
  while ($arquivo = $diretorio->read()) {
  if($fileName == $arquivo){
  echo "<scritp>alert('Audio salvo com sucesso!')</script>";
  echo "<a href='" . $path . $arquivo . "'>" . $arquivo . "</a><br />";
  }
  }
  $diretorio->close(); */
?>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12" style="height: 49%;">
                    <button onclick="location.href = 'telaPrincipal.php?t=visualiza_projeto'" id="button" class="btn btn-default" style="width: 140px; background: #23527c; color:white; height: 70px; margin-top:50px; font-size: 1.5em;">Voltar</button>
                    <button id="button" onclick="salva_descricao('<?php echo $id_projeto ?>', '<?php echo $id_veiculo ?>', '<?php echo $id_tarefa ?>', '<?php echo $id_funcionario ?>', '<?php echo $id_executa ?>')" class="btn btn-default" style="width: 140px; height: 70px; margin-top:50px; margin-left: 40px; background: #23527c; color:white; font-size: 1.5em;">Finalizar</button>
                </div>
            </div>
        </div>
    </body>
</html>
