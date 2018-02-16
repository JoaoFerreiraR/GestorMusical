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

        if(isset($_POST["ApagarArtista"])){
          $del = $_POST["ApagarArtista"];
          $sql = "DELETE from Artista where IDArtista ='$del';";
          $resultado2=mysqli_query($ligacao,$sql);
        }
        
        







        ?>




<?php require('head.php');?>


    <!-- Example DataTables Card-->
    <div class="card mb-3">
      <div class="card-header  ">
        <i class="fa fa-music"></i> Artistas
        <?php if($func == 1 || $func==2){
          ?>
         <div class=" card-text small float-right">
              <a href="AddArt.php"><button type="button" name = "NewArtist" class="btn btn-success text-right" title ="Adicionar Artista"><i class="fa fa-plus"></i> Adicionar Artista
              </button></a>
            </div>
       <?php }?>
       </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Género</th>
                  <th>Data Nascimento</th>
                  <th>Data de Óbito</th>
                   <th></th>
                  
                  <?php if($func==2)echo"<th></th><th></th>";?>
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
                $query="SELECT * FROM Artista;";
                $result = mysqli_query($ligacao,$query);
                while ($row = mysqli_fetch_array($result) ) {
                  ?>
                  <tr>
                    <td> <?php echo($row['NomeCompleto']); ?> </td> <?php
                    ?><td> <?php echo($row['genero']); ?> </td> <?php
                    ?><td> <?php echo($row['DataNascimento']); ?> </td> <?php
                    ?><td> 
                      <?php
                      if(empty($row['DataObito'])){
                        echo "N/A";
                      } else echo($row['DataObito']);
                      ?>
                    </td>

                 <form action="Artista.php" method="get">
                    <td>
                      <button id = "verArtista" title='Visualizar Artista' type = "submit" class="btn btn-info" name = "Artista" value = "<?php echo($row['IDArtista']);?>"><i class="fa fa-fw fa-eye "></i></button>
                    </td>
                  </form>
                    <?php if($func==2){?>
                     <form action="EditArtista.php" method="get">
                    <td>
                      <button id = "EditarArtista" title='Editar Artista' type = "submit" class="btn btn-success" name = "Artista" value = "<?php echo($row['IDArtista']);?>"><i class="fa fa-fw fa-pencil-square-o"></i></button>
                    </td>
                  </form>
                  <form action="" method="post">

                    <td>
                      <button id = "ApagarArtista" title='Eliminar Artista' type = "submit" class="btn btn-danger" name = "ApagarArtista" value = "<?php echo($row['IDArtista']);?>"><i class="fa fa-fw fa-trash-o"></i></button>
                    </td>
                     </form>
                    <?php }}?>
                 
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