-- @var = variable de cession, in/out VAR_PARAM = parametre, DECLARE var = variable déclarée (locale à la fonction/procédure)

			----	Activite 1		----

--	Donnez tous les pseudos des organisateurs (administrateurs) et le texte des actualités qu’ils ont postées, S'IL Y EN A.

SELECT cpt_pseudo, act_contenu 
FROM t_organisateur_org
JOIN t_actualite_act USING (cpt_pseudo);

--CORRECTION

SELECT cpt_pseudo, act_id
FROM t_compte_cpt
JOIN t_organisateur_org USING (cpt_pseudo)
LEFT OUTER JOIN t_actualite_act USING (cpt_pseudo);

--	Donnez (à l’aide de 2 méthodes différentes) la liste de tous les pseudos des organisateurs (administrateurs) qui n’ont pas encore publié d’actualité.

--	Methode 1

SELECT cpt_pseudo
FROM t_organisateur_org
WHERE cpt_pseudo NOT IN (SELECT cpt_pseudo FROM t_actualite_act);

--	Methode 2 : EXCEPT (PLUS PERFORMANT)

SELECT cpt_pseudo
FROM t_organisateur_org
EXCEPT
SELECT cpt_pseudo
FROM t_actualite_act

--	Methode 3 : NOT EXISTS (PERFORMANT AUSSI)

SELECT cpt_pseudo
FROM t_organisateur_org
WHERE not exists (	SELECT NULL 
					FROM t_actualite_act 
					WHERE t_organisateur_org.cpt_pseudo = t_actualite_act.cpt_pseudo );

-- Methode 4 : IS NULL (utilisation de 'is NULL' que quand jointure externe : logique)

SELECT cpt_pseudo, act_id
FROM t_compte_cpt
JOIN t_organisateur_org USING (cpt_pseudo)
LEFT OUTER JOIN t_actualite_act USING (cpt_pseudo) /* jusqu'ici on a le cpt des organisateurs qui ont publié OU PAS des actualités */
WHERE act_contenu IS NULL;

		--	----	ACTIVITE 2		----
		
-- 1. Ecrire une fonction qui retourne la liste de tous les invités participant à une animation.

--Préparation de la requête :
SELECT GROUP_CONCAT(ivt_libelle)
FROM t_invite_ivt
JOIN t_intervention_int USING (cpt_pseudo)
WHERE ani_id = '2'

DROP FUNCTION IF EXISTS invites_ani; 

DELIMITER // --Pour préciser que c'est une procédure/fonction (il n'y a pas de ';')
CREATE FUNCTION invites_ani(ani_id_recherchee INT) RETURNS VARCHAR(500) --Utilisation de GROUP_CONCAT()
BEGIN
SET @return := (SELECT GROUP_CONCAT(ivt_libelle) 
				FROM t_invite_ivt
				JOIN t_intervention_int USING (cpt_pseudo)
				WHERE ani_id = ani_id_recherchee );
RETURN @return;
END;
//
DELIMITER ;

-- Autre méthode : (corrigé)

DROP FUNCTION IF EXISTS invites_ani; 

DELIMITER // --Pour préciser que c'est une procédure/fonction (il n'y a pas de ';')
CREATE FUNCTION invites_ani(id_ani_recherchee INT) RETURNS VARCHAR(500) --Utilisation de GROUP_CONCAT()
BEGIN
	DECLARE liste_invites VARCHAR(500);
	
	SELECT GROUP_CONCAT(ivt_libelle) INTO liste_invites --On met le GROUP_CONCAT dans (INTO) la liste des invités que l'on retournera ensuite
	FROM t_invite_ivt
	JOIN t_intervention_int USING (cpt_pseudo)
	WHERE ani_id = id_ani_recherchee;
	
	RETURN liste_invites;
END;
//
DELIMITER ;

--Petite amélioration s'il n'y a pas d'invités :

DROP FUNCTION IF EXISTS invites_ani; 

DELIMITER // /* Pour préciser que c'est une procédure/fonction (il n'y a pas de ';') */
CREATE FUNCTION invites_ani(id_ani_recherchee INT) RETURNS VARCHAR(500) /* Utilisation de GROUP_CONCAT() */
BEGIN
	DECLARE liste_invites VARCHAR(500);
	
	SELECT GROUP_CONCAT(ivt_libelle) INTO liste_invites /* On met le GROUP_CONCAT dans (INTO) la liste des invités que l'on retournera ensuite */
	FROM t_invite_ivt
	JOIN t_intervention_int USING (cpt_pseudo)
	WHERE ani_id = id_ani_recherchee;
	IF liste_invites IS NULL THEN
		SET liste_invites := "Il n'y pas encore aucun invités pour l'instant";
	END IF;
	RETURN liste_invites;
