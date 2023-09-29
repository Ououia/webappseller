# Webappseller

## Installation du projet

### Étape 1: Clonage du dépôt

Clonez le dépôt sur votre machine locale:

```https://github.com/Ououia/webappseller.git```

### Étape 2: Configuration du fichier local

Rendez-vous dans le dossier config:

copier le fichier local-exemple.php dans le dossier config et renommez la copie en  **local.php**

### Etape 3 : Crée votre base de donnée 

Dans le dossier public il y a un dossier export_db , dans ce dossier il y a le script de création de la base de donnée 

### Étape 4: Configuration de la base de données

Le fichier local-exemple.php sert de template, veuillez entrer les informations de connexion à votre base de données

ex : 

```<?php

$localConfig = [
    "database" => [
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname' => 'webappseller,
        'charset' => 'utf8',
    ],
    "baseUri" => ""
];
```

### Étape 5: Lancement du projet

Démarrer votre serveur apache 

```sudo service apache2 start```

### Etape 5 : Jouer au jeu 

Le lancement du jeu devrait initialiser toutes les données necessaire pour jouer


