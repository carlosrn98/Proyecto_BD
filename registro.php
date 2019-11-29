<?php
  include"config.php";
  require_once "HTML/Template/ITX.php";

  $link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link));
  mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database");
  $query="SELECT curdate()";
  $result = mysqli_query($link, $query) or die("query failed");
  $line = mysqli_fetch_assoc($result);

  $template = new HTML_Template_ITX('./templates');
  $template->loadTemplatefile("inicio.html", true, true);
  $template->setVariable("TITULO", "Registro");
  $template->addBlockfile("CONTENIDO", "INICIO", "registrarse.html");
  $template->setVariable("maximo",$line['curdate()']);
  $template->touchBlock('INICIO');
  $template->parseCurrentBlock();

  $template->show();
  @mysqli_close($link);
?>
