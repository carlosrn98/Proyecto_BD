<?php
  include"config.php";
  $link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link));
  mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database");
  $idU=$_POST['idP'];
  $idLugar=$_POST['idL'];
  $cali=$_POST['cali'];
  $query="INSERT INTO pf_calificaciones(calificacion,idLugar,idUsuario) VALUES ($cali,$idU,$idLugar)";
  $result = mysqli_query($link, $query) or die("query failed");
  @mysqli_close($link);
?>
