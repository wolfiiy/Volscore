// Filename:  HttpServer.cs        
// Author:    Benjamin N. Summerton <define-private-public>
//            Adapted to the specific topic of Volleyball score keeper by X. Carrel
// License:   Unlicense (http://unlicense.org/)

using System;
using System.IO;
using System.Text;
using System.Net;
using System.Threading.Tasks;
using static VolScore.IVolscoreDB;
using MySqlX.XDevAPI.Relational;
using static System.Formats.Asn1.AsnWriter;
using static System.Net.Mime.MediaTypeNames;
using System.Drawing;
using System.Net.NetworkInformation;
using System.Runtime.InteropServices;
using System.Diagnostics;

namespace VolScore
{
    class HttpServer
    {
        public static HttpListener listener;
        public static string url = "http://localhost:8000/";
        public static int pageViews = 0;
        public static int requestCount = 0;
        public static string pageData;
        private static VolscoreDB volscoreDB = new VolscoreDB();

        private static void LoadGame(int gameNb)
        {
            if (gameNb> 0) // a specific game has been requested
            {
                Game? game = volscoreDB.GetGame(gameNb);
                if (game != null)
                {
                    pageData =
                        "<!DOCTYPE>" +
                        "<html>";
                    AddHeader();
                    AddBody(game);
                    pageData +=
                        "</html>";
                }
                else
                {
                    pageData =
                        "<head>" +
                        "   <title>VolScore</title>" +
                        "</head>"+
                        "<body>" +
                        "  <h1>Ce match n'existe pas</h1>" +
                        "</body>";
                }
            }
            else
            {
                // override content with example html
                // TEMPORARY
                string[] readText = File.ReadAllLines("../../../Resources/FdM.html");
                pageData = "";
                foreach (string s in readText) pageData += s;
            }
        }

        private static void AddHeader()
        {
            string[] readText = File.ReadAllLines("../../../Resources/header.html");
            pageData = "";
            foreach (string s in readText) pageData += s;
        }

        private static void AddBody(Game? game)
        {
            Game theGame = (Game)game;
            pageData += $"<body>";
            AddGame(theGame);
            pageData += $"</body>";
        }

        private static void AddGame(Game game)
        {
            pageData += $"<h2> Match {game.Number}</h2>                         ";
            pageData += $"<table>                                                 ";
            pageData += $"    <tr>                                                ";
            pageData += $"        <th> De </th>                                 ";
            pageData += $"        <td colspan = '2'> {game.Type} </td>          ";
            pageData += $"    </tr>                                               ";
            pageData += $"    <tr>                                                ";
            pageData += $"        <th> Niveau </th>                             ";
            pageData += $"        <td colspan = '2'> {game.Level} </td>         ";
            pageData += $"    </tr>                                               ";
            pageData += $"    <tr>                                                ";
            pageData += $"        <th> Catégorie </th>                          ";
            pageData += $"        <td colspan = '2'> {game.Category} </td>      ";
            pageData += $"    </tr>                                               ";
            pageData += $"    <tr>                                                ";
            pageData += $"        <th> Ligue </th>                              ";
            pageData += $"        <td colspan = '2'> {game.League} </td>        ";
            pageData += $"    </tr>                                               ";
            pageData += $"    <tr>                                                ";
            pageData += $"        <th> Entre </th>                              ";
            pageData += $"        <td> {game.ReceivingTeamName} </td>               ";
            pageData += $"        <td> {game.VisitingTeamName} </td>                ";
            pageData += $"    </tr>                                               ";
            pageData += $"    <tr>                                                ";
            pageData += $"        <th> Lieu </th>                               ";
            pageData += $"        <td colspan = '2'> {game.Place} </td>         ";
            pageData += $"    </tr>                                               ";
            pageData += $"    <tr>                                                ";
            pageData += $"        <th> Salle </th>                              ";
            pageData += $"        <td colspan = '2'> {game.Venue} </td>         ";
            pageData += $"    </tr>                                               ";
            pageData += $"    <tr>                                                ";
            pageData += $"        <th> Date </th>                               ";
            pageData += $"        <td colspan = '2'> {game.Moment} </td>        ";
            pageData += $"    </tr>                                               ";
            pageData += $"    <tr>                                                ";
            pageData += $"        <th> Heure </th>                              ";
            pageData += $"        <td colspan = '2'> {game.Moment} </td>        ";
            pageData += $"    </tr>                                               ";
            pageData += $"</table>                                                ";

        }

        public static async Task HandleIncomingConnections()
        {
            bool runServer = true;
            int requestedGame = 0;

            // While a user hasn't visited the `shutdown` url, keep on handling requests
            while (runServer)
            {
                // Will wait here until we hear from a connection
                HttpListenerContext ctx = await listener.GetContextAsync();

                // Peel out the requests and response objects
                HttpListenerRequest req = ctx.Request;
                // do nothing if `favicon.ico` is requested
                if (req.Url.AbsolutePath != "/favicon.ico")
                {
                    HttpListenerResponse resp = ctx.Response;

                    // Print out some info about the request
                    Console.WriteLine("Request #: {0}", ++requestCount);
                    Console.WriteLine(req.Url.ToString());
                    Console.WriteLine(req.HttpMethod);
                    Console.WriteLine(req.UserHostName);
                    Console.WriteLine(req.UserAgent);
                    Console.WriteLine();

                    // Get game Number from querystring
                    try
                    {
                        requestedGame = int.Parse(req.QueryString.Get("game"));
                    }
                    catch (Exception e)
                    {
                        requestedGame = 0;
                    }

                    // If `shutdown` url requested w/ POST, then shutdown the server after serving the page
                    if ((req.HttpMethod == "POST") && (req.Url.AbsolutePath == "/shutdown"))
                    {
                        Console.WriteLine("Shutdown requested");
                        runServer = false;
                    }

                    // Write the response info
                    LoadGame(requestedGame);
                    string disableSubmit = !runServer ? "disabled" : "";
                    byte[] data = Encoding.UTF8.GetBytes(pageData);
                    resp.ContentType = "text/html";
                    resp.ContentEncoding = Encoding.UTF8;
                    resp.ContentLength64 = data.LongLength;
                    // Write out to the response stream (asynchronously), then close it
                    await resp.OutputStream.WriteAsync(data, 0, data.Length);
                    resp.Close();
                }

            }
        }


        public static void Main(string[] args)
        {
            // Create a Http server and start listening for incoming connections
            listener = new HttpListener();
            listener.Prefixes.Add(url);
            listener.Start();
            Console.WriteLine("Listening for connections on {0}", url);

            // Handle requests
            Task listenTask = HandleIncomingConnections();
            listenTask.GetAwaiter().GetResult();

            // Close the listener
            listener.Close();
        }
    }
}