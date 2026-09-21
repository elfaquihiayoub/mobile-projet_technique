
## identifient fonctionel

here we can use :
	Id_animatur -> nom_animateur + prenom_animateur +email_animateur
	 id_thematique -> Nom_thematique + descreption_thematique
	 id_episode  ->titre_episode + descreption_episode + duree_episode + date_publication_episode+id_thematique+Id_animatur
	 

## -- les entiter
```
Animateur
thematique
episode
```


lire les regles :

Animateur ------(1,N)---animer------(1,1)--------episdoe
thematique -----(0,N)----appartien-----(1,1)---episode

![[Pasted image 20260911104342.png]](MCD_prototype.png.png)