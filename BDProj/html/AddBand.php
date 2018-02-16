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
 <div class="col-md-6 offset-3">
<div class="bg-danger text-white text-center">
<?php

if(isset($_POST["NovaBandaSub"])){
$target_dir = "images/bandas/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "O ficheiro não é uma imagem.<br>";
        $uploadOk = 0;
    }

$actual_name = pathinfo($target_file,PATHINFO_FILENAME);
$original_name = $actual_name;
$extension = pathinfo($target_file, PATHINFO_EXTENSION);

$i = 1;
$NomeFicheiro=basename($_FILES["file"]["name"]);
while(file_exists('images/bands/'.$actual_name.".".$extension))
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

if(empty($_POST["ArtistaID"])){
  echo "Por favor seleccione pelo menos 1 Artista.<br>";
  $uploadOk=0;
}



// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "O upload de uma nova Banda falhou.";
// if everything is ok, try to upload file
} else {
$ArtistasIDs= $_POST["ArtistaID"];
	  $NovaDataN = $_POST["Bday"];
    $NovaDataO = $_POST["Oday"];
    
    
    if (move_uploaded_file($_FILES["file"]["tmp_name"], 'images/bands/'.$NomeFicheiro)) {
       	$NovaBandaNome= $_POST["NomeB"] ;
       	$NovaDataN = $_POST["Bday"];
       	$NovaDataO = $_POST["Oday"];
        $NovoPaisOrigem =$_POST["country"];




       	if(!empty($_POST["Oday"])) { //se tivermos posto data de fim
       		if(date($NovaDataN)>date($NovaDataO)){  
    			echo "A Data de Fim tem de ser maior que a de Fundação.";
  			  }
  			  else{
                   	$SQL1="INSERT into Banda(NomeBanda,DataInicio,DataFim,imagem,PaisOrigem) values('$NovaBandaNome','$NovaDataN','$NovaDataO','$NomeFicheiro','$NovoPaisOrigem');";
                   	$rez=mysqli_query($ligacao,$SQL1);
                   	//inserir Musicos na banda
                     $N = count($ArtistasIDs);
                      for($i=0; $i < $N; $i++) {
                          $SQL3= "INSERT into FazParte(IDArtista,NomeBanda) values ('$ArtistasIDs[$i]','$NovaBandaNome');";
                         $rez3=mysqli_query($ligacao,$SQL3);
                        }
                        
                        if($rez and $rez3) echo "</div><div class='bg-success text-white text-center'>Foi criado uma nova Banda com sucesso!";
          }
       	}else{
       		
       		         $SQL1="INSERT into Banda(NomeBanda,DataInicio,imagem,PaisOrigem) values('$NovaBandaNome','$NovaDataN', '$NomeFicheiro','$NovoPaisOrigem');";
                    $rez=mysqli_query($ligacao,$SQL1);
                    //inserir Musicos na banda
                     $N = count($ArtistasIDs);
                      for($i=0; $i < $N; $i++) {
                          $SQL3= "INSERT into FazParte(IDArtista,NomeBanda) values ('$ArtistasIDs[$i]','$NovaBandaNome');";
                         $rez3=mysqli_query($ligacao,$SQL3);
                        }
                        
                        if($rez and $rez3) echo "</div><div class='bg-success text-white text-center'>Foi criado uma nova Banda com sucesso!";
			
       	}
    } else {
        echo "Ocorreu um erro do servidor a fazer upload do ficheiro.";
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
        <i class="fa fa-user-plus"></i> Adicionar Banda</div>
        <form action = "" method = "post"  enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-group">
              <div class="form-row">
              	<div class="col-md-6">
              		 <label for="file">Imagem da Banda</label>
   						<input type="file" class="form-control-file" id="file" aria-describedby="fileHelp" name= "file" id= "file" required>
   						 <small id="fileHelp" class="form-text text-muted">A imagem da Banda tem de ser em formato JPG e ter menos de 1Mb.</small>

				</div>
                <div class="col-md-6 ">
                	<div class="col align-self-center">
                  <label for="exampleInputName">Nome da Banda</label>
                  <input class="form-control" id="exampleInputName" name = "NomeB" type="text" aria-describedby="nameHelp" placeholder="Introduza o Nome da Banda" required>
                  </div>
                  
              </div>
             
              </div>
              
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-4">
      			 <label for="bday">Data de Fundação</label>
                 <input type="date" name="Bday" value="0000-00-00" required >

      			 <label for="bday">Data de Fim</label>
                 <input type="date" name="Oday" value="0000-00-00" >
                
                </div>
              <div class="col-md-6 offset-2">
                <div class="col align-self-end">
                      <label for="inputState">País de Origem</label>
                      <select name="country" class = "form-control" required>
<option value="Afganistan" selected>Afghanistan</option> 
<option value="Albania">Albania</option>
<option value="Algeria">Algeria</option>
<option value="American Samoa">American Samoa</option>
<option value="Andorra">Andorra</option>
<option value="Angola">Angola</option>
<option value="Anguilla">Anguilla</option>
<option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
<option value="Argentina">Argentina</option>
<option value="Armenia">Armenia</option>
<option value="Aruba">Aruba</option>
<option value="Australia">Australia</option>
<option value="Austria">Austria</option>
<option value="Azerbaijan">Azerbaijan</option>
<option value="Bahamas">Bahamas</option>
<option value="Bahrain">Bahrain</option>
<option value="Bangladesh">Bangladesh</option>
<option value="Barbados">Barbados</option>
<option value="Belarus">Belarus</option>
<option value="Belgium">Belgium</option>
<option value="Belize">Belize</option>
<option value="Benin">Benin</option>
<option value="Bermuda">Bermuda</option>
<option value="Bhutan">Bhutan</option>
<option value="Bolivia">Bolivia</option>
<option value="Bonaire">Bonaire</option>
<option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
<option value="Botswana">Botswana</option>
<option value="Brazil">Brazil</option>
<option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
<option value="Brunei">Brunei</option>
<option value="Bulgaria">Bulgaria</option>
<option value="Burkina Faso">Burkina Faso</option>
<option value="Burundi">Burundi</option>
<option value="Cambodia">Cambodia</option>
<option value="Cameroon">Cameroon</option>
<option value="Canada">Canada</option>
<option value="Canary Islands">Canary Islands</option>
<option value="Cape Verde">Cape Verde</option>
<option value="Cayman Islands">Cayman Islands</option>
<option value="Central African Republic">Central African Republic</option>
<option value="Chad">Chad</option>
<option value="Channel Islands">Channel Islands</option>
<option value="Chile">Chile</option>
<option value="China">China</option>
<option value="Christmas Island">Christmas Island</option>
<option value="Cocos Island">Cocos Island</option>
<option value="Colombia">Colombia</option>
<option value="Comoros">Comoros</option>
<option value="Congo">Congo</option>
<option value="Cook Islands">Cook Islands</option>
<option value="Costa Rica">Costa Rica</option>
<option value="Cote DIvoire">Cote D'Ivoire</option>
<option value="Croatia">Croatia</option>
<option value="Cuba">Cuba</option>
<option value="Curaco">Curacao</option>
<option value="Cyprus">Cyprus</option>
<option value="Czech Republic">Czech Republic</option>
<option value="Denmark">Denmark</option>
<option value="Djibouti">Djibouti</option>
<option value="Dominica">Dominica</option>
<option value="Dominican Republic">Dominican Republic</option>
<option value="East Timor">East Timor</option>
<option value="Ecuador">Ecuador</option>
<option value="Egypt">Egypt</option>
<option value="El Salvador">El Salvador</option>
<option value="Equatorial Guinea">Equatorial Guinea</option>
<option value="Eritrea">Eritrea</option>
<option value="Estonia">Estonia</option>
<option value="Ethiopia">Ethiopia</option>
<option value="Falkland Islands">Falkland Islands</option>
<option value="Faroe Islands">Faroe Islands</option>
<option value="Fiji">Fiji</option>
<option value="Finland">Finland</option>
<option value="France">France</option>
<option value="French Guiana">French Guiana</option>
<option value="French Polynesia">French Polynesia</option>
<option value="French Southern Ter">French Southern Ter</option>
<option value="Gabon">Gabon</option>
<option value="Gambia">Gambia</option>
<option value="Georgia">Georgia</option>
<option value="Germany">Germany</option>
<option value="Ghana">Ghana</option>
<option value="Gibraltar">Gibraltar</option>
<option value="Great Britain">Great Britain</option>
<option value="Greece">Greece</option>
<option value="Greenland">Greenland</option>
<option value="Grenada">Grenada</option>
<option value="Guadeloupe">Guadeloupe</option>
<option value="Guam">Guam</option>
<option value="Guatemala">Guatemala</option>
<option value="Guinea">Guinea</option>
<option value="Guyana">Guyana</option>
<option value="Haiti">Haiti</option>
<option value="Hawaii">Hawaii</option>
<option value="Honduras">Honduras</option>
<option value="Hong Kong">Hong Kong</option>
<option value="Hungary">Hungary</option>
<option value="Iceland">Iceland</option>
<option value="India">India</option>
<option value="Indonesia">Indonesia</option>
<option value="Iran">Iran</option>
<option value="Iraq">Iraq</option>
<option value="Ireland">Ireland</option>
<option value="Isle of Man">Isle of Man</option>
<option value="Israel">Israel</option>
<option value="Italy">Italy</option>
<option value="Jamaica">Jamaica</option>
<option value="Japan">Japan</option>
<option value="Jordan">Jordan</option>
<option value="Kazakhstan">Kazakhstan</option>
<option value="Kenya">Kenya</option>
<option value="Kiribati">Kiribati</option>
<option value="Korea North">Korea North</option>
<option value="Korea Sout">Korea South</option>
<option value="Kuwait">Kuwait</option>
<option value="Kyrgyzstan">Kyrgyzstan</option>
<option value="Laos">Laos</option>
<option value="Latvia">Latvia</option>
<option value="Lebanon">Lebanon</option>
<option value="Lesotho">Lesotho</option>
<option value="Liberia">Liberia</option>
<option value="Libya">Libya</option>
<option value="Liechtenstein">Liechtenstein</option>
<option value="Lithuania">Lithuania</option>
<option value="Luxembourg">Luxembourg</option>
<option value="Macau">Macau</option>
<option value="Macedonia">Macedonia</option>
<option value="Madagascar">Madagascar</option>
<option value="Malaysia">Malaysia</option>
<option value="Malawi">Malawi</option>
<option value="Maldives">Maldives</option>
<option value="Mali">Mali</option>
<option value="Malta">Malta</option>
<option value="Marshall Islands">Marshall Islands</option>
<option value="Martinique">Martinique</option>
<option value="Mauritania">Mauritania</option>
<option value="Mauritius">Mauritius</option>
<option value="Mayotte">Mayotte</option>
<option value="Mexico">Mexico</option>
<option value="Midway Islands">Midway Islands</option>
<option value="Moldova">Moldova</option>
<option value="Monaco">Monaco</option>
<option value="Mongolia">Mongolia</option>
<option value="Montserrat">Montserrat</option>
<option value="Morocco">Morocco</option>
<option value="Mozambique">Mozambique</option>
<option value="Myanmar">Myanmar</option>
<option value="Nambia">Nambia</option>
<option value="Nauru">Nauru</option>
<option value="Nepal">Nepal</option>
<option value="Netherland Antilles">Netherland Antilles</option>
<option value="Netherlands">Netherlands (Holland, Europe)</option>
<option value="Nevis">Nevis</option>
<option value="New Caledonia">New Caledonia</option>
<option value="New Zealand">New Zealand</option>
<option value="Nicaragua">Nicaragua</option>
<option value="Niger">Niger</option>
<option value="Nigeria">Nigeria</option>
<option value="Niue">Niue</option>
<option value="Norfolk Island">Norfolk Island</option>
<option value="Norway">Norway</option>
<option value="Oman">Oman</option>
<option value="Pakistan">Pakistan</option>
<option value="Palau Island">Palau Island</option>
<option value="Palestine">Palestine</option>
<option value="Panama">Panama</option>
<option value="Papua New Guinea">Papua New Guinea</option>
<option value="Paraguay">Paraguay</option>
<option value="Peru">Peru</option>
<option value="Phillipines">Philippines</option>
<option value="Pitcairn Island">Pitcairn Island</option>
<option value="Poland">Poland</option>
<option value="Portugal">Portugal</option>
<option value="Puerto Rico">Puerto Rico</option>
<option value="Qatar">Qatar</option>
<option value="Republic of Montenegro">Republic of Montenegro</option>
<option value="Republic of Serbia">Republic of Serbia</option>
<option value="Reunion">Reunion</option>
<option value="Romania">Romania</option>
<option value="Russia">Russia</option>
<option value="Rwanda">Rwanda</option>
<option value="St Barthelemy">St Barthelemy</option>
<option value="St Eustatius">St Eustatius</option>
<option value="St Helena">St Helena</option>
<option value="St Kitts-Nevis">St Kitts-Nevis</option>
<option value="St Lucia">St Lucia</option>
<option value="St Maarten">St Maarten</option>
<option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
<option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
<option value="Saipan">Saipan</option>
<option value="Samoa">Samoa</option>
<option value="Samoa American">Samoa American</option>
<option value="San Marino">San Marino</option>
<option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
<option value="Saudi Arabia">Saudi Arabia</option>
<option value="Senegal">Senegal</option>
<option value="Serbia">Serbia</option>
<option value="Seychelles">Seychelles</option>
<option value="Sierra Leone">Sierra Leone</option>
<option value="Singapore">Singapore</option>
<option value="Slovakia">Slovakia</option>
<option value="Slovenia">Slovenia</option>
<option value="Solomon Islands">Solomon Islands</option>
<option value="Somalia">Somalia</option>
<option value="South Africa">South Africa</option>
<option value="Spain">Spain</option>
<option value="Sri Lanka">Sri Lanka</option>
<option value="Sudan">Sudan</option>
<option value="Suriname">Suriname</option>
<option value="Swaziland">Swaziland</option>
<option value="Sweden">Sweden</option>
<option value="Switzerland">Switzerland</option>
<option value="Syria">Syria</option>
<option value="Tahiti">Tahiti</option>
<option value="Taiwan">Taiwan</option>
<option value="Tajikistan">Tajikistan</option>
<option value="Tanzania">Tanzania</option>
<option value="Thailand">Thailand</option>
<option value="Togo">Togo</option>
<option value="Tokelau">Tokelau</option>
<option value="Tonga">Tonga</option>
<option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
<option value="Tunisia">Tunisia</option>
<option value="Turkey">Turkey</option>
<option value="Turkmenistan">Turkmenistan</option>
<option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
<option value="Tuvalu">Tuvalu</option>
<option value="Uganda">Uganda</option>
<option value="Ukraine">Ukraine</option>
<option value="United Arab Erimates">United Arab Emirates</option>
<option value="United Kingdom">United Kingdom</option>
<option value="United States of America">United States of America</option>
<option value="Uraguay">Uruguay</option>
<option value="Uzbekistan">Uzbekistan</option>
<option value="Vanuatu">Vanuatu</option>
<option value="Vatican City State">Vatican City State</option>
<option value="Venezuela">Venezuela</option>
<option value="Vietnam">Vietnam</option>
<option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
<option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
<option value="Wake Island">Wake Island</option>
<option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
<option value="Yemen">Yemen</option>
<option value="Zaire">Zaire</option>
<option value="Zambia">Zambia</option>
<option value="Zimbabwe">Zimbabwe</option>
</select>
                    </div>

                  </div>

              </div>
                <hr class="mt-2">
                
                 <label for="checkbox">Membros da Banda</label>
                  <div class= "row">
                  <div class= "col-md-8 offset-1">
                    <?php 
                    $SQLARTISTAS="SELECT a.IDArtista,a.NomeCompleto, i.Nome from Artista a Join Toca t on a.IDArtista = t.IDArtista join Instrumento i on i.ID = t.NumSerie;";
                    $rez4 = mysqli_query($ligacao,$SQLARTISTAS);
                    while ($row = mysqli_fetch_array($rez4) ) {
                    echo"
                      <input type='checkbox' name='ArtistaID[]' value='".$row['IDArtista']."' /> ".$row['NomeCompleto']." - ".$row['Nome'].".<br />";
                      }
                      ?>
                  </div>
                </div>

            </div>

          
            <div class="card-footer small text-right">
              <button type="submit" name = "NovaBandaSub" class="btn btn-success btn-lg" title ="Adicionar Banda"><i class="fa fa-plus"></i> Adicionar Banda</button>
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