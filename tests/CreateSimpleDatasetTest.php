<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class CreateSimpleDatasetTest extends TestCase
{
    /** @test */
    public function dataset_wrapper_is_ok()
    {
        $foo = [
            'nb_cheques_vacances'
        ];
        $schema = Dataset::wrapper()->schema();

        $this->assertStringContainsString($schema, '<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">');
        $this->assertStringContainsString($schema, '<xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:UseCurrentLocale="true">');
        $this->assertStringContainsString($schema, '<xs:complexType>');
        $this->assertStringContainsString($schema, '<xs:choice minOccurs="0" maxOccurs="unbounded">');
        $this->assertStringContainsString($schema, '<xs:element name="' . $this->tablename . '">');
        $this->assertStringContainsString($schema, '<xs:complexType>');
        $this->assertStringContainsString($schema, '<xs:sequence>');
        $this->assertStringContainsString($schema, '<xs:element name="nb_cheques_vacances" type="xs:string" minOccurs="0" />');
        $this->assertStringContainsString($schema, ' </xs:sequence>');
        $this->assertStringContainsString($schema, ' </xs:complexType>');
        $this->assertStringContainsString($schema, ' </xs:element>');
        $this->assertStringContainsString($schema, ' </xs:choice>');
        $this->assertStringContainsString($schema, ' </xs:complexType>');
        $this->assertStringContainsString($schema, ' </xs:element>');
        $this->assertStringContainsString($schema, '</xs:schema>');
    }
}
