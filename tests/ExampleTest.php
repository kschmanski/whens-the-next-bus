<?php

use PHPUnit\Framework\TestCase;
use src\MetroTransitApiHandler;

final class ExampleTest extends TestCase {
    /**
     * Test that a valid Route Label returns the correct Route ID.
     *
     * @return void
     */
    public function testValidRouteLabelReturnsCorrectRouteId() : void {
        $this->assertEquals(901,
                            (new MetroTransitApiHandler())->getRouteIdForRouteLabel('METRO Blue Line'));
    }

    /**
     * Test that an invalid Route Label returns a NULL Route ID.
     *
     * @return void
     */
    public function testInvalidRouteLabelReturnsNullRouteId() : void {
        $this->assertNull((new MetroTransitApiHandler())->getRouteIdForRouteLabel('Blink-182 is a great band'));
    }

    /**
     * Test that a valid Direction Name returns the correct Direction ID.
     *
     * @return void
     */
    public function testValidDirectionReturnsCorrectDirectionId() : void {
        $this->assertEquals(1,
                            (new MetroTransitApiHandler())->getDirectionIdForRouteIdAndDirection(901,
                                                                                                 'Southbound'));
    }

    /**
     * Test that an invalid Direction Name returns a NULL Direction ID.
     *
     * @return void
     */
    public function testInvalidDirectionReturnsNullDirectionId() : void {
        $this->assertNull((new MetroTransitApiHandler())->getDirectionIdForRouteIdAndDirection(901, 'Green Day is cool too'));
    }

    /**
     * Test that a valid Stop Name returns the correct Place Code.
     *
     * @return void
     */
    public function testValidStopNameReturnsCorrectPlaceCode() : void {
        $this->assertEquals('TF2',
                            (new MetroTransitApiHandler())->getPlaceCodeForRouteIdDirectionIdAndPlaceDescription(901,
                                                                                                                 1,
                                                                                                                 'Target Field Station Platform 2'));
    }

    /**
     * Test that an invalid Stop Name returns a NULL Place Code.
     *
     * @return void
     */
    public function testInvalidStopNameReturnsNullPlaceCode() : void {
        $this->assertNull((new MetroTransitApiHandler())->getPlaceCodeForRouteIdDirectionIdAndPlaceDescription(901, 0, 'Kaz\'s Bus Stop'));
    }

    /**
     * Test that getSoonestDepartureForRouteIdDirectionIdPlaceCode returns an instance of StdClass.
     *
     * @return void
     */
    public function testGetSoonestDepartureForRouteIdDirectionIdPlaceCodeReturnsStdClass() : void {
        $this->assertInstanceOf('stdClass',
                                (new MetroTransitApiHandler())->getSoonestDepartureForRouteIdDirectionIdPlaceCode(901,
                                                                                                                  0,
                                                                                                                  'TF2'));
    }

    /**
     * Test that getSoonestDepartureForRouteIdDirectionIdPlaceCode->departure_text is a string.
     *
     * @return void
     */
    public function testGetSoonestDepartureForRouteIdDirectionIdPlaceCodeDepartureTextReturnsString() : void {
        $this->assertIsString((new MetroTransitApiHandler())->getSoonestDepartureForRouteIdDirectionIdPlaceCode(901,
                                                                                                                0,
                                                                                                                'TF2')
                                                            ->departure_text);
    }
}