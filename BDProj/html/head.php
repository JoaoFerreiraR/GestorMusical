

        <body class="fixed-nav sticky-footer bg-dark" id="page-top">
              <div class="modal fade" id="logoutPop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Tem a certeza que pretende fazer logout?</h5>
                      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-fw fa-close"></i></span>
                      </button>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-secondary" type="button" data-dismiss="modal">Não</button>
                      <a class="btn btn-primary" href="logout.php">Sim</a>
                    </div>
                  </div>
                </div>
              </div>
          <!-- Navigation-->
          <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <a class="navbar-brand" href="dashboard.php"><img  src="images/icon.png"> Base de Dados <img  src="images/icon.png"></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
              <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                  <a class="nav-link" href="dashboard.php">
                    <i class="fa fa-fw fa-dashboard"></i>
                    <span class="nav-link-text">Dashboard</span>
                  </a>
                </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Artistas">
            <a class="nav-link" href="Artistas.php">
              <i class="fa fa-fw fa-star"></i>
              <span class="nav-link-text">Artistas</span>
            </a>
          </li>                
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Bandas">
            <a class="nav-link" href="Bandas.php">
              <i class="fa fa-fw fa-music"></i>
              <span class="nav-link-text">Bandas</span>
            </a>
          </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Albums">
            <a class="nav-link" href="Albums.php">
              <i class="fa fa-fw fa-book"></i>
              <span class="nav-link-text">Albums</span>
            </a>
          </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Concertos">
            <a class="nav-link" href="Concertos.php">
              <i class="fa fa-fw fa-camera-retro  "></i>
              <span class="nav-link-text">Concertos</span>
            </a>
          </li> 
          
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Utilizadores">
            <a class="nav-link" href="Utilizadores.php">
              <i class="fa fa-fw fa-users "></i>
              <span class="nav-link-text">Utilizadores</span>
            </a>
          </li>
          <?php
          if($func=='2'||$func=='1'){?>

           <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-certificate"></i>
            <span class="nav-link-text">Adicionar elementos</span>
          </a>



          <ul class="sidenav-second-level collapse" id="collapseComponents">
            
            <li>
              <a href="AddMusicas.php"><i class="fa fa-fw fa-music"></i> Adicionar Músicas</a>
            </li>
            <li>
              <a href="AddEditora.php"><i class="fa fa-fw fa-tag  "></i> Adicionar Editora</a>
            </li>
            <li>
              <a href="AddInstrumento.php"><i class="fa fa-fw fa-gavel  "></i> Adicionar Instrumento</a>
            </li>

          </ul>
        </li>
        <?php }
                         

          
          echo "<li class='nav-item' data-toggle='tooltip' data-placement='right' title='Link'>
          <a class='nav-link' href='EditOwn.php'>
          <i class='fa fa-fw fa-pencil'></i>
          <span class='nav-link-text'>Editar própria conta</span>
          </a>
          </li>";

          /* <a href='EditOwn.php'>Edita a tua conta aqui!</a><br> */
          
          
          
        
        ?>
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
          <?php echo "<img src='images/avatars/" . $avatar . "' height='40' width='40' >";?>
                 <a class="nav-link" href = 'Profile.php?profile=<?php echo $user;?>'> <?php echo "Logado como: " . $user;?></a>
       <li class="nav-item">
        <a class="nav-link" data-toggle="modal" data-target="#logoutPop">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="container-fluid">

 <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        
        <li class="breadcrumb-item active">
          <?php
        if($pass == $CheckPass){ //se user for legit
          echo "<big>Bem vindo $user</big>";
        }
        ?>
      </li>
    </ol>
  