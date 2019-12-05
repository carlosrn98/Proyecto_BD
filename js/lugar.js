$(document).ready(function(){
  var flag=0;
  var ExpCadena = /^[a-zñÑáéíóúÁÉÍÓÚ\s]+(\s[a-zñÑáéíóúÁÉÍÓÚ\s]+)*$/i;
  var regexcoor= /^[0-9.]+(\s[0-9.]+)*$/i;
 $("#agregar").click(function (e){
   alertas="";
   e.preventDefault();
   if ( !ExpCadena.test( $("#nombre").val() ) || $("#nombre").val() ==""){
     alertas="Ningun campo puede tener ningun caracter especial o estar vacio";
     $('#nombre').css('background-color', 'red');
   }
   else {
     $('#nombre').css('background-color', 'white');
   }
   if ( !regexcoor.test( $("#latitud").val() ) || $("#latitud").val() =="" ){
     alertas="Ningun campo puede tener ningun caracter especial o estar vacio";
     $('#latitud').css('background-color', 'red');
   }
   else {
     $('#latitud').css('background-color', 'white');
   }
   if ( !regexcoor.test( $("#longitud").val() ) || $("#longitud").val() ==""){
     alertas="Ningun campo puede tener ningun caracter especial o estar vacio";
     $('#longitud').css('background-color', 'red');
   }
   else {
     $('#longitud').css('background-color', 'white');
   }
   if ( !regexcoor.test( $("#categoria").val() ) || $("#categoria").val() ==""){
     alertas="Ningun campo puede tener ningun caracter especial o estar vacio";
     $('#categoria').css('background-color', 'red');
   }
   else {
     $('#categoria').css('background-color', 'white');
   }
   if(alertas)
     alert(alertas);
   else{
     var params="nombre="+$("#nombre").val()+"&descripcion="+$('#descripcion').val()+"&latitud="+$('#latitud').val();
     params+="&longitud="+$('#longitud').val()+"&categoria="+$('#categoria').val();
     params+="&nom="+nombreLT+"&idP="+idP;

     url='./agregarLugarBD.php';

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
});
