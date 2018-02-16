<?php require('header.php');?>
<body>

<?php
include 'session.php';

if(isset($_POST["fazerlogin"])){
$pass = md5($_POST["password"]);
$user = $_POST["username"];
}



$SQL="
	SELECT username, funcao, md5pass, avatar from Utilizador where username = '$user';
";

$resultado=mysqli_query($ligacao,$SQL);


if (mysqli_num_rows($resultado)==0) { 

	echo "<center><a href='registar.php'>Essa conta não existe, cria uma aqui!</a></center>";
}
else{
	while($tuplo = mysqli_fetch_array($resultado)) {
	 	$user = $tuplo["username"];
	 	$func = $tuplo["funcao"];
		$CheckPass = $tuplo["md5pass"];
		$avatar = $tuplo["avatar"];
	 	if($pass == $CheckPass){ //se user for legit
	 	echo "<b><center>Bem vindo $user, tem permissão $func! </center></b>";
	 	echo "<center><img src='http://alunos.deec.uc.pt/~jferreira/ProjectoTeste/html/images/avatars/" . $avatar . "' height='200' width='200'></center> ";

	 	$_SESSION["username"] = $user;
	 	$_SESSION["funcao"] = $func;
	 	$_SESSION["password"] = $CheckPass;
	 	echo "<center><a href='EditOwn.php'>Edita a tua conta aqui!</a></center>";

	 	if($func == "2"){ // SE FOR ADMIN
	 		echo "<center><a href='admin.php'>Funções de Admin</a></center>";
	 	}
	 	}
	 	else{
	 		echo $pass . " " . $CheckPass;
	 		echo "<b><center>Pass errada, por favor insira a pass correcta.</center></b>";
	 		echo "<center><a href='http://alunos.deec.uc.pt/~jferreira/ProjectoTeste/'>Regressar à pagina anterior</a></center>";
	 	}
	 }




mysqli_close($ligacao);
}
?>
	<!-- Bootstrap core JavaScript-->
	<script src="../vendor/jquery/jquery.min.js"></script>
  	<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  	<!-- Core plugin JavaScript-->
  	<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
</body>
</html>