using MySql.Data.MySqlClient;
using System.Diagnostics;
using VolScore;

namespace VolScore
{
    /// <summary>
    /// Cette suite de tests est basée sur la DB telle que créée par le script VolScore.sql
    /// </summary>
    [TestClass]
    public class VolscoreDBTests
    {
        static VolscoreDB vdb;

        [ClassInitialize]
        public static void ClassInitialize(TestContext testContext)
        {
            vdb = new VolscoreDB();
            string script = File.ReadAllText(@"..\..\..\..\..\database\volscore.sql");
            MySqlCommand cmd = new MySqlCommand(script,vdb.Connection);
            cmd.ExecuteNonQuery();
        }

        [TestMethod]
        public void GetTeamsTest()
        {
            List<IVolscoreDB.Team> teams = vdb.GetTeams();
            Assert.AreEqual(6, teams.Count);
        }

        [TestMethod]
        public void GetTeamTest()
        {
            IVolscoreDB.Team team = vdb.GetTeam(3);
            Assert.AreEqual("Froideville", team.Name);
        }

        [TestMethod]
        public void GetGameTest()
        {
            IVolscoreDB.Game game = vdb.GetGame(1);
            // check some fields
            Assert.AreEqual("Championnat", game.Type);
            Assert.AreEqual("U17", game.League);
            Assert.AreEqual("Froideville", game.ReceivingTeamName);
        }

        [TestMethod]
        public void GetCaptainTest()
        {
            IVolscoreDB.Member cap = vdb.GetCaptain(vdb.GetTeam(3)); // Froideville
            Assert.AreEqual("Stewart", cap.LastName);
        }

        [TestMethod]
        public void GetLiberoTest()
        {
            IVolscoreDB.Member lib = vdb.GetLibero(vdb.GetTeam(2)); // Froideville
            Assert.AreEqual("Eaton", lib.LastName);
        }

        [TestMethod]
        public void GetGamesTests()
        {
            List<IVolscoreDB.Game> games = vdb.GetGames();
            Assert.AreEqual(3, games.Count);
            Assert.AreEqual("U17", games[0].League);
            Assert.AreEqual("Dorigny", games[1].Place);
            Assert.AreEqual("Yverdon", games[2].ReceivingTeamName);
        }
    }
}