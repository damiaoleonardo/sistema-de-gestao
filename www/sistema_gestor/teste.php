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
        $teste = 3;
        $j = 0;
        $i = 0;
        ?>
        <table border="1">
            <?php
            ?>
           
            <?php
            while ($i < 3) {
                ?>
               <tr>
                <td rowspan="<?php echo $teste ?> ">Célula 1</td>
               </tr>
               
               <?php 
               while($j < 2){
               ?>
               <tr>
                <td>Headphone</td>
                <td>WSGWEGW</td>
                 <td>SEVBEW</td>
              </tr>
             <?php 
               $j++;  
               }
               ?>
           

                <?php
                $i++;
            }
            ?>
        </table>

    </body>
</html>
