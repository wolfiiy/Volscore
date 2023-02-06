// WriteNumber function: Writes a number in ASCII art at a given location
// Author : X. Carrel
// Feb 2023

// Writes the number in the console with upper left corner at position (posx,posy)
// Warning: no checks performed as far as screen overflow is concerned
void WriteNumber(int number, int posx, int posy)
{
    // Thank you: https://patorjk.com/software/taag/
    string[,] numbers = new string[10, 7] {
        {
            " ██████╗ ",
            "██╔═████╗",
            "██║██╔██║",
            "████╔╝██║",
            "╚██████╔╝",
            " ╚═════╝ ",
            "         ",
        },
        {
            "   ██╗   ",
            "  ███║   ",
            "  ╚██║   ",
            "   ██║   ",
            "   ██║   ",
            "   ╚═╝   ",
            "         ",
        },
        {
            "██████╗  ",
            "╚════██╗ ",
            " █████╔╝ ",
            "██╔═══╝  ",
            "███████╗ ",
            "╚══════╝ ",
            "         ",
        },
        {
            "██████╗  ",
            "╚════██╗ ",
            " █████╔╝ ",
            " ╚═══██╗ ",
            "██████╔╝ ",
            "╚═════╝  ",
            "         ",
        },
        {
            "██╗  ██╗ ",
            "██║  ██║ ",
            "███████║ ",
            "╚════██║ ",
            "     ██║ ",
            "     ╚═╝ ",
            "         ",
        },
        {
            "███████╗ ",
            "██╔════╝ ",
            "███████╗ ",
            "╚════██║ ",
            "███████║ ",
            "╚══════╝ ",
            "         ",
        },
        {
            " ██████╗ ",
            "██╔════╝ ",
            "███████╗ ",
            "██╔═══██╗",
            "╚██████╔╝",
            " ╚═════╝ ",
            "         ",
        },
        {
            "███████╗ ",
            "╚════██║ ",
            "    ██╔╝ ",
            "   ██╔╝  ",
            "   ██║   ",
            "   ╚═╝   ",
            "         ",
        },
        {
            " █████╗  ",
            "██╔══██╗ ",
            "╚█████╔╝ ",
            "██╔══██╗ ",
            "╚█████╔╝ ",
            " ╚════╝  ",
            "         ",
        },
        {
            " █████╗  ",
            "██╔══██╗ ",
            "╚██████║ ",
            " ╚═══██║ ",
            " █████╔╝ ",
            " ╚════╝  ",
            "         ",
        }
    };

    int nbDigits = number == 0 ? 0 : (int)Math.Log10(number); // number of digits in the number to display
    for (int digit = nbDigits; digit >= 0; digit--)         // Loop on all digits of the number, left to right
    {
        int d = (number / (int)Math.Pow(10, digit)) % 10;   // extract the Nth number
        int px = posx + 10 * (nbDigits - digit);            // compute screen position with respect to requested pos
        // Write the digit
        for (int i = 0; i < 7; i++)
        {
            Console.SetCursorPosition(px, posy+i);
            Console.Write(numbers[d,i]);
        }
    }
}
