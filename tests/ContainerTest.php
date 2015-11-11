<?php

namespace Koka\Flash\Tests;

use Koka\Flash\Container;
use PHPixie\Test\Testcase;

class ContainerTest extends Testcase
{
    /**
     * @var Container
     */
    protected $container;

    protected $sessionStub;

    public function testIteratorWithoutMessages()
    {
        $this->container->rewind();
        $this->assertFalse($this->container->valid());
    }

    public function testIteratorWithMessages()
    {
        $data = ['One', 'Two', 'Three'];
        $this->sessionStub->set('messages', [10 => $data]);

        $this->container->rewind();
        $this->assertTrue($this->container->valid());
        $this->assertSame('One', $this->container->current());
        $this->assertSame(0, $this->container->key());
        $this->container->next();

        $this->assertTrue($this->container->valid());
        $this->assertSame('Two', $this->container->current());
        $this->assertSame(1, $this->container->key());
        $this->container->next();

        $this->assertTrue($this->container->valid());
        $this->assertSame('Three', $this->container->current());
        $this->assertSame(2, $this->container->key());
        $this->container->next();
        $this->assertFalse($this->container->valid());
    }

    protected function setUp()
    {
        $this->sessionStub = new SessionStub();

        $contextMock = $this->quickMock('\PHPixie\HTTP\Context', ['session']);
        $this->method($contextMock, 'session', $this->sessionStub);

        $containerMock = $this->quickMock('\PHPixie\HTTP\Context\Container', ['httpContext']);
        $this->method($containerMock, 'httpContext', $contextMock);

        $this->container = new Container($containerMock);
    }
}
