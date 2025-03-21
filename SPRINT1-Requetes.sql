#	----	ACTUALITES	----

#	----	1. Requête listant toutes les actualités de la table des actualités et leur auteur (login) ----

SELECT act_titre,cpt_pseudo FROM t_actualite_act;

#	----	2. Requête donnant les données d'une actualité dont on connaît l'identifiant (n°) ----

SELECT * FROM t_actualite_act WHERE act_id ='2';

#	----	3. Requête listant les 5 dernières actualités dans l'ordre décroissant ----

SELECT * FROM t_actualite_act
WHERE act_id < 6 
ORDER BY act_id DESC;

#	----	4. Requête recherchant et donnant la (ou les) actualité(s) contenant un mot particulier ----

SELECT * FROM t_actualite_act
WHERE act_contenu LIKE '%zkj%';

#	----	5. Requête listant toutes les actualités postées à une date particulière + le login de l’auteur ----

SELECT act_titre,cpt_pseudo FROM t_actualite_act
WHERE act_date = '2021-10-12 00:00:00';

#	----	PASSEPORTS / POSTS	----

#	----	12. Requête listant tous les posts associés à un invité particulier ----

SELECT pos_text FROM t_post_pos
JOIN t_passeport_pas USING (pas_id)
WHERE cpt_pseudo = 'Gims';

#	----	13. Requête listant tous les invités n’ayant pas de post ----

SELECT ivt_libelle FROM t_invite_ivt
WHERE ivt_libelle NOT IN (	SELECT ivt_libelle FROM t_invite_ivt
							JOIN t_passeport_pas USING (cpt_pseudo)
							JOIN t_post_pos USING (pas_id)	)
					
#	----	PROFILS (ADMIN/INVITES)	----
			
#	----	1. Requête listant toutes les données de tous les profils classés par statut ----
#OUTER JOIN : LEFT OUTER JOIN va retourner tous les enregistrements de la table table_A AINSI que ceux en COMMUN de la table table_B (si juste cpt_pseudo dans les colonnes est commun, il récupère quand même la ligne ou il est présent).
#Données de tous les profils = t_compte_cpt + t_invite_ivt + t_organisateur_org

SELECT * FROM t_compte_cpt
LEFT JOIN t_invite_ivt USING (cpt_pseudo)
LEFT JOIN t_organisateur_org USING (cpt_pseudo)
ORDER BY cpt_statut;

#	----	2. Requête de vérification des données de connexion (login et mot de passe) ----

SELECT * FROM t_compte_cpt
WHERE cpt_pseudo LIKE 'corentinZitta' AND cpt_mdp LIKE 'kzdnfeurf';

#	----	3. Requête récupérant les données d'un profil particulier (utilisateur connecté) ----

SELECT * FROM t_compte_cpt
LEFT JOIN t_invite_ivt USING (cpt_pseudo)
LEFT JOIN t_organisateur_org USING (cpt_pseudo)
WHERE cpt_pseudo LIKE 'corentinZitta' AND cpt_mdp LIKE 'kzdnfeurf'

#	----	4. Requête de mise à jour du mot de passe d'un profil ----

UPDATE t_compte_cpt
SET cpt_mdp = 'nouveaumdpkzdnfeurf'
WHERE cpt_pseudo LIKE 'corentinZitta';

#	----	DONNEES DES INVITES	----

#	----	1. Requête listant toutes les données de tous les invités ----

SELECT * FROM t_invite_ivt;

#	----	2. Requête donnant les données d'un invité à partir de son ID (ou n°) ----

SELECT * FROM t_invite_ivt
WHERE cpt_pseudo LIKE 'dojaCat'

#	----	3. Requête(s) listant les données d'un invité à partir de son ID (ou n°) + toutes les animations auxquelles il participe ----

SELECT * FROM t_invite_ivt
JOIN t_intervention_int USING (cpt_pseudo)
LEFT JOIN t_animation_ani USING (ani_id)
WHERE cpt_pseudo LIKE 'dojaCat'

#	----	4. Requête de mise à jour des données d'un invité ----

UPDATE t_invite_ivt
SET ivt_libelle = 'Doja CatXX', ivt_discipline = 'auteure-compositrice-interprèteXX'
WHERE cpt_pseudo = 'dojaCat';

#	----	5. Requête de recherche d'un invité via un mot-clé contenu dans sa biographie ----

SELECT * FROM t_invite_ivt
WHERE ivt_biographie LIKE '%Los Angel%';

#	----	6. Requête(s) / Code SQL de suppression des données d'un invité en particulier (connaissant son ID)	----

DELETE FROM t_invite_ivt
WHERE cpt_pseudo LIKE 'dojaCat'

#	----	ANIMATIONS	----

#	----	1. Requête listant toutes les animations, leur lieu et le nom du (ou des) invité(s)	----

SELECT ani_libelle, lie_libelle, ivt_libelle FROM t_animation_ani
JOIN t_lieu_lie USING (lie_id)
JOIN t_intervention_int USING (ani_id)
JOIN t_invite_ivt USING (cpt_pseudo);

#	----	2. Requête qui récupère dans la table de gestion des animations les données d'une animation en particulier (connaissant son ID / son intitulé)	----

SELECT * FROM t_animation_ani
WHERE ani_id = '4';

#	----	3. Requête donnant toutes les animations sur une plage horaire (ex : matin)	----

