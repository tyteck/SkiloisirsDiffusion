<?php

namespace SkiLoisirsDiffusion\Tests\SoapHelpers;

use PHPUnit\Framework\TestCase;
use SkiLoisirsDiffusion\SoapHelpers\SoapElement;

class SoapElementTest extends TestCase
{
    /** @test */
    public function soap_element_is_ok()
    {
        $expectedElementName = 'lorem';
        $expectedElementValue = 'ipsum';
        $expectedElementType = 'string';
        $expectedElementNbOccurs = '0';

        $soapElement = SoapElement::create($expectedElementName, $expectedElementValue, $expectedElementType, $expectedElementNbOccurs);
        $this->assertEquals(
            '<xs:element name="lorem" type="xs:string" minOccurs="0" />',
            $soapElement->schema()
        );
        $this->assertEquals(
            "<lorem>{$expectedElementValue}</lorem>",
            $soapElement->body()
        );
    }
}
