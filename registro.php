<?php
  include"config.php";
  require_once "HTML/Template/ITX.php";

  $flag=0;

  $template = new HTML_Template_ITX('./templates');
  $template->loadTemplatefile("inicio.html", true, true);
  $template->setVariable("TITULO", "Registro");
  $template->addBlockfile("CONTENIDO", "INICIO", "registrarse.html");
  $template->touchBlock('INICIO');
  $template->parseCurrentBlock();


  $nombre=$_POST['NuevoNmbr'];
  $apellido=$_POST['NuevoApe'];
  $genero=$_POST['genero'];
  $fechaN=$_POST['FN'];
  $correo=$_POST['NuevoCorreo'];
  $usuario=$_POST['NuevoUsr'];
  $passwrd1=$_POST['passwrd1'];
  $passwrd2=$_POST['passwrd2'];

  $template->setVariable("funcionregistro","verifica($nombre,$apellido,$correo,$usuario,$passwrd1,$passwrd2)");

  // $link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link));
  // mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database");
  // $query="INSERT INTO pf_usuarios(nombre, apellido, email, nombreUsr, password, fechaNacimiento, genero, fechaRegistro, tipoUsuario) VALUES('$nombre', '$apellido', '$correo','$usuario', '$passwrd1', '$fechaN', '$genero', CURRENT_DATE(), 2)";
  //
  // if(mysqli_query($link, $query)==TRUE){
  //   $query="SELECT idUsuario FROM pf_usuarios WHERE nombreUsr='$usuario'";
  //   $result = mysqli_query($link, $query) or die("Query 4 failed");
  //
  //   while($line = mysqli_fetch_assoc($result)){
  //     $idUsuarioPrincipal=$line['idUsuario'];
  //   }
  //   mysqli_free_result($result);
  //   $query="INSERT INTO pf_contactos(usuarioPrincipal, idUsuario) VALUES($idUsuarioPrincipal, $idUsuarioPrincipal)";
  //   mysqli_query($link, $query);
  //   header("location: index.php");
  // }
  //
  //
  // @mysqli_close($link);


  $template->show();
?>
