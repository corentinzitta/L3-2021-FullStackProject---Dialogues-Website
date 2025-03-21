#	-----	ACTIVITE 1	-----
SET @max_id := (SELECT MAX(pfl_id) FROM t_profil_pfl);

#	-----	ACTIVITE 1	-----
SET @annee := (SELECT MIN(YEAR(pfl_date)) FROM t_profil_pfl); SELECT @annee;

#	-----	ACTIVITE 1	-----
SET @annee2 := SELECT YEAR(pfl_date) fROM t_profil_pfl;
SET @min_annee := SELECT MIN(@annee2);

#	-----	ACTIVITE 2 : view	-----

CREATE VIEW INFOS_CPT(pseudo_du_cpt,statut_du_cpt) #On choisit le nom des données
AS SELECT cpt_pseudo, cpt_statut
FROM t_compte_cpt;

SELECT * FROM INFOS_CPT;

#	-----	ACTIVITE 3 : fonctions	-----

# Une fonction renvoie une valeur de retour (return) , une procédure traite des données et ne renvoie rien (ou pas implicitement). Ils prennent tous les deux des paramètres (et non des arguments), ce sont des sous-programmes

DELIMITER // #Pour préciser que c'est une procédure/fonction, il n'y a pas de ';'
CREATE FUNCTION hello_world() RETURNS TEXT BEGIN
RETURN 'Hello World'; END;
//
DELIMITER ;
--puis ensuite pour appeler la fonction (SELECT) / Pour appeler la procédure (CALL):
SELECT hello_world();
	
	-----------------
#Ne prend pas en compte l'anniversaire:

DELIMITER // #Pour préciser que c'est une procédure/fonction, il n'y a pas de ';'
CREATE FUNCTION age_cpt(year_cpt DATE) RETURNS INTEGER 
BEGIN
RETURN (YEAR(CURRENT_DATE)-YEAR(year_cpt));
END;
//
DELIMITER ;

#OU

DELIMITER //
CREATE FUNCTION age_cpt(year_cpt DATE) RETURNS INTEGER 
BEGIN
DECLARE AGE INT DEFAULT 0;
SET AGE := YEAR(CURRENT_DATE)-YEAR(year_cpt)
RETURN AGE;
END;
//
DELIMITER ;

#OU : MIEUX, prend en compte l'anniversaire

DROP FUNCTION IF EXISTS age_cpt;

DELIMITER //
CREATE FUNCTION age_cpt(date_anniversaire DATE) RETURNS INT
BEGIN
	DECLARE AGE INT DEFAULT 0;
	SET AGE := YEAR(CURRENT_DATE)-YEAR(date_anniversaire);
	IF MONTH(date_anniversaire) > MONTH( CURDATE() )  OR (DAY(date_anniversaire) > DAY(CURDATE()) )
		THEN SET AGE = (AGE-1);
	END IF;
	RETURN AGE;
END;
//
DELIMITER ;

#	----	APPEL FUNCTION	----
SET @date_naissance := (SELECT date_naissance_a_supp FROM t_compte_cpt WHERE cpt_pseudo = 'Bieber');
SELECT age_cpt(@date_naissance);

#	-----	ACTIVITE 4 : procédure	-----

# pas de return en procédure, possibilité de renvoyer quand meme avec IN (entrée) | OUT (sortie) | INOUT (entree et sortie)

DELIMITER //
CREATE PROCEDURE age_titulaire_pfl(in id_du_profil INT, out age_pfl INT) 
BEGIN
	SET @date_naissance := (SELECT pfl_date_naissance FROM t_profil_pfl WHERE pfl_id = id_du_profil); 
	age_pfl := (SELECT age_cpt(@date_naissance));
END;
//
DELIMITER ;

#	----	APPEL PROCEDURE	----

call age_titulaire_pfl(1,@date_naissance);

#	CREATION DE LA TABLE 

CREATE TABLE sql_psm_test
(
   	nom_pfl	VARCHAR(30),
	prenom_pfl VARCHAR(30),
    date_naissance DATE
    
);

#Test pour récupérer l'âge du profil

SET @naissancepfl := (SELECT date_naissance FROM sql_psm_test WHERE prenom_cpt = 'mimo');
SELECT age_cpt(@naissancepfl);

#Faire une vue cointenant l'âge du profil

CREATE view vue_age
AS SELECT nom_cpt, prenom_cpt, age_cpt(date_naissance) as AGE
FROM sql_psm_test;

#Procedure pour avoir l'age moyen (avec Average (AVG)) : 

DROP PROCEDURE IF EXISTS donner_age_moyen;

DELIMITER //
CREATE PROCEDURE donner_age_moyen(OUT AGE_MOYEN DOUBLE) #DOUBLE pour avoir plus de précision
BEGIN
	SELECT AVG(AGE) INTO AGE_MOYEN_PFL FROM vue_age;
END;
// DELIMITER

##	-----	ACTIVITE 5 : TRIGGERS (DECLENCHEURS)	-----

#Un trigger est ATTACHE à 1 SEULE table
#UTILISATION DES OPERATEURS : OLD & NEW (Utilisable en même temps seulement avec UPDATE)

#Ajout d'une colonne de date creation profil
ALTER TABLE sql_psm_test
ADD pfl_date DATE;


#Création du trigger : qui applique à la date de création du profil la date du jour d’insertion des données du nouveau profil
DROP TRIGGER IF EXISTS maj_date;

DELIMITER //
CREATE TRIGGER maj_date
BEFORE INSERT ON sql_psm_test #Comme on a BEFORE, on sait dans quelle ligne on est
FOR EACH ROW
BEGIN
SET NEW.pfl_date := CURDATE( ); #NEW indique la nouvelle donnée insérée, donc on s'applique à 1 seul ROW.
END;
//
DELIMITER ;

#TEST du Trigger : Il doit mettre la date d'ajd dans pfl_date (derniere date d'ici 1992)
INSERT INTO sql_psm_test VALUES ('tyda','momo','2005-12-25','1992-06-01');

#Création du trigger : met à jour la date associée au PROFIL (pfl_date) suite à la mise à jour (UPDATE) d’une ligne de la table de gestion des COMPTES (ATTENTION : PROFIL != COMPTE)

alter table sql_psm_test rename to sql_psm_pfl; #Je renomme la table pour faire l'exercice

#Je créé une nouvelle table de compte
CREATE TABLE sql_psm_cpt
(
	cpt_id INT PRIMARY KEY AUTO_INCREMENT,
	cpt_pseudo VARCHAR(20),
	cpt_mdp VARCHAR(30)
);

ALTER TABLE sql_psm_cpt ADD CONSTRAINT FK_idpfl FOREIGN KEY (pfl_id) REFERENCES sql_psm_pfl(pfl_id);

#TRIGGER : met à jour la date associée au PROFIL (pfl_date) suite à la mise à jour (UPDATE) d’une ligne de la table de gestion des COMPTES (ATTENTION : PROFIL != COMPTE)

DROP TRIGGER IF EXISTS maj_date_pfl_cpt;

DELIMITER //
CREATE TRIGGER maj_date_pfl_cpt
AFTER UPDATE ON sql_psm_cpt
FOR EACH ROW
BEGIN
UPDATE sql_psm_pfl SET pfl_date = CURDATE( ) WHERE sql_psm_pfl.pfl_id = NEW.pfl_id; #NEW.pfl_id c'est la colonne/ligne (foreign key) pfl_id dans la table sql_psm_cpt
END;
//
DELIMITER ;

