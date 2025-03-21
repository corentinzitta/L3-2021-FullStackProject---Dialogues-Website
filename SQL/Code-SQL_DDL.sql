/* Convention titre de table (mettre 3 lettres (usr,lie,new..)) */

create table t_useraccount_usr
(
	usr_pseudo varchar(20) primary key not null,
	usr_password char(32)
)

create table t_profil_pro
(
	pro_nom varchar(60) not null,
	pro_prenom varchar(60) not null,
	pro_mail varchar(100) not null,
	pro_validity char(1) not null,
	pro_status char(1) not null,
	pro_date date not null,
	usr_pseudo varchar(20) primary key not null,
	foreign key (usr_pseudo) references t_useraccount_usr(usr_pseudo)
)

create table t_news_new
(
	new_number int primary key not null AUTO_INCREMENT,
	new_title varchar(50) not null,
	new_text varchar(300) not null,
	new_pubdate date not null,
	new_etat char(1),
	usr_pseudo varchar(20) not null,
	foreign key (usr_pseudo) references t_useraccount_usr(usr_pseudo)
)

create table t_presentation_pre
(
	pre_number int primary key not null AUTO_INCREMENT, 
	pre_structure varchar(60) not null,
	pre_adresse varchar(100) not null,
	pre_mail varchar(100) not null,
	pre_phonenbr char(12),
	pre_horaires varchar(60),
	pre_bvntxt varchar(300) not null,
	usr_pseudo varchar(20) not null,
	foreign key (usr_pseudo) references t_useraccount_usr(usr_pseudo)
)

create table t_selection_sel
(
	sel_number int primary key not null AUTO_INCREMENT,
	sel_title varchar(100) not null,
	sel_textintro varchar(200) not null,
	sel_addeddate date not null,
	usr_pseudo varchar(20) not null,
	foreign key (usr_pseudo) references t_useraccount_usr(usr_pseudo)
)

create table t_element_ele
(
	ele_number int primary key not null AUTO_INCREMENT,
	ele_title varchar(100) not null,
	ele_text varchar(300) not null,
	ele_pubdate date,
	ele_img varchar(100) not null,
	ele_etat char(1)
)

create table t_liaison_lia
(
	ele_number int primary key not null,
	sel_number int primary key not null,
	foreign key (ele_number) references t_element_ele(ele_number),
	foreign key (sel_number) references t_selection_sel(sel_number)
)

create table t_lien_lie
(
	lie_numero int primary key not null AUTO_INCREMENT,
	lie_title varchar(60) not null,
	lie_url varchar(60) not null,
	lie_author varchar(100),
	lie_pubdate varchar(15) not null,
	ele_number int not null,
	foreign key (ele_number) references t_element_ele(ele_number)
)


----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
/* meilleur solution : insérer les foreign keys a la fin */
/* Les int mettre auto_increment (sauf table liaison) */

/* La commande AUTO_INCREMENT est utilisée dans le langage SQL afin de spécifier qu’une colonne numérique avec une clé primaire (PRIMARY KEY) sera incrémentée automatiquement à chaque ajout d’enregistrement dans celle-ci. */

/* Convention titre de table (mettre 3 lettres (usr,lie,new..)) */

create table t_useraccount_usr
(
	usr_pseudo varchar(20) primary key not null,
	usr_password char(32)
) ENGINE = InnoDB;

create table t_profil_pro
(
	pro_nom varchar(60) not null,
	pro_prenom varchar(60) not null,
	pro_mail varchar(100) not null,
	pro_validity char(1) not null,
	pro_status char(1) not null,
	pro_date date not null,
	usr_pseudo varchar(20) primary key not null
) ENGINE = InnoDB;

create table t_news_new
(
	new_number int primary key not null AUTO_INCREMENT, /* pour que AUTO_INCREMENT marche il faut que ça soit une clé primaire */
	new_title varchar(50) not null,
	new_text varchar(300) not null,
	new_pubdate date not null,
	new_etat char(1),
	usr_pseudo varchar(20) not null
) ENGINE = InnoDB;

create table t_presentation_pre
(
	pre_number int primary key not null AUTO_INCREMENT, 
	pre_structure varchar(60) not null,
	pre_adresse varchar(100) not null,
	pre_mail varchar(100) not null,
	pre_phonenbr char(12),
	pre_horaires varchar(60),
	pre_bvntxt varchar(300) not null,
	usr_pseudo varchar(20) not null
) ENGINE = InnoDB;

