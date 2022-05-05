<?php

require __DIR__ . '/vendor/autoload.php';

use Curl\Curl;

function findNextBus(string $route, string $stop, string $direction) : void {
    echo findRouteIdForRouteLabel($route) . PHP_EOL;
    echo ('Bus route: ' . $route . PHP_EOL);
    echo ('Bus stop: ' . $stop . PHP_EOL);
    echo ('Direction: ' . $direction . PHP_EOL);
}

function findRouteIdForRouteLabel(string $route_label) : string {
    $curl = new Curl();
    $bus_routes = $curl->get('https://svc.metrotransit.org/nextripv2/routes');
    $f = array_search($route_label, array_column($bus_routes, 'route_label'));

    // This is so ugly, update this
    $f = ((array)$bus_routes[(int)$f])['route_id'];
    // Update this return type
    return $f ?: 'none';
}

// Do some error handling in case we don't get enough args or too many args
findNextBus($argv[1], $argv[2], $argv[3]);