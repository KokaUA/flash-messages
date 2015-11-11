<?php

namespace Koka\Flash\Tests;

use Koka\Flash\Flash;
use Koka\Flash\Message;
use PHPixie\Test\Testcase;

class FlashTest extends Testcase
{
    /**
     * @var Flash
     */
    protected $flash;

    public function testFlashInstance()
    {
        $this->assertInstanceOf('\Koka\Flash\FlashInterface', $this->flash);
    }

    public function testPushErrorMessage()
    {
        $this->assertFalse($this->flash->has());
        $this->flash->error('Test error message');
        $this->asserttrue($this->flash->has());
    }

    public function testPushDangerMessage()
    {
        $this->assertFalse($this->flash->has());
        $this->flash->danger('Test danger message');
        $this->asserttrue($this->flash->has());
    }

    public function testPushWarningMessage()
    {
        $this->assertFalse($this->flash->has());
        $this->flash->warning('Test warning message');
        $this->asserttrue($this->flash->has());
    }

    public function testPushNoticeMessage()
    {
        $this->assertFalse($this->flash->has());
        $this->flash->notice('Test notice message');
        $this->asserttrue($this->flash->has());
    }

    public function testPushInfoMessage()
    {
        $this->assertFalse($this->flash->has());
        $this->flash->info('Test info message');
        $this->asserttrue($this->flash->has());
    }

    public function testPushSuccessMessage()
    {
        $this->assertFalse($this->flash->has());
        $this->flash->success('Test success message');
        $this->asserttrue($this->flash->has());
    }

    public function testHasMessagesWithoutType()
    {
        $this->assertFalse($this->flash->has());
        $this->flash->success('Test has message');
        $this->asserttrue($this->flash->has());
    }

    public function testHasMessagesWithType()
    {
        $this->assertFalse($this->flash->has());
        $this->flash->success('Test has message');
        $this->assertFalse($this->flash->has(Message::INFO));
        $this->assertTrue($this->flash->has(Message::SUCCESS));
    }

    public function testPopMessagesWithoutType()
    {
        $this->assertNull($this->flash->pop());
        $this->flash->success('Test pop message');
        $this->flash->success('Test pop message');
        $this->assertCount(2, $this->flash->pop());
        $this->assertNull($this->flash->pop());
    }

    public function testPopMessageWithIntType()
    {
        $this->flash->success('Test pop message');
        $this->flash->success('Test pop message');
        $this->flash->info('Test pop message');
        $this->assertCount(2, $this->flash->pop(Message::SUCCESS));

    }

    public function testPopMessageWithArrayType()
    {
        $this->flash->success('Test pop message');
        $this->flash->success('Test pop message');
        $this->flash->info('Test pop message');
        $this->flash->info('Test pop message');
        $this->flash->notice('Test pop message');
        $this->assertCount(3, $this->flash->pop([Message::SUCCESS, Message::NOTICE]));
    }

    protected function setUp()
    {
        $sessionStub = new SessionStub();

        $contextMock = $this->quickMock('\PHPixie\HTTP\Context', ['session']);
        $this->method($contextMock, 'session', $sessionStub);

        $containerMock = $this->quickMock('\PHPixie\HTTP\Context\Container', ['httpContext']);
        $this->method($containerMock, 'httpContext', $contextMock);

        $this->flash = new Flash($containerMock);
    }
}
