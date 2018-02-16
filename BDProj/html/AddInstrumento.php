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
 <div class="col-md-5 offset-3">
<div class="bg-danger text-white text-center">
<?php

if(isset($_POST["NovoInstrumentoSub"])){
      $NomeInstrumentoNovo = $_POST["NomeInst"];
      $IDInstrumentoNovo = $_POST["IDSerie"];
      $CorNova=$_POST["Cor"];
      $SQL="  SELECT ID, Nome from Instrumento where ID = '$IDInstrumentoNovo';";
      $Registar="INSERT into Instrumento(ID,Nome,Cor) values('$IDInstrumentoNovo','$NomeInstrumentoNovo','$CorNova');";
      $resultado=mysqli_query($ligacao,$SQL);
     if($resultado->num_rows >= 1){
      echo "<b><center>Já existe um Instrumento com esse Número de Série !</center></b>";
    }else{
      $checkres= mysqli_query($ligacao,$Registar);
      if($checkres) echo "</div><div class='bg-success text-white text-center'>Foi criado um novo instrumento com sucesso!";
      
    }

}
?>
</div>
</div>
</div>
<div class="row">





 <div class="col-md-5 offset-3  ">
 <div class="card mb-3">
      <div class="card-header">
        <i class="fa fa-user-plus"></i> Adicionar Instrumento</div>
        <form action = "" method = "post"  enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-group">
              <div class="form-row">
              
                <div class="col-md-6 ">
                	<div class="col align-self-center">
                  <label for="exampleInputName">Nome do Instrumento</label>
                  <input class="form-control" id="exampleInputName" name = "NomeInst" type="text" aria-describedby="nameHelp" placeholder="Introduza Nome" required>
                  </div>
                </div>
                  <div class="col align-self-end">
                  <label for="exampleInputLastName">Número de Série</label>
                  <input class="form-control" id="exampleInputLastName" name = "IDSerie" type="number" aria-describedby="nameHelp" placeholder="Introduza Número de série" required>
                  </div>
              </div>
              <div class="col-md-5 ">
              <label for="exampleInputLastName">Cor</label>
              <select name="Cor" class = "form-control" required>
                <option value="Preto" selected>Preto</option> 
                <option value="Vermelho">Vermelho</option>
                <option value="Branco">Branco</option>
                <option value="Azul">Azul</option>
                <option value="Verde">Verde</option>
                <option value="Amarelo">Amarelo</option>
                <option value="Roxo">Roxo</option>
                <option value="Castanho">Castanho</option>
              </select>
              </div>

              </div>

            </div>
           
          
            <div class="card-footer small text-right">
              <button type="submit" name = "NovoInstrumentoSub" class="btn btn-success btn-lg" title ="Adicionar Instrumento"><i class="fa fa-plus"></i> Adicionar Instrumento</button>
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

  <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
        </script>


</body>
</html>