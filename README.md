# OkyDoky

## Configuration

Pour connecter la base de donnée, il faut créer un fichier `config.php` avec pour modèle `config.example.php`.

Il faut également modifier le fichier `.htaccess` pour remplacer `/user/` par le vrai sous-répetoire de votre installation (ou remplacer par `/` si l'installation est à la racine).

## Working

- Upload de document (sur `/post`)
- Affichage des 10 derniers documents (10 pour limiter la quantité de données. Sur `/feed`)

## To fix

- Les URLs local sont en absolut en http par défaut, il faut réfléchir à plus intéligant en prenant en compte une installation en sous-répertoire
- le .htaccess n'est pas universel
- le fichiers de config est mélanger avec ces méthodes. Utiliser héritage

