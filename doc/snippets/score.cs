// vdb est la variable qui donne accès à la base de donnée

Game game = vdb.GetGame(1); // on récupère le match #1

while (!vdb.GameIsOver(game))
{
    Set newset = vdb.AddSet(game);
    while (!vdb.SetIsOver(newset))
    {
        if (random.Next(2) == 0)
        {
            vdb.AddPoint(newset, true);
        } else
        {
            vdb.AddPoint(newset, false);
        }
    }
}
