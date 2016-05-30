<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Formul&aacute;rio de Upload de Arquivo</title>
    </head>
    <body>
        <?php
        $host = "localhost";
        $user = "root";
        $pass = "";
        $banco = "sistema_de_gestao";
        $conexao = mysql_connect($host, $user, $pass)or die(mysql_error());
        $bd = mysql_select_db($banco, $conexao)or die(mysql_error());

        function get_post_action($name) {
            $params = func_get_args();
            foreach ($params as $name) {
                if (isset($_POST[$name])) {
                    return $name;
                }
            }
        }
        switch (get_post_action('imagem', 'audio')) {
            case 'imagem':
                if (isset($_POST['imagem'])) {
                    $pasta = "images";
                    if ($_FILES['arquivo']['tmp_name']) {
                       echo $nome = $_FILES['arquivo']['name'];
                        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $pasta . "/" . $nome)) {
                            $sql = "insert into ugb_mes (imagem_ugb) values ('$nome')";
                            mysql_query($sql);
                        } else {
                            echo "Falha ao mover arquivo";
                        }
                    }
                }
                $files = glob("images/*.*");
                for ($i = 1; $i < count($files); $i++) {
                    $num = $files[$i];
                    echo ' <li--><img alt="random image" src="' . $num . '" />';
                }

                $sql_select = "select imagem_ugb from ugb_mes where id_ugbmes = 1 ";
                $result = mysql_query($sql_select);
                while ($aux_imagem = mysql_fetch_array($result)) {
                    echo $imagem['imagem_ugb'];
                }


            
              
            break;

        case 'audio':
            if (isset($_POST['audio'])) {

                $allowedExts = array("jpg", "jpeg", "gif", "png", "mp3", "mp4", "wma");
                //echo $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $fileName = $_FILES['file']['name'];
                $extension = substr($fileName, strrpos($fileName, '.') + 1); // getting the info about the image to get its extension
                if ((($_FILES["file"]["type"] == "video/mp4") || ($_FILES["file"]["type"] == "audio/mp3") || ($_FILES["file"]["type"] == "audio/wma") || ($_FILES["file"]["type"] == "image/pjpeg") || ($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg")) && ($_FILES["file"]["size"] < 500000) && in_array($extension, $allowedExts)) {
                    if (in_array($extension, $allowedExts)) {
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
            }

            $path = "musicas/";
            $diretorio = dir($path);

            echo "Lista de Arquivos do diretório '<strong>" . $path . "</strong>':<br />";
            while ($arquivo = $diretorio->read()) {
                echo "<a href='" . $path . $arquivo . "'>" . $arquivo . "</a><br />";
            }
            $diretorio->close();

            break;
        default:
            echo "nenhum dos dois";
        //no action sent
    }
    ?>

    <form  action="" method="post"  enctype="multipart/form-data">
        <input type="file" name="arquivo"/>
        <input type="submit" name="imagem" value="Fazer Upload"/>

        <label for="file"><span>Filename:</span></label>
        <input type="file" name="file" id="file" /> 
        <br/>
        <input type="submit" name="audio" value="salvar audio"/>
    </form>

</body>
</html>