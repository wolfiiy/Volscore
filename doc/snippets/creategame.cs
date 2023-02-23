// Créer un match dans 10 jours entre l'équipe 1 et 2
moment = DateTime.Now.AddDays(10);
vdb.CreateGame(new IVolscoreDB.Game(1,"Coupe","Régional-Valais","F","F3",1,"",2,"","Fully","Grande Halle", moment));
