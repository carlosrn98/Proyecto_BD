function confirmarpasswrd(cadena1,cadena2){
  var params="pass="+cadena1+"&confirm="+cadena2;

  url='./confirmar.php';

  $.ajax({
    url: url,
    dataType: 'html',
    type: 'POST',
    async: true,
    data: params,
    success:muestraContenido,
    error: funcionErrors
  });
  console.log(params);
  return true;
}

function muestraContenido(result, status, xhr){
  console.log(result);
}

function funcionErrors(xhr, status, error){
  alert(xhr);
}
