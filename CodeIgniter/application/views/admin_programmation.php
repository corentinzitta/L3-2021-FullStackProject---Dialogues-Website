<?php
/*
echo "voici vos informations : ";

echo $_SESSION['username']; //orianeRaoult ou corentinZitta ...
*/

/*


=========================================================================
						Animations avec une seule requete
=========================================================================
*/
$compteur = 0;

if(!isset($_SESSION['username'])) //si la session n'est pas ouverte, on redirige
{
	//echo "pas de session";
	redirect(base_url()."index.php/compte/connecter");
}

foreach($administrateurs as $admin) //Si l'username de la session ne correspond pas à un administrateur(compteur = 0), on redirige 
{
	if($_SESSION['username'] == $admin['cpt_pseudo'])
	{
		$compteur++;
	}
}

if($compteur == 0)
{
	//echo $_SESSION['username'];
	//echo "compteur = 0";
	redirect(base_url()."index.php/compte/connecter");
}

echo"<h1>"; echo "<center>"; echo $titre; echo "</center>"; echo"</h1>";

/*
=========================================================================
						Animations passées
=========================================================================
*/

if($animations != NULL)
{
	$compteur_passee = 0;
	
	echo"<h1>"; echo "Animation passées" ; echo"</h1>";
	
	//Définition des tetes de tableau
	echo"<table class=\"table\">";
			
	echo "<tr>";
			
		echo "<th>"; echo "Animation"; echo "</th>";
		echo "<th>"; echo "Lieu"; echo "</th>";
		echo "<th>"; echo "Début"; echo "</th>";
		echo "<th>"; echo "Fin"; echo "</th>";
		echo "<th>"; echo "Invité"; echo "</th>";
		echo "<th>"; echo "Discipline"; echo "</th>";
		echo "<th>"; echo "Plus d'informations"; echo "</th>";
			
	echo "</tr>";
	
	foreach($animations as $ani_passee)
	{
		if($ani_passee["period"] == 0) //ani passée
		{
			$compteur_passee++;
		
			/*foreach($animations as $ani_passee) //Definition du contenu du tableau : $ani = 1 row (1 ligne). foreach ne fonctionne que pour les tableaux et les objets, fournit une façon simple de parcourir des tableaux. foreach passe en revue le tableau $all_animations. À chaque itération, la valeur de l'élément courant est assignée à $ani.
			{ */
				if (!isset($traite[$ani_passee["ani_libelle"]])) //permet le fait de ne pas avoir plusieurs lignes (row) contenant le même ani_libelle
				{	
					echo "<tr>";
					
						//ANIMATION
					
						if(strcmp($ani_passee["ani_libelle"], NULL) == 0)
						{
							echo "<td>"; echo "Aucune animation !"; echo "</td>";
						}
						else
						{
							echo "<td>"; echo $ani_passee["ani_libelle"]; echo "</td>";
						}
					
						//LIEU
					
						if($ani_passee["lie_libelle"] == NULL)
						{
							echo "<td>"; echo "Aucun lieu !"; echo "</td>";
						}
						else
						{
							echo "<td>"; echo $ani_passee["lie_libelle"];  echo "<br/>"; echo"<input type=\"button\" value=\"".$ani_passee["lie_libelle"]."\">"; echo "</td>";
						}
					
						//DEBUT
					
						if($ani_passee["ani_debut"] == NULL)
						{
							echo "<td>"; echo "Pas encore de donnée concernant la date de début !"; echo "</td>";
						}
						else
						{
							echo "<td>"; echo $ani_passee["ani_debut"]; echo "</td>";
						}
					
						//FIN
					
						if($ani_passee["ani_fin"] == NULL) // ou : if( $ani["ani_fin"] == NULL )
						{
							echo "Pas encore de donnée concernant la date de fin !";
						}
						else
						{
							echo "<td>"; echo $ani_passee["ani_fin"]; echo "</td>";
						}
					
						//INVITE
					
						echo "<td>";
					
						$ani_lib = $ani_passee["ani_libelle"]; //utilisé dans le foreach imbriqué
					
						foreach($animations as $anim)//meme foreach qu'au dessus (on récupère chaque ligne du tableau)
						{
							//echo $ani_lib;
							//echo $ani["ani_libelle"];
							//echo $anim["ani_libelle"];
						
							if( strcmp($ani_lib,$anim["ani_libelle"]) == 0)//selection des invites faisant partie de la même animation (on compare la chaine de l'anim de 1er row avec celle des autres row)
							{
								if ($anim["ivt_libelle"] == NULL) //if(strcmp(NULL,$ani["ivt_libelle"]) == 0)
								{
									echo "Pas encore d'invité renseigné !";
								} 
								else
								{
									echo "<ul>";
										echo "<li>";
										echo $anim["ivt_libelle"];
										echo "<br/>";
										echo"<input type=\"button\" value=\"".$anim["ivt_libelle"]."\">";
										echo "</li>";
									echo "</ul>";
								}
							}
						
						
						}
					
						echo "</td>";
					
						//Cf : "Création/modification avec des crochets" de la doc officielle php.net /manuel/Références du langage/Les types
						$traite[ $ani_passee["ani_libelle"] ] = 1; //$traite[] = tableau | $ani["ani_libelle"] = "Show - Doja Cat ft Justin Bieber" / $ani["ani_libelle"] = "Show - Justin Bieber"...
					
						//DISCIPLINE
					
						if($ani_passee["ivt_discipline"] == NULL)
						{
							echo "<td>"; echo "Pas encore de discipline renseignée !"; echo "</td>";
						}
						else
						{
							echo "<td>"; echo $ani_passee["ivt_discipline"]; echo "</td>";
						}
					
						//PLUS D'INFORMATION
						echo "<td>"; echo"<input type=\"button\" value=\"Cliquer\">"; echo "</td>";
				
					echo "</tr>";
				}
			//} 
			
			
		}
	}
	echo"</table>";

	
	if($compteur_passee == 0)
	{
		echo "<h3>";
		echo "Aucune animation passée pour l'instant!";
		echo "</h3>";
		echo "<br/>";
	}
	
	//test
	//echo $compteur_passee;
}

