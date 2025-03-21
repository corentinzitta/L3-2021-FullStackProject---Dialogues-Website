/* 1. Requêtes d'ajout des données d'un profil + compte associé */

INSERT INTO t_useraccount_usr VALUES ('raoult_oriane',MD5('secretraoult'))
INSERT INTO t_profil_pro VALUES ('Raoult', 'Oriane', 'raoult.o@gmail.com', 'A', 'R', curdate(), 'raoult_oriane')

/* 2. Requête de vérification des données de connexion (pseudo et mot de passe), cad requête qui vérifie l’existence (ou non) du couple pseudo / mot de passe dans la base */

SELECT * from t_useraccount_usr

/* 3. Requête de récupération de toutes les données d'un profil (dont on connaît le pseudo) */

SELECT * from t_profil_pro
WHERE usr_pseudo='raoult_oriane'

/* 4. Requête permettant de connaître le statut d’un utilisateur dont on connaît le nom et le prénom */

SELECT pro_status from t_profil_pro
WHERE pro_nom='Raoult' AND pro_prenom='Oriane'

/* 5. Requête de modification des données d'un profil (pseudo connu) */
 
UPDATE t_profil_pro
SET pro_prenom = 'Noellie' , pro_nom = 'Raoult'
WHERE usr_pseudo ='raoult_noellie'

/* 6. Requête de mise à jour du mot de passe d'un compte (pseudo connu) */

UPDATE t_compte_cpt
SET usr_password = MD5('secretoriane') 
WHERE usr_pseudo='raoult_oriane'

/* 7. Requête listant toutes les données des profils + comptes associés */

select * 
from t_useraccount_usr,t_profil_pro
where t_useraccount_usr.usr_pseudo = t_profil_pro.usr_pseudo

--OU

select * 
from t_useraccount_usr
Join t_profil_pro using (usr_pseudo)

/* 8. Requête de validation d'un profil (pseudo connu) */

update t_profil_pro
set pro_validity = 'A', pro_status = 'R'
where usr_pseudo='raoult_oriane'

/* 9. Requête de désactivation (/activation) d'un profil (pseudo connu) */

update t_profil_pro
set pro_validity = 'D'
where usr_pseudo='raoult_oriane'

/* 10. Requête d’ajout des informations de la structure */

INSERT INTO t_presentation_pre
VALUES 	(NULL, 'Dialogues', 'Parvis Marie Paul Kermarec, Square Mgr Roull, 29200 Brest', 'boutique@librairiedialogues.fr', '+33298448868', '10h-17h30', "Bienvenue chez votre librairie dialogues en ligne, bien que moins conviviale qu'en magasin nous sommes certain que notre showroom saura vous combler", 'zitta_corentin');

/* 11. Requête vérifiant qu’il n’y a qu’une seule ligne dans la table de gestion de la présentation */

select pre_number from t_presentation_pre

/* 12. Requête donnant les informations sur la structure */

select * from t_presentation_pre

/* 13. Requête de modification de l’adresse, du n° de téléphone et de l’adresse e-mail de la structure (structure = t_presentation_pre)*/

update t_presentation_pre
set pre_adresse = 'Parvis Marie Paul Kermarec, Square Mgr Roull, 29200 Brest', pre_phonenbr = '+33298448868', pre_mail='boutique@librairiedialogues.fr'

/* 14. Requête de suppression de toutes les informations de la structure */

DELETE FROM t_presentation_pre -- Ne reinitialise pas l'auto_increment

TRUNCATE TABLE t_presentation_pre --Va réinitialiser l'auto_increment

/* 15. Requête d'ajout d'une actualité */

INSERT INTO t_news_new VALUES (NULL,'Naruto Shippuden disponible chez votre librairie','Revoyez vos classique : tous les tomes de Naruto Shippuden sont disponibles chez votre librairie préferée',curdate(),'L','raoult_noellie')

/* 16. Requête donnant la dernière actualité ajoutée */

select *
from t_news_new
order by new_number DESC LIMIT 1

/* 17. Requête listant toutes les actualités et leur auteur */

select new_title,usr_pseudo
from t_news_new

/* 18. Requête listant les 5 dernières actualités ajoutées et leur auteur */

select new_title,usr_pseudo
from t_news_new
order by new_number DESC LIMIT 5

