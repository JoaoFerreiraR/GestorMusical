<html lang="pt">
<head>
 	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  	<meta name="description" content="Projeto de Base de Dados">
  	<meta name="author" content="José Castanheira João Ferreira Base de Dados">
  	<title>Bem-vindo!</title>
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
      <div class="card-header">Registo</div>
      <div class="card-body">
        <form action="registado.php" method="POST">
          <div class="form-group">
            <label for="exampleInputUsername1">Username:</label>
            <input class="form-control" id="exampleInputUsername1" type="text" aria-describedby="usernameHelp" name="username" placeholder="Introduza o seu novo username" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password:</label>
            <input class="form-control" id="exampleInputPassword1" type="password" name="password" placeholder="Introduza a sua nova password" required>
		  </div>
		  <div class="form-group">
            <label for="exampleInputBirthDate">Data de nascimento:</label>
            <input class="form-control" id="exampleInputBirthDate" type="DATE" name="dataNascimento"  required>
          </div>
          <input class="btn btn-primary btn-block"  type="submit" name="fazerlogin" value="Registar">
        </form>
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
