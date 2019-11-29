<?php
  include"config.php";
  require_once "HTML/Template/ITX.php";

  $idUsuarioPrincipal=$_GET['idP'];

  $template = new HTML_Template_ITX('./templates');
  $template->loadTemplatefile("inicio.html", true, true);

  $link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link));
  mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database");

  $template->setCurrentBlock("INICIO");
  $template->setVariable("TITULO", "Invitaciones");
  $template->addBlockfile("CONTENIDO", "INICIO", "invitaciones.html");


  $query="SELECT nombreUsr, idLugar, fecha, pf_lugaresTuristicos.nombre AS nombreL FROM pf_lugaresTuristicos RIGHT JOIN pf_invitaciones USING(idLugar) JOIN pf_contactos USING(idContacto ) LEFT JOIN pf_usuarios USING(idUsuario) WHERE usuarioPrincipal = $idUsuarioPrincipal AND idInvitacion IS NOT NULL";
  $result = mysqli_query($link, $query) or die("Query 2 failed");
  while($line = mysqli_fetch_assoc($result)){
    $template->setCurrentBlock("NInvitaciones");

    $template->setVariable("NOMBRE_USR", $line['nombreUsr']);
    $template->setVariable("NOMBRE_LUGAR", $line['nombreL']);
    $template->setVariable("FECHA", $line['fecha']);
    $template->setVariable("IDL", $line['idLugar']);
    $template->setVariable("IDP", $idUsuarioPrincipal);
    
    $template->parseCurrentBlock("NInvitaciones");
  }
  mysqli_free_result($result);

  $template->touchBlock("INICIO");
  $template->parseCurrentBlock();

  @mysqli_close($link);
  $template->show();
?>
