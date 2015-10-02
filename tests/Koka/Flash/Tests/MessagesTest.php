<?php

namespace Koka\Flash\Tests;

use Koka\Flash\Messages;
use Koka\Flash\Message;

class MessagesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Messages
     */
    protected $messages;

    protected function setUp()
    {
        $sessionStub = new SessionStub();

        $contextMock = $this->getMockBuilder('\PHPixie\HTTP\Context')
            ->setMethods(['session'])
            ->disableOriginalConstructor()
            ->getMock();
        $contextMock->expects($this->any())
            ->method('session')
            ->willReturn($sessionStub);

        $containerMock = $this->getMockBuilder('\PHPixie\HTTP\Context\Container')
            ->setMethods(['httpContext'])
            ->disableOriginalConstructor()
            ->getMock();
        $containerMock->expects($this->any())
            ->method('httpContext')
            ->willReturn($contextMock);

        $this->messages = new Messages($containerMock);
    }

    public function testGetEmptyMessages()
    {
        $this->assertEmpty($this->messages->get());
    }

    public function testPushMessage()
    {
        $this->messages->push(Message::SUCCESS, 'success message');
        $this->assertCount(1, $this->messages->get()[Message::SUCCESS]);
    }

    public function testPopWithType()
    {
        $this->messages->push(Message::SUCCESS, 'success message');
        $this->messages->pop(Message::SUCCESS);
        $this->assertEmpty($this->messages->get());
    }

    public function testPopWithoutType()
    {
        $this->messages->push(Message::SUCCESS, 'success message');
        $this->messages->pop();
        $this->assertEmpty($this->messages->get());
    }

    public function testPopEmptyMessages()
    {
        $this->assertNull($this->messages->pop(Message::ERROR));
    }

    public function testValidMessage()
    {
        $this->messages->push(Message::SUCCESS, 'success message');
        $message = $this->messages->pop(Message::SUCCESS);
        $this->assertInstanceOf('Koka\Flash\Message', $message);
        $this->assertSame('success message', $message->getMessage());
        $this->assertSame('success', $message->getType());
    }

    public function testPopAllEmpty()
    {
        $this->assertNull($this->messages->popAll());
    }

    public function testPopAllMessages()
    {
        $this->messages->push(Message::SUCCESS, 'success message 1');
        $this->messages->push(Message::SUCCESS, 'success message 2');
        $this->messages->push(Message::NOTICE, 'notice message 1');
        $this->messages->push(Message::WARNING, 'warning message 1');
        $this->assertCount(4, $this->messages->popAll());
        $this->assertEmpty($this->messages->get());
    }

    public function testPopAllWithType()
    {
        $this->messages->push(Message::ERROR, 'Error message 1');
        $this->messages->push(Message::ERROR, 'Error message 2');
        $this->messages->push(Message::WARNING, 'warning message 1');
        $this->assertCount(2, $this->messages->popAll(Message::ERROR));
        $this->assertCount(1, $this->messages->popAll(Message::WARNING));
        $this->assertEmpty($this->messages->get());
    }

    public function testPopWithArrayTypes()
    {
        $this->messages->push(Message::ERROR, 'Error message 1');
        $this->messages->push(Message::ERROR, 'Error message 2');
        $this->messages->push(Message::WARNING, 'warning message 1');
        $this->messages->push(Message::SUCCESS, 'success message 1');
        $this->messages->push(Message::SUCCESS, 'success message 2');
        $this->messages->push(Message::NOTICE, 'notice message 1');
        $this->assertCount(3, $this->messages->popAll([Message::SUCCESS, Message::NOTICE]));
        $this->assertCount(3, $this->messages->popAll());
    }

    public function testHasMessagesWithoutType()
    {
        $this->assertFalse($this->messages->hasMessages());
        $this->messages->push(Message::SUCCESS, 'success message 1');
        $this->assertTrue($this->messages->hasMessages());
    }

    public function testHasMessagesWithType()
    {
        $this->messages->push(Message::SUCCESS, 'success message 1');
        $this->assertFalse($this->messages->hasMessages(Messages::WARNING));
        $this->assertTrue($this->messages->hasMessages(Messages::SUCCESS));
    }

    public function testMagicAddMessages()
    {
        $this->messages->info('Info message');
        $this->messages->notice('notice message');
        $this->assertCount(2, $this->messages->popAll());
    }

    public function testCurrent()
    {
        $this->assertFalse($this->messages->current());
        $this->messages->notice('notice message');
        $this->messages->rewind();
        $this->assertInstanceOf('Koka\Flash\Message', $this->messages->current());
    }

    public function testNext()
    {
        $this->messages->notice('notice message');
        $this->messages->notice('notice message');
        $this->messages->rewind();
        $this->assertInstanceOf('Koka\Flash\Message', $this->messages->next());
        $this->assertFalse($this->messages->next());
    }

    public function testKey()
    {
        $this->assertNull($this->messages->key());
        $this->messages->notice('notice message');
        $this->messages->rewind();
        $this->assertSame($this->messages->key(), 0);
    }

    public function testValid()
    {
        $this->assertFalse($this->messages->valid());
        $this->messages->notice('notice message');
        $this->messages->rewind();
        $this->assertTrue($this->messages->valid());
    }

    public function testRewind()
    {
        $this->assertFalse($this->messages->valid());
        $this->messages->notice('notice message');
        $this->messages->rewind();
        $this->assertTrue($this->messages->valid());
    }
}
