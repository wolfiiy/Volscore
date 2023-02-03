using MySql.Data.MySqlClient;
using System.Diagnostics;
using VolScore;
using static VolScore.IVolscoreDB;

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
            Random random = new Random();

            vdb = new VolscoreDB();

            // Reset the database
            string script = File.ReadAllText(@"..\..\..\..\..\database\volscore.sql");
            MySqlCommand cmd = new MySqlCommand(script,vdb.Connection);
            cmd.ExecuteNonQuery();

            // Add some games around current date

            // Today
            DateTime today = DateTime.Now;
            DateTime moment = new DateTime(today.Year, today.Month, today.Day, 20, 0, 0);

            string query =
                $"INSERT INTO games (type,level,category,league,location,venue,moment,receiving_id,visiting_id) " +
                $"VALUES('Coupe', 'Régional-Vaud', 'F', 'F2', 'Froideville', 'Complexe sportif', '{moment.ToString("yyyy-MM-dd HH:mm")}', {random.Next(1, 7)}, {random.Next(1, 7)});";
            cmd = new MySqlCommand(query, vdb.Connection);
            cmd.ExecuteNonQuery();

            // Future games
            DateTime tomorrow = DateTime.Now.AddDays(1);
            moment = new DateTime(tomorrow.Year, tomorrow.Month,tomorrow.Day,20,0,0);
            query =
                $"INSERT INTO games (type,level,category,league,location,venue,moment,receiving_id,visiting_id) " +
                $"VALUES('Coupe', 'Régional-Vaud', 'F', 'F2', 'Lausanne', 'Vennes', '{moment.ToString("yyyy-MM-dd HH:mm")}', {random.Next(1, 7)}, {random.Next(1, 7)});";
            cmd = new MySqlCommand(query, vdb.Connection);
            cmd.ExecuteNonQuery();
            moment = moment.AddDays(1);
            query =
                $"INSERT INTO games (type,level,category,league,location,venue,moment,receiving_id,visiting_id) " +
                $"VALUES('Coupe', 'Régional-Vaud', 'F', 'F2', 'Lutry', 'Les Pales', '{moment.ToString("yyyy-MM-dd HH:mm")}', {random.Next(1, 7)}, {random.Next(1, 7)});";
            cmd = new MySqlCommand(query, vdb.Connection);
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
            Assert.AreEqual(6, games.Count);
            Assert.AreEqual("U17", games[0].League);
            Assert.AreEqual("Yverdon", games[1].Place);
            Assert.AreEqual("LUC", games[2].ReceivingTeamName);
        }
    }
}