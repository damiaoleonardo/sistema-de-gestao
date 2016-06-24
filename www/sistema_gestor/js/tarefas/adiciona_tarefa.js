 $(function(){
     $('.formulario_tarefa').submit(function(){ 
          $.ajax({
          type: 'POST',
          url: '../control/tarefas/adiciona_tarefa.php',
          data: $('.formulario_tarefa').serialize(),
           success: function( data ){
             if(data){
                $('.recebe_resposta_tarefa').html(data);
               }
             }
            });
         return false;
      });
});



