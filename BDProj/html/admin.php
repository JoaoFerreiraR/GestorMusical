<?php

include 'session.php';

/* PORQUE É QUE O FORM ACABA NOS UTILIZADORES E NÃO NO NOME DA BANDA? SENDO ASSIM COMECEM UM NOVO FORM A SEGUIR (FOI O QUE FIZ THO) */
/* TENHAM CUIDADO COMO FECHAM OS ELEMENTOS NOS ECHOS, TEM QUE HAVER UMA HERARQUIA. NÃO É FECHAR QUANDO SE LEMBRAM DE TAL */
/* ALBUNS NÃO ESTÃO A APARECER */

$SQL="
	SELECT username, funcao, md5pass, avatar from Utilizador where username = '$user';
";

$resultado = mysqli_query($ligacao,$SQL);

	if (mysqli_num_rows($resultado)==0) { 
	    echo "Erro!";
    } else {
	    while($tuplo = mysqli_fetch_array($resultado)) {
	 	    $user = $tuplo["username"];
	 	    $func = $tuplo["funcao"];
		    $CheckPass = $tuplo["md5pass"];
			$avatar = $tuplo["avatar"];
	   }
	}
?>
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

	<body class="fixed-nav sticky-footer bg-dark" id="page-top">
		<!-- Navigation-->
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
			<a class="navbar-brand" href="dashboard.php">Base de Dados</a>
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive"
			    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
					<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
						<a class="nav-link" href="dashboard.php">
							<i class="fa fa-fw fa-dashboard"></i>
							<span class="nav-link-text">Dashboard</span>
						</a>
					</li>
					<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
						<a class="nav-link" href="tables.html">
							<i class="fa fa-fw fa-table"></i>
							<span class="nav-link-text">Tables</span>
						</a>
					</li>
					<?php
						if($pass == $CheckPass){ //se user for legit
							$_SESSION["username"] = $user;
							$_SESSION["funcao"] = $func;
							$_SESSION["password"] = $CheckPass;
							echo "<li class='nav-item' data-toggle='tooltip' data-placement='right' title='Link'>
								<a class='nav-link' href='EditOwn.php'>
									<i class='fa fa-fw fa-pencil'></i>
									<span class='nav-link-text'>Editar conta</span>
								</a>
							</li>";

							/* <a href='EditOwn.php'>Edita a tua conta aqui!</a><br> */
			
							
							if($func == "2"){ // SE FOR ADMIN
								echo "<li class='nav-item' data-toggle='tooltip' data-placement='right' title='Link'>
								<a class='nav-link' href='admin.php'>
									<i class='fa fa-fw fa-lock'></i>
									<span class='nav-link-text'>Funções de administrador</span>
								</a>
							</li>";
							}
						}
					?>
				</ul>
				<ul class="navbar-nav sidenav-toggler">
					<li class="nav-item">
						<a class="nav-link text-center" id="sidenavToggler">
							<i class="fa fa-fw fa-angle-left"></i>
						</a>
					</li>
				</ul>
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" data-toggle="modal" data-target="#exampleModal">
							<i class="fa fa-fw fa-sign-out"></i>Logout</a>
					</li>
				</ul>
			</div>
		</nav>
		<div class="content-wrapper">
			<div class="container-fluid">
				<!-- Breadcrumbs-->
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="#">Dashboard</a>
					</li>
					<li class="breadcrumb-item active">Funções do administrator</li>
				</ol>
				<div class="row">
					<div class="col-lg-4">
						<div class="card mb-3">
							<div class="card-header">
								<i class="fa fa-unlock-alt"></i> Editar funções
							</div>
							<div class="card-body">
								<?php
									if(isset($_SESSION['username']) || !empty($_SESSION['username'])) { //se tiver sessão iniciada
										if($func != '2'){
											echo "<center> Nao tem permissoes de admin!<center>";
										}
										else{
											$SQLUSERS = "SELECT username from Utilizador where username != '$user';";
											$SQLCONCERTS = "SELECT Nome,IDConcerto from Concerto;";
											$SQLBANDS = "SELECT NomeBanda from Banda;";
											$SQLALBUMS = "SELECT Nome, IDAlbum from Album;"; // DEPOIS FAZER QUERY DAS MÚSICAS DO ALBUM
											$SQLEDITS = "SELECT Nome, IDEditora from Editora;";
											$SQLINST = "SELECT Nome, ID from Instrumento;";
											$SQLART = "SELECT IDArtista, NomeCompleto from Artista;";
								?>
								
									<?php
										//DROPDOWN USERNAMES
										if(isset($_POST["deleteuser"])){
											$IDUSER= $_POST["listausers"];
											if ($IDUSER == 'root') 
												echo "<center>este user não pode ser eliminado.</center>";
											else {
												$SQLDeleteUser = "DELETE from Utilizador where username= '$IDUSER';";
												mysqli_query($ligacao,$SQLDeleteUser);
												echo "<center>Eliminou com sucesso o utilizador.</center>";
											}
										}
										$resultado=mysqli_query($ligacao,$SQLUSERS);
										echo "<form action='' method='POST'>
												<div class='form-group'>
													<label for='exampleInputUsers1'>Utilizadores:</label><br>";
										
										if(mysqli_num_rows($resultado)){
											$select= '<select id="exampleInputUsers1" class="form-control form-control-sm" name="listausers">';
											while($rs=mysqli_fetch_array($resultado)){
												$select.='<option value="'.$rs['username'].'">'.$rs['username'].'</option>';
											}
										}
										$select.='</select><br><input class="btn btn-primary btn-block" type="submit" name="deleteuser" value="Apagar User"></div></form><hr>';
										echo $select;
										//END DROPDOWNUSERNAMES


										//DROP DOWN CONCERTOS
										$resultado=mysqli_query($ligacao,$SQLCONCERTS);
										echo "<form action='' method='POST'>
												<div class='form-group'>
													<label for='exampleInputConcerts1'>Concertos:</label><br>";
										if(mysqli_num_rows($resultado)){
											$select= '<select id="exampleInputConcerts1" class="form-control form-control-sm" name="listaconcertos">';
											while($rs=mysqli_fetch_array($resultado)){
												$select.='<option value="'.$rs['IDConcerto'].'">'.$rs['Nome'].'</option>';
											}
										}
										$select.='</select></div>';
										echo $select;
										//END

										//DROP DOWN BANDAS
										$resultado=mysqli_query($ligacao,$SQLBANDS);
										echo "<div class='form-group'>
										<label for='exampleInputBands1'>Bandas:</label><br>";

										if(mysqli_num_rows($resultado)){
											$select= '<select id="exampleInputBands1" class="form-control form-control-sm" name="listabandas">';
											while($rs=mysqli_fetch_array($resultado)){
												$select.='<option value="'.$rs['NomeBanda'].'">'.$rs['NomeBanda'].'</option>';
											}
										}
										$select.='</select></div>';
										echo $select;
										// END
									?>
									<?php
										//DROP DOWN ALBUNS
										$resultado=mysqli_query($ligacao,$SQLALBUMS);
										echo "<div class='form-group'>
												<label for='exampleInputAlbums1'>Albuns (para ver as musicas seleccione o album):</label><br>";

										if(mysqli_num_rows($resultado)){
											$select= '<select id="exampleInputAlbums1" class="form-control form-control-sm" name="listalbuns">';
											while($rs=mysqli_fetch_array($resultado)){
												$select.='<option value="'.$rs['IDAlbum'].'">'.$rs['Nome'].'</option>';
											}
										}
										$select.='</select></div>
													<input class="btn btn-primary btn-block" type="submit" name="submitalbuns" value="Listar músicas do album"></form><hr>';
										echo $select;
										// END
									?>
									<form action='' method='POST'>
									<?php
										if(isset($_POST["submitalbuns"])){
											$IDA= $_POST["listalbuns"];
											$SQLMUSICS = "SELECT nome, IDMusica from Musica where IDalbum = '$IDA';"; 
											$resultadoMusica=mysqli_query($ligacao,$SQLMUSICS);
											echo "<div class='form-group'>
													<label for='exampleInputAlbumMusics1'>Músicas do Album:</label><br>";

											if(mysqli_num_rows($resultadoMusica)){
												$select= '<select id="exampleInputAlbumMusics1" class="form-control form-control-sm" name="listamusicas">';
												while($rs=mysqli_fetch_array($resultadoMusica)){
													$select.='<option value="'.$rs['IDMusica'].'">'.$rs['nome'].'</option>';
													}
												}
											$select.='</select></div>';
											echo $select;

										}




										//DROP DOWN EDITORAS
										$resultado=mysqli_query($ligacao,$SQLEDITS);
										echo "<div class='form-group'>
													<label for='exampleInputEditoras1'>Editoras:</label><br>";

										if(mysqli_num_rows($resultado)){
											$select= '<select id="exampleInputEditoras1" class="form-control form-control-sm" name="listaeditoras">';
											while($rs=mysqli_fetch_array($resultado)){
												$select.='<option value="'.$rs['IDEditora'].'">'.$rs['Nome'].'</option>';
											}
										}
										$select.='</select></div>';
										echo $select ;
										// END

										//DROP DOWN INSTRUMENTOS
										$resultado=mysqli_query($ligacao,$SQLINST);
										echo "<div class='form-group'>
												<label for='exampleInputInstruments1'>Instrumentos:</label><br>";

										if(mysqli_num_rows($resultado)){
											$select= '<select id="exampleInputInstruments1" class="form-control form-control-sm" name="listainstrumentos">';
											while($rs=mysqli_fetch_array($resultado)){
												$select.='<option value="'.$rs['ID'].'">'.$rs['Nome'].'</option>';
											}
										}
										$select.='</select></div>';
										echo $select;
										// END

										//DROP DOWN ARTISTAS
										$resultado=mysqli_query($ligacao,$SQLART);
										echo "<div class='form-group'>
												<label for='exampleInputArtists1'>Artistas:</label><br>";

										if(mysqli_num_rows($resultado)){
											$select= '<select id="exampleInputArtists1" class="form-control form-control-sm" name="listartistas">';
											while($rs=mysqli_fetch_array($resultado)){
												$select.='<option value="'.$rs['IDArtista'].'">'.$rs['NomeCompleto'].'</option>';
											}
										}
										$select.='</select></div>
													<input class="btn btn-primary btn-block" type="submit" name="SUBMIT_ALGO" value="MUDAR NAME DO BOTÃO"></form>';
										echo $select;
										// END

										}

										mysqli_close($ligacao);
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<footer class="sticky-footer">
			<div class="container">
				<div class="text-center">
					<small>Copyright © João Ferreira e José Castanheira 2017</small>
				</div>
			</div>
		</footer>


		<!-- Bootstrap core JavaScript-->
		<script src="../vendor/jquery/jquery.min.js"></script>
		<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- Core plugin JavaScript-->
		<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
		<!-- Page level plugin JavaScript-->
		<script src="../vendor/chart.js/Chart.min.js"></script>
		<script src="../vendor/datatables/jquery.dataTables.js"></script>
		<script src="../vendor/datatables/dataTables.bootstrap4.js"></script>
		<!-- Custom scripts for all pages-->
		<script src="../js/sb-admin.min.js"></script>
		<!-- Custom scripts for this page-->
		<script src="../js/sb-admin-datatables.min.js"></script>
		<script src="../js/sb-admin-charts.min.js"></script>
	</body>

	</html>