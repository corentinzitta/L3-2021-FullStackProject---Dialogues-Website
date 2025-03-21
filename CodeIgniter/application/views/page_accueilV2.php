<h1><?php echo $titre;?></h1> 

<br />

<?php
//Affichage des actualités sous forme de tableau
	if($actualites != NULL) 
	{
		//Définition des tetes de tableau
		echo"<table class=\"table\">";
		
		echo "<tr>";
		
		echo "<th>"; echo "Titre"; echo "</th>";
		echo "<th>"; echo "Contenu"; echo "</th>";
		echo "<th>"; echo "Date"; echo "</th>";
		//echo "<th>"; echo "Etat"; echo "</th>";
		echo "<th>"; echo "cpt_pseudo"; echo "</th>";
		
		echo "</tr>";
		
		foreach($actualites as $actu) //Definition du contenu du tableau
		{ 
			echo "<tr>";
			
			echo "<td>"; echo $actu["act_titre"]; echo "</td>";
			echo "<td>"; echo $actu["act_contenu"]; echo "</td>";
			echo "<td>"; echo $actu["act_date"]; echo "</td>";
			//echo "<td>"; echo $actu["act_etat"]; echo "</td>";
			echo "<td>"; echo $actu["cpt_pseudo"]; echo "</td>";
			 
			
			echo "</tr>";
		} 
		echo"</table>";
	}
	else 
	{
		echo "<br />";
      	echo "Aucune actualité pour l'instant!";
	} 
?>