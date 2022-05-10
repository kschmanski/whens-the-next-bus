# whens-the-next-bus
A command-line tool interacting with the [Metro Transit API](https://svc.metrotransit.org/swagger/index.html) to output when the bus or train is arriving at the given stop in the given direction.

#Prerequisites
System requirements are the following:
* PHP > 7.3 
  * This will likely work with any version of PHP > 7.0, but I tested this on a machine with PHP 7.3.29 installed 
  * Instructions for installing PHP are here: https://www.geeksforgeeks.org/how-to-install-php-on-macos/
* Composer > 2.0
  * Composer is a dependency management tool for PHP
  * Composer's download page is located here: https://getcomposer.org/download/
# Installation
To install this tool, clone the GitHub repository:
```bash
git clone git@github.com:kschmanski/whens-the-next-bus.git
```

Then, run composer install from inside the `whens-the-next-bus` directory:
```bash
composer install
```
This should install the necessary libraries needed for this project, which are CURL and PHPUnit.

#Usage
The tool takes in three arguments:
* Argument 1 is the Route name
* Argument 2 is the Stop name
* Argument 3 is the direction (north, south, east or west)

Example:
```bash
php nextbus.php "METRO Blue Line" "Mall of America Station" "south"
```
# Unit tests
To run the unit tests, run the following from your command line:
```bash
./vendor/bin/phpunit --testdox tests
```

# Troubleshooting
* Why do I see `* Closing connection 0` outputted on my Command Line?
  * It's likely that your version of curl is outdated
  * If you're using Homebrew, updating curl should be straightforward
  * More info: https://github.com/php-curl-class/php-curl-class/issues/596