<?php
session_start();
date_default_timezone_set("Europe/Lisbon");
$username = "2013139657";
$password = "2013139657";
$basedados = "bd_2013139657";
$servidor = "delta.deec.uc.pt";
$ligacao=mysqli_connect($servidor,$username,$password);

@mysqli_select_db($ligacao,$basedados) or die( "Não foi possível seleccionar a BD");
if(!isset($_SESSION['username']) && empty($_SESSION['username'])) {
	    header('Location: http://alunos.deec.uc.pt/~jferreira/BDProj/');
}
else{

$user= $_SESSION["username"];
$func= $_SESSION["funcao"];
$pass = $_SESSION["password"];
$avatar= $_SESSION["avatar"];
$sSQL= 'SET CHARACTER SET utf8'; 
mysqli_query($ligacao,$sSQL) or die ('Can\'t charset in DataBase');
}
?>