/* 19. Requête de modification d'une actualité */

update t_news_new
set new_title = 'Naruto Shippuden disponible chez votre librairie', new_text = 'Revoyez vos classique : tous les tomes de Naruto Shippuden sont disponibles chez votre librairie préferée'
where new_number = '4'

/* 20. Requête de suppression d'une actualité à partir de son ID (n°) */

Delete from t_news_new --Cette requete ne va pas re-initialiser l'auto_increment
where new_number = '4'

ALTER TABLE t_new_new AUTO_INCREMENT=1 --pour remettre l'auto_increment

/* 21. Requête de désactivation de toutes les actualités publiées avant une certaine date (archivage des actualités trop anciennes) */

Update t_news_new
set new_etat = 'C'
where new_pubdate < 01-01-2020

/* 22. Requête d'ajout d'une sélection */

INSERT INTO t_selection_sel VALUES (NULL,'Scolaire','Bienvenue dans le showroom scolaire, dans ce showroom vous pourrez trouver tout ce qui est relatif aux études, allant de la maternelle, aux livres pour les études supérieurs.',curdate(),'raoult_noellie')

/* 23. Requête listant tous les éléments d’une sélection particulière */

select ele_title from t_element_ele
JOIN t_liaison_lia USING (ele_number)
JOIN t_selection_sel USING (sel_number)
where sel_title like 'Mangas'

/* COMMENT AFFICHER A PARTIR DE CETTE REQUETE SEULEMENT * DE T_ELEMENT_ELE, SANS INCLURE t_liaison_lia et t_selection_sel
select * from t_element_ele
JOIN t_liaison_lia USING (ele_number)
JOIN t_selection_sel USING (sel_number)
where sel_title like 'Mangas' */ 

/* 24. Requête comptant le nombre de sélections qui existent dans la base de données */

select count(sel_number) 
from t_selection_sel

/* 25. Requête listant toutes les sélections et leurs éléments éventuels (+ lien(s)) : */

SELECT sel_number, sel_title, ele_number, ele_text, lie_url
FROM t_selection_sel 
LEFT OUTER JOIN t_liaison_lia USING (sel_number)
LEFT OUTER JOIN t_element_ele USING (ele_number)
LEFT OUTER JOIN t_lien_lie USING (ele_number);

SELECT sel_number, sel_title, ele_number, ele_text, lie_url
FROM t_lien_lie 
JOIN t_element_ele USING (ele_number)
RIGHT OUTER JOIN t_liste_lis USING(ele_number) 
RIGHT OUTER JOIN t_selection_sel USING (sel_number);

/* 26. Requête de modification d'une sélection */

update t_selection_sel
set sel_title = 'Mangas'
where sel_number = '1'

/* 27. Requête(s) de suppression d'une sélection à partir de son identifiant (ID) */

delete from t_selection_sel
where sel_number= '4'

/* 28. Requête listant toutes les sélections qui n’ont pas d’élément associé */

select ele_title, sel_title
from t_element_ele
JOIN t_liaison_lia USING (ele_number)
RIGHT JOIN t_selection_sel USING (sel_number)
where ele_title is NULL

/* 29. Requête récupérant toutes les données d’un élément dont on connaît l’identifiant (ID) */

select * from t_element_ele
where ele_number = '4'

/* 30. Requête d'ajout d'un élément pour une sélection particulière (ID connu) */

INSERT INTO t_element_ele VALUES (NULL, 'Mondes en guerre\r\nGuerres mondiales et impériales. 1870-1945', 'Explorer la diversité des pratiques guerrières sur tous les continents depuis la préhistoire jusqu\'à nos jours, telle est l\'ambition des Mondes en guerre.', curdate(), 'chemin/hg.jpg', 'P');
INSERT INTO t_liaison_lia VALUES ('5', '4');

/* ALTER TABLE t_element_ele AUTO_INCREMENT=1 */

/* 31. Requête(s) de suppression d'un élément particulier (ID connu) */

delete from t_element_ele
where ele_number = '4'

/* 32. Requête donnant l’ID de l’élément suivant connaissant l’ID de l’élément actuel choisi dans une sélection d’ID connu (puis même chose pour l’élément précédent) */
/* ORDER BY .. ASC est par défaut */

