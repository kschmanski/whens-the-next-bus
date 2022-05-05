<?php

function findNextBus(string $route, string $stop, string $direction) : void {
    echo ('Bus route: ' . $route . PHP_EOL);
    echo ('Bus stop: ' . $stop . PHP_EOL);
    echo ('Direction: ' . $direction . PHP_EOL);
}

// Do some error handling in case we don't get enough args or too many args
findNextBus($argv[1], $argv[2], $argv[3]);