<!-- Appelé par Programmation : Controller		-->

<!-- <h1><?php //echo $titre;?> </h1> -->

<br />
<?php

/*
=========================================================================
						Animations avec une seule requete
=========================================================================
*/
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






<?php

/*

	Ancienne version avec plusieurs requêtes

=========================================================================
						Animations passées
=========================================================================
*/

/*

echo"<h1>"; echo $titre_ani_passees; echo"</h1>";

//Affichage des actualités sous forme de tableau
	if($animations_passees != NULL) //$all_animations obtenu par get_all_animations (dans Db_model): est un tableau (array) contenant toutes les animations avec les données qui nous intéressent
	{
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
		
		foreach($animations_passees as $ani) //Definition du contenu du tableau : $ani = 1 row (1 ligne). foreach ne fonctionne que pour les tableaux et les objets, fournit une façon simple de parcourir des tableaux. foreach passe en revue le tableau $all_animations. À chaque itération, la valeur de l'élément courant est assignée à $ani.
		{ 
			if (!isset($traite[$ani["ani_libelle"]])) //permet le fait de ne pas avoir plusieurs lignes (row) contenant le même ani_libelle
			{	
				echo "<tr>";
				
					//ANIMATION
				
					if(strcmp($ani["ani_libelle"], NULL) == 0)
					{
						echo "<td>"; echo "Aucune animation !"; echo "</td>";
					}
					else
					{
						echo "<td>"; echo $ani["ani_libelle"]; echo "</td>";
					}
				
					//LIEU
				
					if($ani["lie_libelle"] == NULL)
					{
						echo "<td>"; echo "Aucun lieu !"; echo "</td>";
					}
					else
					{
						echo "<td>"; echo $ani["lie_libelle"];  echo "<br/>"; echo"<input type=\"button\" value=\"".$ani["lie_libelle"]."\">"; echo "</td>";
					}
				
					//DEBUT
				
					if($ani["ani_debut"] == NULL)
					{
						echo "<td>"; echo "Pas encore de donnée concernant la date de début !"; echo "</td>";
					}
					else
					{
						echo "<td>"; echo $ani["ani_debut"]; echo "</td>";
					}
				
					//FIN
				
					if($ani["ani_fin"] == NULL) // ou : if( $ani["ani_fin"] == NULL )
					{
						echo "Pas encore de donnée concernant la date de fin !";
					}
					else
					{
						echo "<td>"; echo $ani["ani_fin"]; echo "</td>";
					}
				
					//INVITE
				
					echo "<td>";
				
					$ani_lib = $ani["ani_libelle"]; //utilisé dans le foreach imbriqué
				
					foreach($animations_passees as $anim)//meme foreach qu'au dessus (on récupère chaque ligne du tableau)
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
					$traite[ $ani["ani_libelle"] ] = 1; //$traite[] = tableau | $ani["ani_libelle"] = "Show - Doja Cat ft Justin Bieber" / $ani["ani_libelle"] = "Show - Justin Bieber"...
				
					//DISCIPLINE
				
					if($ani["ivt_discipline"] == NULL)
					{
						echo "<td>"; echo "Pas encore de discipline renseignée !"; echo "</td>";
					}
					else
					{
						echo "<td>"; echo $ani["ivt_discipline"]; echo "</td>";
					}
				
					//PLUS D'INFORMATION
					echo "<td>"; echo"<input type=\"button\" value=\"Cliquer\">"; echo "</td>";
			
				echo "</tr>";
			}
		} 
		echo"</table>";
		//**RAJOUTE**
	}
	else 
	{
		echo "<h3>";
      	echo "Aucune animation passée pour l'instant!";
		echo "</h3>";
	} 
	
	*/
	
	/*
	=========================================================================
							Animations En Cours
	=========================================================================
	*/
	
	/*
	
	if($animations_en_cours != NULL) //$all_animations obtenu par get_all_animations (dans Db_model): est un tableau (array) contenant toutes les animations avec les données qui nous intéressent
	{	
		echo"<h1>"; echo $titre_ani_en_cours; echo"</h1>";
		
		//Définition des tetes de tableau
		echo"<table class=\"table\">";
		
		echo "<tr>";
		
		echo "<th>"; echo "Animation"; echo "</th>";
		echo "<th>"; echo "Lieu"; echo "</th>";
		echo "<th>"; echo "Début"; echo "</th>";
		echo "<th>"; echo "Fin"; echo "</th>";
		echo "<th>"; echo "Invité"; echo "</th>";
		echo "<th>"; echo "Discipline"; echo "</th>";
		
		// ***RAJOUTE***
		echo "<th>"; echo "Plus d'informations"; echo "</th>";
		
		echo "</tr>";
		
		foreach($animations_en_cours as $ani) //Definition du contenu du tableau : $ani = 1 row (1 ligne). foreach ne fonctionne que pour les tableaux et les objets, fournit une façon simple de parcourir des tableaux. foreach passe en revue le tableau $all_animations. À chaque itération, la valeur de l'élément courant est assignée à $ani.
		{ 	
			if (!isset($traite[$ani["ani_libelle"]])) //permet le fait de ne pas avoir plusieurs lignes (row) contenant le même ani_libelle
			{	
				$ani_lib = $ani["ani_libelle"];
				
				echo "<tr>";
				
				//ANIMATION
				
				if(strcmp($ani["ani_libelle"], NULL) == 0)
				{
					echo "<td>"; echo "Aucune animation !"; echo "</td>";
				}
				else
				{
					echo "<td>"; echo $ani["ani_libelle"]; echo "</td>";
				}
				
				//LIEU
				
				if($ani["lie_libelle"] == NULL)
				{
					echo "<td>"; echo "Aucun lieu !"; echo "</td>";
				}
				else
				{
					echo "<td>"; echo $ani["lie_libelle"];  echo "<br/>"; echo"<input type=\"button\" value=\"".$ani["lie_libelle"]."\">"; echo "</td>";
				}
				
				//DEBUT
				
				if($ani["ani_debut"] == NULL)
				{
					echo "<td>"; echo "Pas encore de donnée concernant la date de début !"; echo "</td>";
				}
				else
				{
					echo "<td>"; echo $ani["ani_debut"]; echo "</td>";
				}
				
				//FIN
				
				if($ani["ani_fin"] == NULL) // ou : if( $ani["ani_fin"] == NULL )
				{
					echo "Pas encore de donnée concernant la date de fin !";
				}
				else
				{
					echo "<td>"; echo $ani["ani_fin"]; echo "</td>";
				}
				
				//INVITE
				
				echo "<td>";
				
				foreach($animations_en_cours as $anim)//meme foreach qu'au dessus (on récupère chaque ligne du tableau)
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
				$traite[ $ani["ani_libelle"] ] = 1; //$traite[] = tableau | $ani["ani_libelle"] = "Show - Doja Cat ft Justin Bieber" / $ani["ani_libelle"] = "Show - Justin Bieber"...
				
				//DISCIPLINE
				
				if(strcmp(NULL,$ani["ivt_discipline"]) == 0)
				{
					echo "<td>"; echo "Pas encore de discipline renseignée !"; echo "</td>";
				}
				else
				{
					echo "<td>"; echo $ani["ivt_discipline"]; echo "</td>";
					//**RAJOUTE**
				}
				
				//PLUS D'INFORMATION
				echo "<td>"; echo"<input type=\"button\" value=\"Cliquer\">"; echo "</td>";
			
				echo "</tr>";
			}
		} 
		echo"</table>";
		//**RAJOUTE**
	}
	else 
	{
		echo "<h3>";
      	echo "Aucune animation en cours!";
		echo "</h3>";
		echo "<br />";
	} 
	
	*/
	
	/*
	=========================================================================
							Animations futures
	=========================================================================
	*/
	
	/*
	
	if($animations_futures != NULL) //$all_animations obtenu par get_all_animations (dans Db_model): est un tableau (array) contenant toutes les animations avec les données qui nous intéressent
	{	
		echo"<h1>"; echo $titre_ani_futures; echo"</h1>";
		
		//Définition des tetes de tableau
		echo"<table class=\"table\">";
		
		echo "<tr>";
		
		echo "<th>"; echo "Animation"; echo "</th>";
		echo "<th>"; echo "Lieu"; echo "</th>";
		echo "<th>"; echo "Début"; echo "</th>";
		echo "<th>"; echo "Fin"; echo "</th>";
		echo "<th>"; echo "Invité"; echo "</th>";
		echo "<th>"; echo "Discipline"; echo "</th>";
		
		// ***RAJOUTE***
		echo "<th>"; echo "Plus d'informations"; echo "</th>";
		
		echo "</tr>";
		
		foreach($animations_futures as $ani) //Definition du contenu du tableau : $ani = 1 row (1 ligne). foreach ne fonctionne que pour les tableaux et les objets, fournit une façon simple de parcourir des tableaux. foreach passe en revue le tableau $all_animations. À chaque itération, la valeur de l'élément courant est assignée à $ani.
		{ 	
			if (!isset($traite[$ani["ani_libelle"]])) //permet le fait de ne pas avoir plusieurs lignes (row) contenant le même ani_libelle
			{	
				//Définition des tetes de tableau
				$ani_lib=$ani["ani_libelle"];
				
				echo "<tr>";
			
					//ANIMATION
			
					if(strcmp($ani["ani_libelle"], NULL) == 0)
					{
						echo "<td>"; echo "Aucune animation !"; echo "</td>";
					}
					else
					{
						echo "<td>"; echo $ani["ani_libelle"]; echo "</td>";
					}
			
					//LIEU
			
					if(strcmp($ani["lie_libelle"], NULL) == 0)
					{
						echo "<td>"; echo "Aucun lieu !"; echo "</td>";
					}
					else
					{	
						echo "<td>"; echo $ani["lie_libelle"];  echo "<br/>"; echo"<input type=\"button\" value=\"".$ani["lie_libelle"]."\">"; echo "</td>";
					}
			
					//DEBUT
			
					if(strcmp($ani["ani_debut"], NULL) == 0)
					{
						echo "<td>"; echo "Pas encore de donnée concernant la date de début !"; echo "</td>";
					}
					else
					{
						echo "<td>"; echo $ani["ani_debut"]; echo "</td>";
					}
			
					//FIN
			
					if(strcmp($ani["ani_fin"], NULL) == 0) // ou : if( $ani["ani_fin"] == NULL )
					{
						echo "Pas encore de donnée concernant la date de fin !";
					}
					else
					{
						echo "<td>"; echo $ani["ani_fin"]; echo "</td>";
					}
			
				//INVITE
			
				echo "<td>";
				
				foreach($animations_futures as $anim)//meme foreach qu'au dessus (on récupère chaque ligne du tableau)
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
				$traite[ $ani["ani_libelle"] ] = 1; //$traite[] = tableau | $ani["ani_libelle"] = "Show - Doja Cat ft Justin Bieber" / $ani["ani_libelle"] = "Show - Justin Bieber"...
				
				//DISCIPLINE
				
				if(strcmp(NULL,$ani["ivt_discipline"]) == 0)
				{
					echo "<td>"; echo "Pas encore de discipline renseignée !"; echo "</td>";
				}
				else
				{
					echo "<td>"; echo $ani["ivt_discipline"]; echo "</td>";
					//**RAJOUTE**
				}
				
				//PLUS D'INFORMATION
				echo "<td>"; echo"<input type=\"button\" value=\"Cliquer\">"; echo "</td>";
			
				echo "</tr>";
			}
		} 
		echo"</table>";
		//**RAJOUTE**
	}
	else 
	{
		echo "<h3>";
      	echo "Aucune animation future pour l'instant!";
		echo "</h3>";
		echo "<br />";
	} 
	
	*/
?>
				