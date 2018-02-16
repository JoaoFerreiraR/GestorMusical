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

        if(isset($_POST["ApagarUser"])){
          $del = $_POST["ApagarUser"];
          $sql = "DELETE from Utilizador where username ='$del';";
          mysqli_query($ligacao,$sql);
        }
        if(isset($_POST["PromoUser"])){
          $del = $_POST["PromoUser"];
          $sql = "UPDATE Utilizador SET funcao='2' WHERE username='$del';";
          mysqli_query($ligacao,$sql);
        }
        if(isset($_POST["PromoUser2"])){
          $del = $_POST["PromoUser2"];
          $sql = "UPDATE Utilizador SET funcao='1' WHERE username='$del';";
          mysqli_query($ligacao,$sql);
        }
        if(isset($_POST["DemoteUser"])){
          $del = $_POST["DemoteUser"];
          $sql = "UPDATE Utilizador SET funcao='0' WHERE username='$del';";
          mysqli_query($ligacao,$sql);
        }
        
        







        ?>



<?php require('head.php');?>



     <!-- Example DataTables Card-->
    <div class="card mb-3">
      <div class="card-header  ">
        <i class="fa fa-music"></i> Utilizadores
     
       </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Username</th>
                  <th>Data de Nascimento</th>
                
                  <th>Funcão</th>
                  <th></th>
                  <?php if($func=='2'){ ?>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                 <?php } ?>
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

               $query="SELECT username,DataNascimento,funcao from Utilizador where username<>'$user' and username<>'root';";
                $result = mysqli_query($ligacao,$query);

                while ($row = mysqli_fetch_array($result) ) {
                  ?>
                  <tr>
                    <td> <?php echo($row['username']); ?> </td> <?php
                    ?><td> <?php echo($row['DataNascimento']); ?> </td> <?php
                     ?><td> <?php 
                    if($row['funcao']=='0') echo("Utilizador"); 
                    if($row['funcao']=='1') echo("Manager da Banda"); 
                    if($row['funcao']=='2') echo("Administrador"); 

                    ?></td>




                  <form action="Profile.php" method="GET">
                    <td>
                      <button id = "verPerfil" title='Visualizar Perfil' type = "submit" class="btn btn-info" name = "profile" value = "<?php echo($row['username']);?>"><i class="fa fa-fw fa-eye "></i></button>
                    </td>
                  </form>
                   <?php if($func==2){?>
                    <form action="" method="post">
                     
                   
                    <td>
                      <button id = "ApagarUser" title='Eliminar User' type = "submit" class="btn btn-danger" name = "ApagarUser" value = "<?php echo($row['username']);?>"><i class="fa fa-fw fa-trash-o"></i></button>
                    </td>
                     <td>
                      <button id = "DemoverUser" title='Demover User' type = "submit" class="btn btn-danger" name = "DemoteUser" value = "<?php echo($row['username']);?>"><i class="fa fa-fw fa-thumbs-o-down"></i>User</button>
                    </td>
                    <td>
                      <button id = "PromoverUser2" title='Promover User a Banda' type = "submit" class="btn btn-warning" name = "PromoUser2" value = "<?php echo($row['username']);?>"><i class="fa fa-fw fa-key"></i>Band</button>
                    </td>
                    <td>
                      <button id = "PromoverUser" title='Promover User' type = "submit" class="btn btn-success" name = "PromoUser" value = "<?php echo($row['username']);?>"><i class="fa fa-fw fa-key"></i>Admin</button>
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