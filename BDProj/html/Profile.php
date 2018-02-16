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
      $userID= $_GET["profile"];
      $SQLPERFIL= "SELECT username,avatar,DataNascimento,funcao from Utilizador where username= '$userID';";
      $resultado=mysqli_query($ligacao,$SQLPERFIL);

      while($tuplo = mysqli_fetch_array($resultado)) {
       $UserMostrar=$tuplo["username"];
       $DataNascimentoMostrar=$tuplo["DataNascimento"];
       $fotouserMostrar="images/avatars/" . $tuplo["avatar"];
       if($tuplo["funcao"] == '0') $funcaoMostrar= "Utilizador";
       if($tuplo["funcao"] == '1') $funcaoMostrar= "Conta de banda";
       if($tuplo["funcao"] == '2') $funcaoMostrar= "Administrador";
     }
     if (mysqli_num_rows($resultado)==0) { //nao existe esse user
              $URL="http://alunos.deec.uc.pt/~jferreira/BDProj/html/dashboard.php";
               echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
               echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
              }





     ?>
    
    <div class = "row">
      <div class="col-md-3">
        <div class="card mb-3">
          <div class="card-header">
           <i class="fa fa-user"></i> Utilizador
         </div>
         <div class="card-body">
          <h6 class="card-title mb-1">
            <img class="card-img-top img-fluid" src="<?php echo"$fotouserMostrar"?>" alt="">
            <?php echo"<center><big>".$UserMostrar."</big></center>";?>

          </h6>
          <p class="card-title "><center><b><?php echo "Este utilizador é do tipo: " . $funcaoMostrar;?></b></center>
            <p class="card-text small text-center">Data de Nascimento:<?php echo $DataNascimentoMostrar;?><br></p>
          </p>

        </div>
      </div>
    </div>
    <div class ="col-md-4">
     <div class="card mb-3">
      <div class="card-header">
        <i class="fa fa-music"></i> Albums adquiridos pelo utilizador</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Estilo</th>
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

                $queryAlbums="SELECT A.IDAlbum as IDAlbum, A.Nome as NomeAlbum, A.estilo as Estilo ,A.NomeBanda as NomeBanda from Utilizador U  join Obter O on O.username = U.username  join Album A on A.IDAlbum = O.IDAlbum where U.username = '$UserMostrar'; 
                ";
                $result = mysqli_query($ligacao,$queryAlbums);

                while ($row = mysqli_fetch_array($result) ) {
                  ?>
                  <tr>
                    <td> <?php echo($row['NomeAlbum']); ?> </td> <?php
                    ?><td> <?php echo($row['Estilo']); ?> </td> <?php
                    ?><td> <?php echo($row['NomeBanda']); ?> </td>

                    <form action="musicas.php" method="GET">
                      <td>
                        <button id = "verAlbum" title='Visualizar Album' type = "submit" class="btn btn-info" name = "album" value = "<?php echo($row['IDAlbum']);?>"><i class="fa fa-fw fa-eye "></i></button>
                      </td>
                    </form>

                    <?php 
                  }
                  ?>
                  
                </tr> 
              </tbody>
            </table>
            <div class="card-footer small text-muted text-center">Para ver mais info, carregar no ícone (<i class="fa fa-fw fa-eye "></i>)</div>
          </div>
        </div>
      </div>
    </div>
     <div class ="col-md-5">
     <div class="card mb-3">
      <div class="card-header">
        <i class="fa fa-music"></i> Concertos assistidos pelo utilizador</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Localidade</th>
                  <th>Data</th>
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

                $queryAlbums="SELECT C.IDConcerto as IDConcerto, C.Nome as NomeConcerto, C.Localidade as Localidade, C.Data as DataConcerto from Utilizador U  join Assiste L on L.username = U.username  join Concerto C on C.IDConcerto = L.IDConcerto where U.username = '$UserMostrar'; 
; 
                ";
                $result = mysqli_query($ligacao,$queryAlbums);

                while ($row = mysqli_fetch_array($result) ) {
                  ?>
                  <tr>
                    <td> <?php echo($row['NomeConcerto']); ?> </td> <?php
                    ?><td> <?php echo($row['Localidade']); ?> </td> <?php
                    ?><td> <?php echo($row['DataConcerto']); ?> </td>

                    <form action="concerto.php" method="GET">
                      <td>
                        <button id = "verConcerto" title='Visualizar Concerto' type = "submit" class="btn btn-info" name = "Concerto" value = "<?php echo($row['IDConcerto']);?>"><i class="fa fa-fw fa-eye "></i></button>
                      </td>
                    </form>
                    
                    <?php 
                  }
                  ?>
                  
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