create table t_selection_sel
(
	sel_number int primary key not null AUTO_INCREMENT,
	sel_title varchar(100) not null,
	sel_textintro varchar(200) not null,
	sel_addeddate date not null,
	usr_pseudo varchar(20) not null
) ENGINE = InnoDB;

create table t_element_ele
(
	ele_number int primary key not null AUTO_INCREMENT,
	ele_title varchar(100) not null,
	ele_text varchar(300) not null,
	ele_pubdate date,
	ele_img varchar(100) not null,
	ele_etat char(1)
) ENGINE = InnoDB;

create table t_liaison_lia
(
	ele_number int not null,
	sel_number int not null,
    primary key (ele_number,sel_number)
) ENGINE = InnoDB;

create table t_lien_lie
(
	lie_numero int primary key not null AUTO_INCREMENT,
	lie_title varchar(60) not null,
	lie_url varchar(60) not null,
	lie_author varchar(100),
	lie_pubdate varchar(15) not null,
	ele_number int not null
) ENGINE = InnoDB;

----------- commandes utilisées à posteriori -----------

/* ALTER TABLE t_news_new MODIFY new_number int AUTO_INCREMENT : utilisé si AUTO_INCREMENT n'était pas présent dans le code */
(
/* AFIN DE RAJOUTER LE MOTEUR DE STOCKAGE InnoDB par la suite */
ALTER TABLE t_useraccount_usr ENGINE = InnoDB
ALTER TABLE t_profil_pro ENGINE = InnoDB
ALTER TABLE t_news_new ENGINE = InnoDB
ALTER TABLE t_presentation_pre ENGINE = InnoDB
ALTER TABLE t_selection_sel ENGINE = InnoDB
ALTER TABLE t_element_ele ENGINE = InnoDB
ALTER TABLE t_liaison_lia ENGINE = InnoDB
ALTER TABLE t_lien_lie ENGINE = InnoDB
)

/* Ajout des foreign keys : */

ALTER TABLE t_profil_pro ADD CONSTRAINT FK_pro_usr FOREIGN KEY (usr_pseudo) references t_useraccount_usr(usr_pseudo) /* On nomme nous même la contrainte (convention avec FK pour ForeignKey: FK_tableOrigine_tableFinale) */
ALTER TABLE t_news_new ADD CONSTRAINT FK_new_usr FOREIGN KEY (usr_pseudo) references t_useraccount_usr(usr_pseudo)
ALTER TABLE t_presentation_pre ADD CONSTRAINT FK_pre_usr FOREIGN KEY (usr_pseudo) references t_useraccount_usr(usr_pseudo)
ALTER TABLE t_selection_sel ADD CONSTRAINT FK_sel_usr FOREIGN KEY (usr_pseudo) references t_useraccount_usr(usr_pseudo)
ALTER TABLE t_liaison_lia ADD CONSTRAINT FK_lia_ele FOREIGN KEY (ele_number) references t_element_ele(ele_number)
ALTER TABLE t_liaison_lia ADD CONSTRAINT FK_lia_sel FOREIGN KEY (sel_number) references t_selection_sel(sel_number)
ALTER TABLE t_lien_lie ADD CONSTRAINT FK_lie_ele FOREIGN KEY (ele_number) references t_element_ele(ele_number)

INSERT INTO t_useraccount_usr
VALUES 	('zitta_corentin',MD5('secretzitta')),
		('rak_babui',MD5('secretbabui')),
		('azd_versea',MD5('secretversea'));


INSERT INTO t_profil_pro 
VALUES 	('azd', 'versea', 'buyre@gmail.com', 'A', 'R', '2021-01-21', 'azd_versea'),
('Charpiette', 'Arthur', 'charpiette.a@gmail.com', 'A', 'A', '2021-01-29', 'charpiette_arthur'),
('premier', 'gestionnaire', 'gestionnaire1@gmail.com', 'A', 'A', '2021-01-29', 'gestionnaire1'),
('Lanciaux', 'Jerome', 'lanciauxj@gmail.com', 'A', 'A', '2021-01-29', 'lanciaux_jerome'),
('rak', 'Babui', 'blaqad@gmail.com', 'D', 'R', '2021-01-21', 'rak_babui'),
('zitta', 'corentin', 'blala1@gmail.com', 'A', 'A', '2021-01-21', 'zitta_corentin');

