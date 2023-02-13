
// Comment stocker et manipuler les informations (prénom, nom, année de naissance) concernant une personne en C# ?

// On va utiliser une structure, ce qui permet de rassembler des variables de types différents sous un seul nom 

Person joe; // Une variable qui se nomme joe est qui contient les informations relatives à une personne

joe.firstname = "Joe";
joe.lastname = "Dalton";
joe.birthyear = 1970;

int age = DateTime.Now.Year - joe.birthyear;

if (age >= 18)
{
    Console.WriteLine(joe.firstname + " " + joe.lastname + " est majeur");
}
else
{
    Console.WriteLine(joe.firstname + " " + joe.lastname + " est mineur");
}
Console.ReadKey();


// Définition de la structure Person
// C'est-à-dire quelles sont les informations que l'on veut retenir pour chaque personne
struct Person
{
    public string firstname;    // Prénom
    public string lastname;     // Nom de famille
    public int birthyear;       // Année de naissance
}