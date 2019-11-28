$(document).ready(function(){
  var flag=0;
  var ExpCadena = /^[a-zñÑáéíóúÁÉÍÓÚ]+(\s[a-zñÑáéíóúÁÉÍÓÚ]+)*$/i;
 $("#Registrarse").click(function (e){
   alertas="";
   e.preventDefault();
   if ( !ExpCadena.test( $("#nombre").val() ) )
     alertas="Ningun campo puede tener ningun caracter especial";
   if ( !ExpCadena.test( $("#apellido").val() ) )
     alertas="Ningun campo puede tener ningun caracter especial";
   if ( !ExpCadena.test( $("#usuario").val() ) )
     alertas="Ningun campo puede tener ningun caracter especial";
   if ( !ExpCadena.test( $("#password").val() ) )
     alertas="Ningun campo puede tener ningun caracter especial";
   if ( !ExpCadena.test( $("#confirm_password").val() ) )
     alertas="Ningun campo puede tener ningun caracter especial";
    if(alertas)
      alert(alertas);
    else {
      alert("Eso compa");
    }
  });



 $('#password, #confirm_password').on('keyup', function () {
   if ($('#password').val() == $('#confirm_password').val()){
     $('#message').html('Coinciden').css('color', 'green');
     flag+=1;
   }
   else{
     $('#message').html('No coinciden').css('color', 'red');
   }

 });
});
