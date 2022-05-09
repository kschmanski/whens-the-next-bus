<?php

use src\MetroTransitApiHandler;

require __DIR__ . '/vendor/autoload.php';

function findNextBus(string $route_label, string $stop, string $direction) : void {
    $api_handler = new MetroTransitApiHandler();

    // Get the Route ID
    $route_id = $api_handler->getRouteIdForRouteLabel($route_label);

    if (is_null($route_id)) {
        echo ('Unable to find valid route ID for route ' . $route_label . PHP_EOL);
        exit();
    }

    // Get the Direction ID
    $direction_name = ucfirst($direction) . 'bound';
    $direction_id = $api_handler->getDirectionIdForRouteIdAndDirection($route_id, $direction_name);

    if (is_null($direction_id)) {
        echo ('Unable to find valid direction ID for direction ' . $direction . PHP_EOL);
        exit();
    }

    // Get the Place Code
    $place_code = $api_handler->getPlaceCodeForRouteIdDirectionIdAndPlaceDescription($route_id, $direction_id, $stop);

    if (is_null($place_code)) {
        echo ('Unable to find valid Place Code for stop ' . $stop . PHP_EOL);
        exit();
    }

    // Now that we have all the data we need, get the soonest departure
    $soonest_departure = $api_handler->getSoonestDepartureForRouteIdDirectionIdPlaceCode($route_id, $direction_id, $place_code);

    echo $soonest_departure->departure_text . PHP_EOL;
    exit();
}

// Do some error handling in case we don't get enough args or too many args
findNextBus($argv[1], $argv[2], $argv[3]);

// TODO - some data validation