<?php

/*
Sample atoum configuration file to have tests results in xUnit format.
Do "php path/to/test/file -c path/to/this/file" or "php path/to/atoum/scripts/runner.php -c path/to/this/file -f path/to/test/file" to use it.
*/

use \mageekguy\atoum;

$script->addDefaultReport();

$xunit = new atoum\reports\asynchronous\xunit();
$runner->addReport($xunit);
 
$writer = new atoum\writers\file(__DIR__.'/../build/logs/atoum.xunit.xml');
$xunit->addWriter($writer);

