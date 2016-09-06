 $(function(){
     $('.form-horizontal').submit(function(){ 
          $.ajax({
          type: 'POST',
          url: '../control/controle-manutencao/adiciona_atividade.php',
          data: $('.form-horizontal').serialize(),
           success: function( data ){
             if(data){
                $('.recebe_resposta').html(data);
               }
             }
            });
         return false;
      });
});



