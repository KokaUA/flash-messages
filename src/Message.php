<?php

namespace Koka\Flash;

/**
 * Class Message
 * @package Koka\Flash
 */
class Message
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var Types
     */
    protected $types;

    /**
     * @param string $type
     * @param string $message
     * @param Types $types
     */
    public function __construct($type, $message, Types $types)
    {
        $this->type = $type;
        $this->text = $message;
        $this->types = $types;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getMessage();
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->text;
    }

    /**
     * @param bool $asKey
     * @return string
     */
    public function getType($asKey = false)
    {
        if ($asKey) {
            return $this->type;
        }
        return $this->types->getType($this->type);
    }
}
