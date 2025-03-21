<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Compte extends CI_Controller 
{ 
	public function __construct()
		{
			parent::__construct();
			$this->load->model('db_model');
			$this->load->helper('url_helper');
		}


		public function lister()
		{
			$data['titre'] = 'Liste des pseudos :'; 
			$data['pseudos'] = $this->db_model->get_all_compte();
	
			$this->load->view('templates/haut'); 
			$this->load->view('compte_liste',$data); 
			$this->load->view('templates/bas');
		}
		
		public function creer()
		{
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id', 'id', 'required');
			$this->form_validation->set_rules('mdp', 'mdp', 'required');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('templates/haut');
				$this->load->view('compte_creer');
				$this->load->view('templates/bas');
			}
			else
			{
				//Utilisation du model : Db_model
				$this->db_model->set_compte(); 
				
				//chargement des vues
				$this->load->view('templates/haut');
				$this->load->view('compte_succes');
				$this->load->view('templates/bas');
			}
		}
		
		public function connecter()
		{
			//if(isset($S_SESSION))
			
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('pseudo', 'pseudo', 'required');
			$this->form_validation->set_rules('mdp', 'mdp', 'required');

			if ($this->form_validation->run() == FALSE) //les règles (rules) ne sont pas respectées
			{
				$this->load->view('templates/haut');
				$this->load->view('compte_connecter');
				$this->load->view('templates/bas');
			}
			else //les règles (rules) sont respectées
			{
				$username = $this->input->post('pseudo');
				$password = $this->input->post('mdp');
				
				if($this->db_model->connect_compte($username,$password) == 2) //On connecte un invite
				{
					$statut = 'Invite';
					$session_data = array('username' => $username, 'statut' => $statut );
					$this->session->set_userdata($session_data); //positionne les variables de session utiles pendant la durée d'ouverture de la session(eq : $_SESSION['username']=$username;)
					
					//chargement des vues
					$this->load->view('templates/haut_invite');
					$this->load->view('invite_menu');
					$this->load->view('templates/bas_invite');
				}
				else if($this->db_model->connect_compte($username,$password) == 1) //On connecte un admin
				{
					$statut = 'Admin';
					$session_data = array('username' => $username, 'statut' => $statut );
					$this->session->set_userdata($session_data); //positionne les variables de session utiles pendant la durée d'ouverture de la session(eq : $_SESSION['username']=$username;)
					
					//données que l'on envoie :
					$data['titre'] = 'Liste des animations :'; 
					$data['animations'] = $this->db_model->get_period_animations();
					$data['administrateurs'] = $this->db_model->get_admin();
					$data['username'] = $session_data;
					
					$this->load->view('templates/haut_admin');
					$this->load->view('admin_menu',$data);
					$this->load->view('templates/bas_admin');
				}
				else //la mdp ou identifiant est mauvais
				{
				 $this->load->view('templates/haut');
				 $this->load->view('compte_connecter');
				 $this->load->view('templates/bas');
				}
			}
		}
				
		public function deconnecter()
		{
			//on récupère la session
			$session_data = $this->session->userdata('username'); 
			
			//on la supprime
			//$this->session->unset_userdata($session_data);
			//$this->session->destroy();
			$this->session->sess_destroy();
			//on rédirige
			$this->load->helper('url'); //on charge le helper d'url (contient des méthodes pour nous aider avec les url)
			redirect(base_url()); //base_url donne le chemin vers la page de départ que l'on a définit
		}
		
		public function consulter()
		{
			$data['titre'] = 'Les informations de votre profil';
			$data['infos_cpt'] = $this->db_model->get_infos_compte();
			$data['administrateurs'] = $this->db_model->get_admin();
			
			$this->load->view('templates/haut_admin');
			$this->load->view('admin_infos',$data);
			$this->load->view('templates/bas_admin');
		}
		
		public function modifier()
		{
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('new_mdp', 'Password', 'required', array('required' => 'Veuillez saisir le mot de passe!'));
			$this->form_validation->set_rules('confirm_new_mdp', 'Password Confirmation','required|matches[new_mdp]', array('required' => 'Veuillez saisir la confirmation de mot de passe!'));
			
			$this->form_validation->set_message('matches','Les deux mots de passes doivent correspondre !');
			//$this->form_validation->set_message('required','Veuillez saisir la confirmation de mot de passe!');
			
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('templates/haut_admin');
				$this->load->view('admin_update_password');
				$this->load->view('templates/bas_admin');
			}
			else
			{
				//Utilisation du model : Db_model
				
				if ( $this->session->userdata('statut') == 'Admin' && $this->db_model->set_new_password($this->session->userdata('username')) )
				{
					$data['titre'] = 'Liste des animations :'; 
					$data['animations'] = $this->db_model->get_period_animations();
					$data['administrateurs'] = $this->db_model->get_admin();
					
					$this->load->view('templates/haut');
					$this->load->view('admin_programmation',$data); //transmet les informations du tableau associatif $data
					$this->load->view('templates/bas');
				}
				else if( $this->session->userdata('statut') == 'Invite' && $this->db_model->set_new_password($this->session->userdata('username')) )
				{
					$data['titre'] = 'Vos informations :'; 
					$data['infos_invites'] = $this->db_model->get_infos_all_invites();
					
					$this->load->view('templates/haut');
					$this->load->view('invite_profil',$data); //transmet les informations du tableau associatif $data
					$this->load->view('templates/bas');
				}
				else
				{
					$this->load->view('templates/haut_admin');
					$this->load->view('admin_update_password');
					$this->load->view('templates/bas_admin');
				}
				
				//chargement des vues

			}
			
		}



}

?>