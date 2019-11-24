function verifica(nombre,apellido,correo,usuario,pass1,pass2){
  var params="nombre="+nombre+"&apellido="+apellido+"&correo"+correo+"&usuario"+usuario+"&pass1"+pass1+"&pass2"+pass2;

  url='./registraenBD.php';
  if(nombre.includes("\'")||apellido.includes("\',\"")||correo.includes("\',\"")||pass1.includes("\',\"")||pass2.includes("\',\""))
    alert("Ninguno de los campos puede contener comillas");

  $.ajax({
    url: url,
    dataType: 'html',
    type: 'POST',
    async: true,
    data: params,
    success:muestraContenido,
    error: funcionErrors
  });
  console.log(nombre);
  return true;
}

function muestraContenido(result, status, xhr){
  console.log(result);
}

function funcionErrors(xhr, status, error){
  alert(xhr);
}
