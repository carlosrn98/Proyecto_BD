<?php
  include"config.php";
  require_once "HTML/Template/ITX.php";

  $template = new HTML_Template_ITX('./templates');
  $template->loadTemplatefile("inicio.html", true, true);
  $username=$_GET['nombre'];

  $lugarSearch=$_POST['Lugares'];

  $template->setCurrentBlock("INICIO");
  $template->setVariable("TITULO", "Admin $username");
  $template->addBlockfile("CONTENIDO", "INICIO", "admin.html");

  $idUsuarioPrincipal=$_GET['idP'];

  $flag=0;
  $flagL=0;

  $link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link));
  mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database");

  if(isset($_POST['enter'])){
    $usernameSearch=$_POST['Personas'];
    $query="SELECT idUsuario, nombreUsr FROM pf_usuarios WHERE nombreUsr='$usernameSearch'";
    $result = mysqli_query($link, $query) or die("Query 2 failed");
    while($line = mysqli_fetch_assoc($result)){
      $flag=1;
      $id=$line['idUsuario'];
      $user=$line['nombreUsr'];
    }
    mysqli_free_result($result);

    if($flag==1){
      //query que agrega busqueda en historial
      $query="INSERT INTO pf_historial(fecha, idUsuario, busqueda) VALUES(CURRENT_TIMESTAMP(), $idUsuarioPrincipal, '$user')";
      mysqli_query($link, $query) or die("Query 2 failed");
    }//if


    header("location: perfilUsuarioAdmin.php?idP=$idUsuarioPrincipal&id=$id&nom=$user");
  }//if
  else if(isset($_POST['enterL'])){
    $query="SELECT idLugar, nombre FROM pf_lugaresTuristicos WHERE nombre='$lugarSearch'";
    $result = mysqli_query($link, $query) or die("Query 2 failed");
    while($line = mysqli_fetch_assoc($result)){
      $flagL=1;
      $idLugar=$line['idLugar'];
      $nombreLugar=$line['nombre'];
    }
    mysqli_free_result($result);

    if($flagL==1){
      //query que agrega busqueda en historial
      $query="INSERT INTO pf_historial(fecha, idUsuario, busqueda) VALUES(CURRENT_TIMESTAMP(), $idUsuarioPrincipal, '$nombreLugar')";
      mysqli_query($link, $query) or die("Query 2 failed");
    }//if

    header("location: lugar.php?idP=$idUsuarioPrincipal&idLugar=$idLugar&nomL=$nombreLugar");
  }
  else{
    $query = "SELECT nombre, apellido, nombreUsr, idUsuario, tipo FROM pf_usuarios LEFT JOIN pf_tiposUsuario USING(tipoUsuario)";
    $result = mysqli_query($link, $query) or die("Query 2 failed");
    while($line = mysqli_fetch_assoc($result)){
      $template->setCurrentBlock("NPersonas");

      $template->setVariable("USUARIOS_NOMBRE", $line['nombre']);
      $template->setVariable("USUARIOS_APELLIDO", $line['apellido']);
      $template->setVariable("NOMBRE_USR", $line['nombreUsr']);
      $template->setVariable("TIPO", $line['tipo']);
      $template->setVariable("ID", $line['idUsuario']);

      $template->parseCurrentBlock("NPersonas");
    }
    mysqli_free_result($result);

    $query = "SELECT nombre, categoria FROM pf_lugaresTuristicos LEFT JOIN pf_categorias USING(idCategoria)";
    $result = mysqli_query($link, $query) or die("Query 3 failed");
    while($line = mysqli_fetch_assoc($result)){
      $template->setCurrentBlock("NLugares");

      $template->setVariable("LUGARES_NOMBRE", $line['nombre']);
      $template->setVariable("CATEGORIA", $line['categoria']);

      $template->parseCurrentBlock("NLugares");
    }
    mysqli_free_result($result);


    //query para sacar los posts
    $query = "SELECT idLugar, pf_usuarios.nombre AS nombreU, apellido, fecha, nombreUsr, pf_usuarios.idUsuario AS idU, comentario, pf_lugaresTuristicos.nombre AS nombreL, descripcion FROM pf_usuarios RIGHT JOIN pf_contactos ON pf_usuarios.idUsuario=pf_contactos.idUsuario RIGHT JOIN pf_posts ON  pf_contactos.idUsuario= pf_posts.idUsuario LEFT JOIN pf_lugaresTuristicos USING(idLugar) GROUP BY idPost ORDER BY fecha desc";
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
      $template->setVariable("IDL", $line['idLugar']);

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
