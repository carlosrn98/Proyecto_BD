$(document).ready(function(){
  var flag=0;
 $("#Registrarse").click(function (event){
   alert("existo");
 });

 $('#password, #confirm_password').on('keyup', function () {
   if ($('#password').val() == $('#confirm_password').val()){
     $('#message').html('Coinciden').css('color', 'green');
     flag=1;
   }
   else{
     $('#message').html('No coinciden').css('color', 'red');
     flag=0;
   }
    console.log(flag);
 });
});
