$(document).ready(function(){
  var flag=0;
  var ExpCadena = /^[a-zñÑáéíóúÁÉÍÓÚ]+(\s[a-zñÑáéíóúÁÉÍÓÚ]+)*$/i;
 $("#Registrarse").click(function (e){
   alertas="";
   e.preventDefault();
   if ( !ExpCadena.test( $("#nombre").val() ) ){
     alertas="Ningun campo puede tener ningun caracter especial o estar vacio";
     $('#nombre').css('background-color', 'red');
   }
   if ( !ExpCadena.test( $("#apellido").val() ) ){
     alertas="Ningun campo puede tener ningun caracter especial o estar vacio";
     $('#apellido').css('background-color', 'red');
   }
   if ( !ExpCadena.test( $("#usuario").val() ) ){
     alertas="Ningun campo puede tener ningun caracter especial o estar vacio";
     $('#usuario').css('background-color', 'red');
   }
   if ( !ExpCadena.test( $("#password").val() ) ){
     alertas="Ningun campo puede tener ningun caracter especial o estar vacio";
     $('#password').css('background-color', 'red');
   }
   if ( !ExpCadena.test( $("#confirm_password").val() ) ){
     alertas="Ningun campo puede tener ningun caracter especial o estar vacio";
     $('#confirm_password').css('background-color', 'red');
   }
    if(alertas && ($('#password').val() != $('#confirm_password').val()))
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
