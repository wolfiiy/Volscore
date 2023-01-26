using VolScore;

namespace VolScore
{
    /// <summary>
    /// Cette suite de tests est basée sur la DB telle que créée par le script VolScore.sql
    /// </summary>
    [TestClass]
    public class VolscoreDBTests
    {
        [TestMethod]
        public void GetTeamsTests()
        {
            VolscoreDB vdb = new VolscoreDB();
            List<IVolscoreDB.Team> teams = vdb.GetTeams();
            Assert.AreEqual(4, teams.Count);
        }
    }
}