INSERT INTO t_news_new 
VALUES 	(1, 'Le nouveau livre tendance en SF : Expiration', 'Les neuf histoires qui constituent ce livre brillent à la fois par leur originalité et leur universalité. Des questions ancestrales - l\'homme dispose-t-il d\'un libre arbitre ? si non, que peut-il faire de sa vie ? - sont abordées sous un angle radicalement nouveau.', '2021-01-28', 'C', 'zitta_corentin'),
(2, 'Le nouveau manga tendance : Jujutsu Kaisen', 'Souffrance, regrets, humiliations... les sentiments négatifs que ressentent les humains se transforment peu à peu en fléaux se cachant dans notre existence. Sévissant dans le monde entier, ils sont capables d\'entraîner les gens dans de terribles malheurs et, parfois même, jusqu\'à la mort. ', '2021-01-30', 'C', 'zitta_corentin'),
(3, 'Des nouveaux arrivages dans votre librairie', 'Nous avons pu mettre la main sur des nouveaux lives qui sauront vous faire passer un agréable moment confiné :\r\n- De la démocratie en pandémie, de Barbara Stiegler\r\n- La Chronique des Bridgerton, de Julia Quinn\r\n- Les choses humaines, de Karine Tuil\r\n- Ce matin-là, de Gaëlle Josse', '2021-01-12', 'L', 'zitta_corentin');


INSERT INTO t_presentation_pre
VALUES 	(1, 'Dialogues', 'Parvis Marie Paul Kermarec, Square Mgr Roull, 29200 Brest', 'boutique@librairiedialogues.fr', '+33298448868', '10h-17h30', 'Bienvenue chez votre librairie dialogues en ligne, bien que moins conviviale qu\'en magasin nous sommes certain que notre showroom saura vous combler', 'zitta_corentin');
		
		
INSERT INTO t_selection_sel 
VALUES 	(1, 'Mangas', 'Bienvenue dans le showroom Manga, trouvez votre bonheur parmi les shonen, seinen, shojo que nous proposons', '2021-01-23', 'zitta_corentin'),
(2, 'SF', 'Bienvenue dans le showroom SF, trouvez votre bonheur parmi les différents types de livres que nous proposons : dystopie, Post-Apocalyptique, Space Opera, Science-Fantasy.. et encore pleins d\'autres', '2021-01-23', 'zitta_corentin'),
(3, 'Littérature', 'Bienvenue dans le showroom Littérature, nous sommes sûr que vous trouverez votre bonheur parmi nos Romans, Biographie, Mémoires, Contes, Epopées', '2021-01-23', 'zitta_corentin');

INSERT INTO t_element_ele 
VALUES 	(1, 'One Piece : Tome 25', 'Il était une fois, dans un monde avec des pirates..', '2021-01-30', 'chemin/opt25.jpg', 'P'),
(2, 'Bleach : Tome 12', 'Ichigo se retrouve face à aizen, aucune issue mais il n\'est pas arrivé au bout de ses surprises', '2021-01-31', 'chemin/blt12.jpg', 'B'),
(3, 'Demon Slayer : Tome 11', 'Tanjiro s\'entraine à maitriser le souffle integrale, pendant ce temps, quelque chose d\'horrible est en train de se préparer..', '2021-01-28', 'chemin/dst11.jpg', 'P');
		
INSERT INTO t_liaison_lia
VALUES 	('123', '01'),
		('165', '02'),,
		('1097', 'Demon Slayer : Tome 11', 'Tanjiro s''entraine à maitriser le souffle integrale, pendant ce temps, quelque chose d''horrible est en train de se préparer..', '2021-01-28', 'chemin/dst11.jpg', 'P');

INSERT INTO t_lien_lie 
VALUES 	(1, 'Avis One Piece tome 25', 'https://www.senscritique.com/bd/L_Homme_qui_valait_100_millions_One_Piece_tome_25/17393533', 'senscritique', '2021-01-30', 1),
(2, 'Avis Bleach tome 12', 'https://www.babelio.com/livres/Kubo-Bleach-Tome-12--Flower-on-the-Precipice/11723', 'babelio', '2021-01-30', 2),
(3, 'Avis Demon Slayer tome 11', 'https://www.babelio.com/livres/Gotouge-Demon-Slayer-tome-11/1258597', 'babelio', '2021-01-30', 3);

INSERT INTO t_profil_pro VALUES ('zitta', 'frederic', 'zitta.f@gmail.com', 'A', 'A', curdate(), 'zitta_frederic') /* curdate() pour la date actuelle */

INSERT INTO t_selection_sel 
VALUES 
(NULL, 'histoire', 'Bienvenue dans le showroom Histoire, vous saurez trouver votre bonheur parmis la grande quantité de livre que nous proposons', curdate(), 'zitta_frederic'); /* NULL pour l'auto_increment ou ne rien mettre pour auto_increment */
		