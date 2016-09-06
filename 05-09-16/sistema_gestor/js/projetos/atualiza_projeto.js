 $(function(){
     $('.formulario_projeto_atualiza').submit(function(){ 
          $.ajax({
          type: 'POST',
          url: '../control/projetos/atualiza_projeto.php',
          data: $('.formulario_projeto_atualiza').serialize(),
           success: function( data ){
             if(data){
                $('.recebe_resposta_projeto_atualiza').html(data);
               }
             }
            });
         return false;
      });
});