/*
=========================================================================
						Animations en cours
=========================================================================
*/


if($animations != NULL)
{
	$compteur_en_cours = 0;
	
	echo"<h1>"; echo "Animation en cours" ; echo"</h1>";
	
	//Définition des tetes de tableau
	echo"<table class=\"table\">";
			
	echo "<tr>";
			
		echo "<th>"; echo "Animation"; echo "</th>";
		echo "<th>"; echo "Lieu"; echo "</th>";
		echo "<th>"; echo "Début"; echo "</th>";
		echo "<th>"; echo "Fin"; echo "</th>";
		echo "<th>"; echo "Invité"; echo "</th>";
		echo "<th>"; echo "Discipline"; echo "</th>";
		echo "<th>"; echo "Plus d'informations"; echo "</th>";
			
	echo "</tr>";
	
	foreach($animations as $ani_en_cours)
	{
		if($ani_en_cours["period"] == 1) //ani en cours
		{
			$compteur_en_cours++;
		
			/*foreach($animations as $ani_passee) //Definition du contenu du tableau : $ani = 1 row (1 ligne). foreach ne fonctionne que pour les tableaux et les objets, fournit une façon simple de parcourir des tableaux. foreach passe en revue le tableau $all_animations. À chaque itération, la valeur de l'élément courant est assignée à $ani.
			{ */
				if (!isset($traite[$ani_en_cours["ani_libelle"]])) //permet le fait de ne pas avoir plusieurs lignes (row) contenant le même ani_libelle
				{	
					echo "<tr>";
					
						//ANIMATION
					
						if(strcmp($ani_en_cours["ani_libelle"], NULL) == 0)
						{
							echo "<td>"; echo "Aucune animation !"; echo "</td>";
						}
						else
						{
							echo "<td>"; echo $ani_en_cours["ani_libelle"]; echo "</td>";
						}
					
						//LIEU
					
						if($ani_en_cours["lie_libelle"] == NULL)
						{
							echo "<td>"; echo "Aucun lieu !"; echo "</td>";
						}
						else
						{
							echo "<td>"; echo $ani_en_cours["lie_libelle"];  echo "<br/>"; echo"<input type=\"button\" value=\"".$ani_en_cours["lie_libelle"]."\">"; echo "</td>";
						}
					
						//DEBUT
					
						if($ani_en_cours["ani_debut"] == NULL)
						{
							echo "<td>"; echo "Pas encore de donnée concernant la date de début !"; echo "</td>";
						}
						else
						{
							echo "<td>"; echo $ani_en_cours["ani_debut"]; echo "</td>";
						}
					
						//FIN
					
						if($ani_en_cours["ani_fin"] == NULL) // ou : if( $ani["ani_fin"] == NULL )
						{
							echo "Pas encore de donnée concernant la date de fin !";
						}
						else
						{
							echo "<td>"; echo $ani_en_cours["ani_fin"]; echo "</td>";
						}
					
						//INVITE
					
						echo "<td>";
					
						$ani_lib = $ani_en_cours["ani_libelle"]; //utilisé dans le foreach imbriqué
					
						foreach($animations as $anim)//meme foreach qu'au dessus (on récupère chaque ligne du tableau)
						{
							//echo $ani_lib;
							//echo $ani["ani_libelle"];
							//echo $anim["ani_libelle"];
						
							if( strcmp($ani_lib,$anim["ani_libelle"]) == 0)//selection des invites faisant partie de la même animation (on compare la chaine de l'anim de 1er row avec celle des autres row)
							{
								if ($anim["ivt_libelle"] == NULL) //if(strcmp(NULL,$ani["ivt_libelle"]) == 0)
								{
									echo "Pas encore d'invité renseigné !";
								} 
								else
								{
									echo "<ul>";
										echo "<li>";
										echo $anim["ivt_libelle"];
										echo "<br/>";
										echo"<input type=\"button\" value=\"".$anim["ivt_libelle"]."\">";
										echo "</li>";
									echo "</ul>";
								}
							}
						
						
						}
					
						echo "</td>";
					
						//Cf : "Création/modification avec des crochets" de la doc officielle php.net /manuel/Références du langage/Les types
						$traite[ $ani_en_cours["ani_libelle"] ] = 1; //$traite[] = tableau | $ani["ani_libelle"] = "Show - Doja Cat ft Justin Bieber" / $ani["ani_libelle"] = "Show - Justin Bieber"...
					
						//DISCIPLINE
					
						if($ani_en_cours["ivt_discipline"] == NULL)
						{
							echo "<td>"; echo "Pas encore de discipline renseignée !"; echo "</td>";
						}
						else
						{
							echo "<td>"; echo $ani_en_cours["ivt_discipline"]; echo "</td>";
						}
					
						//PLUS D'INFORMATION
						echo "<td>"; echo"<input type=\"button\" value=\"Cliquer\">"; echo "</td>";
				
					echo "</tr>";
				}
			//} 
			
			
		}
	}
	echo"</table>";

	
	if($compteur_en_cours == 0)
	{
		echo "<h3>";
		echo "Aucune animation en cours pour l'instant!";
		echo "</h3>";
		echo "<br/>";
	}
	
	//test
	//echo $compteur_passee;
}


