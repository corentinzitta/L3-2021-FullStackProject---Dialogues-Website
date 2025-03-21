        <!-- Portfolio Grid-->
        <section class="page-section bg-light" id="portfolio">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase"> <?php echo $titre ?> </h2>
                </div>
                <div class="row">
				<div class="col-lg-4 col-sm-6 mb-4">

<?php

if($all_invites != NULL) 
{	
	foreach($all_invites as $inv) //Pour chaque ligne obtenu par la requete..
	{ 
			//echo $invite_traite;
			//echo $inv["ivt_libelle"];
			
			if ( !isset($traite_row[$inv["ivt_libelle"] ]) ) //Si on a pas encore traité l'invité de la ligne..
			{
				//On affiche son image et son nom
				            echo " <div class=\"portfolio-item\">
                            <a class=\"portfolio-link\" data-bs-toggle=\"modal\" href=\"#portfolioModal1\">
                                <div class=\"portfolio-hover\">
                                    <div class=\"portfolio-hover-content\"><i class=\"fas fa-plus fa-3x\"></i></div>
                                </div>
                                <img class=\"img-fluid\" src=\" " . $this->config->base_url() . $inv["ivt_img"] . "\" alt=\"...\" /> <!-- lien base_url (visualisable dans config.php) : https://obiwan2.univ-brest.fr/licence/lic110/dev/CodeIgniter/  -->
                            </a>  
                            <div class=\"portfolio-caption\"> 
							<div class=\"portfolio-caption-heading\">". $inv["ivt_libelle"] . "</div>";
					
					//on récupère l'ivt_libelle sur lequel on travail
					$ivt_lib = $inv["ivt_libelle"];
					
					//On récupère ses différents URL 			
					foreach($all_invites as $inv_concerne)
					{
							if( strcmp($ivt_lib,$inv_concerne["ivt_libelle"]) == 0)//On traite un seul invité à la fois (un ivt_libelle à la fois) : celui de la premiere boucle foreach
							{
								if ($inv_concerne["url_lien"] != NULL) //On a un lien à afficher
								{
									if(!isset($traite_lien[ $inv_concerne["url_lien"] ])) // on vérifie s'il à pas déjà été affiché
									{
										echo "<div class=\"portfolio-caption-subheading text-muted\"> " . $inv_concerne["url_lien"] . "</div> ";
										//echo "<a href = \"" . $inv_concerne["url_lien"] . "\"</a> ";
										$traite_lien[ $inv_concerne["url_lien"] ] = 1;
									}
										
								}
								else if($inv_concerne["url_lien"] == NULL ) //on a pas de lien à afficher
								{
										echo "Aucun réseau social renseigné pour le moment";
										echo "<br/>";
										break;
								}
										 
							}	
					}
					
					//On récupère ses différents posts
					foreach($all_invites as $inv_post)
					{
							if( strcmp($ivt_lib,$inv_post["ivt_libelle"]) == 0)//On traite un seul invité à la fois (un ivt_libelle à la fois) : celui de la premiere boucle foreach
							{
								if ($inv_post["pos_text"] != NULL) //On a un lien à afficher
								{
									if(!isset($traite_post[ $inv_post["pos_text"] ])) // on vérifie s'il à pas déjà été affiché
									{
										echo "<br/>";
										echo "<div class=\"portfolio-caption-subheading text-muted\"> " . $inv_post["pos_text"] . "</div> ";
										//echo "<a href = \"" . $inv_concerne["url_lien"] . "\"</a> ";
										$traite_post[ $inv_post["pos_text"] ] = 1;
									}
										
								}
								else if($inv_post["pos_text"] == NULL ) //on a pas de lien à afficher
								{
									echo "<br/>";
									echo "Pas de post pour cet invité";
									break;
								}
										 
							}	
					}
					
					//On a bien traité l'invité $inv["ivt_libelle"]
					$traite_row[ $inv["ivt_libelle"] ] = 1;
					
					echo "</div>
						</div>
						</div> 
						<div class=\"col-lg-4 col-sm-6 mb-4\"> ";
			}
	}
	
}
else
{
	echo "<h2> Aucun invité pour l'instant! </h2>";
}

?>