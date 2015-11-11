<?php

namespace Koka\Flash;

use Iterator;
use PHPixie\HTTP\Context\Container as HttpContextContainer;

/**
 * Class Container
 * @package Koka\Flash
 */
class Container implements Iterator
{
    /**
     * @var array
     */
    protected $MessagesCopy = [];

    /**
     * @var HttpContextContainer
     */
    protected $httpContextContainer;

    /**
     * @param HttpContextContainer $httpContextContainer
     */
    public function __construct(HttpContextContainer $httpContextContainer)
    {
        $this->httpContextContainer = $httpContextContainer;
    }

    /**
     * @return Message
     */
    public function current()
    {
        return current($this->MessagesCopy);
    }

    /**
     * @return Message
     */
    public function next()
    {
        return next($this->MessagesCopy);
    }

    /**
     * @return boolean
     */
    public function valid()
    {
        if ($this->key() !== null) {
            return true;
        } else {
            $this->MessagesCopy = [];
            return false;
        }
    }

    /**
     * @return int
     */
    public function key()
    {
        return key($this->MessagesCopy);
    }

    /**
     * @return Message
     */
    public function rewind()
    {
        $messages = $this->get();
        $allMessages = [];
        if (!empty($messages)) {
            foreach ($messages as $type => $array) {
                foreach ($messages[$type] as $key => $message) {
                    $allMessages[] = $message;
                    unset($messages[$type][$key]);
                }
            }

            $this->set($messages);
        }
        $this->MessagesCopy = $allMessages;
        return reset($this->MessagesCopy);
    }

    /**
     * @return array
     */
    protected function get()
    {
        $messages = $this->session()->get('messages');
        return is_array($messages) ? $messages : [];
    }

    /**
     * @return \PHPixie\HTTP\Context\Session
     */
    protected function session()
    {
        return $this->httpContextContainer->httpContext()->session();
    }

    /**
     * @param array $messages
     */
    protected function set(array $messages)
    {
        $this->session()
            ->set('messages', array_filter($messages, function ($val) {
                return count($val) ? true : false;
            }));
    }
}
