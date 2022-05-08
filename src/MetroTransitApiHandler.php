<?php

namespace src;

use Curl\Curl;
use stdClass;

class MetroTransitApiHandler {
    /**
     * @var Curl
     */
    private $curl;

    /**
     * @var
     */
    private $api_base_url = 'https://svc.metrotransit.org/nextripv2/';

    /**
     * Constructor. Instantiate the Curl object used for this Api handler.
     */
    public function __construct() {
        $this->curl = new Curl();
    }

    /**
     * Close the instance of Curl when we are done.
     */
    public function __destruct() {
        $this->curl->close();
    }

    /**
     * Return the Route ID for the passed in $route_label.
     *
     * @param string $route_label
     *
     * @return string
     */
    public function findRouteIdForRouteLabel(string $route_label) : ?string {
        $all_routes = $this->curl->get($this->api_base_url . 'routes');

        $route_id = null;

        // Could use array_search and array_column here, but choosing to do it manually for readability
        // For each possible route, find the one that matches the passed in $route_label
        foreach ($all_routes as $route) {
            if ($route->route_label == $route_label) {
                $route_id = $route->route_id;
                break;
            }
        }

        if (is_null($route_id)) {
            throw new Exception('Null Route ID');
        }

        return $route_id;
    }

    /**
     * Return the Direction ID for the given $route_id and $direction_name.
     *
     * @param string $route_id
     * @param string $direction_name
     *
     * @return int
     */
    public function getDirectionIdForRouteIdAndDirection(string $route_id, string $direction_name) : int {
        $directions = $this->curl->get($this->api_base_url . 'directions/' . $route_id);

        $direction_id = null;

        foreach ($directions as $direction) {
            if ($direction->direction_name == $direction_name) {
                $direction_id = $direction->direction_id;
                break;
            }
        }

        return $direction_id;
    }

    /**
     * Returns the Place Code for the passed in $route_id, $direction_id, and $place_description.
     *
     * For example, a Place Description might be 'VA Medical Center Station', for which the
     * corresponding Place Code would be 'VAMC'.
     *
     * @param string $route_id
     * @param int $direction_id
     * @param string $place_description
     *
     * @return string
     */
    public function getPlaceCodeForRouteIdDirectionIdAndPlaceDescription(string $route_id, int $direction_id, string $place_description) : string {
        // TODO - should probably update this GET to use an array of params instead of just hardcoding link
        $places = $this->curl->get($this->api_base_url . 'stops/' . $route_id . '/' . $direction_id);

        $place_code = null;

        foreach ($places as $place) {
            if ($place->description == $place_description) {
                $place_code = $place->place_code;
                break;
            }
        }

        return $place_code;
    }

    /**
     * Returns the soonest Departure given the $route_id, $direction_id, and $place_code.
     *
     * @param string $route_id
     * @param int $direction_id
     * @param string $place_code
     *
     * @return stdClass
     */
    public function getSoonestDepartureForRouteIdDirectionIdPlaceCode(string $route_id, int $direction_id, string $place_code) : stdClass {
        // TODO - should probably update this GET to use an array of params instead of just hardcoding link
        $schedule = $this->curl->get($this->api_base_url . $route_id . '/' . $direction_id . '/' . $place_code);

        $departures = $schedule->departures;

        return $departures[0];
    }
}