END;
//
DELIMITER ;


-- 2. Appeler la fonction (SELECT)

SELECT invites_ani(2);

-- 3. Ecrire alors une procédure qui insère une actualité à la date d’aujourd’hui connaissant l’id de l’animation et en précisant l’intitulé de l’animation, sa date de début et de fin et la liste des invités prévus. L’auteur de l’actualité sera l’organisateur principal.

--utilisation de concat() ou concat_ws() pour le texte de l'actualité.

-- pas de return en procédure, possibilité de renvoyer quand meme avec IN (entrée) | OUT (sortie) | INOUT (entree et sortie)


DROP PROCEDURE IF EXISTS insert_actu; 

DELIMITER //
CREATE PROCEDURE insert_actu(in id_animation INT) /* pas de out car rien a retourner */
BEGIN
	DECLARE liste_invites VARCHAR(500);
	DECLARE texte_actualite VARCHAR(500);
	
	SELECT invites_ani(id_animation) INTO liste_invites;
	
	IF liste_invites IS NOT NULL THEN /* Remarque : l'amelioriation de tout à l'heure nous empeche que liste_invites soit NULL */
		SELECT CONCAT_WS('--> ', ani_libelle, ani_debut, ani_fin, liste_invites) INTO texte_actualite FROM t_animation_ani WHERE ani_id = id_animation; /* ne marchera pas si l'animation n'existe pas */
		INSERT INTO t_actualite_act VALUES (NULL, 'Nouvelle Animation !',texte_actualite, NOW(), 'P', 'organisateur'); 
	END IF;
END;
//
DELIMITER ;

/* Appel de la procédure : */

call insert_actu(4);

--4. créez un déclencheur (trigger) ajoutant une actualité dès l’ajout d’un invité à une animation.

DELIMITER //
CREATE TRIGGER AjoutActualiteAnimation /* pas de out car rien a retourner */
AFTER INSERT ON t_intervention_int
FOR EACH ROW
BEGIN
	call insert_actu(NEW.ani_id);
END;
//
DELIMITER ;

		--	----	Activite 3		----
		
--	Ecrivez une procédure qui renvoie en sortie le nombre d’animations déjà passées / en cours / à venir.

DROP PROCEDURE IF EXISTS nbr_ani; 

DELIMITER //
CREATE PROCEDURE nbr_ani(out nbr_ani_passee INT, out nbr_ani_encours INT, out nbr_ani_avenir INT)
BEGIN
	SELECT COUNT(ani_id) INTO nbr_ani_passee FROM t_animation_ani WHERE ani_fin < NOW();
 	SELECT COUNT(ani_id) INTO nbr_ani_encours FROM t_animation_ani WHERE ani_debut <= NOW() AND ani_fin > NOW();
	SELECT COUNT(ani_id) INTO nbr_ani_avenir FROM t_animation_ani WHERE ani_debut > NOW();
END;
//
DELIMITER ;

-- Appel de la procedure :

call nbr_ani(@nbp,@nbc,@nbv);
SELECT @nbp;
SELECT @nbc;
SELECT @nbv;

			----	Activite 4		----
		
--Trigger1 : OR et AND à faire (et utilisation de NEW et OLD)
	
-- trigger qui, suite à la modification des données d’une animation, insère une nouvelle actualité dans la table de gestion des actualités en annonçant la modification dans le texte de la nouvelle actualité.

-- Si 1 colonne change et pas les autres, alors je met 1 actualité qui indique le changement
-- Si plusieurs colonne changent et pas les autres, alors je met 1 actualité "MODIFICATIONS MAJEURES"
DROP TRIGGER IF EXISTS modifAnim; 

