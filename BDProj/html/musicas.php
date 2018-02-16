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
      $albumID= $_GET["album"];
      $SQLALBUM= "SELECT * from Album where IDAlbum= '$albumID';";
      $resultado=mysqli_query($ligacao,$SQLALBUM);
      if (mysqli_num_rows($resultado)==0) { //nao existe esse user
              $URL="http://alunos.deec.uc.pt/~jferreira/BDProj/html/dashboard.php";
               echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
               echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
              }


      $sqlCheckReview = "SELECT * from Classifica where username= '$user' and IDAlbum= '$albumID';";
      $res2=mysqli_query($ligacao,$sqlCheckReview);
      $FEZREVIEW =TRUE;
      if(mysqli_num_rows($res2)==0){
        $FEZREVIEW=FALSE;
        $SuaReview="N/A";
      }
       while($tuplo = mysqli_fetch_array($res2)) {
        $SuaReview=$tuplo["score"];
     }

      if(isset($_POST["NovaReview"])){
        $rev= $_POST["NovaReview"];
        $sqlfazernova = "INSERT into Classifica(username,IDAlbum,score) values('$user','$albumID','$rev');";
        $adq2=mysqli_query($ligacao,$sqlfazernova);
        $FEZREVIEW=TRUE;
      }

      if(isset($_POST["MudarReview"])){
        $rev= $_POST["MudarReview"];
        $sqlmudarrev = "UPDATE Classifica set score = '$rev' where username='$user' and IDAlbum='$albumID';";
        $adq3=mysqli_query($ligacao,$sqlmudarrev);
        $FEZREVIEW=TRUE;
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

          if(isset($_POST["ApagarMusica"])){
          $del = $_POST["ApagarMusica"];
          $sql = "DELETE from Musica where IDMusica ='$del';";
          mysqli_query($ligacao,$sql);
        }
      


      if(isset($_POST["adquirir"])){
        $comprado= $_POST["adquirir"];
        $sqladquirir = "INSERT into Obter(username,IDAlbum) values('$user','$comprado');";
        $adq=mysqli_query($ligacao,$sqladquirir);
        $TEMALBUM=TRUE;

      }

        if(isset($_POST["ApagarMusica"])){
          $del = $_POST["ApagarMusica"];
          $sql = "DELETE from Musica where IDMusica ='$del';";
          mysqli_query($ligacao,$sql);
        }


      

       


     ?>
    
    <div class = "row">
      <div class="col-md-4">
        <div class="card mb-3">
          <div class="card-header">
           <i class="fa fa-music"></i> Álbum
            <?php if(($func == 1 && strtolower($user) ==strtolower($NomeBanda)|| $func==2 )){
          ?>
         <div class=" card-text small float-right">
              <a href="EditAlbum.php?album=<?php echo $albumID;?>"><button type="submit" name = "NewBand" class="btn btn-warning text-right" title ="Editar Album"><i class="fa fa-pencil"></i> Editar Album
              </button></a>
            </div>
       <?php }?>
         </div>
         <div class="card-body">
          <h6 class="card-title mb-1">
            <img class="card-img-top img-fluid " src="<?php echo"$foto"?>" alt="">
            <?php echo"<center><b>".$NomeAlbum."</b></center><br>";
                  echo"<center>Pontuação Média: " . $review . "<br><small>A sua avaliação: ".$SuaReview."</small></center>";
            ?>

          </h6>
          <p class="card-title "><center><b>Banda: <?php echo $NomeBanda;?></b></center>
            <p class="card-text small text-center">Estilo: <?php echo  $estilo;?><br>
              Ano: <?php echo $ano;?><br>

              <?php

              if($TEMALBUM==FALSE){?>
               <form action="" method="post">
              <center><button id = "AdquirirAlbum" title='Visualizar Artista' type = "submit" class=" btn btn-primary" name = "adquirir" value = "<?php echo($albumID);?>"><i class="fa fa-plus-circle  "></i> Adquirir Álbum</button></center>
              </form>
              <?php
              }
              else{ //tem album
              echo "<button type=\"button\" class=\"btn btn-success disabled\">Álbum Adquirido</button>";
              
                        if($FEZREVIEW==FALSE){
                          echo "<div class= 'row'>
                          <div class='col-md-4 offset-md-4' >
                          <form id='FormReview' action='' method='POST'>
                          <div class='form-group'>";

                          $select= '<select id="reviews" class="form-control form-control-sm " name="NovaReview">';
                          for($i=1;$i<=5;$i++){
                            if($i ==1){
                              $select.='<option value="'.$i.'">'.$i.' Estrela</option>';
                            }else{
                              $select.='<option  value="'.$i.'">'.$i.' Estrelas</option>';
                              if($i==5) $select.='<option selected value=5>- Estrelas</option>';
                            }
                          }
                          $select.='</select></div></form></div></div>';
                          echo $select;

                        }
                        else{

                          echo "<div class= 'row'>
                          <div class='col-md-4 offset-md-4' >
                          <form id='FormReview2' action='' method='POST'>
                          <div class='form-group'>";

                          $select= '<select id="reviews2" class="form-control form-control-sm " name="MudarReview">';
                          for($i=1;$i<=5;$i++){
                            if($i ==1){
                              $select.='<option value="'.$i.'">'.$i.' Estrela</option>';
                            }else{
                              $select.='<option  value="'.$i.'">'.$i.' Estrelas</option>';
                               if($i==5) $select.='<option selected value=5>- Estrelas</option>';
                            }
                          }
                          $select.='</select></div></form></div></div>';
                          echo $select;

                        }
            }
              ?>
              </p>
          </p>

          </div>
        </div>
      </div>
      <div class ="col-md-8">
        <div class="card mb-3">
          <div class="card-header">
            <?php if($func == 1 || $func==2){
          ?>
         <div class=" card-text small float-right">
              <a href="AddMusicas.php"><button type="button" name = "NewAlbum" class="btn btn-success text-right" title ="Adicionar Musicas"><i class="fa fa-plus"></i> Adicionar Músicas
              </button></a>
            </div>
       <?php }?>
            <i class="fa fa-music"></i> Músicas do Álbum <b><?php echo $NomeAlbum;?></b> </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable"  cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nome</th>
                      <th>Duração</th>
                     <?php if($func=='2' || $func=='1') echo "<th></th>";?>

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

                $query="SELECT * FROM Musica where IDAlbum = '$albumID';";
                $result = mysqli_query($ligacao,$query);
                while ($row = mysqli_fetch_array($result)) { ?>
                <tr>
                  <td> <?php echo($row['nome']); ?> </td>
                  <td> <?php echo($row['duracao']); ?> </td> 

                  
                   
                  
                    <?php if(($func==2)||($func==1 && $user == $NomeBanda)){?>
                   
                    <form action="" method="post">
                    <td>
                      <button id = "ApagarMusica" title='Eliminar Musica' type = "submit" class="btn btn-danger" name = "ApagarMusica" value = "<?php echo($row['IDMusica']);?>"><i class="fa fa-fw fa-trash-o"></i></button>
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
<script>
$(document).ready(function(){
  $("#reviews").change(function() {
     $("#FormReview").submit();
  });
  $("#reviews2").change(function() {
     $("#FormReview2").submit();
  });


});
</script>


</body>


</html>