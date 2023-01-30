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

namespace VolScore
{
    public class VolscoreDB : IVolscoreDB
    {
        private MySqlConnection _connection;

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
            _connection = new MySqlConnection(connectStr);
        }

        #region DB interactions
        /// <summary>
        /// Pour ouvrir l'accès à la base de données
        /// </summary>
        private bool OpenConnection()
        {
            try
            {
                _connection.Open();
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
                _connection.Close();
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
                MySqlCommand cmd = new MySqlCommand(query, _connection);
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
                MySqlCommand cmd = new MySqlCommand(query, _connection);

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
                MySqlCommand cmd = new MySqlCommand(query, _connection);

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
                cmd.Connection = _connection;

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
                MySqlCommand cmd = new MySqlCommand(query, _connection);
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

            MySqlCommand cmd = new MySqlCommand(query, _connection);
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
            MySqlCommand cmd = new MySqlCommand(query, _connection);
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
            MySqlCommand cmd = new MySqlCommand(query, _connection);
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
            MySqlCommand cmd = new MySqlCommand(query, _connection);
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
            MySqlCommand cmd = new MySqlCommand(query, _connection);
            MySqlDataReader reader = cmd.ExecuteReader();
            reader.Read();
            Member res = new Member(reader.GetInt32(0), reader.GetString(1), reader.GetString(2), reader.GetString(3), reader.GetInt32(4), reader.GetInt32(5), reader.IsDBNull(6) ? false : reader.GetBoolean(6));
            reader.Close();
            return res;
        }

        public Member GetLibero(Team team)
        {
            string query = $"SELECT id, `first_name`, `last_name`, `role`, `license`, `number`, `libero` FROM members WHERE team_id = {team.Id} AND libero=1;";
            MySqlCommand cmd = new MySqlCommand(query, _connection);
            MySqlDataReader reader = cmd.ExecuteReader();
            reader.Read();
            Member res = new Member(reader.GetInt32(0), reader.GetString(1), reader.GetString(2), reader.GetString(3), reader.GetInt32(4), reader.GetInt32(5), reader.IsDBNull(6) ? false : reader.GetBoolean(6));
            reader.Close();
            return res;
        }

        public int CreateGame(Game game)
        {
            throw new NotImplementedException();
        }

        public int AddSet(Game game)
        {
            throw new NotImplementedException();
        }

        public int NumberOfSets(Game game)
        {
            throw new NotImplementedException();
        }

        public Set GetSet(Game game, int setNb)
        {
            throw new NotImplementedException();
        }

        public bool DefinePlayersPositions(Game game, int setNb, int teamNb, int playerP1, int playerP2, int playerP3, int playerP4, int playerP5, int playerP6)
        {
            throw new NotImplementedException();
        }

        public List<Game> GetGames()
        {
            List<Game> games = new List<Game>();
            string query =
                $"SELECT games.id, type, level,category,league,receiving_id,r.name as receiving,visiting_id,v.name as visiting,location,venue,moment " +
                $"FROM games INNER JOIN teams r ON games.receiving_id = r.id INNER JOIN teams v ON games.visiting_id = v.id ";
            MySqlCommand cmd = new MySqlCommand(query, _connection);
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

                games.Add(newgame);
            }
            reader.Close();
            return games;
        }

        #endregion
    }
}
