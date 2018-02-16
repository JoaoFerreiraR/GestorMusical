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

if(isset($_POST["NovoShowSub"])){

  if(empty($_POST["NomeBanda"])){
    echo "Por Favor escolha pelo menos 1 banda participante.<br>";
    }
    else{
        $NomesBandas= $_POST["NomeBanda"];
       	$DataEvento = $_POST["DataEvento"];
       	$Localidade = $_POST["Localidade"];
        $NomeEvento = $_POST["NomeEvento"];


       	$SQL1="INSERT into Concerto(Localidade,Nome,Data) values('$Localidade','$NomeEvento','$DataEvento');";
       	$rez=mysqli_query($ligacao,$SQL1);
       	  $SQL2= "SELECT IDConcerto from Concerto where Nome = '$NomeEvento' group by IDConcerto DESC LIMIT 1;";
            $rez2=mysqli_query($ligacao,$SQL2);
            while ($row = mysqli_fetch_array($rez2) ) {
                 $NovoConcertoID= $row["IDConcerto"];
               }
          
         $N = count($NomesBandas);
          for($i=0; $i < $N; $i++) {
              $SQL3= "INSERT into Atua(NomeBanda,IDConcerto) values ('$NomesBandas[$i]','$NovoConcertoID');";
             $rez3=mysqli_query($ligacao,$SQL3);
            }
            
            if($rez and $rez3) echo "</div><div class='bg-success text-white text-center'>Foi criado um novo Evento com sucesso!";
       }
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
                  <input class="form-control" id="exampleInputName" name = "NomeEvento" type="text" aria-describedby="nameHelp" placeholder="Introduza o Nome do Evento" required>
                  </div>

                  
              </div>
                <div class="col-md-6 ">
             <label for="bday">Data do Evento </label>
                 <input type="date" name="DataEvento" value="0000-00-00" required >

                </div>
             
              </div>
              
            </div>
            <div class="form-group">
              <div class="form-row">
              
              <div class="col-md-6 ">
                <div class="col align-self-end">
                      <label for="inputState">Localidade</label>
                       <input class="form-control" id="exampleInputName" name = "Localidade" type="text" aria-describedby="nameHelp" placeholder="Introduza a localidade do Evento" required>

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
              <button type="submit" name = "NovoShowSub" class="btn btn-success btn-lg" title ="Adicionar Evento"><i class="fa fa-plus"></i> Adicionar Evento</button>
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