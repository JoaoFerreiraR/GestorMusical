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

if(isset($_POST["NovaMusicaSub"])){
  $NomeMusica= $_POST["NomeM"];
  $duracaoMusica=$_POST["DuracaoMusica"];
  $AlbumPertence=$_POST["AlbumID"];
$SQLInserirMusica= "INSERT into Musica(duracao,nome,IDAlbum) values('$duracaoMusica','$NomeMusica','$AlbumPertence');";
 $resultado3 = mysqli_query($ligacao,$SQLInserirMusica);
 if($resultado3)  echo "</div><div class='bg-success text-white text-center'>Foi adicionada a música com sucesso!";
}
?>
</div>
</div>
</div>
<div class="row">





 <div class="col-md-6 offset-3">
 <div class="card mb-3">
      <div class="card-header">
        <i class="fa fa-user-plus"></i> Adicionar Música</div>
        <form action = "" method = "post"  enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-group">
              <div class="form-row">
              	<div class="col-md-6">
                  <label for="exampleInputName">Nome da Música</label>
                  <input class="form-control" id="exampleInputName" name = "NomeM" type="text" aria-describedby="nameHelp" placeholder="Introduza o Nome da Música" required>
              		

				</div>
                <div class="col-md-6 ">
                	<div class="col align-self-center">
                  <label for="exampleInputName">Duração da Música</label>
                    <input class = "form-control" id="settime" type="time" step="1" name="DuracaoMusica" min="00:00:00" max="23:59:59" required />
                     <small id="hour" class="form-text text-muted">HH:MM:SS</small>

                  </div>
                  
              </div>
             
              </div>

              <label for="inputState">Álbum ao qual a Música Pertence</label>
                      <select name = 'AlbumID' id="inputState" class="form-control">
                        <?php
                        $query="SELECT * FROM Album;";
                         $resultado4 = mysqli_query($ligacao,$query);
                        // $row = mysqli_fetch_array($result);
                        while ($row = mysqli_fetch_array($resultado4) ) {
                          ?><option   value = "<?php echo ($row['IDAlbum'])?>" selected> <?php echo($row['Nome']); ?> </option> <?php
                        }
                        ?>
                      </select>
              
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-4">
      		
                
                </div>
            
              </div>
               

            </div>

          
            <div class="card-footer small text-right">
              <button type="submit" name = "NovaMusicaSub" class="btn btn-success btn-lg" title ="Adicionar Banda"><i class="fa fa-plus"></i> Adicionar Música</button>
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