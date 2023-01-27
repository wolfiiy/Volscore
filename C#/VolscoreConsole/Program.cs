using VolScore;

VolscoreDB vdb = new VolscoreDB();
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

Console.ReadKey();