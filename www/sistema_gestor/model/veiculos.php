<?php
require('../model/Connection.class.php');
 $conexao = Connection::getInstance();
 
class Veiculos {
   
   private $placa;
   private $nome_veiculo;
   private $tipo;
   private $id;
   
   function getId() {
       return $this->id;
   }

   function setId($id) {
       $this->id = $id;
   }
   
   function getPlaca() {
       return $this->placa;
   }

   function getNome() {
       return $this->nome_veiculo;
   }

   function getTipo() {
       return $this->tipo;
   }

   function setPlaca($placa) {
    if (preg_match('/^[a-z A-Z]{3}\-[0-9]{4}$/', $placa)) {
       $this->placa = $placa; 
        
      } else {
     throw new Exception("Placa do veiculo esta incorreta");
     }
   }

   function setNome($nome_veiculo,$flag_veiculo) {
         if($flag_veiculo == 1){
            $result_adiciona = mysql_query("select veiculos.nome from veiculos where veiculos.nome= '$nome_veiculo'");
        if (mysql_num_rows($result_adiciona)) {
             throw new Exception('<script>alert("Nome ja existente, por favor tente outro!")</script>');
        } else {
           $this->nome_veiculo = $nome_veiculo;
        }
        }else if($flag_veiculo == 2){
            session_start("nome_veiculo"); $nome_veiculo_atual = $_SESSION['nome_do_veiculo'];
            if ($nome_veiculo_atual == $nome_veiculo) {
                $this->nome_veiculo = $nome_veiculo;
            } else {
                $result_atualiza = mysql_query("select veiculos.nome from veiculos where veiculos.nome = '$nome_veiculo'");
                if (mysql_num_rows($result_atualiza)) {
                    throw new Exception('<script>alert("Nome ja existente, por favor tente outro!")</script>');
                } else {
                    $this->nome_veiculo = $nome_veiculo;
                }
            }
        } 
   }

   function setTipo($tipo) {
       $this->tipo = $tipo;
   }
   
  function AddVeiculos(Veiculos $obj){
       $nome = $obj->getNome();
       $placa = $obj->getPlaca();
       $tipo =  $obj->getTipo();   
       $query = "insert into veiculos (nome,placa,id_tipo) values ('$nome','$placa','$tipo')";
       mysql_query($query);
   }

  function AtualizaDados(Veiculos $obj){
      $veiculo_atualiza = $obj->getNome();
      $placa_atualiza = $obj->getPlaca();
      $tipo_atualiza =  $obj->getTipo();  
      $id_do_veiculos_atualiza = $obj->getId();
      $query_atualiza = "UPDATE veiculos SET nome='$veiculo_atualiza', placa='$placa_atualiza',id_tipo='$tipo_atualiza' where veiculos.id_veiculo= $id_do_veiculos_atualiza";
      mysql_query($query_atualiza);
     
  }
 
}
