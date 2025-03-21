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

?>
