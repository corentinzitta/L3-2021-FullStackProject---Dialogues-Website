<?php

$compteur = 0;

if(!isset($_SESSION['username'])) //si la session n'est pas ouverte, on redirige
{
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
	//echo $compteur;
	redirect(base_url()."index.php/compte/connecter");
}

//echo $_SESSION['username'];
//echo $compteur;

echo "<h1>";  echo"<center>"; echo $titre; echo"</center>"; echo "</h1>"; 

echo"<table class=\"table\">";
		
echo "<tr>";
		
	echo "<th>"; echo "Identifiant"; echo "</th>";
	echo "<th>"; echo "Prenom"; echo "</th>";
	echo "<th>"; echo "Nom"; echo "</th>";
	echo "<th>"; echo "Mail"; echo "</th>";
		
echo "</tr>";


foreach($infos_cpt as $inf)
{
	if($inf["cpt_pseudo"] == $_SESSION['username'])
	{	
		echo "<tr>";
		echo "<td>"; echo $inf["cpt_pseudo"]; echo "</td>";
		
		if($inf["org_prenom"] != NULL)
		{
			echo "<td>"; echo $inf["org_prenom"]; echo "</td>";
		}
		else
		{
			echo "<td>"; echo "Non renseigné!"; echo "</td>";
		}
		
		if($inf["org_nom"] != NULL)
		{
			echo "<td>"; echo $inf["org_nom"]; echo "</td>";
		}
		else
		{
			echo "<td>"; echo "Non renseigné!"; echo "</td>";
		}
		
		if($inf["org_mail"] != NULL)
		{
			echo "<td>"; echo $inf["org_mail"]; echo "</td>";
		}
		else
		{
			echo "<td>"; echo "Non renseigné!"; echo "</td>";
		}
		echo "</tr>";
	}
	
}
echo "</table>";
?>


<h3> <center> Modifier des informations </center> </h3>
<br/>
<center> <button type="button"> <a href = "<?php echo $this->config->base_url();?>index.php/compte/modifier"> Modifier </a> </center>
	