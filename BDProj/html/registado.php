<html lang="pt">
<head>
 	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  	<meta name="description" content="Projeto de Base de Dados">
  	<meta name="author" content="José Castanheira João Ferreira Base de Dados">
  	<title>Registado!</title>
  	<!-- Bootstrap core CSS-->
  	<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  	<!-- Custom fonts for this template-->
  	<link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  	<!-- Custom styles for this template-->
  	<link href="../css/sb_admin/sb-admin.css" rel="stylesheet">
</head>
<body class="bg-dark">
<div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Registado</div>
      <div class="card-body">
      	<?php
$username = "2013139657";
$password = "2013139657";
$basedados = "bd_2013139657";
$servidor = "delta.deec.uc.pt";
$ligacao=mysqli_connect($servidor,$username,$password);
@mysqli_select_db($ligacao,$basedados) or die( "Não foi possível seleccionar a BD");


$sSQL= 'SET CHARACTER SET utf8'; 
mysqli_query($ligacao,$sSQL) or die ('Can\'t charset in DataBase');

$USER = $_POST["username"];
$pass = md5($_POST["password"]);
$DataNasc = $_POST["dataNascimento"];

$SQL="	SELECT username, funcao from Utilizador where username = '$USER';";
$Registar="INSERT INTO Utilizador(username,md5pass,avatar,DataNascimento,funcao) values('$USER','$pass','defaultavatar.jpg','$DataNasc','0');";

$resultado=mysqli_query($ligacao,$SQL);
if($resultado->num_rows >= 1){
	echo "<b><center>Já existe um utilizador com esse username !</center></b>";
 	echo "<center><a href='registar.php'>Clica aqui para regressares à pagina anterior.</a></center>";
}else{
	mysqli_query($ligacao,$Registar);
	$resultado=mysqli_query($ligacao,$SQL);
	if($resultado){
	 while($tuplo = mysqli_fetch_array($resultado)) {
	 	$user = $tuplo["username"];
	 	$func = $tuplo["funcao"];
	 	echo "<b><center>Ficou registado com o nome: $user!</center></b>";
	 }
	}
}
mysqli_close($ligacao);
?>
          <a class="btn btn-primary btn-block" href="../index.php">Voltar ao login</a>
      </div>
    </div>
  </div>
  	<!-- Bootstrap core JavaScript-->
	<script src="../vendor/jquery/jquery.min.js"></script>
  	<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  	<!-- Core plugin JavaScript-->
  	<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
</body>
</html>