/*
=========================================================================
						Animations futures
=========================================================================
*/



if($animations != NULL)
{
	$compteur_future = 0;
	
	echo"<h1>"; echo "Animations futures" ; echo"</h1>";
	
	//Définition des tetes de tableau
	echo"<table class=\"table\">";
			
	echo "<tr>";
			
		echo "<th>"; echo "Animation"; echo "</th>";
		echo "<th>"; echo "Lieu"; echo "</th>";
		echo "<th>"; echo "Début"; echo "</th>";
		echo "<th>"; echo "Fin"; echo "</th>";
		echo "<th>"; echo "Invité"; echo "</th>";
		echo "<th>"; echo "Discipline"; echo "</th>";
		echo "<th>"; echo "Plus d'informations"; echo "</th>";
			
	echo "</tr>";
	
	foreach($animations as $ani_future)
	{
		if($ani_future["period"] == 2) //ani future
		{
			$compteur_future++;
		
			/*foreach($animations as $ani_passee) //Definition du contenu du tableau : $ani = 1 row (1 ligne). foreach ne fonctionne que pour les tableaux et les objets, fournit une façon simple de parcourir des tableaux. foreach passe en revue le tableau $all_animations. À chaque itération, la valeur de l'élément courant est assignée à $ani.
			{ */
				if (!isset($traite[$ani_future["ani_libelle"]])) //permet le fait de ne pas avoir plusieurs lignes (row) contenant le même ani_libelle
				{	
					echo "<tr>";
					
						//ANIMATION
					
						if(strcmp($ani_future["ani_libelle"], NULL) == 0)
						{
							echo "<td>"; echo "Aucune animation !"; echo "</td>";
						}
						else
						{
							echo "<td>"; echo $ani_future["ani_libelle"]; echo "</td>";
						}
					
						//LIEU
					
						if($ani_future["lie_libelle"] == NULL)
						{
							echo "<td>"; echo "Aucun lieu !"; echo "</td>";
						}
						else
						{
							echo "<td>"; echo $ani_future["lie_libelle"];  echo "<br/>"; echo"<input type=\"button\" value=\"".$ani_future["lie_libelle"]."\">"; echo "</td>";
						}
					
						//DEBUT
					
						if($ani_future["ani_debut"] == NULL)
						{
							echo "<td>"; echo "Pas encore de donnée concernant la date de début !"; echo "</td>";
						}
						else
						{
							echo "<td>"; echo $ani_future["ani_debut"]; echo "</td>";
						}
					
						//FIN
					
						if($ani_future["ani_fin"] == NULL) // ou : if( $ani["ani_fin"] == NULL )
						{
							echo "Pas encore de donnée concernant la date de fin !";
						}
						else
						{
							echo "<td>"; echo $ani_future["ani_fin"]; echo "</td>";
						}
					
						//INVITE
					
						echo "<td>";
					
						$ani_lib = $ani_future["ani_libelle"]; //utilisé dans le foreach imbriqué
					
						foreach($animations as $anim)//meme foreach qu'au dessus (on récupère chaque ligne du tableau)
						{
							//echo $ani_lib;
							//echo $ani["ani_libelle"];
							//echo $anim["ani_libelle"];
						
							if( strcmp($ani_lib,$anim["ani_libelle"]) == 0)//selection des invites faisant partie de la même animation (on compare la chaine de l'anim de 1er row avec celle des autres row)
							{
								if ($anim["ivt_libelle"] == NULL) //if(strcmp(NULL,$ani["ivt_libelle"]) == 0)
								{
									echo "Pas encore d'invité renseigné !";
								} 
								else
								{
									echo "<ul>";
										echo "<li>";
										echo $anim["ivt_libelle"];
										echo "<br/>";
										echo"<input type=\"button\" value=\"".$anim["ivt_libelle"]."\">";
										echo "</li>";
									echo "</ul>";
								}
							}
						
						
						}
					
						echo "</td>";
					
						//Cf : "Création/modification avec des crochets" de la doc officielle php.net /manuel/Références du langage/Les types
						$traite[ $ani_future["ani_libelle"] ] = 1; //$traite[] = tableau | $ani["ani_libelle"] = "Show - Doja Cat ft Justin Bieber" / $ani["ani_libelle"] = "Show - Justin Bieber"...
					
						//DISCIPLINE
					
						if($ani_future["ivt_discipline"] == NULL)
						{
							echo "<td>"; echo "Pas encore de discipline renseignée !"; echo "</td>";
						}
						else
						{
							echo "<td>"; echo $ani_future["ivt_discipline"]; echo "</td>";
						}
					
						//PLUS D'INFORMATION
						echo "<td>"; echo"<input type=\"button\" value=\"Cliquer\">"; echo "</td>";
				
					echo "</tr>";
				}
			//} 
			
			
		}
	}
	echo"</table>";

	
	if($compteur_future == 0)
	{
		echo "<h3>";
		echo "Aucune animation future pour l'instant!";
		echo "</h3>";
		echo "<br/>";
	}
	
	//test
	//echo $compteur_passee;
}




?>