DELIMITER //
CREATE TRIGGER modifAnim
AFTER UPDATE ON t_animation_ani
FOR EACH ROW
BEGIN
--SET @compteur := 0; Si je n'avais pas mis les AND
	IF(NEW.ani_debut != OLD.ani_debut AND NEW.ani_fin = OLD.ani_fin AND NEW.ani_libelle = OLD.ani_libelle AND NEW.ani_desc = OLD.ani_desc AND NEW.lie_id = OLD.lie_id) THEN
		INSERT INTO t_actualite_act VALUES (NULL,'Attention, Modification de l''animation ',CONCAT_WS("--> ",OLD.ani_libelle,OLD.ani_desc, "Attention, report de la date du début de l'animation",NEW.ani_debut),NOW(),'P','organisateur');
	
	ELSEIF(NEW.ani_fin != OLD.ani_fin AND NEW.ani_debut = OLD.ani_debut AND NEW.ani_libelle = OLD.ani_libelle AND NEW.ani_desc = OLD.ani_desc AND NEW.lie_id = OLD.lie_id) THEN
		INSERT INTO t_actualite_act VALUES (NULL,'Attention, Modification de l''animation ',CONCAT_WS("--> ",OLD.ani_libelle,OLD.ani_desc, "Attention, report de la date de fin de l'animation",NEW.ani_fin),NOW(),'P','organisateur');
	
	ELSEIF(NEW.ani_libelle != OLD.ani_libelle AND NEW.ani_debut = OLD.ani_debut AND NEW.ani_fin = OLD.ani_fin AND NEW.ani_desc = OLD.ani_desc AND NEW.lie_id = OLD.lie_id) THEN
		INSERT INTO t_actualite_act VALUES (NULL,'Attention, Modification de l''animation ',CONCAT_WS("--> ",OLD.ani_libelle,OLD.ani_desc, "Attention, modification du titre de l'animation",NEW.ani_libelle),NOW(),'P','organisateur');
	
	ELSEIF(NEW.ani_desc != OLD.ani_desc AND NEW.ani_debut = OLD.ani_debut AND NEW.ani_fin = OLD.ani_fin AND NEW.ani_libelle = OLD.ani_libelle AND NEW.lie_id = OLD.lie_id) THEN
		INSERT INTO t_actualite_act VALUES (NULL,'Attention, Modification de l''animation ',CONCAT_WS("--> ",OLD.ani_libelle,OLD.ani_desc, "Attention, modification de la description de l'animation",NEW.ani_desc),NOW(),'P','organisateur');
	
	ELSEIF(NEW.lie_id != OLD.lie_id AND NEW.ani_debut = OLD.ani_debut AND  NEW.ani_fin = OLD.ani_fin AND NEW.ani_libelle = OLD.ani_libelle AND NEW.ani_desc = OLD.ani_desc) THEN
		INSERT INTO t_actualite_act VALUES (NULL,'Attention, Modification de l''animation ',CONCAT_WS("--> ",OLD.lie_id,OLD.ani_desc, "Attention, modification du lieu de l'animation",NEW.lie_id),NOW(),'P','organisateur');
	ELSE
		INSERT INTO t_actualite_act VALUES (NULL,'Attention, plusieurs modification de l''animation ',CONCAT_WS("--> ",NEW.ani_libelle,NEW.ani_desc,"Horaire début de l'animation",NEW.ani_debut,"Horaire fin de l'animation",NEW.ani_fin,"lieu",NEW.lie_id),NOW(),'P','organisateur');
	END IF;
END;	
//
DELIMITER ;

-- TEST :
UPDATE t_animation_ani
SET ani_libelle = "c'est le test", ani_desc = "j'ai modifié 2 informations OMG"
WHERE ani_id = 8

-- Trigger 2

-- trigger qui suite à la suppression d’une animation programmée, supprime, dans la table des actualités, toutes celles qui font référence (« parlent ») à l’animation concernée
-- Utilisation de concat('%',), LIKE

DROP TRIGGER IF EXISTS suppAnim; 

DELIMITER //
CREATE TRIGGER suppAnim
AFTER DELETE ON t_animation_ani
FOR EACH ROW --boucle sur chaques lignes
BEGIN
	DELETE FROM t_actualite_act
	WHERE act_contenu LIKE CONCAT('%',OLD.ani_libelle,'%'); -- une partie de act_contenu contient le nom de l'animation  
END;	
//
DELIMITER ;

		----	Activite 5		----
		
--Si pas d'idée, faire procedure/fonction de nettoyage ou procedure/fonction qui empeche un invité d'être à 2 activités en même temps
	
--Préparez plusieurs vues pour votre base de données (au moins une vue par étudiant) :
	
CREATE VIEW INFOS_CPT(pseudo_du_cpt,statut_du_cpt) #On choisit le nom des données qui sont affichées
AS 
SELECT cpt_pseudo, cpt_statut
FROM t_compte_cpt;
	
--EXECUTION

SELECT * FROM INFOS_CPT;
	
----
	
DROP VIEW IF EXISTS INVTES_ANI;
	
CREATE VIEW INVITES_ANI(animation_libelle,invite_intervenant,nombre_invites_intervenant) #On choisit le nom des données qui sont affichées
AS 
SELECT ani_libelle, GROUP_CONCAT(ivt_libelle), COUNT(ivt_libelle)
FROM t_animation_ani
JOIN t_intervention_int USING (ani_id)
JOIN t_invite_ivt USING (cpt_pseudo)
GROUP BY ani_libelle;
	
--EXECUTION

SELECT * FROM INVITES_ANI;

-- Préparez plusieurs fonctions pour votre base de données (au moins une fonction par étudiant).
-- 1 fonction qui retourne le nbr d'animations auquel participe 1 invité entré en parametre

DROP FUNCTION IF EXISTS nbr_animations_invite; 

