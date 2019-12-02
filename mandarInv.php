<?php
  include"config.php";

  $idUsuarioPrincipal = $_GET['idP'];
  $idLugar=$_GET['idLugar'];
  $nombreLugar=$_GET['nomL'];
  $usuarioInvitado=$_POST['Personas'];

  $flag=0;

  $link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link));
  mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database");

  //query para saber el id del usuario al que se quiere invitar
  $query="SELECT idUsuario FROM pf_usuarios WHERE nombreUsr='$usuarioInvitado'";
  $result = mysqli_query($link, $query) or die("query failed");
  while($line = mysqli_fetch_assoc($result)){
    $idUsuarioInvitado=$line['idUsuario'];
  }
  mysqli_free_result($result);

  //query que verifica si el usuario al que se quiere invitar también sigue al usuario que invita
  $query="SELECT idUsuario FROM pf_contactos LEFT JOIN pf_usuarios USING(idUsuario) WHERE usuarioPrincipal=$idUsuarioInvitado";
  $result = mysqli_query($link, $query) or die("query failed");
  while($line = mysqli_fetch_assoc($result)){
    $flag=$line['idUsuario'];
  }
  mysqli_free_result($result);

  if($flag==$idUsuarioPrincipal){
    //query para sacar el idContacto
    $query="SELECT idContacto FROM pf_contactos WHERE usuarioPrincipal=$idUsuarioInvitado AND idUsuario=$idUsuarioPrincipal";
    $result = mysqli_query($link, $query) or die("query failed");
    while($line = mysqli_fetch_assoc($result)){
      $idContacto=$line['idContacto'];
    }
    mysqli_free_result($result);

    //inserción de invitacion
    $query="INSERT INTO pf_invitaciones(idLugar, idContacto, fecha) VALUES($idLugar, $idContacto, CURRENT_TIMESTAMP())";
    mysqli_query($link, $query) or die("query failed");
  }//if

  $query2="SELECT nombreUsr FROM pf_usuarios WHERE idUsuario=$idUsuarioPrincipal";
  $result = mysqli_query($link, $query2) or die("query failed");
  while($line = mysqli_fetch_assoc($result)){
    $username=$line['nombreUsr'];
  }
  mysqli_free_result($result);

  @mysqli_close($link);

  header("location: usuario.php?token=$idUsuarioPrincipal&nombre=$username");
?>
