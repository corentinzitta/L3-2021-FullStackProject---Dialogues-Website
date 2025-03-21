<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>La musique dans la peau!</title>
        <!-- Favicon-->
        <!-- ><link rel="icon" type="image/x-icon" href="assets/favicon.ico" /> -->
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="<?php echo base_url();?>style/css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        
		<!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
         
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
						<li class="nav-item"><a class="nav-link" href="<?php echo $this->config->base_url(); ?>index.php/programmation/lister_admin">Programmation</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $this->config->base_url(); ?>index.php/compte/consulter">Profil</a></li>
                        <!--<li class="nav-item"><a class="nav-link"> truc3 </a></li> -->
                        <!-- <li class="nav-item"><a class="nav-link" href="#team">Team</a></li> -->
                        <li class="nav-item"><a class="nav-link" href="<?php echo $this->config->base_url(); ?>index.php/compte/deconnecter">Déconnexion</a></li>
                    </ul>
                </div>
            </div>
        </nav> 
		
	    <!-- MASTHEAD -->
 
	    <header class="masthead">
	        <div class="container">
	            <div class="masthead-subheading">Bienvenue sur le back office de l'application !</div>
	            <div class="masthead-heading text-uppercase">La musique dans la peau</div>
	           <!-- <a class="btn btn-primary btn-xl text-uppercase" href="#services">Voir les actualités</a> -->
	        </div>
	    </header>
	    