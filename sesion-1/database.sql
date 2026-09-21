CREATE DATABASE IF NOT EXISTS Annuaire_de_podcasts;
use Annuaire_de_podcasts;

create table Animateur(
 id_animateur int primary key auto_increment,
 nom varchar(50) not null,
 prenom varchar(50) not null,
 email varchar(50) unique not null

);
create table thematique(
 id_thematique int primary key auto_increment,
 Nom_thematique varchar(100) not null,
 descreption_thematique text 
);

create table episode (
 id_episode  int primary key auto_increment,
 titre varchar(150) not null,
 descreption_episode text not null,
 duree_episode time not null,
 date_publication datetime not null,
 id_animateur int not null,
 id_thematique int not null,
 foreign key (id_animateur) references Animateur(id_animateur),
  foreign key (id_thematique) references thematique(id_thematique)
);

