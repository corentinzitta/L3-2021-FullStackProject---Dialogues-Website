<?php

	if(!isset($_SESSION['username']) || !isset($_SESSION['statut'])) //si la session n'est pas ouverte, on redirige
	{
		//echo "pas de session";
		redirect(base_url()."index.php/compte/connecter");
	}

	if ($_SESSION['statut'] != 'Invite')
	{
		redirect(base_url()."index.php/compte/connecter");
	}

	if ($infos_invites != NULL)
	{
		echo"<h1>"; echo "<center>"; echo $titre ; echo"</h1>"; echo "</center>";
	
		//Définition des tetes de tableau
		echo"<table class=\"table\">";
				
		echo "<tr>";
				
			echo "<th>"; echo "Identifiant"; echo "</th>";
			echo "<th>"; echo "Nom d'artiste"; echo "</th>";
			echo "<th>"; echo "Discipline"; echo "</th>";
			echo "<th>"; echo "Biographie"; echo "</th>";
			echo "<th>"; echo "URL"; echo "</th>";
				
		echo "</tr>";
		
		foreach($infos_invites as $invite)
		{
			if ( !isset($ivt_traite[ $invite["cpt_pseudo"] ]) )
			{
					if($invite["cpt_pseudo"] == $_SESSION['username'])
					{
						//Identifiant
						echo "<td>"; echo $invite['cpt_pseudo']; echo "</td>";
						
						//Nom d'artiste
						if(strcmp($invite["ivt_libelle"], NULL) == 0)
						{
							echo "<td>"; echo "Aucune nom d'artiste renseigné !"; echo "</td>";
						}
						else
						{
							echo "<td>"; echo $invite["ivt_libelle"]; echo "</td>";
						}
						
						//Discipline
						if(strcmp($invite["ivt_discipline"], NULL) == 0)
						{
							echo "<td>"; echo "Aucune discipline renseignée !"; echo "</td>";
						}
						else
						{
							echo "<td>"; echo $invite["ivt_discipline"]; echo "</td>";
						}
						
						//Biographie
						if(strcmp($invite["ivt_biographie"], NULL) == 0)
						{
							echo "<td>"; echo "Aucune biographie renseignée !"; echo "</td>";
						}
						else
						{
							echo "<td>"; echo $invite["ivt_biographie"]; echo "</td>";
						}
						
						//URL
						echo "<td>";
						foreach($infos_invites as $inv)
						{
							if($inv["cpt_pseudo"] == $_SESSION['username'])
							{
								if($inv["url_lien"] == NULL)
								{
									echo "Aucune lien renseigné !";
									break;
								}
								else
								{
									echo "<ul>";
												echo "<li>";
												echo $inv["url_lien"];
												echo "</li>";
									echo "</ul>";
								}
							}
						}
						echo"</td>";
						
						$ivt_traite[ $invite["cpt_pseudo"] ] = 1;
						echo "</tr>";
						echo "</table>";
					}
				
			}
		
		}
			
	}
	else
	{
		echo "erreur pour afficher vos informations";
	}
	
?>

<h3> <center> Modifier des informations </center> </h3>
<br/>
<center> <button type="button"> <a href = "<?php echo $this->config->base_url();?>index.php/compte/modifier"> Modifier </a> </center>