SELECT * FROM t_animation_ani
WHERE ani_debut BETWEEN '2021-12-12 19:00:00' AND '2021-12-12 21:00:00';

#	CE QUI ETAIT ATTENDU

SELECT * FROM t_animation_ani WHERE HOUR(ani_debut) >= 9 AND HOUR(ani_fin) <= 12.

#	----	4. Requête donnant toutes les animations sur un lieu et une plage horaire	----

SELECT * FROM t_animation_ani
WHERE ani_debut BETWEEN '2021-12-12 19:00:00' AND '2021-12-12 21:00:00' 
AND lie_id = '1';

#	----	5. Requête récupérant toutes les animations d'un invité (connaissant son ID)	----

SELECT * FROM t_animation_ani
JOIN t_intervention_int USING (ani_id)
WHERE cpt_pseudo LIKE 'justinBieber';

#	----	6. Requête qui liste les animations collectives + nom des invités	----

SELECT ani_id, ani_libelle, GROUP_CONCAT(ivt_libelle), COUNT(ani_id) FROM t_invite_ivt
JOIN t_intervention_int USING (cpt_pseudo)
JOIN t_animation_ani USING (ani_id)
GROUP BY ani_id
HAVING COUNT(ani_id) > 1
	
#	----	7. Requête d'ajout d'une animation avec précision du lieu et du (des) invité(s) concerné(s) !	----

INSERT INTO t_animation_ani VALUES (NULL,'Show - Justin et Rihanna ensemble!','cest la description!!','2021-12-12 19:00:00','2021-12-12 23:00:00','2');

#	----	8. Requête de mise à jour des données d'une animation dont on connaît l'ID	----

UPDATE t_animation_ani
SET ani_libelle = 'Cest leur dernier show ensemble!'
WHERE ani_id = '5';

#	----	9. Requête(s) de suppression de toutes les participations à des animations d'un invité en particulier (connaissant son ID) !?	----

SET @id_a_supprimer = 	(SELECT ani_id FROM t_intervention_inter
						WHERE cpt_pseudo = 'dojaCat');

DELETE FROM t_intervention_int
WHERE cpt_pseudo = 'dojaCat';

DELETE FROM t_animation_ani
WHERE ani_id = @id_a_supprimer;

#	----	10. Requête(s) / Code SQL de suppression des données d'une animation en particulier (connaissant son ID) !?	----
	
DELETE FROM t_intervention_int
WHERE ani_id = '2';

DELETE FROM t_animation_ani
WHERE ani_id = '2';

#	----	LIEUX / SERVICES	----

#	----	1. Requête donnant tous les lieux	----

SELECT lie_libelle FROM t_lieu_lie;

#	----	2. Requête donnant les caractéristiques d'un lieu connu par son nom ou son ID	----

SELECT * FROM t_lieu_lie WHERE lie_id = '2'

#	----	3. Requête qui récupère tous les services pour un lieu sélectionné en particulier	----

SELECT ser_libelle FROM t_service_ser
JOIN t_lieu_lie USING (lie_id)
WHERE lie_libelle LIKE '%Nord%'; -- Si on ne connait pas le lie_id

--SINON :

SELECT ser_libelle FROM t_service_ser
WHERE lie_id = '2';

#	----	4. Requête qui liste tous les lieux sans service	----

SELECT lie_id FROM t_lieu_lie
LEFT JOIN t_service_ser USING (lie_id) -- LEFT JOIN car c'est les lieux qui n'ont pas de services ici.
WHERE ser_id IS NULL;

-- AUTRE VERSION avec RIGHT JOIN : 

SELECT lie_id FROM t_service_ser
RIGHT JOIN t_lieu_lie USING (lie_id) -- RIGHT JOIN car c'est les services (t_service_ser) qui n'ont pas de lieux (t_lieu_lie) ici.
WHERE ser_id IS NULL;

-- Essayer cette requete d'abord pour comprendre : Nous donne toutes les correspondances des tables et celles qui n'en ont pas avec la table de droite

SELECT * FROM t_service_ser
RIGHT JOIN t_lieu_lie USING (lie_id);

#	----	5. Requête qui liste toutes les animations sur un lieu particulier	----

--Si on ne connait pas le lie_id
SELECT ani_libelle FROM t_animation_ani
JOIN t_lieu_lie USING (lie_id)
WHERE lie_libelle LIKE '%Nord%';

--Si on connait le lie_id
SELECT ani_libelle FROM t_animation_ani
WHERE lie_id = '1';

#	----	6. Requête d'ajout des données d'un lieu (/ d'un service lié à un lieu)	----

INSERT INTO t_service_ser
VALUES (NULL,'cage à selfie','1');

#	----	7. Requête de mise à jour des données d'un lieu (/ d'un service) dont on connaît l'ID	----

UPDATE t_service_ser
SET lie_id = '2'
WHERE ser_libelle LIKE '%selfie%';

#	----	8. Requête de suppression des données d'un lieu (/ d'un service)	----

DELETE FROM t_service_ser
WHERE ser_libelle LIKE '%selfie%';

ALTER TABLE t_service_ser AUTO_INCREMENT = 1;

#	----	9. Requête de suppression d'un lieu (/ d'un service) (connaissant son ID)	----

DELETE FROM t_service_ser
WHERE ser_id = '6';

ALTER TABLE t_service_ser AUTO_INCREMENT = 1;


