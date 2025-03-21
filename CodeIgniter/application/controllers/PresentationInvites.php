<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PresentationInvites extends CI_Controller 
{ 
	public function __construct()
		{
			parent::__construct();
			$this->load->model('db_model');
			$this->load->helper('url_helper');
		}

		public function lister()
		{
			$data['titre'] = 'Liste des invites :'; 
			//$data['invites'] = $this->db_model->get_invites();
			$data['all_invites'] = $this->db_model->get_all_invites();
			
	
			$this->load->view('templates/haut'); 
			$this->load->view('page_invites',$data); //transmet les informations du tableau associatif $data
			$this->load->view('templates/bas');
		}
		
		public function getInfos() //Récupère les infos d'un invite (utilisé dans le compte de l'invité)
		{
			$data['titre'] = 'Vos informations :'; 
			
			$data['infos_invites'] = $this->db_model->get_infos_all_invites();
			
	
			$this->load->view('templates/haut_invite'); 
			$this->load->view('invite_profil',$data); //transmet les informations du tableau associatif $data
			$this->load->view('templates/bas_invite');
		}
		
		

}

?>