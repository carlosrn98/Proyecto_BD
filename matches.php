<?php
  include"config.php";
  require_once "HTML/Template/ITX.php";

  $template = new HTML_Template_ITX('./templates');
  $template->loadTemplatefile("inicio.html", true, true);
  $template->setVariable("TITULO", "Registro");
  $template->addBlockfile("CONTENIDO", "INICIO", "registrarse.html");
  $template->touchBlock('INICIO');
  $template->setVariable("matches","es lo mismo");
  $template->parseCurrentBlock();
  $template->show();
?>
