<?php
  include"config.php";
  $id=$_POST['id'];
  $idUsuarioPrincipal=$_POST['idP'];

  $link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link));
  mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database");

  $query="INSERT INTO pf_contactos(usuarioPrincipal, idUsuario) VALUES($idUsuarioPrincipal, $id)";
  mysqli_query($link, $query) or die("query failed");

  @mysqli_close($link);
?>
