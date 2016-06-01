<?php
if (isset($_POST['imagem_tipo'])) {
    $pasta = "ugb_tipo/imagem_ugbtipo";
    if ($_FILES['arquivo']['tmp_name']) {
        $ext = substr($_FILES['arquivo']['name'], -4);
        if ($ext == "jpeg") {
            $ext = "." . $ext;
        }
        $arquivo = "ugb_tipo" . $ext;
        if (file_exists($dir) && $nmImP != $arquivo) {
            unlink($dir);
        }
        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $pasta . "/" . $arquivo)) {
            echo "<script>alert('imagem salva com sucesso!')</script>";
            echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=telaPrincipal.php?t=ugb-tipo'>";
            //  $sql = "insert into ugb_mes (imagem_ugb) values ('$nome')";
            //  mysql_query($sql);
        } else {
            echo "Falha ao mover arquivo";
        }
    }
}
?>


