<?php

namespace Koka\Flash;

use PHPixie\HTTP\Context\Container;

/**
 * Class Messages
 * @method void error(string $message)
 * @method void warning(string $message)
 * @method void notice(string $message)
 * @method void info(string $message)
 * @method void success(string $message)
 * @package Koka\Flash
 */
class Messages extends Type
{

    /**
     * @var Container
     */
    protected $httpContextContainer;

    /**
     * @param \PHPixie\HTTP\Context\Container $httpContextContainer
     */
    public function __construct(Container $httpContextContainer)
    {
        $this->httpContextContainer = $httpContextContainer;
    }

    /**
     * @return \PHPixie\HTTP\Context\Session
     */
    protected function session()
    {
        return $this->httpContextContainer->httpContext()->session();
    }

    /**
     * @return array
     */
    public function get()
    {
        $messages = $this->session()->get('messages');
        return is_array($messages) ? $messages : [];
    }

    /**
     * @param array $messages
     */
    private function set(array $messages)
    {
        $this->session()
            ->set('messages', array_filter($messages, function ($val) {
                return count($val) ? true : false;
            }));
    }

    /**
     * @param $type int|string
     * @param $message string
     * @param bool $typeAsString
     */
    public function push($type, $message, $typeAsString = false)
    {
        $messages = $this->get();
        $message = new Message($type, $message, $typeAsString);
        $messages[$message->getType(true)][] = $message;
        $this->set($messages);
    }

    /**
     * @param int $type
     * @return \Koka\Flash\Message|null
     */
    public function pop($type = null)
    {
        $messages = $this->get();
        if ($type) {
            !array_key_exists($type, $messages)
                ?: $message = array_pop($messages[$type]);
        } else {
            $type = key($messages);
            !isset($type)
                ?: $message = array_pop($messages[$type]);
        }
        $this->set($messages);
        return isset($message) ? $message : null;
    }

    /**
     * @param int $type
     * @return \Koka\Flash\Message|null
     */
    public function popAll($type = null)
    {
        $messages = $this->get();
        if ($type && is_int($type) && isset($messages[$type])) {
            foreach ($messages[$type] as $key => $message) {
                $allMessages[] = $message;
                unset ($messages[$type][$key]);
            }
        } elseif ($type && is_array($type)) {
            foreach ($type as $subType) {
                if (isset($messages[$subType])) {
                    foreach ($messages[$subType] as $key => $message) {
                        $allMessages[] = $message;
                        unset ($messages[$subType][$key]);
                    }
                }
            }
        } else {
            foreach ($messages as $type => $array) {
                foreach ($messages[$type] as $key => $message) {
                    $allMessages[] = $message;
                    unset ($messages[$type][$key]);
                }
            }
        }
        $this->set($messages);
        return isset($allMessages) ? $allMessages : null;
    }

    /**
     * @param int|string $type
     * @return bool
     */
    public function hasMessages($type = null)
    {
        $messages = $this->get();
        return $type ? array_key_exists($type, $messages) : !empty($messages);
    }

    /**
     * @param int|string $type
     * @param array $args
     */
    public function __call($type, $args)
    {
        !in_array($type, ['error', 'warning', 'notice', 'info', 'success'])
            ?: $this->push($type, $args[0], true);
    }
}
