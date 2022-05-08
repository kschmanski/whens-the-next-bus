<?php

include 'MetroTransitApiHandler.php';
require __DIR__ . '/vendor/autoload.php';

function findNextBus(string $route_label, string $stop, string $direction) : void {
    $api_handler = new MetroTransitApiHandler();

    $route_id = $api_handler->findRouteIdForRouteLabel($route_label);
    $direction_name = ucfirst($direction) . 'bound';
    $direction_id = $api_handler->getDirectionIdForRouteIdAndDirection($route_id, $direction_name);
    $place_code = $api_handler->getPlaceCodeForRouteIdDirectionIdAndPlaceDescription($route_id, $direction_id, $stop);
    $a = $api_handler->getScheduleForRouteIdDirectionIdPlaceCode($route_id, $direction_id, $place_code);
    var_dump($a['departure_text']);
}


// Do some error handling in case we don't get enough args or too many args
findNextBus($argv[1], $argv[2], $argv[3]);