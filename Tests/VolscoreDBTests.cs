using Volscore;

namespace VolScore
{
    [TestClass]
    public class VolscoreDBTests
    {
        [TestMethod]
        public void GetTeamsTests()
        {
            VolscoreDB vdb = new VolscoreDB();
            List<IVolscoreDB.Team> teams = vdb.GetTeams();
            Assert.AreEqual(6, teams.Count);
        }
    }
}