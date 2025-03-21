<?php
class Db_model extends CI_Model //gestion CRUD : Create Retrieve Update Delete
{
	public function __construct()
	{ 
		$this->load->database(); //utilisation de $this pour accéder aux données de la base
	}
	
//	========================================
//				Comptes
//	========================================

	public function get_all_compte()
	{
		$query = $this->db->query("SELECT cpt_pseudo FROM t_compte_cpt;"); 
		return $query->result_array();
	}
	
	public function set_compte()
	{
		$this->load->helper('url');
		$id = $this->input->post('id');
		$mdp = $this->input->post('mdp');
	
		$req = "INSERT INTO t_compte_cpt VALUES ('".$id."','".$mdp."','D');";
		$query = $this->db->query($req);
	
		return ($query);
	}
	
	public function set_new_password($id)
	{
		$this->load->helper('url');
		$mdp = $this->input->post('confirm_new_mdp');
		
		//hachage et sel du mdp
		$salt = "OnRajouteDuSelPourAllongerleMDP123!!45678__Test";
		$hashed_password = hash('sha256', $salt.$mdp);
	
		$req = "UPDATE t_compte_cpt SET cpt_mdp = '".$hashed_password."' WHERE cpt_pseudo = '" . $id ."'";
		$query = $this->db->query($req);
	
		return ($query);
	}
	
	
	/*
	=====================================================
			connect_compte($username, $password)
	=====================================================
			Détermine si le compte existe et s'il est invité ou un admin
			puis vérifie la cohésion du mot de passe avec m'identifiant
	=====================================================
			renvoi 2 si invité qui peut se connecter
			renvoi 1 si admin qui peut se connecter
			renvoi 0 si echec de connexion
	=====================================================
	*/
	
	
	public function connect_compte($username, $password)
	{
		// On rajoute du sel... pour empêcher les attaques par "Rainbow Tables" cf http://en.wikipedia.org/wiki/Rainbow_table
		$salt = "OnRajouteDuSelPourAllongerleMDP123!!45678__Test";
		
		$hashed_password = hash('sha256', $salt.$password);
		
		$query_connexion =$this->db->query("	SELECT cpt_pseudo,cpt_mdp FROM t_compte_cpt
												WHERE cpt_pseudo='".$username."'
												AND cpt_mdp='".$hashed_password."'
												AND cpt_statut = 'A';");
		
		$query_invite = $this->db->query(" 	SELECT cpt_pseudo FROM t_invite_ivt
											WHERE cpt_pseudo ='".$username."' ;");
		
		if($query_invite->num_rows() > 0) //c'est un invité
		{
			if($query_connexion->num_rows() > 0) //tentative de connexion (execution de la requete de connexion)
			{
				return 2; //c'est un invite 
			}
			else
			{
				return 0;
			}
		}
		else //c'est un admin ou un identifiant inexistant ou un compte inactif
		{
			if($query_connexion->num_rows() > 0) 
			{
				return 1; 
			}
		
			else
			{
				return 0;
			}
		}
		
	}
	
	public function get_infos_compte()
	{
		$query =$this->db->query("	SELECT cpt_pseudo, org_prenom, org_nom, org_mail 
									FROM t_compte_cpt
									LEFT JOIN t_organisateur_org USING (cpt_pseudo)");
												
		return $query->result_array();
	}
	
	public function get_admin()
	{
		$query =$this->db->query("	SELECT cpt_pseudo
									FROM t_organisateur_org");
												
		return $query->result_array();
	}

	
	//	========================================
	//				Actualites
	//	========================================
	
	/*public function get_actualite(id_actualite)
	{
		$query = $this->db->query("SELECT * FROM t_actualite_act; ");
		return $query->result_array(); //retourne un tableau
	}*/
	
	public function get_all_actualites()
	{
		$query = $this->db->query("SELECT act_titre, act_contenu, act_date FROM t_actualite_act WHERE act_etat = 'P' ORDER BY act_date DESC; ");
		return $query->result_array(); //retourne un tableau
	}
	
	//	========================================
	//				Animations / Programmation
	//	========================================
	

	public function get_all_animations()
	{
		$query = $this->db->query("	SELECT ani_libelle, lie_libelle, ani_debut, ani_fin, ivt_libelle, ivt_discipline FROM t_animation_ani
									LEFT JOIN t_lieu_lie USING (lie_id)
									LEFT JOIN t_intervention_int USING (ani_id)
									LEFT JOIN t_invite_ivt USING (cpt_pseudo); ");
		return $query->result_array(); //retourne un tableau
	}
	
	public function get_period_animations()
	{
		$query = $this->db->query("	SELECT ani_libelle, lie_libelle, ani_debut, ani_fin, ivt_libelle, ivt_discipline, periode_selon_date(ani_debut,ani_fin) AS period FROM t_animation_ani
									LEFT JOIN t_lieu_lie USING (lie_id)
									LEFT JOIN t_intervention_int USING (ani_id)
									LEFT JOIN t_invite_ivt USING (cpt_pseudo)
									ORDER BY ani_debut ASC;");
		
		return $query->result_array(); //retourne un tableau
	}
	/*
	public function get_passedPeriod_animations()
	{
		$query = $this->db->query("	SELECT ani_libelle, lie_libelle, ani_debut, ani_fin, ivt_libelle, ivt_discipline FROM t_animation_ani
									LEFT JOIN t_lieu_lie USING (lie_id)
									LEFT JOIN t_intervention_int USING (ani_id)
									LEFT JOIN t_invite_ivt USING (cpt_pseudo)
									WHERE periode_selon_date(ani_debut,ani_fin) = 0 
									ORDER BY ani_debut ASC;");
		return $query->result_array(); //retourne un tableau
	}
	
	public function get_currentPeriod_animations()
	{
		$query = $this->db->query("	SELECT ani_libelle, lie_libelle, ani_debut, ani_fin, ivt_libelle, ivt_discipline FROM t_animation_ani
									LEFT JOIN t_lieu_lie USING (lie_id)
									LEFT JOIN t_intervention_int USING (ani_id)
									LEFT JOIN t_invite_ivt USING (cpt_pseudo)
									WHERE periode_selon_date(ani_debut,ani_fin) = 1 
									ORDER BY ani_debut ASC;");
		return $query->result_array(); //retourne un tableau
	}
	
	public function get_futurePeriod_animations()
	{
		$query = $this->db->query("	SELECT ani_libelle, lie_libelle, ani_debut, ani_fin, ivt_libelle, ivt_discipline FROM t_animation_ani
									LEFT JOIN t_lieu_lie USING (lie_id)
									LEFT JOIN t_intervention_int USING (ani_id)
									LEFT JOIN t_invite_ivt USING (cpt_pseudo)
									WHERE periode_selon_date(ani_debut,ani_fin) = 2
									ORDER BY ani_debut ASC; ");
		return $query->result_array(); //retourne un tableau
	}*/
	
	//	========================================
	//				Invités
	//	========================================
	
	public function get_all_invites()
	{
		$query = $this->db->query("	SELECT ivt_libelle, ivt_discipline, ivt_biographie, ivt_img, url_lien, pos_text FROM t_invite_ivt
									LEFT JOIN t_reseau_res USING (cpt_pseudo)
									LEFT JOIN t_url_url USING (url_id)
									LEFT JOIN t_passeport_pas USING (cpt_pseudo)
									LEFT JOIN t_post_pos USING (pas_id)
									ORDER BY pos_date DESC; ");
		return $query->result_array(); //retourne un tableau
	}
	
	public function get_invites()
	{
		$query = $this->db->query("	SELECT ivt_libelle FROM t_invite_ivt;");
		
		return $query->result_array(); //retourne un tableau
	}
	
	public function get_infos_all_invites()
	{
		$query = $this->db->query("	SELECT cpt_pseudo, ivt_libelle, ivt_discipline, ivt_biographie, url_lien FROM t_invite_ivt
									LEFT JOIN t_reseau_res USING (cpt_pseudo)
									LEFT JOIN t_url_url USING (url_id) ");
									
		return $query->result_array(); //retourne un tableau
		
	}
	
}