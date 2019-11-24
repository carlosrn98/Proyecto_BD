<?php
  include"config.php";

  $idUsuarioPrincipal=$_GET['idP'];
  $idLugar=$_GET['idL'];
  $nombreLugar=$_GET['nomL'];
  $comentario=$_POST['comentario'];
  $username=$_GET['nom'];

  $link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link));
  mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database");
  $query = "INSERT INTO pf_posts(comentario, idLugar, idUsuario, fecha) VALUES('$comentario', $idLugar, $idUsuarioPrincipal, CURRENT_TIMESTAMP)";
  $result = mysqli_query($link, $query) or die("Query 3 failed");

  @mysqli_close($link);
  header("location: usuario.php?token=$idUsuarioPrincipal&nombre=$username");
?>
