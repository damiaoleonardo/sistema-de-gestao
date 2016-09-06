 $(function(){
     $('.form_controle').submit(function(){ 
          $.ajax({
          type: 'POST',
          url: '../control/controle-manutencao/adiciona_atividade_insere.php',
          data: $('.form_controle').serialize(),
           success: function( data ){
             if(data){
                $('.recebe_resposta_insere').html(data);
               }
             }
            });
         return false;
      });
});



