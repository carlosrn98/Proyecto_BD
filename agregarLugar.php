<?php
  include"config.php";
  require_once "HTML/Template/ITX.php";

  $template = new HTML_Template_ITX('./templates');
  $template->loadTemplatefile("inicio.html", true, true);

  $link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link));
  mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database");

  $idUsuarioPrincipal=$_GET['idP'];
  $nombre=$_GET['nom'];

  $template->setCurrentBlock("INICIO");
  $template->setVariable("TITULO", "Agregar lugar");
  $template->addBlockfile("CONTENIDO", "INICIO", "agregarLugar.html");

  $template->setCurrentBlock('NUsuario');
  $template->setVariable("IDP", $idUsuarioPrincipal);
  $template->setVariable("NOMBRE_USR", $nombre);
  $template->parseCurrentBlock('NUsuario');

  $query = "SELECT categoria FROM pf_categorias";
  $result = mysqli_query($link, $query) or die("Query 3 failed");
  while($line = mysqli_fetch_assoc($result)){
    $template->setCurrentBlock("NCategoria");

    $template->setVariable("CATEGORIA", $line['categoria']);

    $template->parseCurrentBlock("NCategoria");
  }
  mysqli_free_result($result);


  $template->touchBlock('INICIO');
  $template->parseCurrentBlock();

  @mysqli_close($link);
  $template->show();
?>
