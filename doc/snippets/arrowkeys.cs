ConsoleKey cki;
do
{
    cki = Console.ReadKey().Key;
    switch (cki)
    {
        case ConsoleKey.DownArrow:
            Console.WriteLine("bas");
            break;
        case ConsoleKey.UpArrow:
            Console.WriteLine("haut");
            break;
        case ConsoleKey.LeftArrow:
            Console.WriteLine("gauche");
            break;
        case ConsoleKey.RightArrow:
            Console.WriteLine("droite");
            break;
    }
} while (cki != ConsoleKey.Escape);