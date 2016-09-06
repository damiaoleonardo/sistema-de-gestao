<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $date = "2016-09-05";
        $duedt = explode("-", $date);
        $date = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
        $week = (int) date('W', $date);
        echo "Número da semana: " . $week;
        ?>
    </body>
</html>
