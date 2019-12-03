<?php
  include"config.php";

  $idUsuarioPrincipal=$_GET['idP'];
  $username=$_GET['nom'];

  $link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link));
  mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database");

  if(isset($_POST['enterNombreUsr'])){
    $nuevoUsername=$_POST['nombreUsr'];
    $query="UPDATE pf_usuarios SET nombre='$nuevoUsername' WHERE idUsuario=$idUsuarioPrincipal";
    mysqli_query($link, $query) or die("query failed");
  }

  @mysqli_close($link);
?>
