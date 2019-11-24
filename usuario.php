<?php
  include"config.php";
  require_once "HTML/Template/ITX.php";

  $template = new HTML_Template_ITX('./templates');
  $template->loadTemplatefile("inicio.html", true, true);
  $username=$_GET['nombre'];

  $template->setCurrentBlock("INICIO");
  $template->setVariable("TITULO", "Página de $username");
  $template->addBlockfile("CONTENIDO", "INICIO", "usuario.html");
  $idUsuarioPrincipal=$_GET['token'];

  $link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link));
  mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database");

  if(isset($_POST['enter'])){
    $usernameSearch=$_POST['Personas'];
    $query="SELECT idUsuario, nombreUsr FROM pf_usuarios WHERE nombreUsr='$usernameSearch'";
    $result = mysqli_query($link, $query) or die("Query 2 failed");
    while($line = mysqli_fetch_assoc($result)){
      $id=$line['idUsuario'];
      $user=$line['nombreUsr'];
    }
    mysqli_free_result($result);

    header("location: perfilUsuario.php?idP=$idUsuarioPrincipal&id=$id&nom=$user");
  }
  else{
    $query = "SELECT nombre, apellido, nombreUsr, idUsuario FROM pf_usuarios";
    $result = mysqli_query($link, $query) or die("Query 2 failed");
    while($line = mysqli_fetch_assoc($result)){
      $template->setCurrentBlock("NPersonas");

      $template->setVariable("USUARIOS_NOMBRE", $line['nombre']);
      $template->setVariable("USUARIOS_APELLIDO", $line['apellido']);
      $template->setVariable("NOMBRE_USR", $line['nombreUsr']);
      $template->setVariable("ID", $line['idUsuario']);

      $template->parseCurrentBlock("NPersonas");
    }
    mysqli_free_result($result);

    $query = "SELECT nombre FROM pf_lugaresTuristicos";
    $result = mysqli_query($link, $query) or die("Query 3 failed");
    while($line = mysqli_fetch_assoc($result)){
      $template->setCurrentBlock("NLugares");

      $template->setVariable("LUGARES_NOMBRE", $line['nombre']);

      $template->parseCurrentBlock("NLugares");
    }
    mysqli_free_result($result);

    //query para sacar los contactos del usuario
    $query = "SELECT nombre, apellido, nombreUsr, idUsuario FROM pf_contactos LEFT JOIN pf_usuarios USING(idUsuario) WHERE usuarioPrincipal=$idUsuarioPrincipal AND NOT idUsuario=$idUsuarioPrincipal";
    $result = mysqli_query($link, $query) or die("Query 4 failed");
    while($line = mysqli_fetch_assoc($result)){
      $template->setCurrentBlock("NContactos");

      $template->setVariable("USUARIOS_NOMBRE", $line['nombre']);
      $template->setVariable("USUARIOS_APELLIDO", $line['apellido']);
      $template->setVariable("NOMBRE_USR", $line['nombreUsr']);
      $template->setVariable("ID", $line['idUsuario']);
      $template->setVariable("IDP", $idUsuarioPrincipal);

      $template->parseCurrentBlock("NContactos");
    }
    mysqli_free_result($result);
    //fin del query para los contactos

    //query para sacar los posts
    $query = "SELECT pf_usuarios.nombre AS nombreU, apellido, fecha, nombreUsr, pf_usuarios.idUsuario AS idU, comentario, pf_lugaresTuristicos.nombre AS nombreL, descripcion FROM pf_usuarios RIGHT JOIN pf_contactos ON pf_usuarios.idUsuario=pf_contactos.idUsuario RIGHT JOIN pf_posts ON  pf_contactos.idUsuario= pf_posts.idUsuario LEFT JOIN pf_lugaresTuristicos USING(idLugar) WHERE usuarioPrincipal=$idUsuarioPrincipal ORDER BY fecha desc";
    $result = mysqli_query($link, $query) or die("Query 5 failed");
    while($line = mysqli_fetch_assoc($result)){
      $template->setCurrentBlock("NPosts");

      $template->setVariable("USUARIOS_NOMBRE", $line['nombreU']);
      $template->setVariable("USUARIOS_APELLIDO", $line['apellido']);
      $template->setVariable("NOMBRE_USR", $line['nombreUsr']);
      $template->setVariable("COMENTARIO", $line['comentario']);
      $template->setVariable("LUGAR_NOMBRE", $line['nombreL']);
      $template->setVariable("LUGAR_DESCRIPCION", $line['descripcion']);
      $template->setVariable("ID", $line['idU']);
      $template->setVariable("IDP", $idUsuarioPrincipal);
      $template->setVariable("FECHA", $line['fecha']);

      $template->parseCurrentBlock("NPosts");
    }
    mysqli_free_result($result);
    //fin del query de posts
    $template->setCurrentBlock("INICIO");
    $template->setVariable("NOMBRE_USR", "$username");
    $template->setVariable("ID", $idUsuarioPrincipal);
    $template->setVariable("IDP", $idUsuarioPrincipal);
    $template->parseCurrentBlock();

  }//else
  @mysqli_close($link);
  $template->show();
?>
