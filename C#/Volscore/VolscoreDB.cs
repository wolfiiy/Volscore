/*
 * XCL
 * ETML
 * Novembre/Décembre 2020
 * class dbHandler pour gérer les accès et la lecture/écriture des données de cette application. 
 */

using System.Diagnostics;
using MySql.Data.MySqlClient;
using System.Collections.Generic;
using VolScore;
using static VolScore.IVolscoreDB;
using Org.BouncyCastle.Utilities;
using System.Collections;
using System.Reflection.PortableExecutable;

namespace VolScore
{
    public class VolscoreDB : IVolscoreDB
    {
        public MySqlConnection Connection;

        /// <summary>
        /// Constructeur par defaut
        /// </summary>
        public VolscoreDB()
        {
            Init();
            OpenConnection();
        }


        /// <summary>
        /// Initialise la connexion à la base de données voulue (nom, adresse, crédentiels)
        /// </summary>
        private void Init()
        {
            string srv_addr = "localhost";
            string dbname = "volscore";
            string uid = "root";
            string pass = "root";
            string connectStr;
            connectStr = "SERVER=" + srv_addr + ";" + "DATABASE=" + dbname + ";" + "UID=" + uid + ";" + "PASSWORD=" + pass + ";";
            Connection = new MySqlConnection(connectStr);
        }

        #region DB interactions
        /// <summary>
        /// Pour ouvrir l'accès à la base de données
        /// </summary>
        private bool OpenConnection()
        {
            try
            {
                Connection.Open();
                Debug.WriteLine("DB connection is now open");
                return true;
            }
            catch (MySqlException ex)
            {
                switch (ex.Number)
                {
                    case 0:
                        Debug.WriteLine("Cannot connect to server.  Contact administrator");
                        break;

                    case 1045:
                        Debug.WriteLine("Invalid username/password, please try again");
                        break;
                }
                return false;
            }
        }


        /// <summary>
        /// Pour clore l'accès à la base de données
        /// </summary>        
        private bool CloseConnection()
        {
            try
            {
                Connection.Close();
                Debug.WriteLine("DB connection is now closed");
                return true;
            }
            catch (MySqlException ex)
            {
                Debug.WriteLine(ex.Message);
                return false;
            }
        }


        /// <summary>
        /// Pour obtenir le contenu de la table t_value de la DB
        /// </summary>
        /// <returns></returns>
        public List<string>[] SelectAllUsers()
        {
            string query = "SELECT * FROM t_users";

            // create a list to store the result
            List<string>[] list = new List<string>[3];
            list[0] = new List<string>();
            list[1] = new List<string>();
            list[2] = new List<string>();

            // open connection
            if (OpenConnection())
            {
                // create Command
                MySqlCommand cmd = new MySqlCommand(query, Connection);
                // create a data reader and Execute the command
                MySqlDataReader dataReader = cmd.ExecuteReader();

                // read the data and store them in the list
                while (dataReader.Read())
                {
                    list[0].Add(dataReader["id"] + "");
                    list[1].Add(dataReader["username"] + "");
                    list[2].Add(dataReader["password"] + "");
                }

                // close Data Reader
                dataReader.Close();

                // close Connection
                CloseConnection();
            }
            return list;
        }


        /// <summary>
        /// Select with one only answer, , just for example
        /// </summary>
        private int CountUsers()
        {
            string query = "SELECT Count(*) FROM t_users";
            int Count = -1;

            //Open Connection
            if (this.OpenConnection())
            {
                //Create Mysql Command
                MySqlCommand cmd = new MySqlCommand(query, Connection);

                //ExecuteScalar will return one value
                Count = int.Parse(cmd.ExecuteScalar() + "");

                //close Connection
                this.CloseConnection();

                return Count;
            }
            else
            {
                return Count;
            }
        }

        /// <summary>
        /// Insert statement, just for example
        /// </summary>
        private void InsertUser(string user, string pword)
        {
            string query = $"INSERT INTO t_users (username, password) VALUES ('{user}','{pword}')";

            //open connection
            if (this.OpenConnection())
            {
                //create command and assign the query and connection from the constructor
                MySqlCommand cmd = new MySqlCommand(query, Connection);

                //Execute command
                cmd.ExecuteNonQuery();

                //close connection
                this.CloseConnection();
            }
        }


