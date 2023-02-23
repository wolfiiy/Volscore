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

            moment = DateTime.Now.AddDays(10);
            vdb.CreateGame(new IVolscoreDB.Game(1,"Coupe","Régional-Valais","F","F3",random.Next(1,7),"",random.Next(1,7),"","Fully","Grande Halle", moment));

            // Add scores to games in the past
            // Start with listing past games
            List<Game> pastgames = new List<Game>();
            query =
                $"SELECT games.id, type, level,category,league,receiving_id,r.name as receiving,visiting_id,v.name as visiting,location,venue,moment " +
                $"FROM games INNER JOIN teams r ON games.receiving_id = r.id INNER JOIN teams v ON games.visiting_id = v.id " +
                $"WHERE moment < '{today.ToString("yyyy-MM-dd")}' ";
            cmd = new MySqlCommand(query, vdb.Connection);
            MySqlDataReader reader = cmd.ExecuteReader();
            while (reader.Read())
            {
                Game newgame = new Game(
                                reader.GetInt32(0),  // Number
                                reader.GetString(1), // Type
                                reader.GetString(2), // Level
                                reader.GetString(3), // category
                                reader.GetString(4), // league
                                reader.GetInt32(5),  // receiving_id
                                reader.GetString(6), // receiving name
                                reader.GetInt32(7),  // visiting id
                                reader.GetString(8), // visiting name
                                reader.GetString(9), // Location
                                reader.GetString(10), // Venue
                                reader.GetDateTime(11));

                pastgames.Add(newgame);
            }
            reader.Close();

            // Add scores to each past game
            foreach (Game game in pastgames)
            {
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
            }


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
            Assert.AreEqual(7, games.Count);
            Assert.AreEqual("U17", games[0].League);
            Assert.AreEqual("Dorigny", games[1].Place);
            Assert.AreEqual("Yverdon", games[2].ReceivingTeamName);
        }

        [TestMethod]
        public void GetGamesByTimeTests()
        {
            Assert.AreEqual(3, vdb.GetGamesByTime(IVolscoreDB.TimeInThe.Past).Count);
            Assert.AreEqual(1, vdb.GetGamesByTime(IVolscoreDB.TimeInThe.Present).Count);
            int futureGames = vdb.GetGamesByTime(IVolscoreDB.TimeInThe.Future).Count;
            if (futureGames < 2 || futureGames > 4) Assert.Fail(); // must do this in case you run the test at 11PM !!
        }
    }
}