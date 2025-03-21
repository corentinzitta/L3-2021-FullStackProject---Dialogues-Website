<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Actualite extends CI_Controller 
{ 
	public function __construct()
		{
			parent::__construct();
			$this->load->model('db_model');
			$this->load->helper('url_helper');
		}

		public function lister()
		{
			$data['titre'] = 'Liste des actualités :'; 
			$data['actualites'] = $this->db_model->get_all_actualites();
	
			$this->load->view('templates/haut'); 
			$this->load->view('page_accueil',$data); 
			$this->load->view('templates/bas');
		}
		
		public function lister2()
		{
			$data['titre'] = 'Liste des actualités V2:'; 
			$data['actualites'] = $this->db_model->get_all_actualites();
	
			$this->load->view('templates/haut'); 
			$this->load->view('page_accueilV2',$data); 
			$this->load->view('templates/bas');
		}

}

?>