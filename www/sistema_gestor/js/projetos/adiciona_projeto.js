 $(function(){
     $('.formulario_projeto').submit(function(){ 
          $.ajax({
          type: 'POST',
          url: '../control/projetos/adiciona_projeto.php',
          data: $('.formulario_projeto').serialize(),
           success: function( data ){
             if(data){
                $('.recebe_resposta_projeto').html(data);
               }
             }
            });
         return false;
      });
});



