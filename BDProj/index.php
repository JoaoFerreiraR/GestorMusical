<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Projeto de Base de Dados">
  <meta name="author" content="José Castanheira João Ferreira Base de Dados">
  <title>Login</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb_admin/sb-admin.css" rel="stylesheet">
</head>


<body class="bg-dark">

<?php
session_start();
date_default_timezone_set("Europe/Lisbon");
$username = "2013139657";
$password = "2013139657";
$basedados = "bd_2013139657";
$servidor = "delta.deec.uc.pt";
$ligacao=mysqli_connect($servidor,$username,$password);

@mysqli_select_db($ligacao,$basedados) or die( "Não foi possível seleccionar a BD"); 







?>

<div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="bg-danger text-white text-center">
      <?php 
if(isset($_POST["fazerlogin"])){
  $user=$_POST["username"];
  $pass=md5($_POST["password"]);
  $SQL=" SELECT username, funcao, md5pass, avatar from Utilizador where username = '$user'; ";

  $resultado = mysqli_query($ligacao,$SQL);

  if (mysqli_num_rows($resultado)==0) { //nao existe esse user
    echo "Esse Utilizador Não existe.";
  } else {
    while($tuplo = mysqli_fetch_array($resultado)) {
      $user = $tuplo["username"];
      $func = $tuplo["funcao"];
      $CheckPass = $tuplo["md5pass"];
      $avatar = $tuplo["avatar"];
      if($pass!=$CheckPass) echo "Palavra Passe Errada!";
      if($pass==$CheckPass){
        $_SESSION["username"]=$user;
        $_SESSION["funcao"]=$func;
        $_SESSION["password"]=$pass;
        $_SESSION["avatar"]=$avatar;


        header('Location: http://alunos.deec.uc.pt/~jferreira/BDProj/html/dashboard.php');
      }  
}


}
}?>
</div>




      <div class="card-header">Faça login com as suas credenciais</div>
      <div class="card-body">
        <form action="" method="POST">
          <div class="form-group">
            <label for="exampleInputEmail1">Username:</label>
            <input class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" name="username" placeholder="Introduza o seu username" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password:</label>
            <input class="form-control" id="exampleInputPassword1" type="password" name="password" placeholder="Introduza a sua password" required>
          </div>
         
          <input class="btn btn-primary btn-block"  type="submit" name="fazerlogin" value="Entrar">
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="html/registar.php">Não tem conta? Crie aqui!</a>
        </div>
      </div>
    </div>
  </div>
	<!-- Bootstrap core JavaScript-->
	<script src="vendor/jquery/jquery.min.js"></script>
  	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  	<!-- Core plugin JavaScript-->
  	<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>
</html>
