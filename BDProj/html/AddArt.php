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
  	$resultado = mysqli_query($ligacao,$SQL);

  	if (mysqli_num_rows($resultado)==0) { 
  		header('Location: http://alunos.deec.uc.pt/~jferreira/BDProj/');
  		exit;
  	} else {
  		while($tuplo = mysqli_fetch_array($resultado)) {
  			$user = $tuplo["username"];
  			$func = $tuplo["funcao"];
  			$CheckPass = $tuplo["md5pass"];
  			$avatar = $tuplo["avatar"];
      if($pass == $CheckPass){ //se user for legit
      	if($func==0) header('Location: http://alunos.deec.uc.pt/~jferreira/BDProj/html/dashboard.php');

        ?>
<?php require('head.php');?>

















<div class="row">
 <div class="col-md-6 offset-3">
<div class="bg-danger text-white text-center">
<?php

if(isset($_POST["NovoArtistaSub"])){
$target_dir = "images/artistas/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "O ficheiro não é uma imagem.";
        $uploadOk = 0;
    }

$actual_name = pathinfo($target_file,PATHINFO_FILENAME);
$original_name = $actual_name;
$extension = pathinfo($target_file, PATHINFO_EXTENSION);

$i = 1;
$NomeFicheiro=basename($_FILES["file"]["name"]);
while(file_exists('images/artistas/'.$actual_name.".".$extension))
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
    echo "O upload de um novo artista falhou.<br>";
// if everything is ok, try to upload file
} else {
	$NovaDataN = $_POST["Bday"];
    $NovaDataO = $_POST["Oday"];
    
    
    if (move_uploaded_file($_FILES["file"]["tmp_name"], 'images/artistas/'.$NomeFicheiro)) {
       	$NovoArtistaNome= $_POST["PNome"] . " " . $_POST["Unome"];
       	$Novogenero = $_POST["genero"];
       	$NovaDataN = $_POST["Bday"];
       	$NovaDataO = $_POST["Oday"];
        $instrID = $_POST["instrID"];
       	if(!empty($_POST["Oday"])) {
       		if(date($NovaDataN)>date($NovaDataO)){ 
    			echo "A Data de Óbito tem de ser maior que a de Nascimento.<br>";
  			  }
  			  else{
       	$SQL1="INSERT into Artista(NomeCompleto,genero,foto,DataNascimento,DataObito) values('$NovoArtistaNome','$Novogenero','$NomeFicheiro','$NovaDataN','$NovaDataO');";
       	$rez=mysqli_query($ligacao,$SQL1);
       	//inserir Instrumento no artista
            $SQL2= "SELECT IDArtista from Artista where NomeCompleto = '$NovoArtistaNome' group by IDArtista DESC LIMIT 1;";
            $rez2=mysqli_query($ligacao,$SQL2);
            while ($row = mysqli_fetch_array($rez2) ) {
                 $NovoArtistaID= $row["IDArtista"];
               }
            $SQL3= "INSERT into Toca(IDArtista,NumSerie) values ('$NovoArtistaID','$instrID');";
            $rez3=mysqli_query($ligacao,$SQL3);
            if($rez and $rez2 and $rez3) echo "</div><div class='bg-success text-white text-center'>Foi criado um novo artista com sucesso!";
        }
       	}else{
       		
       			$SQL1="INSERT into Artista(NomeCompleto,genero,foto,DataNascimento) values('$NovoArtistaNome','$Novogenero','$NomeFicheiro','$NovaDataN');";
       			$rez=mysqli_query($ligacao,$SQL1);

            //inserir Instrumento no artista
            $SQL2= "SELECT IDArtista from Artista where NomeCompleto = '$NovoArtistaNome' group by IDArtista DESC LIMIT 1;";
            $rez2=mysqli_query($ligacao,$SQL2);
            while ($row = mysqli_fetch_array($rez2) ) {
                 $NovoArtistaID= $row["IDArtista"];
               }
            $SQL3= "INSERT into Toca(IDArtista,NumSerie) values ('$NovoArtistaID','$instrID');";
            $rez3=mysqli_query($ligacao,$SQL3);
            if($rez and $rez2 and $rez3) echo "</div><div class='bg-success text-white text-center'>Foi criado um novo artista com sucesso!";
			
       	}
    } else {
        echo "Ocorreu um erro do servidor a fazer upload do ficheiro.";
    }

    //SELECT IDArtista from Artista where NomeCompleto = "Artista2 BDProj" group by IDArtista DESC LIMIT 1;
}}
?>
</div>
</div>
</div>
<div class="row">





 <div class="col-md-6 offset-3">
 <div class="card mb-3">
      <div class="card-header">
        <i class="fa fa-user-plus"></i> Adicionar Artista</div>
        <form action = "" method = "post"  enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-group">
              <div class="form-row">
              	<div class="col-md-6">
              		 <label for="file">Imagem do Artista</label>
   						<input type="file" class="form-control-file" id="file" aria-describedby="fileHelp" name= "file" id= "file" required>
   						 <small id="fileHelp" class="form-text text-muted">A imagem do Artista tem de ser em formato JPG e ter menos de 1Mb.</small>

				</div>
                <div class="col-md-6 ">
                	<div class="col align-self-center">
                  <label for="exampleInputName">Primeiro Nome</label>
                  <input class="form-control" id="exampleInputName" name = "PNome" type="text" aria-describedby="nameHelp" placeholder="Introduza Primeiro Nome" required>
                  </div>
                  <div class="col align-self-end">
                  <label for="exampleInputLastName">Último Nome</label>
                  <input class="form-control" id="exampleInputLastName" name = "Unome" type="text" aria-describedby="nameHelp" placeholder="Introduza Último Nome" required>
              </div>
              </div>
             
              </div>
              
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-2 offset-0 ">
                      <label for="exampleInputPassword1">Género</label>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="radio" name="genero" id="inlineRadio1" value="H" checked> H 
                        </label>
                      </div>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="radio" name="genero" id="inlineRadio2" value="M" > M
                        </label>
                      </div>
                    </div>
                <div class="col-md-4">
      			 <label for="bday">Data de Nascimento</label>
                 <input type="date" name="Bday" value="1967-02-20" min="1900-12-31" required >

      			 <label for="bday">Data de Óbito</label>
                 <input type="date" name="Oday" value="1994-04-05" min="1900-12-31" max="2100-12-12">
                
                </div>
              <div class="col-md-6 offset-0">
                <div class="col align-self-end">
                      <label for="inputState">Instrumento - nº Série</label>
                      <select name = 'instrID' id="inputState" class="form-control">
                        <?php
                        $query="SELECT * FROM Instrumento";
                        $rez4=mysqli_query($ligacao,$query);
                        // $row = mysqli_fetch_array($result);
                        while ($row = mysqli_fetch_array($rez4) ) {
                          ?><option   value = "<?php echo ($row['ID'])?>" selected> <?php echo($row['Nome']. " - ". $row["ID"]); ?> </option> <?php
                        }
                        ?>
                      </select>
                    <center><a href="AddInstrumento.php"><button type="button" name = "NewArtist" class="btn btn-success btn-sm text-right" title ="Adicionar Instrumento"><i class="fa fa-plus"></i> Adicionar Instrumento
              </button></a></center>
                    </div>
                  </div>
              </div>

            </div>

          
            <div class="card-footer small text-right">
              <button type="submit" name = "NovoArtistaSub" class="btn btn-success btn-lg" title ="Adicionar Artista"><i class="fa fa-plus"></i> Adicionar Artista</button>
            </div>
          </div>
        </div>
      </form>
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

<?php
} 




mysqli_close($ligacao);
}
}

?>



</body>
</html>