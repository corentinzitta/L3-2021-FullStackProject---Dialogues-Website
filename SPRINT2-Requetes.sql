#	----	PASSEPORTS-POSTS / EN TANT QU'INVITE-MEMBRE DE L'EQUIPE D'UN INVITE	----

#	----	1. Requête listant tous les passeports ----

SELECT pas_id FROM t_passeport_pas

#	----	2. Requête listant tous les passeports associés à un invité dont connaît l’ID (ou n°) ----

SELECT pas_id FROM t_passeport_pas WHERE cpt_pseudo ='justinBieber';

#	----	3. Requête d’ajout d’un nouveau passeport ----

INSERT INTO t_passeport_pas
VALUES (NULL, 'jkzbfeu', 'maitreGims');

#	----	4. Requête de modification d’un passeport (ex : passMDP) ----

UPDATE t_passeport_pas
SET pas_mdp = 'yauiedfjf'
WHERE pas_id = 4;

#	----	5. Requête de désactivation d’un passeport ----

#	Pas de colonne d'état de passeport (A/D), on supprimera le passeport afin de le désactiver

UPDATE t_passeport_pas
SET pas_etat = 'D'
WHERE pas_id = '4';

#	----	6. Requête de suppression d’un passeport ----

DELETE FROM t_passeport_pas
WHERE pas_id = '4';

ALTER TABLE t_passeport_pas AUTO_INCREMENT = 1; --Réinitialiser l'auto incrément

#	----	7. Requête listant tous les posts ----

SELECT pos_id, pos_text
FROM t_post_pos

#	----	8. Requête / code SQL d’ajout d’un post de 140 caractères maximum ----

INSERT INTO t_post_pos
VALUES (NULL,'Doja Cat sera déguisée à l''occasion de son concert !',NOW(),'3','P');

#	----	9. Requête de modération (désactivation) d’un post ----

UPDATE t_post_pos
SET pos_etat = 'C'
WHERE pos_id = 4;

#	----	10. Requête de suppression d’un post en particulier ----

DELETE FROM t_post_pos
WHERE pos_id = '5';

ALTER TABLE t_post_pos AUTO_INCREMENT = 1; --Réinitialiser l'auto incrément

#	----	11. Requête de suppression de tous les posts d’un invité en particulier	----

DELETE FROM t_post_pos
WHERE pas_id = (SELECT pas_id FROM t_passeport_pas
				WHERE cpt_pseudo = 'maitreGims');

ALTER TABLE t_post_pos AUTO_INCREMENT = 1; --Réinitialiser l'auto incrément

#	----	INVITES / EN TANT QU'ADMINISTRATEUR	----

#	----	1. Requête listant toutes les données de tous les invités ----

SELECT * FROM t_invite_ivt;

#	----	2. Requête donnant les données d'un invité à partir de son ID (ou n°) ----

SELECT * FROM t_invite_ivt
WHERE cpt_pseudo = 'dojaCat';

#	----	3. Requête(s) listant les données d'un invité à partir de son ID (ou n°) + toutes les animations auxquelles il participe ----

SELECT ivt_libelle, ivt_discipline, ivt_biographie, ivt_img, ani_libelle FROM t_invite_ivt
JOIN t_intervention_int USING (cpt_pseudo)
JOIN t_animation_ani USING (ani_id)
WHERE cpt_pseudo = 'justinBieber';

#	----	4. Requête de mise à jour des données d'un invité ----

UPDATE t_invite_ivt
SET ivt_discipline = 'DJ/Compositeur', ivt_biographie = 'Skrillex, de son vrai nom Sonny John Moore, EST né le 15 janvier 1988 à Los Angeles. C''est un DJ et compositeur américain de musique électronique.'
WHERE cpt_pseudo = 'skrillex';

#	----	5. Requête de recherche d'un invité via un mot-clé contenu dans sa biographie ----

SELECT * FROM t_invite_ivt
WHERE ivt_biographie LIKE '%Sonny%';

#	----	6. Requête(s) / Code SQL de suppression des données d'un invité en particulier (connaissant son ID) ----

DELETE FROM t_invite_ivt
WHERE cpt_pseudo = 'skrillex';

#	----	ANIMATIONS (EN TANT QU'ADMINISTRATEUR)	----

#	----	1. Requête listant toutes les animations, leur lieu et le nom du (ou des) invité(s) ----

SELECT ani_libelle, lie_libelle, ivt_libelle FROM t_animation_ani
JOIN t_lieu_lie USING (lie_id)
JOIN t_intervention_int USING (ani_id)
JOIN t_invite_ivt USING (cpt_pseudo)

#	----	2. Requête qui récupère dans la table de gestion des animations les données d'une animation en particulier (connaissant son ID / son intitulé) ----

SELECT * FROM t_animation_ani
WHERE ani_id = '2';

#	----	3. Requête donnant toutes les animations sur une plage horaire (ex : matin) ----

SELECT * FROM t_animation_ani
WHERE DAY(ani_debut) = DAY(ani_fin) AND HOUR(ani_debut) > '07:00:00' AND HOUR(ani_fin) < '14:00:00';

#	----	4. Requête donnant toutes les animations sur un lieu et une plage horaire ----

SELECT ani_libelle, lie_libelle FROM t_animation_ani
JOIN t_lieu_lie USING (lie_id)
WHERE lie_id = '3' AND DAY(ani_debut) = DAY(ani_fin) AND HOUR(ani_debut) > '07:00:00' AND HOUR(ani_fin) < '14:00:00';

#	----	5. Requête récupérant toutes les animations d'un invité (connaissant son ID) ----

SELECT ani_libelle, cpt_pseudo FROM t_animation_ani
JOIN t_intervention_int USING (ani_id)
WHERE cpt_pseudo = 'dojaCat';

#	----	6. Requête qui liste les animations collectives + nom des invités ----

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

SET @id_a_supprimer = 	(SELECT ani_id FROM t_intervention_int
						WHERE cpt_pseudo = 'dojaCat');

DELETE FROM t_animation_ani
WHERE ani_id = @id_a_supprimer;


DELETE FROM t_intervention_int
WHERE cpt_pseudo = 'dojaCat';


#	----	10. Requête(s) / Code SQL de suppression des données d'une animation en particulier (connaissant son ID) !?	----
	
DELETE FROM t_intervention_int
WHERE ani_id = '2';

