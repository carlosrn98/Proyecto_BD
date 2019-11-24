<?php
  include"config.php";
  require_once "HTML/Template/ITX.php";

  $template = new HTML_Template_ITX('./templates');
  $template->loadTemplatefile("inicio.html", true, true);

	$template->setVariable("TITULO", "Los Lugareños");
	$template->addBlockfile("CONTENIDO", "INICIO", "login.html");
	$template->touchBlock('INICIO');
	$template->parseCurrentBlock();
  $template->show();
?>
