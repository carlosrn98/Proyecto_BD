<?php
  include"config.php";
  $flag=0;
  $link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link));
  mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database");
  $query="SELECT nombreUsr, password, tipoUsuario, idUsuario FROM pf_usuarios";
  $result = mysqli_query($link, $query) or die("Query 1 failed");
  $usuario=$_POST['usuario'];
  $password=$_POST['passwrd'];
  while($line = mysqli_fetch_assoc($result)){
    if($line['nombreUsr']==$usuario && $line['password']==$password){
        $flag=$line['tipoUsuario'];
        $idUsuarioPrincipal=$line['idUsuario'];
        $username=$line['nombreUsr'];
    }
  }
  mysqli_free_result($result);
  if($flag==2){
    header("location: usuario.php?token=$idUsuarioPrincipal&nombre=$username");
  }
  else if($flag==1){
    header("location: admin.php");
  }
  else{
    header("location: index.php");
  }
?>
