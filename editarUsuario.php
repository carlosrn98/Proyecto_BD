<?php
  //echo"llego";
  include"config.php";
  $uploadDir='images/';
  $idUsuarioPrincipal=$_GET['idP'];
  $idUsuarioModificado=$_GET['id'];
  $username=$_GET['nom'];

  $link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link));
  mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database");

  if(isset($_POST['enterNombreUsr'])){
    $nuevoUsername=$_POST['nombreUsr'];
    $query="UPDATE pf_usuarios SET nombreUsr='$nuevoUsername' WHERE idUsuario=$idUsuarioModificado";
    mysqli_query($link, $query) or die("query failed");
  }
  else if(isset($_POST['enterNombre'])){
    $nuevoNombre=$_POST['nombre'];
    $query="UPDATE pf_usuarios SET nombre='$nuevoNombre' WHERE idUsuario=$idUsuarioModificado";
    mysqli_query($link, $query) or die("query failed");
  }
  else if(isset($_POST['enterApellido'])){
    $nuevoApellido=$_POST['apellido'];
    $query="UPDATE pf_usuarios SET apellido='$nuevoApellido' WHERE idUsuario=$idUsuarioModificado";
    mysqli_query($link, $query) or die("query failed");
  }
  else if(isset($_POST['enterEmail'])){
    $nuevoEmail=$_POST['email'];
    $query="UPDATE pf_usuarios SET email='$nuevoEmail' WHERE idUsuario=$idUsuarioModificado";
    mysqli_query($link, $query) or die("query failed");
  }
  else if(isset($_POST['enterFechaN'])){
    $nuevaFecha=$_POST['fechaN'];
    $query="UPDATE pf_usuarios SET fechaNacimiento='$nuevaFecha' WHERE idUsuario=$idUsuarioModificado";
    mysqli_query($link, $query) or die("query failed");
  }
  else if(isset($_POST['enterIm'])  ){
    $query="DELETE FROM pf_imagenesUsr WHERE idUsuario=$idUsuarioModificado";
    mysqli_query($link, $query) or die("query failed");
    $nombreImg=$username.'.jpg';
    $uploadDir.$_FILES['image']['name']=$nombreImg;
    $uploadFile=$uploadDir.$_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);
    $query="INSERT INTO pf_imagenesUsr(nombre, idUsuario) VALUES('$nombreImg', $idUsuarioModificado)";
    mysqli_query($link, $query) or die("query failed");
  }

  $query="SELECT nombreUsr FROM pf_usuarios WHERE idUsuario=$idUsuarioModificado";
  $result = mysqli_query($link, $query) or die("Query 5 failed");
  while($line = mysqli_fetch_assoc($result)){
    $nombreUsr=$line['nombreUsr'];
  }
  mysqli_free_result($result);

  @mysqli_close($link);
  //
  header("location: perfilUsuarioAdmin.php?idP=$idUsuarioPrincipal&id=$idUsuarioModificado&nom=$nombreUsr");
?>
