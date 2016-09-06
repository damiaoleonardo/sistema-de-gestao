<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php

        function verificaDiagonal($xa, $xb, $ya, $yb) {
            if ($xa != $xb) {
                if ($ya != $yb) {
                    return true;
                }
            }
            return false;
        }
/*
        function verificaPontoIguais($xa, $xb, $ya, $yb) {
            if ($xa == $xb) {
                return true;
            }
            return false;
        }*/
        
        
        function verificaNumeroMenorx($xa,$xb,$xc){
            if($xa < $xb){
                if($xa < $xc ){
                    return $xa;
                }
            }else if($xb < $xc){
                if($xb < $xa ){
                    return $xb;
                }
            } else  if($xc < $xb){
                if($xc < $xa ){
                    echo "aqui";
                    return $xc;
                }
            }   
        }
        
          function verificaNumeroMenory($xa,$xb,$xc){
            if($xa < $xb){
                if($xa < $xc ){
                    return $xa;
                }
            }else if($xb < $xc){
                if($xb < $xa ){
                    return $xb;
                }
            } else  if($xc < $xb){
                if($xc < $xa ){
                    echo "aqui";
                    return $xc;
                }
            }   
        }
        
        

        if ($_POST['submit'] == "Enviar") {
            $valorxa = $_POST['diagonalxa'];
            $valorya = $_POST['diagonalya'];
            $valorxb = $_POST['diagonalxb'];
            $valoryb = $_POST['diagonalyb'];
            $valorxc = $_POST['diagonalxc'];
            $valoryc = $_POST['diagonalyc'];
            $flag_ponto = 0;

            if (verificaDiagonal($valorxa, $valorxb, $valorya, $valoryb)) {
                echo "<p>Diagonal encontrada foi " . $valorxa . "," . $valorya . " | " . $valorxb . "," . $valoryb . "</p>";
                echo "Ponto que falta é: " . $valorxa . "," . $valoryb;
            } else if (verificaDiagonal($valorxa, $valorxc, $valorya, $valoryc)) {
                echo "<p>Diagonal encontrada foi " . $valorxa . "," . $valorya . " | " . $valorxc . "," . $valoryc . "</p>";
                echo "Ponto que falta é: " . $valorxa . "," . $valoryc;
            } else if (verificaDiagonal($valorxb, $valorxc, $valoryb, $valoryc)) {
                echo "<p>Diagonal encontrada foi " . $valorxb . "," . $valoryb . " | " . $valorxc . "," . $valoryc . "</p>";
                echo "Ponto que falta é : " . $valorxb . "," . $valoryc;
            } else {
                echo "Diagonal nao encontrada";
            }
        }
        ?>
        <div style="margin: 5% 0% 0% 30%; height: 400px; width: 200px;border:1px solid black;">
           <!-- <form action="teste_aula.php" method="post">
                Diagonal X <input style="height: 25px; width: 100px;" type="number" name="diagonalxa"> Diagonal Y <input style="height: 25px; width: 100px;" type="number" name="diagonalya">
                Diagonal X <input style="height: 25px; width: 100px;" type="number" name="diagonalxb"> Diagonal Y <input style="height: 25px; width: 100px;" type="number" name="diagonalyb">  
                Diagonal X <input style="height: 25px; width: 100px;" type="number" name="diagonalxc"> Diagonal Y <input style="height: 25px; width: 100px;" type="number" name="diagonalyc">
                <input type="submit" value="Enviar" name="submit">
            </form>-->

        </div>


        <div style="margin: 5% 0% 0% 30%; height: 400px; width: 200px;border:1px solid black;">

            <form method="post" action="teste_aula.php" >
                quantidade de entrada <input type="number" name="quantidade">
                Diagonal X <input style="height: 25px; width: 100px;" type="number" name="diagonalxa"> Diagonal Y <input style="height: 25px; width: 100px;" type="number" name="diagonalya">
                Diagonal X <input style="height: 25px; width: 100px;" type="number" name="diagonalxb"> Diagonal Y <input style="height: 25px; width: 100px;" type="number" name="diagonalyb">  
                Diagonal X <input style="height: 25px; width: 100px;" type="number" name="diagonalxc"> Diagonal Y <input style="height: 25px; width: 100px;" type="number" name="diagonalyc">
                <input type="submit" value="Enviar quantidade" name="quantidade">
            </form>
<?php
if ($_POST['quantidade'] == "Enviar quantidade") {
            $valorxa = $_POST['diagonalxa'];
          echo  $valorya = $_POST['diagonalya'];
            $valorxb = $_POST['diagonalxb'];
           echo $valoryb = $_POST['diagonalyb'];
            $valorxc = $_POST['diagonalxc'];
         echo   $valoryc = $_POST['diagonalyc'];
            
       echo "menor x = ".  $menorx = verificaNumeroMenorx($valorxa, $valorxb, $valorxc)."<br>";
       
        echo "menor y =  ".  $menory = verificaNumeroMenory($valorya, $valoryb, $valoryc);
            
            
}
?>
        </div>


            <?php
            ?>


    </body>
</html>
