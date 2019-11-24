<?php
  include"config.php";
  require_once "HTML/Template/ITX.php";

  $template = new HTML_Template_ITX('./templates');
  $template->loadTemplatefile("inicio.html", true, true);

  $idUsuarioPrincipal=$_GET['idP'];
  $idLugar=$_GET['idLugar'];
  $nombreLugar=$_GET['nomL'];


  $link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link));
  mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database");

  $template->setVariable("TITULO", "$nombreLugar");
  $template->addBlockfile("CONTENIDO", "INICIO", "lugar.html");

  $query="SELECT nombreUsr FROM pf_usuarios WHERE idUsuario=$idUsuarioPrincipal";
  $result = mysqli_query($link, $query) or die("query failed");
  while($line = mysqli_fetch_assoc($result)){

    $username=$line['nombreUsr'];

  }
  mysqli_free_result($result);

  $query="SELECT * FROM pf_lugaresTuristicos LEFT JOIN pf_categorias USING(idCategoria) WHERE idLugar=$idLugar";
  $result = mysqli_query($link, $query) or die("query failed");
  while($line = mysqli_fetch_assoc($result)){
    $template->setCurrentBlock("NLugar");
    //foto
    $template->setVariable("NOMBRE_LUGAR", $line['nombre']);
    $template->setVariable("DESC", $line['descripcion']);
    $template->setVariable("LATITUD", $line['latitud']);
    $template->setVariable("LONGITUD", $line['longitud']);
    $template->setVariable("CATEGORIA", $line['categoria']);
    $template->setVariable("IDP", $idUsuarioPrincipal);
    $template->setVariable("IDL", $line['idLugar']);
    $template->setVariable("NOMBRE_USR", $username);

    $template->parseCurrentBlock("NLugar");
  }
  mysqli_free_result($result);



  $template->touchBlock('INICIO');
  $template->parseCurrentBlock();

  @mysqli_close($link);
  $template->show();
?>
