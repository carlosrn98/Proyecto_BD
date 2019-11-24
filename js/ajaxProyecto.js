function seguirU(ele, ele1){
  var params="id="+ele+"&idP="+ele1;

  url='./seguirUsuario.php'

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

function goBack(){
  location.replace(document.referrer);
}


function muestraContenido(result, status, xhr){
  console.log(result);
}

function funcionErrors(xhr, status, error){
  alert(xhr);
}
