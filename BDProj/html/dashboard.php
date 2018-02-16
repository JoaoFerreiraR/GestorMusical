<?php require('header.php');?>
<body>

	<?php 
	include 'session.php';
 $SQL="
  SELECT username, funcao, md5pass, avatar from Utilizador where username = '$user';
  ";
  $resultado = mysqli_query($ligacao,$SQL);

   
   while($tuplo = mysqli_fetch_array($resultado)) {
     $user = $tuplo["username"];
     $func = $tuplo["funcao"];
     $CheckPass = $tuplo["md5pass"];
     $avatar = $tuplo["avatar"];}


	
			
				?>

<?php


 require('head.php');?>



		<?php
			





		$SQLULTIMOALBUM= "SELECT A.IDAlbum from Album A left join Classifica C on A.IDAlbum=C.IDAlbum ORDER BY IDAlbum DESC LIMIT 1;";
		$resultado=mysqli_query($ligacao,$SQLULTIMOALBUM);
		while($tuplo = mysqli_fetch_array($resultado)) {
			$albumID=$tuplo["IDAlbum"];
		}
      $SQLALBUM= "SELECT * from Album where IDAlbum= '$albumID';";
      $resultado=mysqli_query($ligacao,$SQLALBUM);
      $SuaReview= "n/a";

      $sqlCheckReview = "SELECT * from Classifica where username= '$user' and IDAlbum= '$albumID';";
      $res2=mysqli_query($ligacao,$sqlCheckReview);
      $FEZREVIEW =TRUE;
      if(mysqli_num_rows($res2)==0){
        $FEZREVIEW=FALSE;
      }
       while($tuplo = mysqli_fetch_array($res2)) {
        $SuaReview=$tuplo["score"];
     }






      while($tuplo = mysqli_fetch_array($resultado)) {
       $NomeAlbum=$tuplo["Nome"];
       $ano=$tuplo["ano"];
       $estilo= $tuplo["estilo"];
       $foto="images/albums/" . $tuplo["foto"];
       $NomeBanda= $tuplo["NomeBanda"];
       $review = $tuplo["review"];
     }


      $sqlcheckAlbum = "SELECT * from Obter where username= '$user' and IDAlbum= '$albumID';";
      $res=mysqli_query($ligacao,$sqlcheckAlbum);
      $TEMALBUM =TRUE;
      if(mysqli_num_rows($res)==0){
        $TEMALBUM=FALSE;
        $SuaReview="N/A";
      }

      


      if(isset($_POST["adquirir"])){
        $comprado= $_POST["adquirir"];
        $sqladquirir = "INSERT into Obter(username,IDAlbum) values('$user','$comprado');";
        $adq=mysqli_query($ligacao,$sqladquirir);
        $TEMALBUM=TRUE;

      }

//ULTIMA BANDA
      $SQLULTIMOARTISTA= "SELECT * From Artista ORDER BY IDArtista DESC LIMIT 1;";
		$resultado=mysqli_query($ligacao,$SQLULTIMOARTISTA);
		while($tuplo = mysqli_fetch_array($resultado)) {
			   $ArtistaLastID=$tuplo["IDArtista"];
			   $NomeCompleto=$tuplo["NomeCompleto"];
		       $genero=$tuplo["genero"];
		       $DataNascimento= $tuplo["DataNascimento"];
		       $DataObito= $tuplo["DataObito"];
		       if($DataObito==NULL) $DataObito = "N/A";
		       $foto2="images/artistas/" . $tuplo["foto"];
		}


    //random user
    $SQLRANDUSER= "SELECT * FROM Utilizador where (username <> 'root') AND (username <> '$user') ORDER BY RAND() LIMIT 0,1;";
    $resultado3=mysqli_query($ligacao,$SQLRANDUSER);
    while($tuplo = mysqli_fetch_array($resultado3)) {
         $UserMostrar=$tuplo["username"];
       $DataNascimentoMostrar=$tuplo["DataNascimento"];
       $fotouserMostrar="images/avatars/" . $tuplo["avatar"];
       if($tuplo["funcao"] == '0') $funcaoMostrar= "Utilizador";
       if($tuplo["funcao"] == '1') $funcaoMostrar= "Conta de banda";
       if($tuplo["funcao"] == '2') $funcaoMostrar= "Administrador";
    }





		?>
		
<div class="mb-0 mt-4">
	<i class="fa fa-newspaper-o"></i> Últimos Releases</div>
	<hr class="mt-2">
<div class = "row">
      <div class="col-md-3">
        <div class="card mb-3">
          <div class="card-header">
           <i class="fa fa-book"></i> Último Álbum
         </div>
         <div class="card-body">
          <h6 class="card-title mb-1">
            <a href="musicas.php?album=<?php echo $albumID;?>"><img class="card-img-top img-fluid " src="<?php echo"$foto"?>" alt=""> 
            <?php echo"<center><b>".$NomeAlbum."</b></center><br></a>";
                  echo"<center>Pontuação Média: " . $review . "<br><small>A sua avaliação: ".$SuaReview."</small></center>";
            ?>

          </h6>
          <p class="card-title "><center><b><?php echo $NomeBanda;?></b></center>
            <p class="card-text small text-center">Estilo:<?php echo  $estilo;?><br>
              Ano:<?php echo $ano;?><br>

             
             
              </p>
          </p>

          </div>
        </div>
      </div>
		<div class="col-md-3">
        	<div class="card mb-3">
        	  <div class="card-header">
          	 <i class="fa fa-music"></i> Último Artista
        	 </div>
         <div class="card-body">
          <h6 class="card-title mb-1">
            <a href="Artista.php?Artista=<?php echo $ArtistaLastID;?>"><img class="card-img-top img-fluid " src="<?php echo"$foto2"?>" alt=""> 
           

          </h6>
          <p class="card-title "><center><b><?php echo $NomeCompleto;?></b></a></center>
            <p class="card-text small text-center">Data de Nascimento / Óbito:<br> <b><?php echo $DataNascimento . "  &#8212 " . $DataObito;?></b><br>
            </p>
          </p>

          </div>
        </div>
      </div>
<div class="col-md-3">
  <div class="card mb-3">
          <div class="card-header">
           <i class="fa fa-user"></i> Utilizador que talvez conheças!
         </div>
         <div class="card-body">
          <h6 class="card-title mb-1">
                        <a href="Profile.php?profile=<?php echo $UserMostrar;?>"><img class="card-img-top img-fluid " src="<?php echo"$fotouserMostrar"?>" alt=""> 

            <?php echo"<center><big>".$UserMostrar."</big></center>";?></a>

          </h6>
          <p class="card-title "><center><b><?php echo "Este utilizador é do tipo: " . $funcaoMostrar;?></b></center>
            <p class="card-text small text-center">Data de Nascimento:<?php echo $DataNascimentoMostrar;?><br></p>
          </p>
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

<?php



mysqli_close($ligacao);


?>


</body>
</html>