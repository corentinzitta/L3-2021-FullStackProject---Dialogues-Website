<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Programmation extends CI_Controller 
{ 
	public function __construct()
		{
			parent::__construct();
			$this->load->model('db_model');
			$this->load->helper('url_helper');
		}

		public function lister()
		{
			$data['titre'] = 'Liste des animations :'; 
			$data['animations'] = $this->db_model->get_period_animations();
			
			/*$data['titre_ani_passees'] = 'Liste des animations passées :';
			$data['animations_passees'] = $this->db_model->get_passedPeriod_animations();
			
			$data['titre_ani_en_cours'] = 'Liste des animations en cours :';
			$data['animations_en_cours'] = $this->db_model->get_currentPeriod_animations();
			
			$data['titre_ani_futures'] = 'Liste des animations futures :';
			$data['animations_futures'] = $this->db_model->get_futurePeriod_animations(); */
			
	
			$this->load->view('templates/haut'); 
			$this->load->view('page_programmation',$data); //transmet les informations du tableau associatif $data
			$this->load->view('templates/bas');
		}
		
		public function lister_admin()
		{
			$data['titre'] = 'Liste des animations :'; 
			$data['animations'] = $this->db_model->get_period_animations();
			$data['administrateurs'] = $this->db_model->get_admin();
	
			$this->load->view('templates/haut_admin'); 
			$this->load->view('admin_programmation',$data); //transmet les informations du tableau associatif $data
			$this->load->view('templates/bas_admin');
		}
		
		

}

?>