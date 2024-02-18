# SAE-PHP

SAE WEB PHP dont l'objectif est de réaliser une application web afin de présenté le contenu présent dans la base d'album de musique.

### Requirement 

```
php > 8.0
```

### Technologies / librairies utilisés

- Ajax
- Swiper (https://swiperjs.com/)
- Spyc (https://github.com/mustangostang/spyc)

### Mise en place de la base de donnée

Parse le YML (et créer la base de donnée) : 

```
php db/parseYML.php
```

Créer la base de donnée :

```
php db/sqlite.php
```

### Lancer le site web

```
php -S localhost:8000
```

### Fonctionnalité implémentés

- Affichage des albums
- Détail des albums
- Détail d'un artiste avec ses albums
- Recherche avancée dans les albums
- Inscription / Login utilisateur
- Playlist par utilisateur
- Système de notation des albums
- Lecture / Suppression d'un artiste
- Lecture / Creation / Suppression / Modification d'un album

### Diagramme des controllers : 

![image](/diagramme/classes/controller.png)

### Diagramme des forms : 

![image](/diagramme/classes/form.png)

### Diagramme des modèles : 

![image](/diagramme/classes/models.png)

### Diagramme des modèles DB : 

![image](/diagramme/classes/modelsDB.png)

### Diagramme vues : 

![image](/diagramme/classes/view.png)