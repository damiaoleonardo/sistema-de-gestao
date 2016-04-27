<?php
include('../../model/projetos/projetos.php');
$id_projeto = $_POST['campo_select_projeto'];
$id_veiculo = $_POST['campo_select_veiculo'];
if (empty($id_veiculo) || empty($id_projeto)) {
    echo "<script>alert('Por Favor preencha todos os campos necessarios!')</script>";
} else {
     echo "<script>alert('ola!')</script>";
    try {
        $projetos = new projeto();
        $projetos->setId_projeto($id_projeto);
        $projetos->setId_veiculo($id_veiculo);
        $projetos->add_projeto($projetos);
    } catch (Exception $ex) {
        $ex->getMessage();
    }
}
?>
