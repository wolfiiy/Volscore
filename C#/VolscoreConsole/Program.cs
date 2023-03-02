using VolScore;

VolscoreDB vdb = new VolscoreDB();

Console.WriteLine("Equipes:" + Environment.NewLine + "========" + Environment.NewLine);

List<IVolscoreDB.Team> teams = vdb.GetTeams();

foreach (IVolscoreDB.Team team in teams)
{
    Console.WriteLine(team.Name);
    List<IVolscoreDB.Member> players = vdb.GetPlayers(team);
    foreach (IVolscoreDB.Member member in players)
    {
        Console.WriteLine($"    {member.Number} {member.FirstName} {member.LastName}");
    }
}

// Afficher les matches

Console.WriteLine();
Console.WriteLine("Matchs:"+Environment.NewLine+"======="+Environment.NewLine);

List<IVolscoreDB.Game> games = vdb.GetGames();
foreach (IVolscoreDB.Game game in games)
{
    Console.WriteLine($"Match {game.Number}: {game.ReceivingTeamName} vs {game.VisitingTeamName}, {game.Moment.ToString("d MMMM yyyy à HH:mm")}");
    Console.WriteLine($"  Score: {game.ScoreReceiving}-{game.ScoreVisiting}");
    foreach (IVolscoreDB.Set set in vdb.GetSets(game))
    {
        Console.WriteLine($"   {set.ScoreReceiving} - {set.ScoreVisiting}");
    }
}

Console.ReadKey();