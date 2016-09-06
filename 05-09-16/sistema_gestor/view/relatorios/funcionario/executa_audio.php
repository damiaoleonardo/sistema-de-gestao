<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="../../../Audio-HTML5.js"></script>
    </head>
    <body>
        <?php
        $data = $_GET['data'];
        $nome = $_GET['nome'];
         $url = '../../../descricao_das_tarefas/'. $data . '/+' .  $nome. '';
         
         //../../../descricao_das_tarefas/2016-06-27/recording-1694038598.mp3
         
         //require '../../../audio-file.mp3';
        ?>

      
      
         <input type="button" onclick="executaAudio('../../../descricao_das_tarefas/2016-06-27/leonardo.ogg')" value="Executa audio">
    </body>
</html>
