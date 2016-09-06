<?php

if (isset($_POST['imagem'])) {
    $pasta = "informacoes_mes/imagem_informacoes";
    if ($_FILES['arquivo']['tmp_name']) {
        $ext = substr($_FILES['arquivo']['name'], -4);
        if ($ext == "jpeg") {
            $ext = "." . $ext;
        }
        $arquivo = "informacao" . $ext;
        if (file_exists($dir) && $nmImP != $arquivo) {
            unlink($dir);
        }
        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $pasta . "/" . $arquivo)) {
            echo "<script>alert('imagem salva com sucesso!')</script>";
            echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=telaPrincipal.php?t=informacao-mes'>";
        } else {
            echo "Falha ao mover arquivo";
        }
    }
}
?>


