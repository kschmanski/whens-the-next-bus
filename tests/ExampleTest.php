<?php

use PHPUnit\Framework\TestCase;
use \src\MetroTransitApiHandler;

final class ExampleTest extends TestCase {
    public function testMyTest() : void {

        $this->assertEquals(901,
        //(new MetroTransitApiHandler)->findRouteIdForRouteLabel('METRO Blue Line')
            // TODO - do some updating here to not need to instantiate new handlers every time
            (new MetroTransitApiHandler())->findRouteIdForRouteLabel('METRO Blue Line')
        );
    }
}