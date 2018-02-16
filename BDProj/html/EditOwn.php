<?php

include 'session.php';

/* ADICIONAVA O PODER MODIFICAR A FOTOGRAFIA DO UTILIZADOR*/

$SQL="
	SELECT username, funcao, md5pass, avatar,DataNascimento from Utilizador where username = '$user';
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
			$DataAtual=$tuplo["DataNascimento"];
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
<?php require('head.php');?>


<div class="row">
 <div class="col-md-6 offset-3">
<div class="bg-danger text-white text-center">


<?php

if(isset($_SESSION['username']) || !empty($_SESSION['username'])) { //se tiver sessao iniciada
	if(isset($_POST["submit"])){
		$novapass=md5($_POST["novapass"]);
		$novadata=$_POST["novadata"];




$target_dir = "images/avatars/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "O ficheiro não é uma imagem.<br>";
        $uploadOk = 0;
    }

$actual_name = pathinfo($target_file,PATHINFO_FILENAME);
$original_name = $actual_name;
$extension = pathinfo($target_file, PATHINFO_EXTENSION);

$i = 1;
$NomeFicheiro=basename($_FILES["file"]["name"]);
while(file_exists('images/avatars/'.$actual_name.".".$extension))
{           
    $actual_name = (string)$original_name.$i;
    $NomeFicheiro = $actual_name.".".$extension;
    $i++;
}
// Check file size
if ($_FILES["file"]["size"] > 1000000) {
    echo "Esse ficheiro tem mais de 1Mb.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" ) {
    echo "Apenas são permitidos ficheiros JPG.<br>";
    $uploadOk = 0;
}




// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "O upload da nova informação falhou.";
// if everything is ok, try to upload file
} else {

    
    
    if (move_uploaded_file($_FILES["file"]["tmp_name"], 'images/avatars/'.$NomeFicheiro)) {
      
			$SQL="UPDATE Utilizador set md5pass = '$novapass', DataNascimento ='$novadata', avatar= '$NomeFicheiro' where username = '$user';";		
			$rez= mysqli_query($ligacao,$SQL);
       		$_SESSION["username"] = $user;
       	     $_SESSION["funcao"] = $func;
         	 $_SESSION["password"] = $novapass;
       
            
            if($rez) echo "</div><div class='bg-success text-white text-center'>Foi alterado o utilizador com sucesso!";
	
			
		}

					mysqli_close($ligacao);

					}
				}}
				?>

</div>
</div>
</div>

				

					<div class="col-md-4">
						<!-- Example Bar Chart Card-->
						<div class="card mb-3">
							<div class="card-header">
								<i class="fa fa-pencil"></i> Editar conta de 
								<?php
									if($pass == $CheckPass){ //se user for legit
										echo $user;
									}
								?>
							</div>
							<div class="card-body">
      							 <form action = "" method = "post"  enctype="multipart/form-data">
									 <label for="file">Imagem de Perfil</label>
   										<input type="file" class="form-control-file" id="file" aria-describedby="fileHelp" name= "file" id= "file" required>
   						 				<small id="fileHelp" class="form-text text-muted">A imagem de perfil tem de ser em formato JPG e ter menos de 1Mb.</small>
									<div class="form-group">
										<label for="exampleInputPassword1">Introduza a nova password:</label>
										<input class="form-control" id="exampleInputPassword1" type="password" aria-describedby="emailHelp" name="novapass" placeholder="Password"
										    required>
									</div>
									<hr>
									<div class="form-group">
										<label for="exampleInputBirth1">Introduza a nova data de nascimento:</label>
										<input class="form-control" id="exampleInputBirth1" type="date" name="novadata" value='<?php echo($DataAtual)?>' min="1900-12-31" required>
									</div>
									<input class="btn btn-primary btn-block" type="submit" name="submit" value="Fazer alterações">
									<p style="color: red;">

									</p>
								</form>
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