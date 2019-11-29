$(document).ready(function(){
  var flag=0;
  var ExpCadena = /^[a-zñÑáéíóúÁÉÍÓÚ]+(\s[a-zñÑáéíóúÁÉÍÓÚ]+)*$/i;
  var regexemail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
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
   if($("input[name='genero']:checked").length <=0){
     alertas+="\nNo ha seleccionado genero";
     $('#genero').css('background-color', 'red');
   }
   if(!regexemail.test( $("#NuevoCorreo").val() )){
     alertas+="\nFavor de meter un correo con formato xx@xx.xx";
     $('#NuevoCorreo').css('background-color', 'red');
   }
   if ( ( $("#password").val() ) != $('#confirm_password').val()){
     alertas+="\nLas contrasenas tienen que coincidir";
     $('#password').css('background-color', 'red');
   }
    if(alertas)
      alert(alertas);
    else {
      var date = new Date($('#FN').val());
      day = date.getDate() + 1;
      month = date.getMonth() + 1;
      year = date.getFullYear();
      fecha=year+"-"+month+"-"+day;

      inpgenero=$("input[name='genero']:checked").val();

      var params="NuevoNmbr="+$("#nombre").val()+"&NuevoApe="+$("#apellido").val()+"&genero="+inpgenero+"&FN="+fecha;
      params+="&NuevoCorreo="+$("#NuevoCorreo").val()+"&NuevoUsr="+$("#usuario").val();
      params+="&passwrd1="+$("#password").val();

      url='./registrarusuario.php';

      $.ajax({
        url: url,
        dataType: 'html',
        type: 'POST',
        async: true,
        data: params,
        success:muestraContenido,
        error: funcionErrors
      });
    }
  });

  function muestraContenido(result, status, xhr){
    console.log(result);
    window.location.assign("./index.php");
  }

  function funcionErrors(xhr, status, error){
    alert(xhr);
  }

  $('#NuevoCorreo').on('keyup',function (){
    if(regexemail.test( $("#NuevoCorreo").val() )){
      $('#message2').html('Si es un email').css('color', 'green');
    }
    else
      $('#message2').html('NO es un email').css('color', 'red');
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
