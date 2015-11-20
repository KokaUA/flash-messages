<?php

namespace Koka\Flash;

use PHPixie\HTTP\Context\Container as HttpContextContainer;

/**
 * Class Flash
 * @package Koka\Flash
 */
class Flash extends Container implements FlashInterface
{
    /**
     * @var Types
     */
    protected $types;

    /**
     * @param HttpContextContainer $httpContextContainer
     * @param array $types
     */
    public function __construct(HttpContextContainer $httpContextContainer, array $types = [])
    {
        $this->types = new Types($types);
        parent::__construct($httpContextContainer);
    }

    /**
     * @param string|array $type
     * @return Message|null
     */
    public function pop($type = null)
    {
        $messages = $this->get();
        if ($type && is_string($type) && isset($messages[$type])) {
            foreach ($messages[$type] as $key => $message) {
                $allMessages[] = $message;
                unset($messages[$type][$key]);
            }
        } elseif ($type && is_array($type)) {
            foreach ($type as $subType) {
                if (isset($messages[$subType])) {
                    foreach ($messages[$subType] as $key => $message) {
                        $allMessages[] = $message;
                        unset($messages[$subType][$key]);
                    }
                }
            }
        } else {
            foreach ($messages as $type => $array) {
                foreach ($messages[$type] as $key => $message) {
                    $allMessages[] = $message;
                    unset($messages[$type][$key]);
                }
            }
        }
        $this->set($messages);
        return isset($allMessages) ? $allMessages : null;
    }

    /**
     * @param string $type
     * @return bool
     */
    public function has($type = null)
    {
        $messages = $this->get();
        if ($type) {
            return array_key_exists($type, $messages);
        }
        return !empty($messages);
    }

    /**
     * @param string $type
     * @param string $message
     */
    protected function push($type, $message)
    {
        $messages = $this->get();
        $message = new Message($type, $message, $this->types);
        $messages[$message->getType(true)][] = $message;
        $this->set($messages);
    }

    /**
     * @param string $message
     * @return $this
     */
    public function error($message)
    {
        $this->push('error', $message);
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function danger($message)
    {
        $this->push('danger', $message);
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function warning($message)
    {
        $this->push('warning', $message);
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function notice($message)
    {
        $this->push('notice', $message);
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function alert($message)
    {
        $this->push('alert', $message);
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function info($message)
    {
        $this->push('info', $message);
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function success($message)
    {
        $this->push('success', $message);
        return $this;
    }
}
