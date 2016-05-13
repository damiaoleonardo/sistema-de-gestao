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
        <link rel="stylesheet" href="teste3.css" type="text/css">
        <script src="js/jquery.js"></script>
        <script src="js/slider.js"></script>
        
        <script>
            jQuery(document).ready(function ($) {
                var options = {$AutoPlay: true};
                var jssor_slider1 = new $JssorSlider$('slide_banner', options);
            });
        </script>
    </head>
    <body >
        <div id="slide_banner">
            <div id="slide" u="slides">
                <div><?php require './index.php'; ?></div>
                <div><img u="image" src="logo_empresa.png" /></div>
            </div>
   
            
        </div>
    </body>
</html>