select ele_number, ele_title
from t_liaison_lia
JOIN t_element_ele USING (ele_number)
where ele_number > 2 AND sel_number = 1
LIMIT 1

select ele_number, ele_title
from t_liaison_lia
JOIN t_element_ele USING (ele_number)
where ele_number < 7 AND sel_number = 2
ORDER BY ele_number DESC
LIMIT 1

/* 33. Requête de modification d'un élément d'une sélection particulière (ID connus) */

UPDATE t_element_ele
join t_liaison_lia USING (ele_number)
join t_selection_sel USING (sel_number)
set ele_etat = 'B'
where sel_number = '4' AND ele_title LIKE 'Mondes%'

/* 34. Requête(s) de suppression de tous les éléments d’une sélection particulière (ID connu) <=> Requête(s) pour retirer tous les éléménets d'une sélection particulière (ID connu)*/

DELETE FROM t_liaison_lia WHERE sel_number = 5; /* On ne supprime pas vraiment l'élement mais on en enlève son association dans la table t_liaison_lia */

/* 35. Requête de suppression de toutes les sélections n’ayant pas d’élément associé */

delete from t_selection_sel
where sel_number IN (select sel_number
					from t_element_ele
					JOIN t_liaison_lia USING (ele_number)
					RIGHT JOIN t_selection_sel USING (sel_number)
					where ele_title is NULL )
					
/* 36. Requête de désactivation (remise à l’état brouillon) d’un élément particulier (ID connu) */

update t_element_ele
set ele_etat = 'B'
where ele_number = '5'

/* 37. Requête cachant tous les éléments ajoutés par un utilisateur particulier dont on connaît le pseudo */

update t_element_ele
set ele_etat = 'P'
where ele_number IN ( 	select ele_number from t_element_ele
						Join t_liaison_lia using (ele_number)
						Join t_selection_sel using (sel_number)
						where usr_pseudo = 'zitta_corentin'	)

/* 38. Requête qui récupère toutes les données associées (sans oublier les liens) à une sélection particulière dont on connaît l’identifiant (ID) */
						
select distinct * from t_selection_sel
left join t_liaison_lia using (sel_number)
left join t_element_ele using (ele_number)
left join t_lien_lie using (ele_number)
where sel_number = '1'

/* 39. Requête ajoutant un lien pour l’élément choisi */

INSERT INTO t_lien_lie VALUES (NULL, 'Avis Mondes en guerre', 'https://www.fnac.com/Mondes-en-guerre-Tome-III/a14041687/avis', 'fnac', curdate(), '5');

/* 40. Requête de suppression d’un lien dont on connaît l’URL */

delete from t_lien_lie
where lie_url = 'https://www.fnac.com/Mondes-en-guerre-Tome-III/a14041687/avis'

ALTER TABLE t_new_new AUTO_INCREMENT=1

/*
delete from t_lien_lie
where lie_url LIKE '%https://www.fnac.com/Mondes-en-guerre-Tome-III/a14041687/avis%' */

/* 41. Requête listant toutes les URL des liens de la base, sans redondance */

select distinct lie_url 
from t_lien_lie

/* 42. Requête listant tous les éléments, leur sélection et les URL des liens, s’il y en a */

select ele_title, sel_title,lie_url
from t_selection_sel
join t_liaison_lia using (sel_number)
join t_element_ele using (ele_number)
left join t_lien_lie using (ele_number)

/* 43. Requête listant les URL des liens associés à un élément dont on connaît l’identifiant (ID) */

select lie_url,ele_number
from t_lien_lie
join t_element_ele using (ele_number)
where ele_number ='3'

/* 44. Requête qui vérifie l’existence (ou non) d’une URL d’un lien parmi les URL qui existent */

select lie_url,lie_title from t_lien_lie
where lie_url = (	select lie_url from t_lien_lie
	 				where lie_url = 'https://www.fnac.com/Mondes-en-guerre-Tome-III/a14041687/avis')

/* NE FONCTIONNE PAS : EXISTS execute ce qu'il y a au-dessus de lui si la condition après lui renvoie un résultat
					
select lie_url,lie_title
from t_lien_lie
where EXISTS (	select lie_url 
    			from t_lien_lie
				where lie_url = 'https://www.fnac.com/Mondes-en-guerre-Tome-III/a14041687/avis') */
				











