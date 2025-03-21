<?php
class Accueil extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}
	
	
	public function afficher(/*$donnee*/) 
	{
		//$data['parametre'] = ($donnee);
		
		//chargement de view haut.php
		$this->load->view('templates/haut'); 
		
		//chargement de la view du milieu : page_accueil.php
		$this->load->view('page_accueil'/*,$data*/); 
		
		//chargement de la view bas.php
		$this->load->view('templates/bas');
	}
} 

?>