<?php
  include"config.php";
  require_once "HTML/Template/ITX.php";

  $idUsuarioPrincipal=$_GET['idP'];

  $template = new HTML_Template_ITX('./templates');
  $template->loadTemplatefile("inicio.html", true, true);

  $link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link));
  mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database");

  $template->setCurrentBlock("INICIO");
  $template->setVariable("TITULO", "Historial");
  $template->addBlockfile("CONTENIDO", "INICIO", "historial.html");


  $query="SELECT * FROM pf_historial WHERE idUsuario=$idUsuarioPrincipal ORDER BY fecha desc";
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
