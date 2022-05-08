<?php

require __DIR__ . '/vendor/autoload.php';

use Curl\Curl;

class MetroTransitApiHandler {

    /**
     * @var Curl
     */
    private $curl;

    /**
     * @var
     */
    private $api_base_url = 'https://svc.metrotransit.org/nextripv2/';

    public function __construct() {
        $this->curl = new Curl();
    }

    /**
     * @param string $route_label
     * @return string
     */
    public function findRouteIdForRouteLabel(string $route_label) : string {
        // Update this to create a constant for the metro transit site
        $bus_routes = $this->curl->get($this->api_base_url . 'routes');
        $f = array_search($route_label, array_column($bus_routes, 'route_label'));

        // This is so ugly, update this
        $f = ((array)$bus_routes[(int)$f])['route_id'];
        // Update this return type
        return $f ?: 'none';
    }

    /**
     * @param string $route_id
     * @param string $direction_name
     * @return int
     */
    public function getDirectionIdForRouteIdAndDirection(string $route_id, string $direction_name) : int {
        $directions = $this->curl->get($this->api_base_url . 'directions/' . $route_id);

        // Super ugly but it works (will get changed at some point)
        $f = array_search($direction_name, array_column($directions, 'direction_name'));

        // Do some error checking here in case the direction doesn't exist
        $direction_id = ((array)$directions[(int)$f])['direction_id'];

        return $direction_id;
    }

    /**
     * @param string $route_id
     * @param int $direction_id
     * @param string $place_description
     * @return string
     */
    public function getPlaceCodeForRouteIdDirectionIdAndPlaceDescription(string $route_id, int $direction_id, string $place_description) : string {
        // TODO - should probably update this GET to use an array of params instead of just hardcoding link
        $places = $this->curl->get($this->api_base_url . 'stops/' . $route_id . '/' . $direction_id);

        $f = array_search($place_description, array_column($places, 'description'));
        return ((array)$places[$f])['place_code'];
    }

    /**
     * @param string $route_id
     * @param int $direction_id
     * @param string $place_code
     * @return array
     */
    public function getScheduleForRouteIdDirectionIdPlaceCode(string $route_id, int $direction_id, string $place_code) : array {
        // TODO - should probably update this GET to use an array of params instead of just hardcoding link
        $schedule = $this->curl->get($this->api_base_url . $route_id . '/' . $direction_id . '/' . $place_code);
        
        var_dump(((array)$schedule)['departures']);
        return (array)((array)$schedule)['departures'][0];
    }
}