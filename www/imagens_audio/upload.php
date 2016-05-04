<?php
        if (isset($_POST['submit'])) {
            $pasta = "images";
            if ($_FILES['arquivo']['tmp_name']) {
                $nome = $_FILES['arquivo']['name'];
                if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $pasta . "/" . $nome)) {
                    echo "Arquivo $nome movido para $pasta ";
                } else {
                    echo "Falha ao mover arquivo";
                }
            }
        }
        ?>