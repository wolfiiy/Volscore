# Volscore
 
 Volscore est une application C# qui permet de saisir le score d'un match de volleyball, mais surtout de re-créer la feuille de marquage à partir des données saisies, parce que c'est l'enfer de faire ça à la main, jugez-en par vous même [ici](doc/feuille%20de%20match%20officielle%20remplie.png) si vous en doutez...


## Mise en place de l'environnement de travail

### Base de données

### C#

- Installer [UWamp](https://www.uwamp.com/fr/?page=download) 3.1.0 ou plus si besoin et le démarrer
- Lancer PHPMyAdmin depuis le panneau de contrôle d'Uwamp (user root, mdp root)
- Aller sous l'onglet `Import`
- Choisir le fichier `Database>volscore.sql`
- Clicker `Go`
- La base de donnée `volscore` doit apparaître dans la barre latérale

- Ouvrir la solution VS `Volscore.sln` avec VS 2022
- Faire clic droit sur `Tests>VolscoreDBTest.cs`, choisir `Exécuter les tests`
- Si les tests sont verts, c'est tout bon !

Pour la documentation, ouvrez [ce fichier](doc/html/index.html) à partir de votre repo local

### PhP

- Installer [Chocolatey](https://chocolatey.org/) à partir d'un terminal Powershell
- Vérifier la réussite de l'opération en tapant `choco -v`
- Avec Chocolatey, installer l'interpréteur PhP : `choco install php`
- Activer l'extension mysql_pdo de php:
    - Editer le fichier `c:\tools\php8x\php.ini` (`c:\tools` est le dossier d'installation par défaut de choco)
    - Décommenter la ligne `;extension=pdo_mysql`, sauver, quitter
- Vérifier la réussite de l'opération en tapant `php -v`
- Avec Chocolatey, installer l'émulateur de shell bash Cmder : `choco install cmder`
- Vérifier la réussite de l'opération en ouvrant `c:\tools\Cmder\Cmder.exe` à partir d'un explorateur de fichier
- Installer MySQL 8.0.32 (ou plus) à partir [du site](https://dev.mysql.com/downloads/installer/). Attention à:
    - Choisir le 'Legacy authentication mode', c'est-à-dire l'authentification par username/mot de passe
    - Se rappeler du username/mot de passe
- Dans MySQL Workbench, se connecter au serveur local
- Ouvrir le script `Database>volscore.sql` et l'exécuter
- Dans le terminal Cmder, aller dans le dossier `PhP` du repo local
- Lancer un serveur php: `php -S localhost:8000`
- Dans un navigateur, aller à la page `http:\\localhost:8000`