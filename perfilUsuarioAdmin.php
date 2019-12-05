<?php
  include"config.php";
  require_once "HTML/Template/ITX.php";

  $id=$_GET['id'];
  $username=$_GET['nom'];
  $idUsuarioPrincipal=$_GET['idP'];

  $template = new HTML_Template_ITX('./templates');
  $template->loadTemplatefile("inicio.html", true, true);

  $link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link));
  mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database");

  $template->setVariable("TITULO", "$username");
  $template->addBlockfile("CONTENIDO", "INICIO", "perfilUsuarioAdmin.html");

  $query="SELECT * FROM pf_usuarios LEFT JOIN pf_tiposUsuario USING(tipoUsuario) WHERE idUsuario=$id";
  $result = mysqli_query($link, $query) or die("query failed");
  $line = mysqli_fetch_assoc($result);
  $template->setCurrentBlock("NUsuario");
  //foto
  $template->setVariable("NOMBRE_USR", $line['nombreUsr']);
  $template->setVariable("NOMBRE", $line['nombre']);
  $template->setVariable("APELLIDO", $line['apellido']);
  $template->setVariable("EMAIL", $line['email']);
  $template->setVariable("FECHAN", $line['fechaNacimiento']);
  $template->setVariable("GENERO", $line['genero']);
  $template->setVariable("FECHAR", $line['fechaRegistro']);
  $template->setVariable("TIPO", $line['tipo']);
  $template->setVariable("IDP", $idUsuarioPrincipal);
  $template->setVariable("NOMBRE_USR", $username);
  $template->setVariable("ID", $id);

  $template->parseCurrentBlock("NUsuario");

  mysqli_free_result($result);
  $flag=0;

  //query para sacar los posts
  $query="set sql_mode=''";
  $result = mysqli_query($link, $query) or die("Query 5 failed");

  $query = "SELECT  fecha, nombreUsr, pf_usuarios.idUsuario AS idU, comentario, pf_lugaresTuristicos.nombre AS nombreL, descripcion FROM pf_usuarios RIGHT JOIN pf_contactos ON pf_usuarios.idUsuario=pf_contactos.idUsuario RIGHT JOIN pf_posts ON  pf_contactos.idUsuario= pf_posts.idUsuario LEFT JOIN pf_lugaresTuristicos USING(idLugar) WHERE pf_contactos.idUsuario=$id GROUP BY idPost ORDER BY fecha desc";
  $result = mysqli_query($link, $query) or die("Query 5 failed");
  while($line = mysqli_fetch_assoc($result)){
    $template->setCurrentBlock("NPosts");


    $template->setVariable("COMENTARIO", $line['comentario']);
    $template->setVariable("LUGAR_NOMBRE", $line['nombreL']);
    $template->setVariable("LUGAR_DESCRIPCION", $line['descripcion']);
    $template->setVariable("ID", $line['idU']);
    $template->setVariable("IDP", $idUsuarioPrincipal);
    $template->setVariable("FECHA", $line['fecha']);

    $template->parseCurrentBlock("NPosts");
  }
  mysqli_free_result($result);

  //query para sacar el historial
  $query="SELECT * FROM pf_historial WHERE idUsuario=$id ORDER BY fecha desc";
  $result = mysqli_query($link, $query) or die("Query 2 failed");
  while($line = mysqli_fetch_assoc($result)){
    $template->setCurrentBlock("NHistorial");

    $template->setVariable("FECHA", $line['fecha']);
    $template->setVariable("BUSQUEDA", $line['busqueda']);

    $template->parseCurrentBlock("NHistorial");
  }
  mysqli_free_result($result);

  $template->touchBlock('INICIO');
  $template->parseCurrentBlock();

  @mysqli_close($link);
  $template->show();
?>
