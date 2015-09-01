<?php

namespace Koka\Flash\Tests;

use Koka\Flash\Message;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    protected $msg;

    protected function setUp()
    {
        $this->msg = new Message(Message::INFO, 'Info message');
    }

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
        $this->assertSame('info', $this->msg->getType());
        $this->assertSame(Message::INFO, $this->msg->getType(true));
    }

    /**
     * @expectedException RuntimeException
     */
    public function testBadType()
    {
        $msg = new Message('err', 'bad type', true);
    }
}
