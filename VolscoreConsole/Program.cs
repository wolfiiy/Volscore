using VolScore;

VolscoreDB vdb = new VolscoreDB();
List<IVolscoreDB.Team> teams = vdb.GetTeams();

foreach (IVolscoreDB.Team team in teams)
{
    Console.WriteLine(team.Name);
}

Console.ReadKey();