 $(function(){
     $('.formulario_atualiza_tarefa').submit(function(){ 
          $.ajax({
          type: 'POST',
          url: '../control/tarefas/atualiza_tarefa.php',
          data: $('.formulario_atualiza_tarefa').serialize(),
           success: function( data ){
             if(data){
                $('.recebe_resposta_atualiza_tarefa').html(data);
               }
             }
            });
         return false;
      });
});



