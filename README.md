# Volscore
 
 Volscore est une application C# qui permet de saisir le score d'un match de volleyball, mais surtout de re-créer la feuille de marquage à partir des données saisies, parce que c'est l'enfer de faire ça à la main, jugez-en par vous même [ici](doc/feuille%20de%20match%20officielle%20remplie.png) si vous en doutez...


## Mise en place de l'environnement de travail

### Base de données

- Installer [UWamp](https://www.uwamp.com/fr/?page=download) 3.1.0 ou plus si besoin et le démarrer
- Lancer PHPMyAdmin depuis le panneau de contrôle d'Uwamp (user root, mdp root)
- Aller sous l'onglet `Import`
- Choisir le fichier `Volscore>Resources>volscore.sql`
- Clicker `Go`
- La base de donnée `volscore` doit apparaître dans la barre latérale

### C#

- Ouvrir la solution VS `Volscore.sln` avec VS 2022
- Faire clic droit sur `Tests>VolscoreDBTest.cs`, choisir `Exécuter les tests`
- Si les tests sont verts, c'est tout bon !

Pour la documentation, ouvrez [ce fichier](doc/html/index.html) à partir de votre repo local

### PhP

- Dans UWamp, arrêter le serevur Apache
- Cliquer 'Apache config'
- Sélectionner le serveur pour le port 80 (`main-serveur *:80` normalement)
- Mettre le chemin du dossier PhP du repo local dans `Document Root`
- Cliquer 'OK', le serveur redémarre automatiquement
- Cliquer 'Navigateur www', vous devriez voir les équipes et les matches