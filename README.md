# Stardate Class for PHP and ASP

A class for working with stardates from Star Trek. Entire articles have been written on the subject of how stardates supposedly work, and many have struggled to come up with a workable algorithm. The rules for how they're supposed to work are contradictory. One tenth of a stardate is supposed to represent a 24-hour period, but one whole stardate does not represent a 24-hour period, so the whole thing falls apart quite quickly. To make matters worse, the rate at which stardates advance is inconsistent from the TOS era to the movie era to the TNG and beyond era. Some of the newer movies and series used an entirely different system, while others attempted to remain faithful to the TNG-era system. A proprietary algorithm has been developed by Dr. Erin MacDonald, science advisor to the newer series, but this algorithm has not been published as of the time of this writing. Apparently she came up with a workable solution which is supposedly more accurate than anything else out there. I spent some time trying to come up with my own solution, but found that even within TNG there were inconsistencies. I could probably write my own article on the subject at this point, but that is for another place and time.

For the sake of my own sanity, I've put some limitations in place in my code. Stardates less than 10000 are treated as TOS-era dates, and stardates greater than 9999 are treated as TNG-era dates. This leaves gaps in the middle and on either side, but this was already an improvement over the first version of my code from 2009 and I needed to move on to other projects.

## Project Status

When [Dr. Erin MacDonald's algorithm](https://twitter.com/drerinmac/status/1575316749808902145) is made public, I might come back and redo this a third time. Until then, I have no plans to work on this further.

## Installation

### PHP

Place Stardate.class.php in any location on your web server. For additional security, you may wish to place it in a location that isn't directly accessible by users, though attempts to access the library directly will generate a 404 error.

The file Stardate.test.php is not required in order to use the library and does not need to be placed on the web server unless you want to run unit tests.

### ASP Classic

Place Stardate.class.asp in any location on your web server, or on another machine on the same network. For additional security, you may wish to place it in a location that isn't directly accessible by users.

The file Stardate.test.asp is not required in order to use the library and does not need to be placed on the web server unless you want to run unit tests.

## Usage

### PHP

```PHP
// Change the path if you're storing the library in a different folder.
include 'Stardate.class.php';

// Feel free to alias the class so that you don't need to type my name every time you use it.
use ScottVM\Stardate as Stardate;

// Create a stardate numerically.
$secondPilot = new Stardate();
$secondPilot->set_value(1312.4);

// Displays '2265-10-23 09:45:38 PM'
echo $secondPilot->get_value_earthdate();

// Create a stardate from a Gregorian date.
$entD_launch = new Stardate();
$entD_launch->set_value(date_create("2362-11-23 18:40:35"));

// Displays 40759.5
echo $entD_launch->get_value_stardate();
```

### ASP Classic

```vbscript
<!--#include file="Stardate.class.asp"-->
<%
' Create a stardate.
dim secondPilot
set secondPilot = new Stardate
secondPilot.value = 1312.4

' Displays '2265-10-23 09:45:38 PM'
Response.Write secondPilot.value

' Create a stardate from a Gregorian date.
dim entD_launch
set entD_launch = new Stardate
entD_launch.value = DateSerial(2362,11,23) + TimeSerial(18,40,35)

' Displays '40759.5'
Response.Write entD_launch.earthDate
%>
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

See Stardate.test.php or Stardate.test.asp for unit tests.

## Authors

Version 1.0 written January 2009 by Scott Vander Molen

Version 2.0 written December 2023 by Scott Vander Molen
- original algorithm by [Phillip L. Sublett](https://trekguide.com/Stardates.htm); modified
- original Stardate FAQ by [Andrew Main](https://stason.org/TULARC/education-books/startrek-stardates/index.html) 

## License
This work is licensed under a [Creative Commons Attribution 4.0 International License](https://creativecommons.org/licenses/by/4.0/).