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
      	if($func==0) header('Location: http://alunos.deec.uc.pt/~jferreira/BDProj/html/dashboard.php');

          ?>
          <?php require('head.php');?>


          <div class="row">
           <div class="col-md-6 offset-3">
            <div class="bg-danger text-white text-center">
              <?php
              $ArtistaID= $_GET["Artista"];
              $SQLARTISTA= "SELECT Artista.IDArtista,Artista.NomeCompleto,Artista.DataNascimento,Artista.DataObito,Instrumento.Nome,Artista.foto,Artista.genero,Instrumento.ID FROM Artista join Toca on Toca.IDArtista= Artista.IDArtista join Instrumento on Toca.NumSerie= Instrumento.ID where Artista.IDArtista='$ArtistaID';";

              $GetArtista=mysqli_query($ligacao,$SQLARTISTA);
              while($tuplo = mysqli_fetch_array($GetArtista)) {
               $IDArtista=["IDArtista"];
               $NomeCompleto=$tuplo["NomeCompleto"];
               $genero=$tuplo["genero"];
               $DataNascimento= $tuplo["DataNascimento"];
               $DataObito= $tuplo["DataObito"];
               if($DataObito==NULL) $DataObito = "N/A";
               $foto="images/artistas/" . $tuplo["foto"];
               $NomeInstrumento= $tuplo["Nome"];
               $IDInstrumento=$tuplo["ID"];
             }
             if (mysqli_num_rows($GetArtista)==0) { //nao existe esse user
              $URL="http://alunos.deec.uc.pt/~jferreira/BDProj/html/dashboard.php";
               echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
               echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
              }




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
                $NovoArtistaNome= $_POST["PNome"];
                $Novogenero = $_POST["genero"];
                $NovaDataN = $_POST["Bday"];
                $NovaDataO = $_POST["Oday"];
                $instrID = $_POST["instrID"];
                if(!empty($_POST["Oday"])) {
                 if(date($NovaDataN)>date($NovaDataO)){ 
                   echo "A Data de Óbito tem de ser maior que a de Nascimento.<br>";
                 }
                 else{ //se houver data obito
                  $SQL1="
                    UPDATE Artista
                    SET NomeCompleto= '$NovoArtistaNome',genero='$Novogenero',DataNascimento='$NovaDataN',DataObito='$NovaDataO',foto='$NomeFicheiro'
                    WHERE IDArtista='$ArtistaID';";
                  $rez=mysqli_query($ligacao,$SQL1);
                  //trocar instrumento
                 $SQL3= "UPDATE Toca
                  SET Toca.NumSerie= '$instrID'
                  where IDArtista ='$ArtistaID';";
                 $rez3=mysqli_query($ligacao,$SQL3);
                 if($rez and $rez3) echo "</div><div class='bg-success text-white text-center'>Foi alterado o/a artista com sucesso!";
               }
             }else{ //se nao houver

              $SQL1="UPDATE Artista
                    SET NomeCompleto= '$NovoArtistaNome',genero='$Novogenero',DataNascimento='$NovaDataN',foto='$NomeFicheiro'
                    WHERE IDArtista='$ArtistaID';";
              $rez=mysqli_query($ligacao,$SQL1);

            //trocar Instrumento no artista
             $SQL3= "UPDATE Toca
                      SET Toca.NumSerie= '$instrID'
                      where IDArtista ='$ArtistaID';";
             $rez3=mysqli_query($ligacao,$SQL3);
             if($rez and $rez3) echo "</div><div class='bg-success text-white text-center'>Foi alterado o/a artista com sucesso!";

           }
         } else {
          echo "Ocorreu um erro do servidor a fazer upload do ficheiro.";
        }



























              $SQLARTISTA= "SELECT Artista.IDArtista,Artista.NomeCompleto,Artista.DataNascimento,Artista.DataObito,Instrumento.Nome,Artista.foto,Artista.genero,Instrumento.ID FROM Artista join Toca on Toca.IDArtista= Artista.IDArtista join Instrumento on Toca.NumSerie= Instrumento.ID where Artista.IDArtista='$ArtistaID';";

              $GetArtista=mysqli_query($ligacao,$SQLARTISTA);
              while($tuplo = mysqli_fetch_array($GetArtista)) {
               $IDArtista=["IDArtista"];
               $NomeCompleto=$tuplo["NomeCompleto"];
               $genero=$tuplo["genero"];
               $DataNascimento= $tuplo["DataNascimento"];
               $DataObito= $tuplo["DataObito"];
               if($DataObito==NULL) $DataObito = "N/A";
               $foto="images/artistas/" . $tuplo["foto"];
               $NomeInstrumento= $tuplo["Nome"];
               $IDInstrumento=$tuplo["ID"];
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
      <i class="fa fa-user-plus"></i> Editar Artista</div>
      <form action = "" method = "post"  enctype="multipart/form-data">
        <div class="card-body">
          <div class="form-group">
            <div class="form-row">
             <div class="col-md-5">
              <img class="card-img-top img-fluid " src="<?php echo"$foto"?>" alt=""><br>
              <label for="file">Imagem do Artista</label>
              <input type="file" class="form-control-file" id="file" aria-describedby="fileHelp" name= "file" id= "file" required>
              <small id="fileHelp" class="form-text text-muted">A imagem do Artista tem de ser em formato JPG e ter menos de 1Mb.</small>

            </div>
            <div class="col-md-7  ">
             <div class="col align-self-center">
              <label for="exampleInputName">Nome Completo</label>
              <input class="form-control" id="exampleInputName" name = "PNome" type="text" aria-describedby="nameHelp" value="<?php echo $NomeCompleto ?>" required>
            </div>
            <div class="col align-self-center">

             <label for="inputState">Instrumento - nº Série</label>
             <select name = 'instrID' id="inputState" class="form-control">
              <?php
              $query="SELECT * FROM Instrumento";
              $rez4=mysqli_query($ligacao,$query);
                        // $row = mysqli_fetch_array($result);
              while ($row = mysqli_fetch_array($rez4) ) {
                if($row['Nome']==$NomeInstrumento){
                  ?><option   value = "<?php echo ($row['ID'])?>" selected> <?php echo($row['Nome']. " - ". $row["ID"]); ?> </option> 
                  <?php } 
                  else{?>
                  <option   value = "<?php echo ($row['ID'])?>" > <?php echo($row['Nome']. " - ". $row["ID"]); ?>
                    <?php }


                  }
                  ?>
                </select>
                <center><a href="AddInstrumento.php"><button type="button" name = "NewInstrument" class="btn btn-success btn-sm text-right" title ="Adicionar Instrumento"><i class="fa fa-plus"></i> Adicionar Instrumento
                </button></a></center>
                <div class="row">
                  <div class="col-md-5">
                   <label for="bday">Data de Nascimento</label>
                   <input type="date" name="Bday" value="<?php echo $DataNascimento;?>" min="1900-12-31" required >

                   <label for="bday">Data de Óbito</label>
                   <input type="date" name="Oday" value="<?php echo $DataObito;?>" min="1900-12-31" max="2100-12-12" >

                 </div>
                 <div class="col-md-3 offset-3">
                   <label for="exampleInputPassword1">Género</label>
                   <div class="form-check">
                    <label class="form-check-label">
                      <input class="form-check-input" type="radio" name="genero" id="inlineRadio1" value="<?php echo $genero;?>" checked> <?php echo $genero;?>
                    </label>
                  </div>
                  <?php if($genero =='H'){?>

                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="form-check-input" type="radio" name="genero" id="inlineRadio2" value="M" > M
                    </label>
                  </div>
                  <?php };?>
                  <?php if($genero =='M'){?>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="form-check-input" type="radio" name="genero" id="inlineRadio2" value="H" > H
                    </label>
                  </div>
                  <?php };?>


                </div>
              </div>

            </div>

          </div>

        </div>

      </div>

    </div>
    <div class="form-group">
     


      <div class="card-footer small text-right">
        <button type="submit" name = "NovoArtistaSub" class="btn btn-success btn-lg" title ="Editar Artista"><i class="fa fa-pencil"></i> Editar Artista</button>
      </div>

    </div>
  </div>
</form>
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


?>


</body>
</html>