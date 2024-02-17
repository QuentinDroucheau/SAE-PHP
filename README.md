# SAE-PHP

### Configuration php.ini
Assurez de décommentez les lignes suivantes : 
extension=mbstring
extension=pdo_sqlite

### Mise en place de la base de donnée 

Créer la base de donnée :

```
php bd/sqlite.php
```

### Lancer le site web

Commande pour lancer le site web

```
php -S localhost:8000
```