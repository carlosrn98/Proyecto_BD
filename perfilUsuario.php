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
  $template->addBlockfile("CONTENIDO", "INICIO", "perfilUsuario.html");

  $query="SELECT * FROM pf_usuarios WHERE idUsuario=$id";
  $result = mysqli_query($link, $query) or die("query failed");
  while($line = mysqli_fetch_assoc($result)){
    $template->setCurrentBlock("NUsuario");
    //foto
    $template->setVariable("NOMBRE_USR", $line['nombreUsr']);
    $template->setVariable("NOMBRE", $line['nombre']);
    $template->setVariable("APELLIDO", $line['apellido']);
    $template->setVariable("EMAIL", $line['email']);
    $template->setVariable("FECHAN", $line['fechaNacimiento']);
    $template->setVariable("GENERO", $line['genero']);
    $template->setVariable("FECHAR", $line['fechaRegistro']);
    $template->setVariable("ID",$id);
    $template->setVariable("IDP",$idUsuarioPrincipal);
    
    $template->parseCurrentBlock("NUsuario");
  }
  mysqli_free_result($result);

  //query para sacar los posts
  $query="set sql_mode=''";
  $result = mysqli_query($link, $query) or die("Query 5 failed");
  mysqli_free_result($result);

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

  $template->touchBlock('INICIO');
  $template->parseCurrentBlock();

  @mysqli_close($link);
  $template->show();
?>
