using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Volscore
{
    public interface IVolscoreDB
    {
        struct Game
        {
            public int number;
            public string type;
            public string level;
            public string category;
            public string league;
            public string receivingTeam;
            public string visitingTeam;
            public string place;
            public string venue;
            public DateTime moment;

            public Game(int number, string type, string level, string category, string league, string receivingTeam, string visitingTeam, string place, string venue, DateTime moment)
            {
                this.number = number;
                this.type = type;
                this.level = level;
                this.category = category;
                this.league = league;
                this.receivingTeam = receivingTeam;
                this.visitingTeam = visitingTeam;
                this.place = place;
                this.venue = venue;
                this.moment = moment;
            }
        }

        public Game? GetGame(int number);

    }
}
