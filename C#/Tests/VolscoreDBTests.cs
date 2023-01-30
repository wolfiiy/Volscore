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
        public void GetTeamsTest()
        {
            VolscoreDB vdb = new VolscoreDB();
            List<IVolscoreDB.Team> teams = vdb.GetTeams();
            Assert.AreEqual(6, teams.Count);
        }

        [TestMethod]
        public void GetTeamTest()
        {
            VolscoreDB vdb = new VolscoreDB();
            IVolscoreDB.Team team = vdb.GetTeam(3);
            Assert.AreEqual("Froideville", team.Name);
        }

        [TestMethod]
        public void GetGameTest()
        {
            VolscoreDB vdb = new VolscoreDB();
            IVolscoreDB.Game game = vdb.GetGame(1);
            // check some fields
            Assert.AreEqual("Championnat", game.Type);
            Assert.AreEqual("U17", game.League);
            Assert.AreEqual("Froideville", game.ReceivingTeamName);
        }

        [TestMethod]
        public void GetCaptainTest()
        {
            VolscoreDB vdb = new VolscoreDB();
            IVolscoreDB.Member cap = vdb.GetCaptain(vdb.GetTeam(3)); // Froideville
            Assert.AreEqual("Stewart", cap.LastName);
        }

        [TestMethod]
        public void GetLiberoTest()
        {
            VolscoreDB vdb = new VolscoreDB();
            IVolscoreDB.Member lib = vdb.GetLibero(vdb.GetTeam(2)); // Froideville
            Assert.AreEqual("Eaton", lib.LastName);
        }

        [TestMethod]
        public void GetGamesTests()
        {
            VolscoreDB vdb = new VolscoreDB();
            List<IVolscoreDB.Game> games = vdb.GetGames();
            Assert.AreEqual(3, games.Count);
            Assert.AreEqual("U17", games[0].League);
            Assert.AreEqual("Yverdon", games[1].Place);
            Assert.AreEqual("LUC", games[2].ReceivingTeamName);
        }
    }
}