<?php
  include"config.php";

  $idUsuarioPrincipal=$_GET['idP'];
  $nombre=$_GET['nom'];

  $link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link));
  mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database");

  $nombreLugar=$_POST['nombre'];
  $desc=$_POST['descripcion'];
  $latitud=$_POST['latitud'];
  $longitud=$_POST['longitud'];
  $categoria=$_POST['categoria'];
  //print "$categoria";
  //query para buscar id de categoria
  $query="SELECT idCategoria FROM pf_categorias WHERE categoria='$categoria'";
  $result = mysqli_query($link, $query) or die("Query 3 failed");
  while($line = mysqli_fetch_assoc($result)){
    $idCategoria=$line['idCategoria'];
  }
  mysqli_free_result($result);

  $agregar="INSERT INTO pf_lugaresTuristicos(nombre, descripcion, latitud, longitud, idCategoria) VALUES('$nombreLugar','$desc',$latitud, $longitud, $idCategoria)";
  mysqli_query($link, $agregar) or die("Query B failed");

  header("location: admin.php?idP=$idUsuarioPrincipal&nombre=$nombre");

?>
