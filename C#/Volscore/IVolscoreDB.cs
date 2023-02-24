using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace VolScore
{
    public interface IVolscoreDB
    {
        #region Data Structures
        /// <summary>
        /// Structure de données qui contient toutes les informations utiles pour un match
        /// </summary>
        struct Game
        {
            public int Number;                  //!< Numéro officiel du match
            public string Type;                 //!< Type de compétition: Championnat, Coupe, Amical, ...
            public string Level;                //!< Niveau: National, Regional, International
            public string Category;             //!< Catégorie: Homme, Femme, Mixte
            public string League;               //!< Ligue: U19, M4, F2, ...
            public int ReceivingTeamId;         //!< Numéro de l'équipe recevante
            public string ReceivingTeamName;    //!< Nom de l'équipe recevante
            public int VisitingTeamId;          //!< Numéro de l'équipe visiteuse
            public string VisitingTeamName;     //!< Nom de l'équipe visiteuse
            public string Place;                //!< Lieu: Dorigny, Ecublens, Pailly
            public string Venue;                //!< Nom de la salle de sport
            public DateTime Moment;             //!< Date et heure du début du match

            public Game(int number, string type, string level, string category, string league, int receivingTeamId, string receivingTeamName, int visitingTeamId, string visitingTeamName, string place, string venue, DateTime moment)
            {
                Number = number;
                Type = type;
                Level = level;
                Category = category;
                League = league;
                ReceivingTeamId = receivingTeamId;
                ReceivingTeamName = receivingTeamName;
                VisitingTeamId = visitingTeamId;
                VisitingTeamName = visitingTeamName;
                Place = place;
                Venue = venue;
                Moment = moment;
            }
        }

        struct Team
        {
            public int Id;                      //!< Numéro de l'équipe
            public string Name;                 //!< Nom de l'équipe (club)

            public Team(int id, string name)
            {
                Id = id;
                Name = name;
            }
        }

        struct Member
        {
            public int Id;                      //!< Numéro de membre interne pour le système Volscore
            public string FirstName;            //!< Prénom
            public string LastName;             //!< Nom de famille
            public string Role;                 //!< Rôle dans l'équipe: J pour Joueur, C pour Capitaine
            public int License;                 //!< Numéro de license
            public int Number;                  //!< Numéro sur le maillot
            public bool Libero;                 //!< Joue au poste de libéro oui/non

            public Member(int id, string firstName, string lastName, string role, int license, int number, bool libero)
            {
                Id = id;
                FirstName = firstName;
                LastName = lastName;
                Role = role;
                License = license;
                Number = number;
                Libero = libero;
            }
        }

        struct Set
        {
            public int Id;                      //!< L'identifiant du set dans la base de données
            public int Game;                    //!< Le numéro du match auquel ce set appartient
            public int Number;                  //!< L'ordre du set, donc entre 1 et 5
            public DateTime Start;              //!< Le moment du début du set
            public DateTime End;                //!< Le moment de la fin du set
            public int ScoreReceiving;          //!< Le nombre de points marqués par l'équipe recevante
            public int ScoreVisiting;           //!< Le nombre de points marqués par l'équipe visiteuse

            public Set(int game, int number) : this()
            {
                Game = game;
                Number = number;
            }
        }

        enum TimeInThe { Past, Present, Future }

        #endregion
        #region Functions
        /// <summary>
        /// Retourne la liste de toutes les équipes enregistrées
        /// </summary>
        /// <returns></returns>
        public List<Team> GetTeams();

        /// <summary>
        /// Retourne une équipe spécifique
        /// </summary>
        /// <param name="team">Le numéro d'équipe</param>
        /// <returns></returns>
        /// 
        public Team GetTeam(int team);

        /// <summary>
        /// Retourne la liste des joueurs d'une équipe
        /// </summary>
        /// <param name="team"></param>
        /// <returns></returns>
        public List<Member> GetPlayers(Team team);


        /// <summary>
        /// Retourne le capitaine d'une équipe
        /// </summary>
        /// <param name="team"></param>
        /// <returns></returns>
        public Member GetCaptain(Team team);


        /// <summary>
        /// Retourne le libero d'une équipe
        /// </summary>
        /// <param name="team"></param>
        /// <returns></returns>
        public Member GetLibero(Team team);


        /// <summary>
        /// Retourne la liste de tous les matches enregistrés
        /// </summary>
        /// <returns>Une liste triée par date/heure, le match le plus ancien en premier</returns>
        public List<Game> GetGames();


        /// <summary>
        /// Retourne la liste des matches qui sont dans une période donnée
        /// Les matches du 'Present' sont les matches d'aujourd'hui, quelle que soit l'heure.
        /// Un match qui se passe ce soir à 20h00 sera donc selectionné à 16h00 par 'Present' et 'Future' 
        /// </summary>
        /// <param name="period">Une des valeurs 'Past', 'Present', 'Future'</param>
        /// <returns>Une liste triée par date/heure, le match le plus ancien en premier</returns>
        public List<Game> GetGamesByTime(TimeInThe period);


        /// <summary>
        /// Crée un nouveau match dans la base de données avec les données fournies
        /// </summary>
        /// <param name="game"></param>
        /// <returns>
        /// Le match s'il a pu être créé, sinon:
        /// 
        /// -1 si la première équipe n'existe pas
        /// -2 si la deuxième équipe n'existe pas
        /// 
        /// </returns>
        public Game CreateGame(Game game);


        /// <summary>
        /// Supprime un match dans la base de données 
        /// </summary>
        /// <param name="game"></param>
        /// <returns>
        /// </returns>
        public void DeleteGame(int gameid);


        /// <summary>
        /// Ajoute un set à un match
        /// </summary>
        /// <param name="game"></param>
        /// <returns>
        /// Le set qui a été créé
        /// Attention: l'appel à cette fonction causera un crash (exception) si on ajoute un 6è set
        /// </returns>
        public Set AddSet(Game game);


        /// <summary>
        /// Retourne le nombre de sets que le match possède, donc entre 0 et 5
        /// </summary>
        /// <param name="game"></param>
        /// <returns></returns>
        public int NumberOfSets(Game game);

        /// <summary>
        /// Ajoute un point à une des deux équipes du set
        /// </summary>
        /// <param name="set"></param>
        /// <param name="receiving">Ajoute le point à l'équipe recevante si TRUE, visiteuse sinon</param>
        public void AddPoint(Set set, bool receiving);

        /// <summary>
        /// Supprime le dernier point marqué dans le set, quelle que soit l'équipe
        /// </summary>
        /// <param name="set"></param>
        public void RemovePoint(Set set);

        /// <summary>
        /// Retourne une structure contenant les informations de description du match
        /// </summary>
        /// <param name="number"></param>
        /// <returns>
        /// Attention: l'appel à cette fonction causera un crash (exception) si le match n'existe pas !!!
        /// </returns>
        public Game GetGame(int number);

        /// <summary>
        /// Indique si un match est terminé ou pas
        /// </summary>
        /// <param name="number">Le numéro du match</param>
        /// <returns></returns>
        public bool GameIsOver(Game game);

        /// <summary>
        /// Retourne le set voulu du match voulu
        /// </summary>
        /// <param name="game"></param>
        /// <param name="setNb"></param>
        /// <returns>
        /// Une structure de type 'Set' avec les valeurs correspondantes
        /// 
        /// Attention: l'appel à cette fonction causera un crash (exception) si le set n'existe pas !!!
        /// </returns>
        public Set GetSet(Game game, int setNb);

        /// <summary>
        /// Indique si un set est terminé
        /// Prend en compte les cas particuliers:
        ///   - Deux points d'écart en fin de set
        ///   - 15 points au 5ème set
        /// </summary>
        /// <param name="set"></param>
        /// <returns></returns>
        public bool SetIsOver(Set set);

        /// <summary>
        /// Retourne les sets du match voulu
        /// </summary>
        /// <param name="game"></param>
        /// <returns>
        /// Une liste de structure de type 'Set'
        /// 
        /// </returns>
        public List<Set> GetSets(Game game);

        /// <summary>
        /// Définit les positions de départ des joueurs d'une équipe pour un set donné
        /// </summary>
        /// <param name="game">Le match</param>
        /// <param name="setNb">Le numéro du set (1-5)</param>
        /// <param name="teamNb">Le numéro de l'équipe (pas son nom)</param>
        /// <param name="playerPX">Le numéro (de maillot) du joueur en position X</param>
        /// <returns>
        /// 1 si tout est OK
        /// 
        /// -1 si le match n'existe pas
        /// -2 si le set n'existe pas
        /// -3 si l'équipe n'est pas dans ce match
        /// -1x si le joueur annoncé en position x ne peut pas y être placé 
        ///   (numéro de maillot inextistant, joueur déjà placé).
        ///   Exemple: le joueur en position 3 n'existe pas dans l'équipe => erreur -13
        /// </returns>
        public bool DefinePlayersPositions(Game game, int setNb, int teamNb, int playerP1, int playerP2, int playerP3, int playerP4, int playerP5, int playerP6);

        #endregion
    }
}
