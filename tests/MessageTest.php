<?php

namespace Koka\Flash\Tests;

use Koka\Flash\Message;
use Koka\Flash\Types;
use PHPixie\Test\Testcase;

class MessageTest extends Testcase
{
    protected $msg;

    public function testMessageInstance()
    {
        $this->assertInstanceOf('Koka\Flash\Message', $this->msg);
    }

    public function testGetMessage()
    {
        $this->assertSame('Info message', $this->msg->getMessage());
        $this->assertSame('Info message', "$this->msg");
    }

    public function testGetType()
    {
        $this->assertSame('alert-info', $this->msg->getType());
    }

    public function testGetTypeAsKey()
    {
        $this->assertSame('info', $this->msg->getType(true));
    }

    protected function setUp()
    {
        $types = new Types(['info' => 'alert-info']);
        $this->msg = new Message('info', 'Info message', $types);
    }
}
