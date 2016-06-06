$(function(){
     $('.form-horizontal_edit').submit(function(){
          $.ajax({
          type: 'POST',
          url: '../control/veiculos/edita_veiculos.php',
          data: $('.form-horizontal_edit').serialize(),
           success: function( data ){
             if(data){
                $('.recebe_resposta_edit').html(data);
               }
             }
            });
         return false;
      });
});


