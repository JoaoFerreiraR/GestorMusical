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
      $ConcertoID= $_GET["Concerto"];
      $sqlconcerto= "SELECT * from Concerto where IDConcerto= '$ConcertoID';";
      $resultado=mysqli_query($ligacao,$sqlconcerto);

      while($tuplo = mysqli_fetch_array($resultado)) {
       $NomeConcerto=$tuplo["Nome"];
       $Data=$tuplo["Data"];
       $Localidade= $tuplo["Localidade"];
       $IDConcerto = $tuplo["IDConcerto"];
     }
      if (mysqli_num_rows($resultado)==0) { //nao existe esse user
              $URL="http://alunos.deec.uc.pt/~jferreira/BDProj/html/dashboard.php";
               echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
               echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
              }


      $sqlCheckConcerto = "SELECT * from Assiste where username= '$user' and IDConcerto= '$ConcertoID';";
      $res=mysqli_query($ligacao,$sqlCheckConcerto);
      $TEMCONCERTO =TRUE;
      if(mysqli_num_rows($res)==0){
        $TEMCONCERTO=FALSE;
      }

      if(isset($_POST["adquirir"])){
        $comprado= $_POST["adquirir"];
        $sqladquirir = "INSERT into Assiste(username,IDConcerto) values('$user','$comprado');";
        $adq=mysqli_query($ligacao,$sqladquirir);
        $TEMCONCERTO=TRUE;

      }







     ?>
   
    <div class = "row">
      <div class="col-md-3">
        <div class="card mb-3">
          <div class="card-header">
           <i class="fa fa-music"></i> Evento
            <?php if($func == 1 || $func==2 ){
          ?>
         <div class=" card-text small float-right">
              <a href="EditEvent.php?Concerto=<?php echo $ConcertoID;?>"><button type="submit" name = "NewBand" class="btn btn-warning text-right" title ="Editar Evento"><i class="fa fa-pencil"></i> Editar Evento
              </button></a>
            </div>
            <?php }?>
         </div>
         <div class="card-body">

          <p class="card-title "><center><b><?php echo $NomeConcerto;?></b></center>
            <p class="card-text small text-center">Localidade do evento:<br> <b><?php echo $Localidade;?></b><br>
              <br>
              <?php
              if($TEMCONCERTO==FALSE){?>
               <form action="" method="post">
              <center><button id = "VerConcerto" title='Visualizar Concerto' type = "submit" class=" btn btn-primary" name = "adquirir" value = "<?php echo($ConcertoID);?>"><i class="fa fa-plus-circle  "></i> Marcar como visto</button></center>
              </form>
              <?php
              }
              else{
              echo "<button type=\"button\" class=\"btn btn-success disabled\">Evento visto</button>";
              }?>
             
              </p>
          </p>

          </div>
        </div>
      </div>
       <div class ="col-md-4">
     <div class="card mb-3">
      <div class="card-header">
        <i class="fa fa-music"></i> Bandas Participantes no evento</div>
        <div class="card-body">
         <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nome da Banda</th>
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

               $query="SELECT B.NomeBanda as NomeBanda, B.DataInicio as DataInicio, B.PaisOrigem as PaisOrigem from Banda B join Atua A on A.NomeBanda = B.NomeBanda where A.IDConcerto = '$ConcertoID';";
                $result = mysqli_query($ligacao,$query);

                while ($row = mysqli_fetch_array($result) ) {
                  ?>
                  <tr>
                    <td> <?php echo($row['NomeBanda']); ?> </td> <?php
                    ?><td> <?php echo($row['PaisOrigem']); ?> </td>

                  <form action="verbanda.php" method="GET">
                    <td>
                      <button id = "verBanda" title='Visualizar Banda' type = "submit" class="btn btn-info" name = "Banda" value = "<?php echo($row['NomeBanda']);?>"><i class="fa fa-fw fa-eye "></i></button>
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
     <div class ="col-md-5">
     <div class="card mb-3">
      <div class="card-header">
        <i class="fa fa-music"></i> Utilizadores que assistiram ao evento</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>username</th>
                  <th>Função</th>
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

                $queryuser="SELECT U.username as username, U.funcao as funcao from Utilizador U join Assiste A on U.username = A.username where A.IDConcerto = '$ConcertoID';";
                $result = mysqli_query($ligacao,$queryuser);

                while ($row = mysqli_fetch_array($result) ) {
                  ?>
                  <tr>
                    <td> <?php echo($row['username']); ?> </td> <?php
                    ?><td> <?php 
                    if($row['funcao']=='0') echo("Utilizador"); 
                    if($row['funcao']=='1') echo("Manager da Banda"); 
                    if($row['funcao']=='2') echo("Administrador"); 

                    ?></td>

                    <form action="Profile.php" method="GET">
                      <td>
                        <button id = "veruser" title='Visualizar utilizador' type = "submit" class="btn btn-info" name = "profile" value = "<?php echo($row['username']);?>"><i class="fa fa-fw fa-eye "></i></button>
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