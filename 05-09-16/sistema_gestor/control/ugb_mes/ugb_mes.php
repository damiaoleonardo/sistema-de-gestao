<?php

if (isset($_POST['imagem'])) {
    $pasta = "ugb_do_mes/imagem_ugb";
    if ($_FILES['arquivo']['tmp_name']) {
        $ext = substr($_FILES['arquivo']['name'], -4);
        if ($ext == "jpeg") {
            $ext = "." . $ext;
        }
        $arquivo = "ugb" . $ext;
        if (file_exists($dir) && $nmImP != $arquivo) {
            unlink($dir);
        }
        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $pasta . "/" . $arquivo)) {
            echo "<script>alert('imagem salva com sucesso!')</script>";
            echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=telaPrincipal.php?t=ugb-do-mes'>";
        } else {
            echo "Falha ao mover arquivo";
        }
    }
}
?>


