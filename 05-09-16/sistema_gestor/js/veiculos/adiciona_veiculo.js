 $(function(){
     $('.form-horizontal').submit(function(){ 
          $.ajax({
          type: 'POST',
          url: '../control/veiculos/adiciona_veiculo.php',
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


