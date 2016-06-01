<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if (isset($_POST['submit'])) {

            $allowedExts = array("jpg", "jpeg", "gif", "png", "mp3", "mp4", "wma");
            //echo $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $fileName = $_FILES['file']['name'];
            $extension = substr($fileName, strrpos($fileName, '.') + 1); // getting the info about the image to get its extension
            if ((($_FILES["file"]["type"] == "video/mp4") || ($_FILES["file"]["type"] == "audio/mp3") || ($_FILES["file"]["type"] == "audio/wma") || ($_FILES["file"]["type"] == "image/pjpeg") || ($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg")) && ($_FILES["file"]["size"] < 500000) && in_array($extension, $allowedExts)){
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
        
    </body>
</html>
