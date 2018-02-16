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

<?php 
  require('head.php');
  $albumID=$_GET["album"];

      $SQLALBUM= "SELECT Album.Nome as Nome,ano,estilo,foto,NomeBanda,Editora.Nome as NomeEditora from Album join Editora on Album.IDEditora=Editora.IDEditora where IDAlbum= '$albumID';";
      $InfoAlbum=mysqli_query($ligacao,$SQLALBUM);
      
       while($tuplo = mysqli_fetch_array($InfoAlbum)) {
       $NomeAlbum=$tuplo["Nome"];
       $ano=$tuplo["ano"];
       $estilo= $tuplo["estilo"];
       $foto="images/albums/" . $tuplo["foto"];
       $NomeBanda= $tuplo["NomeBanda"];
       $NomeEditora = $tuplo["NomeEditora"];
     }
      if (mysqli_num_rows($InfoAlbum)==0) { //nao existe esse user
              $URL="http://alunos.deec.uc.pt/~jferreira/BDProj/html/dashboard.php";
               echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
               echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
      }





?>
<div class="row">
 <div class="col-md-6 offset-3">
<div class="bg-danger text-white text-center">
<?php

if(isset($_POST["NovoAlbumSub"])){
$target_dir = "images/albums/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "O ficheiro não é uma imagem ou é demasiado grande(culpa do servidor, ver .ini).<br>";
        $uploadOk = 0;
    }

$actual_name = pathinfo($target_file,PATHINFO_FILENAME);
$original_name = $actual_name;
$extension = pathinfo($target_file, PATHINFO_EXTENSION);

$i = 1;
$NomeFicheiro=basename($_FILES["file"]["name"]);
while(file_exists('images/albums/'.$actual_name.".".$extension))
{           
    $actual_name = (string)$original_name.$i;
    $NomeFicheiro = $actual_name.".".$extension;
    $i++;
}
// Check file size
if ($_FILES["file"]["size"] > 1000000) {
    echo "Esse ficheiro tem mais de 1Mb.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" ) {
    echo "Apenas são permitidos ficheiros JPG.<br>";
    $uploadOk = 0;
}



// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "O upload de uma nova Banda falhou.";
// if everything is ok, try to upload file
} else {

    
    
    if (move_uploaded_file($_FILES["file"]["tmp_name"], 'images/albums/'.$NomeFicheiro)) {
        $NovoAlbumNome= $_POST["NomeAlbum"];
        $NovaBandaNome = $_POST["NomeBanda"];
        $AnoNovo = $_POST["AnoLancamento"];
        $EditoraNova =$_POST["EditoraID"];   
        $EstiloNovo = $_POST["Estilo"];


                   $SQL1="UPDATE Album
                    SET Nome='$NovoAlbumNome',ano= '$AnoNovo',estilo= '$EstiloNovo',foto='$NomeFicheiro',NomeBanda='$NovaBandaNome',IDEditora='$EditoraNova' where IDAlbum='$albumID';";
                    $rez=mysqli_query($ligacao,$SQL1);
                        if($rez) echo "</div><div class='bg-success text-white text-center'>O album foi editado com sucesso <br>Para lhe adicionar Músicas carregue <a href='AddMusicas.php'>Aqui</a>";
      
    }else {
        echo "Ocorreu um erro do servidor a fazer upload do ficheiro.";
    }
     $InfoAlbum=mysqli_query($ligacao,$SQLALBUM);
      
       while($tuplo = mysqli_fetch_array($InfoAlbum)) {
       $NomeAlbum=$tuplo["Nome"];
       $ano=$tuplo["ano"];
       $estilo= $tuplo["estilo"];
       $foto="images/albums/" . $tuplo["foto"];
       $NomeBanda= $tuplo["NomeBanda"];
       $NomeEditora = $tuplo["NomeEditora"];
     }

    //SELECT IDArtista from Artista where NomeCompleto = "Artista2 BDProj" group by IDArtista DESC LIMIT 1;
}}
?>
</div>
</div>
</div>
<div class="row">





 <div class="col-md-6 offset-3">
 <div class="card mb-3">
      <div class="card-header">
        <i class="fa fa-user-plus"></i> Editar Álbum</div>
        <form action = "" method = "post"  enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                                <img class="card-img-top img-fluid " src="<?php echo"$foto"?>" alt=""><br>

                   <label for="file">Imagem do Album</label>
              <input type="file" class="form-control-file" id="file" aria-describedby="fileHelp" name= "file" id= "file" required>
               <small id="fileHelp" class="form-text text-muted">A imagem do Álbum tem de ser em formato JPG e ter menos de 1Mb.</small>
                 
        </div>
                <div class="col-md-6 ">
                  <div class="col ">
                  <label for="exampleInputName">Nome do Álbum</label>
                  <input class="form-control" id="exampleInputName" name = "NomeAlbum" type="text" aria-describedby="nameHelp" value="<?php echo $NomeAlbum;?>" required>
                  </div>
                    <div class="col">
                      <label for="inputState"><br>Banda</label>
                       <select name = 'NomeBanda' id="inputState" class="form-control" required>
                        <?php
                        $query="SELECT * FROM Banda";
                        $rez4 = mysqli_query($ligacao,$query);
                        // $row = mysqli_fetch_array($result);
                        while ($row = mysqli_fetch_array($rez4) ) {
                          if($row['NomeBanda']==$NomeBanda){
                          ?><option   value = "<?php echo ($row['NomeBanda'])?>" selected> <?php echo($row['NomeBanda']); ?> </option> <?php
                        }else{?>
                            <option   value = "<?php echo ($row['NomeBanda'])?>" > <?php echo($row['NomeBanda']); ?> </option> 
<?php
                        }

                        }
                        ?>
                      </select>
                       <label for="inputState">Editora</label>
                      <select name = 'EditoraID' id="inputState" class="form-control">
                        <?php
                        $query="SELECT * FROM Editora";
                        $rez4=mysqli_query($ligacao,$query);
                        // $row = mysqli_fetch_array($result);
                         while ($row = mysqli_fetch_array($rez4) ) {
                          if($row['IDEditora']==$IDEditora){
                          ?><option   value = "<?php echo ($row['IDEditora'])?>" selected> <?php echo($row['Nome']); ?> </option> <?php
                        }else{?>
                            <option   value = "<?php echo ($row['IDEditora'])?>" > <?php echo($row['Nome']); ?> </option> 
<?php
                        }

                        }
                        ?>
                      </select>
                    <center><a href="AddEditora.php"><button type="button" name = "NewEditor" class="btn btn-success btn-sm text-right" title ="Adicionar Editora"><i class="fa fa-plus"></i> Adicionar Editora
              </button></a></center>
              <label for="bday">Estilo</label>
                  <input class="form-control" id="exampleInputName" name = "Estilo" type="text" aria-describedby="nameHelp" value="<?php echo $estilo;?>" required>
                    </div>
              </div>
             
              </div>
              
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-4">
             <label for="bday">Ano de Lançamento</label>
                 <input type="number" name="AnoLancamento" min="1337" max="2199" step="1" value="2018" required />

                
                </div>
              <div class="col-md-6 offset-2">
              
                     <div class="col align-self-end">
                     
                    </div>

                  </div>

              </div>
                

            </div>

          
            <div class="card-footer small text-right">
              <button type="submit" name = "NovoAlbumSub" class="btn btn-success btn-lg" title ="Adicionar Album"><i class="fa fa-pencil"></i> Editar Álbum</button>
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