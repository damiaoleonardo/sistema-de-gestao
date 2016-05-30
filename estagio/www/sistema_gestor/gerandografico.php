<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Gráfico em pizza com javascript</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="http://static.pureexample.com/js/flot/jquery.flot.min.js"></script>
        <script src="http://static.pureexample.com/js/flot/jquery.flot.pie.min.js"></script>
        <style type="text/css">body { font-family: Verdana, Arial, sans-serif; font-size: 18px; }</style>
        <style type="text/css">
            #flotcontainer {
                width: 700px;
                height: 500px;
                text-align: left;
            }
        </style>

    </head>
    <body>
        <div id="flotcontainer">
            <script type="text/javascript">
                $(function () {
                    var data = [
                        {label: '<?php echo "manutencao geral" ?>', data: <?php echo 12 ?>},
                        {label: "data2", data: 30},
                        {label: "data3", data: 5}
                        
                    ];
                   
                    
                    
                    var options = {
                        series: {
                            pie: {show: true}
                        },
                        legend: {
                            show: false
                        }
                    };
                    $.plot($("#flotcontainer"), data, options);

                });
            </script>
        </div>
    </body>
</html>



<!--

<script type="text/javascript">
$(function () { 
   var data = [
       {label: "data1", data:10},
       {label: "data2", data: 20},
       {label: "data3", data: 30},
       {label: "data4", data: 40},
       {label: "data5", data: 50},
       {label: "data6", data: 60},
       {label: "data7", data: 70}
   ];

   var options = {
           series: {
               pie: {show: true}
                   },
           legend: {
               show: false
           }
        };

   $.plot($("#flotcontainer"), data, options);  
});
</script>


<div id="legendPlaceholder"></div>
<div id="flotcontainer"></div>-->