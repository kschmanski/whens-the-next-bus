<?php

require __DIR__ . '/vendor/autoload.php';

use Curl\Curl;

function findNextBus(string $route, string $stop, string $direction) : void {
    $route_id = findRouteIdForRouteLabel($route);
    echo $route_id . PHP_EOL;
    $direction_name = ucfirst($direction) . 'bound';
    $direction_id = getDirectionIdForRouteIdAndDirection($route_id, $direction_name);
    echo $direction_id . PHP_EOL;
//    echo ('Bus route: ' . $route . PHP_EOL);
//    echo ('Bus stop: ' . $stop . PHP_EOL);
//    echo ('Direction: ' . $direction . PHP_EOL);
}

function findRouteIdForRouteLabel(string $route_label) : string {
    $curl = new Curl();
    // Update this to create a constant for the metro transit site
    $bus_routes = $curl->get('https://svc.metrotransit.org/nextripv2/routes');
    $f = array_search($route_label, array_column($bus_routes, 'route_label'));

    // This is so ugly, update this
    $f = ((array)$bus_routes[(int)$f])['route_id'];
    // Update this return type
    return $f ?: 'none';
}

function getDirectionIdForRouteIdAndDirection(string $route_id, string $direction_name) : int {
    $curl = new Curl();

    $directions = $curl->get('https://svc.metrotransit.org/nextripv2/directions/' . $route_id);

    // Super ugly but it works (will get changed at some point)
    $f = array_search($direction_name, array_column($directions, 'direction_name'));

    // Do some error checking here in case the direction doesn't exist
    $direction_id = ((array)$directions[(int)$f])['direction_id'];

    return $direction_id;

}

// Do some error handling in case we don't get enough args or too many args
findNextBus($argv[1], $argv[2], $argv[3]);