 $(function(){
     $('.form-update').submit(function(){ 
          $.ajax({
          type: 'POST',
          url: '../control/controle-manutencao/atualiza_atividade.php',
          data: $('.form-update').serialize(),
           success: function( data ){
             if(data){
                $('.recebe_resposta').html(data);
               }
             }
            });
         return false;
      });
});



