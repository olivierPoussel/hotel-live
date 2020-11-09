# Développement full stack - Projet Royal Hôtel

## Initialisation du projet

Récupérer le projet
```
git clone https://github.com/olivierPoussel/hotel-live.git
```
Pré-requis :
* Avoir un Wamp, Xampp, Lamp, Mamp installé ;
* Composer ;
* Symfony cli.
### Windows
Se mettre à la racine du projet et saisir les commandes suivantes :
```powershell
composer install
```
### Linux
```bash
composer install
```

### Configuration
#### MySQL
Créer un user MySQL pour le projet :
```mysql
CREATE DATABASE IF NOT EXISTS `hotel` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
CREATE USER 'symfony'@'localhost' IDENTIFIED BY '1234';
GRANT ALL PRIVILEGES ON hotel.* TO 'symfony'@'localhost';
FLUSH PRIVILEGES;
```
#### Apache
doc : https://symfony.com/doc/current/setup/web_server_configuration.html

Vhost Windows :
```apache
<VirtualHost *:80>
    ServerName hotel-ynov.com
    ServerAlias www.hotel-ynov.com
	DocumentRoot "<pathToProjet>/public"
    DirectoryIndex /index.php

	<Directory  "<pathToProjet>/public">
        Require all granted
        AllowOverride None
        Order Allow,Deny
        Allow from All

        FallbackResource /index.php
	</Directory>
	<Directory "<pathToProjet>/public/bundles">
        FallbackResource disabled
    </Directory>
</VirtualHost>
```

Vhost Linux :
```apache
<VirtualHost *:80>
        ServerName hotel-ynov.com
        ServerAlias www.hotel-ynov.com
        DocumentRoot <pathToProjet>/public
        DirectoryIndex /index.php

        <Directory  <pathToProjet>/public>
                Require all granted
                AllowOverride None
                Order Allow,Deny
                Allow from All
                # mettre ce module si le mode rewrite d'Apache pose problème.
                <IfModule mod_rewrite.c>
                    Options -MultiViews
                    RewriteEngine On
                    RewriteCond %{REQUEST_FILENAME} !-f
                    RewriteRule ^(.*)$ app_dev.php [QSA,L]
                </IfModule>

                FallbackResource /index.php
        </Directory>
        <Directory <pathToProjet>/public/bundles>
            <IfModule mod_rewrite.c>
                RewriteEngine Off
            </IfModule>
            FallbackResource disabled
        </Directory>
        ErrorLog /var/log/apache2/project_error.log
        CustomLog /var/log/apache2/project_access.log combined
</VirtualHost>
```

#### Symfony :
```bash
# .env ou .env.local
DATABASE_URL=mysql://symfony:1234@127.0.0.1:3308/hotel?serverVersion=8.0.18&serverTimezone=Europe/Paris # mettre votre user mysql ainsi que le bon port et la bonne version de votre sgbdr
```
Fichier hosts :

Ouvrir le fichier avec un éditeur de fichier avec les droits d'admintrateur.

Windows :
```bash
# C:\Windows\System32\drivers\etc\hosts
127.0.0.1	hotel-ynov.com www.hotel-ynov.com
::1	hotel-ynov.com www.hotel-ynov.com
```
Linux :
```bash
# /etc/hosts
127.0.0.1	hotel-ynov.com www.hotel-ynov.com
```