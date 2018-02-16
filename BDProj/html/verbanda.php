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
        ?>
<?php require('head.php');?>



      <?php
      $BandNAME= $_GET["Banda"];
      $SQLBANDA= "SELECT * from Banda where NomeBanda= '$BandNAME';";
      $resultado=mysqli_query($ligacao,$SQLBANDA);

      while($tuplo = mysqli_fetch_array($resultado)) {
       $NomeBanda=$tuplo["NomeBanda"];
       $DataInicio=$tuplo["DataInicio"];
       $DataFim= $tuplo["DataFim"];
       if($DataFim==NULL) $DataFim = "ativos";
       $foto="images/bands/" . $tuplo["imagem"];
     }
      if (mysqli_num_rows($resultado)==0) { //nao existe esse user
              $URL="http://alunos.deec.uc.pt/~jferreira/BDProj/html/dashboard.php";
               echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
               echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
              }

     ?>
    
    <div class = "row">
      <div class="col-md-4">
        <div class="card mb-3">
          <div class="card-header">
           <i class="fa fa-music"></i> Banda
              <?php if(($func == 1 &&strtolower($user) ==strtolower($NomeBanda)) || $func==2 ){
          ?>
         <div class=" card-text small float-right">
              <a href="EditBanda.php?Banda=<?php echo $NomeBanda;?>"><button type="submit" name = "NewBand" class="btn btn-warning text-right" title ="Editar Banda"><i class="fa fa-pencil"></i> Editar Banda
              </button></a>
            </div>
       <?php }?>
         </div>
         <div class="card-body">
          <h6 class="card-title mb-1">
            <img class="card-img-top img-fluid " src="<?php echo"$foto"?>" alt="">
           

          </h6>
          <p class="card-title "><center><b><?php echo $NomeBanda;?></b></center>
            <p class="card-text small text-center">Tempo de Atividade:<br> <b><?php echo $DataInicio . "  &#8212 " . $DataFim;?></b><br>
              <br>

             
              </p>
          </p>

          </div>
        </div>
      </div>
      <div class ="col-md-4">
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-music"></i> Álbums da Banda <b><?php echo $NomeBanda;?></b> </div>

            <div class="card-body">
              <div class="table-responsive">
                           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Ano</th>
                  <th>Banda</th>
                  <!--<th>Start date</th>
                    <th>Salary</th> -->
                  </tr>
                </thead>
              <!--<tfoot>
                <tr>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Office</th>
                  <th>Age</th>
                  <th>Start date</th>
                  <th>Salary</th>
                </tr>
              </tfoot>-->
            <tbody>
                <?php

               $query="SELECT A.IDAlbum,A.Nome,A.ano,A.NomeBanda,A.estilo,E.Nome as NomeEditora FROM Album A join Editora E on A.IDEditora=E.IDEditora where A.NomeBanda= '$NomeBanda';";
                $result = mysqli_query($ligacao,$query);

                while ($row = mysqli_fetch_array($result) ) {
                  ?>
                  <tr>
                    <td> <?php echo($row['Nome']); ?> </td> <?php
                    ?><td> <?php echo($row['ano']); ?> </td> <?php
                    ?><td> <?php echo($row['NomeBanda']); ?> </td>


                  <form action="musicas.php" method="GET">
                    <td>
                      <button id = "verAlbum" title='Visualizar Album' type = "submit" class="btn btn-info" name = "album" value = "<?php echo($row['IDAlbum']);?>"><i class="fa fa-fw fa-eye "></i></button>
                    </td>
                  </form>
                   
                    <?php 
                    
                }?>
                  
                </tr> 
              </tbody>
            </table>
             <div class="card-footer small text-muted text-center">Para ver mais info, carregar no ícone (<i class="fa fa-fw fa-eye "></i>)</div>
          </div>

        </div>

      </div>





    </div>

        <div class ="col-md-4">
      <div class="card mb-3">
      <div class="card-header">
        <i class="fa fa-music"></i> Artistas da Banda</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Género</th>
                  <th>Instrumento</th>
                  <!--<th>Start date</th>
                    <th>Salary</th> -->
                  </tr>
                </thead>
              <!--<tfoot>
                <tr>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Office</th>
                  <th>Age</th>
                  <th>Start date</th>
                  <th>Salary</th>
                </tr>
              </tfoot>-->
              <tbody>
                <?php
                $query="SELECT NomeCompleto, Nome,genero,A.IDArtista from Artista A join Toca T on T.IDArtista = A.IDArtista join Instrumento I on T.NumSerie = I.ID join FazParte F on F.IDArtista = A.IDArtista where NomeBanda = '$BandNAME';";
                $result = mysqli_query($ligacao,$query);
                while ($row = mysqli_fetch_array($result) ) {
                  ?>
                  <tr>
                    <td> <?php echo($row['NomeCompleto']); ?> </td> <?php
                    ?><td> <?php echo($row['genero']); ?> </td> <?php
                    ?><td> <?php echo($row['Nome']); ?> </td> 

                 <form action="Artista.php" method="get">
                    <td>
                      <button id = "verArtista" title='Visualizar Artista' type = "submit" class="btn btn-info" name = "Artista" value = "<?php echo($row['IDArtista']);?>"><i class="fa fa-fw fa-eye "></i></button>
                    </td>
                  </form>
                   
                    <?php }?>
                 
                </tr> 
              </tbody>
            </table>
            <div class="card-footer small text-muted text-center">Para ver mais info, carregar no ícone (<i class="fa fa-fw fa-eye "></i>)</div>
          </div>
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

<?php
} 




mysqli_close($ligacao);
}
}

?>

</body>
</html>