        /// <summary>
        /// Update statement, just for example
        /// </summary>
        private void Update(int id, string pword)
        {
            string query = $"UPDATE t_users SET pword='{pword}' WHERE id={id}";

            //Open connection
            if (this.OpenConnection())
            {
                //create mysql command
                MySqlCommand cmd = new MySqlCommand();
                //Assign the query using CommandText
                cmd.CommandText = query;
                //Assign the connection using Connection
                cmd.Connection = Connection;

                //Execute query
                cmd.ExecuteNonQuery();

                //close connection
                this.CloseConnection();
            }
        }


        /// <summary>
        /// Delete statement, just for example
        /// </summary>
        private void Delete(int id)
        {
            string query = $"DELETE FROM t_users WHERE id={id}";

            if (this.OpenConnection())
            {
                MySqlCommand cmd = new MySqlCommand(query, Connection);
                cmd.ExecuteNonQuery();
                this.CloseConnection();
            }
        }
        #endregion

        #region Interface implementation
        public Game GetGame(int number)
        {
            Game res;

            string query =
                $"SELECT games.id, type, level,category,league,receiving_id,r.name as receiving,visiting_id,v.name as visiting,location,venue,moment " +
                $"FROM games INNER JOIN teams r ON games.receiving_id = r.id INNER JOIN teams v ON games.visiting_id = v.id " +
                $"WHERE games.id={number}";

            MySqlCommand cmd = new MySqlCommand(query, Connection);
            MySqlDataReader reader = cmd.ExecuteReader();
            if (reader.Read())
            {
                res = new Game(
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
                reader.Close();
                // Update score
                foreach (Set set in GetSets(res))
                {
                    if (set.ScoreReceiving > set.ScoreVisiting)
                    {
                        res.ScoreReceiving++;
                    }
                    else
                    {
                        res.ScoreVisiting++;
                    }
                }
                return res;
            }
            else
            {
                reader.Close();
                throw new Exception($"Le match {number} n'existe pas");
            }
        }

        public List<Team> GetTeams()
        {
            List<Team> teams = new List<Team>();
            string query = $"SELECT id, `name` FROM teams;";
            MySqlCommand cmd = new MySqlCommand(query, Connection);
            MySqlDataReader reader = cmd.ExecuteReader();
            while (reader.Read())
            {
                teams.Add(new Team(reader.GetInt32(0), reader.GetString(1)));
            }
            reader.Close();
            return teams;
        }

        public Team GetTeam(int teamid)
        {
            string query = $"SELECT id, `name` FROM teams WHERE id = {teamid};";
            MySqlCommand cmd = new MySqlCommand(query, Connection);
            MySqlDataReader reader = cmd.ExecuteReader();
            reader.Read();
            Team res = new Team(reader.GetInt32(0), reader.GetString(1));
            reader.Close();
            return res;
        }

        public List<Member> GetPlayers(Team team)
        {
            List<Member> members = new List<Member>();
            string query = $"SELECT id, `first_name`, `last_name`, `role`, `license`, `number`, `libero` FROM members WHERE team_id = {team.Id};";
            MySqlCommand cmd = new MySqlCommand(query, Connection);
            MySqlDataReader reader = cmd.ExecuteReader();
            while (reader.Read())
            {
                members.Add(new Member(reader.GetInt32(0), reader.GetString(1), reader.GetString(2), reader.GetString(3), reader.GetInt32(4), reader.GetInt32(5), reader.IsDBNull(6) ? false : reader.GetBoolean(6)));
            }
            reader.Close();
            return members;
        }

        public Member GetCaptain(Team team)
        {
            string query = $"SELECT id, `first_name`, `last_name`, `role`, `license`, `number`, `libero` FROM members WHERE team_id = {team.Id} AND role='C';";
            MySqlCommand cmd = new MySqlCommand(query, Connection);
            MySqlDataReader reader = cmd.ExecuteReader();
            reader.Read();
            Member res = new Member(reader.GetInt32(0), reader.GetString(1), reader.GetString(2), reader.GetString(3), reader.GetInt32(4), reader.GetInt32(5), reader.IsDBNull(6) ? false : reader.GetBoolean(6));
            reader.Close();
            return res;
        }

        public Member GetLibero(Team team)
        {
            string query = $"SELECT id, `first_name`, `last_name`, `role`, `license`, `number`, `libero` FROM members WHERE team_id = {team.Id} AND libero=1;";
            MySqlCommand cmd = new MySqlCommand(query, Connection);
            MySqlDataReader reader = cmd.ExecuteReader();
            reader.Read();
            Member res = new Member(reader.GetInt32(0), reader.GetString(1), reader.GetString(2), reader.GetString(3), reader.GetInt32(4), reader.GetInt32(5), reader.IsDBNull(6) ? false : reader.GetBoolean(6));
            reader.Close();
            return res;
        }

        public Game CreateGame(Game game)
        {
            string query =
                $"INSERT INTO games (type,level,category,league,location,venue,moment,receiving_id,visiting_id) "+
                $"VALUES('{game.Type}', '{game.Level}', '{game.Category}', '{game.League}', '{game.Place}', '{game.Venue}', '{game.Moment.ToString("yyyy-MM-dd HH:mm")}', {game.ReceivingTeamId}, {game.VisitingTeamId});";

            MySqlCommand cmd = new MySqlCommand(query, Connection);
            cmd.ExecuteNonQuery();
            game.Number = (int)cmd.LastInsertedId; // the game number is the autogenerated id in the db table
            return game;
        }

        public bool UpdateGame(Game game)
        {
            string query =
                $"UPDATE games SET type = '{game.Type}',level = '{game.Level}',category = '{game.Category}',league = '{game.League}',location='{game.Place}',venue='{game.Venue}',moment='{game.Moment.ToString("yyyy-MM-dd HH:mm")}' " +
                $"WHERE id = {game.Number};";

            MySqlCommand cmd = new MySqlCommand(query, Connection);
            return (cmd.ExecuteNonQuery() == 1);
        }

        public void DeleteGame(int gameid)
        {
            string query = $"DELETE FROM games WHERE id = {gameid};";

            MySqlCommand cmd = new MySqlCommand(query, Connection);
            try
            {
                cmd.ExecuteNonQuery();
            } catch (Exception e)
            {
                throw new Exception("Delete game failed");
            }
        }

        public Set AddSet(Game game)
        {
            List<Set> sets = GetSets(game);
            if (sets.Count >= 5) throw new Exception("Too many sets");
            string query =
                $"INSERT INTO sets (number,game_id) " +
                $"VALUES({sets.Count+1},{game.Number});";

            MySqlCommand cmd = new MySqlCommand(query, Connection);
            cmd.ExecuteNonQuery();
            Set res = new Set(game.Number, sets.Count + 1);
            res.Id = (int)cmd.LastInsertedId;
            return res ;
        }

        public int NumberOfSets(Game game)
        {
            string query = $"select count(s.id) from games g inner join sets s on game_id = g.id where g.id = {game.Number};";
            MySqlCommand cmd = new MySqlCommand(query, Connection);
            MySqlDataReader reader = cmd.ExecuteReader();
            reader.Read();
            int res = reader.GetInt32(0);
            reader.Close();
            return res;
        }

        public Set GetSet(Game game, int setNb)
        {
            Set res = new Set();

            string query =
                $"SELECT sets.id, number, start, end, game_id, " +
                $"(SELECT COUNT(points_on_serve.id) FROM points_on_serve WHERE team_id = receiving_id and set_id = sets.id) as recscore, " +
                $"(SELECT COUNT(points_on_serve.id) FROM points_on_serve WHERE team_id = visiting_id and set_id = sets.id) as visscore " +
                $"FROM games INNER JOIN sets ON games.id = sets.game_id " +
                $"WHERE game_id = {game.Number} and sets.number = {setNb} ";
            MySqlCommand cmd = new MySqlCommand(query, Connection);
            MySqlDataReader reader = cmd.ExecuteReader();
            if (reader.Read())
            {
                res.Id = reader.GetInt32(0);
                res.Number = reader.GetInt32(1);  // Set number
                if (!reader.IsDBNull(2)) res.Start = reader.GetDateTime(2);
                if (!reader.IsDBNull(3)) res.End = reader.GetDateTime(3);
                res.Game = reader.GetInt32(4);  // Game Number
                if (!reader.IsDBNull(5)) res.ScoreReceiving = reader.GetInt32(5);
                if (!reader.IsDBNull(6)) res.ScoreVisiting = reader.GetInt32(6);
            }
            reader.Close();
            return (res);
        }

        public List<Set> GetSets(Game game)
        {
            List<Set> res = new List<Set>();
            for (int setnb = 1; setnb <= NumberOfSets(game); setnb++)
            {
                res.Add(GetSet(game, setnb));
            }
            return res;
        }

        public bool DefinePlayersPositions(Game game, int setNb, int teamNb, int playerP1, int playerP2, int playerP3, int playerP4, int playerP5, int playerP6)
        {
            throw new NotImplementedException();
        }

        public List<Game> GetGames()
        {
            List<Game> games = new List<Game>();
            List<int> gameids = new List<int>();

            string query =
                $"SELECT games.id " +
                $"FROM games "+
                $"ORDER BY moment, games.id";
            MySqlCommand cmd = new MySqlCommand(query, Connection);
            MySqlDataReader reader = cmd.ExecuteReader();
            while (reader.Read())
            {
                gameids.Add(reader.GetInt32(0));
            }
            reader.Close();
            foreach (int gameid in gameids)
            {
                games.Add(GetGame(gameid));
            }
            return games;
        }

        public List<Game> GetGamesByTime(TimeInThe period)
        {
            List<Game> games = new List<Game>();
            List<int> gameids = new List<int>();

            string query =
                $"SELECT games.id " +
                $"FROM games ";

            switch (period)
            {
                case TimeInThe.Past:
                    query += $"WHERE moment < now()";
                    break;
                case TimeInThe.Present:
                    query += $"WHERE DATE(moment) = DATE(now())";
                    break;
                case TimeInThe.Future:
                    query += $"WHERE moment > now()";
                    break;
            }
            query += $" ORDER BY moment, games.id";
            MySqlCommand cmd = new MySqlCommand(query, Connection);
            MySqlDataReader reader = cmd.ExecuteReader();
            while (reader.Read())
            {
                gameids.Add(reader.GetInt32(0));
            }
            reader.Close();
            foreach (int gameid in gameids)
            {
                games.Add(GetGame(gameid));
            }
            return games;
        }

        public bool GameIsOver(Game game)
        {
            List<Set> sets = GetSets(game);
            int recwin = 0;
            int viswin = 0;
            foreach (Set set in sets)
            {
                if (set.ScoreReceiving > set.ScoreVisiting) recwin++;
                if (set.ScoreReceiving < set.ScoreVisiting) viswin++;
            }
            return (recwin == 3 || viswin == 3);
            // TODO handle 5th set score at 15
        }

        public bool SetIsOver(Set set)
        {
            int score1 = 0;
            int score2 = 0;
            int limit = set.Number == 5 ? 15 : 25;

            // get both scores. We don't care about which team is which
            string query = 
                $"select count(id) as points, team_id " +
                $"from points_on_serve where set_id = {set.Id} group by team_id;";

            MySqlCommand cmd = new MySqlCommand(query, Connection);
            MySqlDataReader reader = cmd.ExecuteReader();

            if (reader.Read()) score1 = reader.GetInt32(0);
            if (reader.Read()) score2 = reader.GetInt32(0);
            reader.Close();

            // Assess
            if (score1 < limit && score2 < limit) return false; // no one has enough points
            if (Math.Abs(score2-score1) < 2) return false; // one team has enough points but a 1-point lead only
            return true; // if we get there, we have a winner
        }

        public void AddPoint(Set set, bool receiving)
        {
            Game game = GetGame(set.Game);
            string query =
                 $"INSERT INTO points_on_serve (team_id, set_id, position_of_server) " +
                 $"VALUES({(receiving ? game.ReceivingTeamId : game.VisitingTeamId)},{set.Id},1);";
            MySqlCommand cmd = new MySqlCommand(query, Connection);
            cmd.ExecuteNonQuery();

        }

        public void RemovePoint(Set set)
        {
            string query = $"DELETE FROM points_on_serve WHERE set_id = {set.Id} ORDER BY id DESC LIMIT 1;";
            MySqlCommand cmd = new MySqlCommand(query, Connection);
            cmd.ExecuteNonQuery();
        }

        #endregion
    }
}
