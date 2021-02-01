# OkyDoky

## Base de donnée

Pour connecter la base de donnée, il faut créer un fichier `secret.php` comme ceci : 

```php
<?php
class Secret {
    public const DB_HOST = 'localhost';
    public const DB_USER = '<USER>';
    public const DB_PASSWORD = '<PASSWORD>';
    public const DB_NAME = '<BDD>';
}
```
