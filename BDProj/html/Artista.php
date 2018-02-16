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
      $ArtID= $_GET["Artista"];
      $SQLART= "SELECT * from Artista where IDArtista= '$ArtID';";
      $resultado=mysqli_query($ligacao,$SQLART);

      while($tuplo = mysqli_fetch_array($resultado)) {
       $NomeCompleto=$tuplo["NomeCompleto"];
       $genero=$tuplo["genero"];
       $DataNascimento= $tuplo["DataNascimento"];
       $DataObito= $tuplo["DataObito"];
       if($DataObito==NULL) $DataObito = "N/A";
       $foto="images/artistas/" . $tuplo["foto"];
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
           <i class="fa fa-music"></i> Artista
           <?php if( ($func==2 ) or ($func ==1) ){
          ?>
         <div class=" card-text small float-right">
              <a href="EditArtista.php?Artista=<?php echo $ArtID;?>"><button type="submit" name = "ArtistaID" class="btn btn-warning text-right" title ="Editar Artista"><i class="fa fa-pencil"></i> Editar Artista
              </button></a>
            </div>
       <?php }?>
         </div>
         <div class="card-body">
          <h6 class="card-title mb-1">
            <img class="card-img-top img-fluid " src="<?php echo"$foto"?>" alt="">
           

          </h6>
          <p class="card-title "><center><b><?php echo $NomeCompleto;?></b></center>
            <p class="card-text small text-center">Data de Nascimento / Óbito:<br> <b><?php echo $DataNascimento . "  &#8212 " . $DataObito;?></b><br>
              <br>

              </p>
          </p>

          </div>
        </div>
      </div>
      <div class ="col-md-4">
        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-music"></i> Bandas do Artista </div>
            <div class="card-body">
              <div class="table-responsive">
                           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>País de Origem</th>
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

               $query="SELECT B.NomeBanda as NomeBanda, B.PaisOrigem as Pais from Artista A join FazParte F on F.IDArtista = A.IDArtista join Banda B on F.NomeBanda = B.NomeBanda where A.IDArtista = '$ArtID';";
                $result = mysqli_query($ligacao,$query);

                while ($row = mysqli_fetch_array($result) ) {
                  ?>
                  <tr>
                    <td> <?php echo($row['NomeBanda']); ?> </td> <?php
                    ?><td> <?php echo($row['Pais']); ?> </td>


                  <form action="verbanda.php" method="GET">
                    <td>
                      <button id = "verbanda" title='Visualizar Album' type = "submit" class="btn btn-info" name = "Banda" value = "<?php echo($row['NomeBanda']);?>"><i class="fa fa-fw fa-eye "></i></button>
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
        <i class="fa fa-music"></i> Instrumento que o Artista toca</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Tipo de Instrumento</th>
                  <th>Número de Série</th>
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
                $query="SELECT I.Nome as NomeInstrumento, I.ID as NumSerie,I.Cor as Cor from Artista A join Toca T on T.IDArtista = A.IDArtista join Instrumento I on I.ID = T.NumSerie where A.IDArtista = '$ArtID'";
                $result = mysqli_query($ligacao,$query);
                while ($row = mysqli_fetch_array($result) ) {
                  ?>
                  <tr>
                    <td> <?php echo($row['NomeInstrumento']); ?> </td> <?php
                    ?><td> <?php echo($row['NumSerie']); ?> </td> <?php
                    ?><td> <?php echo($row['Cor']); ?> </td> 

                
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