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
<?php require('head.php');
$ConcertoID= $_GET["Concerto"];
      $sqlconcerto= "SELECT * from Concerto where IDConcerto= '$ConcertoID';";
      $ConcertoInfo=mysqli_query($ligacao,$sqlconcerto);

      while($tuplo = mysqli_fetch_array($ConcertoInfo)) {
       $NomeConcerto=$tuplo["Nome"];
       $Data=$tuplo["Data"];
       $Localidade= $tuplo["Localidade"];
       $IDConcerto = $tuplo["IDConcerto"];
     }
      if (mysqli_num_rows($ConcertoInfo)==0) { //nao existe esse user
              $URL="http://alunos.deec.uc.pt/~jferreira/BDProj/html/dashboard.php";
               echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
               echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
              }











?>
<div class="row">
 <div class="col-md-6 offset-3">
<div class="bg-danger text-white text-center">
<?php

if(isset($_POST["NovoShowSub"])){

  if(empty($_POST["NomeBanda"])){
    echo "Por Favor escolha pelo menos 1 banda participante.<br>";
    }
    else{
        $NomesBandas= $_POST["NomeBanda"];
       	$DataEventoNova = $_POST["DataEventoNova"];
       	$LocalidadeNova = $_POST["LocalidadeNova"];
        $NomeEventoNovo = $_POST["NomeEventoNovo"];


       	$SQL1="UPDATE Concerto
                set Localidade='$LocalidadeNova', Nome= '$NomeEventoNovo',Data= '$DataEventoNova' where IDConcerto='$ConcertoID';";
       	$rez=mysqli_query($ligacao,$SQL1);
       	$CLEARBANDAS= "DELETE FROM Atua where IDConcerto='$ConcertoID'";
        $limp=mysqli_query($ligacao,$CLEARBANDAS);

          
         $N = count($NomesBandas);
          for($i=0; $i < $N; $i++) {
              $SQL3= "INSERT into Atua(NomeBanda,IDConcerto) values ('$NomesBandas[$i]','$ConcertoID');";
             $rez3=mysqli_query($ligacao,$SQL3);
            }
            
            if($rez and $rez3) echo "</div><div class='bg-success text-white text-center'>Foi editado o Evento com sucesso!";
       }
    }
    $ConcertoInfo=mysqli_query($ligacao,$sqlconcerto);

      while($tuplo = mysqli_fetch_array($ConcertoInfo)) {
       $NomeConcerto=$tuplo["Nome"];
       $Data=$tuplo["Data"];
       $Localidade= $tuplo["Localidade"];
       $IDConcerto = $tuplo["IDConcerto"];
     }
      if (mysqli_num_rows($ConcertoInfo)==0) { //nao existe esse user
              $URL="http://alunos.deec.uc.pt/~jferreira/BDProj/html/dashboard.php";
               echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
               echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
              }

    //SELECT IDArtista from Artista where NomeCompleto = "Artista2 BDProj" group by IDArtista DESC LIMIT 1;
?>
</div>
</div>
</div>
<div class="row">





 <div class="col-md-6 offset-3">
 <div class="card mb-3">
      <div class="card-header">
        <i class="fa fa-user-plus"></i> Adicionar Evento</div>
        <form action = "" method = "post"  enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-group">
              <div class="form-row">
              
                <div class="col-md-6 ">
                	<div class="col align-self-center">
                  <label for="exampleInputName">Nome do Evento</label>
                  <input class="form-control" id="exampleInputName" name = "NomeEventoNovo" type="text" aria-describedby="nameHelp" value="<?php echo $NomeConcerto;?>" required>
                  </div>

                  
              </div>
                <div class="col-md-6 ">
             <label for="bday">Data do Evento </label>
                 <input type="date" name="DataEventoNova" value="<?php echo $Data;?>" required >

                </div>
             
              </div>
              
            </div>
            <div class="form-group">
              <div class="form-row">
              
              <div class="col-md-6 ">
                <div class="col align-self-end">
                      <label for="inputState">Localidade</label>
                       <input class="form-control" id="exampleInputName" name = "LocalidadeNova" type="text" aria-describedby="nameHelp" value="<?php echo $Localidade;?>" required>

                    </div>

                  </div>

              </div>
                <hr class="mt-2">
                
                 <label for="checkbox">Bandas Participantes</label>
                  <div class= "row">
                  <div class= "col-md-8 offset-1">
                    <?php 
                    $SQLARTISTAS="SELECT NomeBanda FROM Banda;";
                    $rez4 = mysqli_query($ligacao,$SQLARTISTAS);
                    while ($row = mysqli_fetch_array($rez4) ) {
                    echo"
                      <input type='checkbox' name='NomeBanda[]' value='".$row['NomeBanda']."' /> ".$row['NomeBanda'].".<br />";
                      }
                      ?>
                  </div>
                </div>

            </div>

          
            <div class="card-footer small text-right">
              <button type="submit" name = "NovoShowSub" class="btn btn-success btn-lg" title ="Editar Evento"><i class="fa fa-pencil"></i> Editar Evento</button>
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