DELIMITER // /* Pour préciser que c'est une procédure/fonction (il n'y a pas de ';') */
CREATE FUNCTION nbr_animations_invite(id_invite VARCHAR(60)) RETURNS INT /* Utilisation de GROUP_CONCAT() */
BEGIN
	
	DECLARE nbr_animations INT;
	
	SELECT COUNT(ani_libelle) INTO nbr_animations
	FROM t_animation_ani
	JOIN t_intervention_int USING (ani_id)
	JOIN t_invite_ivt USING (cpt_pseudo)
	WHERE cpt_pseudo = id_invite;
	
	RETURN nbr_animations;
END;
//
DELIMITER ;

-- Execution :

SELECT nbr_animations_invite('justinBieber');


-- Préparez plusieurs procédures pour votre base de données (au moins une procédure par étudiant).

-- 1 procédure qui vérifie qu'un invité n'est pas à 2 animations en même temps, qui renvoie en sortie les invités concernés par ce problème. (PAS REUSSI)

DROP PROCEDURE IF EXISTS probleme_animation_invite; 

DELIMITER //
CREATE PROCEDURE probleme_animation_invite(in id_invite_a_verifier VARCHAR(60),out invites_concernes VARCHAR(500))
BEGIN
	
	SELECT GROUP_CONCAT(ivt_libelle) INTO invites_concernes 
	FROM t_invite_ivt 
	JOIN t_intervention_int using (cpt_pseudo)
	JOIN t_animation_ani using (ani_id)
	WHERE cpt_pseudo = id_invite_a_verifier AND COUNT(ani_debut)......
END;
//
DELIMITER ;

-- 1 procédure qui cache tous les posts publiés, et renvoie le nombre de posts qui ont été cachés

DROP PROCEDURE IF EXISTS cacher_posts_publies; 

DELIMITER //
CREATE PROCEDURE cacher_posts_publies(out nbr_posts_caches INT)
BEGIN
	
	SELECT COUNT(pos_etat) INTO nbr_posts_caches FROM t_post_pos WHERE pos_etat = 'P'; 
	
	UPDATE t_post_pos SET pos_etat = 'C' WHERE pos_etat = 'P';
END;
//
DELIMITER ;

-- Execution :

CALL cacher_posts_publies(@nbr_posts);
SELECT @nbr_posts;

-- Préparez plusieurs triggers pour votre base de données (au moins 2 déclencheurs par étudiant).

--REQUETE EXECUTEE APRES AVOIR DROP TABLE à cause d'une erreur
CREATE TABLE t_objetTrouve_obj
(
	obj_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	obj_libelle VARCHAR(100),
	obj_desc VARCHAR(300),
    tic_num_ticket char(30),
	lie_id INT,
	FOREIGN KEY (tic_num_ticket) REFERENCES t_ticket_tic(tic_num_ticket),
	FOREIGN KEY (lie_id) REFERENCES t_lieu_lie(lie_id)
)


-- 1 déclencheur qui publie une actualité quand un objet à été signalé perdu (après une insertion d'objet dans les objets trouvés).
DROP TRIGGER IF EXISTS actu_obj_perdu; 

DELIMITER //
CREATE TRIGGER actu_obj_perdu
AFTER INSERT ON t_objetTrouve_obj
FOR EACH ROW --boucle sur chaques lignes (obligé de le mettre)
BEGIN
	INSERT INTO t_actualite_act
	VALUES (NULL,"Nouvel objet perdu",CONCAT_WS(" -> ", "Attention, un objet a été perdu, il s'agit de", NEW.obj_libelle, NEW.obj_desc, "Si vous retrouvez cet objet, merci de nous le signaler au plus vite."), NOW(), 'P', 'organisateur');
END;	
//
DELIMITER ;

INSERT INTO t_objetTrouve_obj VALUES (NULL,'Macbook Pro 13','Fond d''écran contenant un palmier',NULL,'3');

-- 1 déclencheur qui publie une actualité quand un objet à été retrouvé (après une modification dans t_objetTrouve_obj.tic_num_ticket)

DROP TRIGGER IF EXISTS actu_obj_retrouve; 

DELIMITER //
CREATE TRIGGER actu_obj_retrouve
AFTER UPDATE ON t_objetTrouve_obj
FOR EACH ROW --boucle sur chaques lignes (obligé de le mettre)
BEGIN
	IF (OLD.tic_num_ticket != NEW.tic_num_ticket) THEN
	INSERT INTO t_actualite_act
	VALUES (NULL,"Objet retrouvé",CONCAT_WS(" -> ", "Objet retrouvé, merci.", NEW.obj_libelle, NEW.obj_desc), NOW(), 'P', 'organisateur');
	END IF; 
END;	
//
DELIMITER ;
