function verificar(ele, ele1){

  if(ele==ele1)
    url='./matches.php';
  else
    url='./nomatches.php';
  var params="pass1="+ele+"&pass2="+ele1;

  $.ajax({
    url: url,
    dataType: 'html',
    type: 'POST',
    async: true,
    data: params,
    success:muestraContenido,
    error: funcionErrors
  });
  console.log(ele,ele1);
  return true;
}

function muestraContenido(result, status, xhr){
  console.log(result);
}

function funcionErrors(xhr, status, error){
  alert(xhr);
}
