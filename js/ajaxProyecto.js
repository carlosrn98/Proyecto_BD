function seguirU(ele, ele1){
  var params="id="+ele+"&idP="+ele1;

  url='./seguirUsuario.php';

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

$(document).ready(function(){
$(".my-rating").starRating({
    starSize: 25,
    callback: function(currentRating, $el){
        // make a server call here
    }
});
});

function cambiarseguir(elemento){
  if(elemento.value==="Seguir")
    elemento.value="Dejar de seguir";
  else
    elemento.value="Seguir";
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
