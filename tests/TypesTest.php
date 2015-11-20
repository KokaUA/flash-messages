<?php

namespace Koka\Flash\Tests;

use Koka\Flash\Types;
use PHPixie\Test\Testcase;

class TypesTest extends Testcase
{
    protected $types;

    protected function setUp()
    {
        $this->types = new Types(['danger' => 'alert alert-danger']);
    }

    public function testTypesInstance()
    {
        $this->assertInstanceOf('Koka\Flash\Types', $this->types);
    }

    public function testGetDefaultType()
    {
        $this->assertSame('success', $this->types->getType('success'));
    }

    public function testGetOverwriteType()
    {
        $this->assertSame('alert alert-danger', $this->types->getType('danger'));
    }
}
