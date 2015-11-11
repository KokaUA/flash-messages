<?php

namespace Koka\Flash;

/**
 * Class Message
 * @package Koka\Flash
 */
class Message
{
    /**
     * @const
     */
    const ERROR = 10;
    /**
     * @const
     */
    const DANGER = 20;

    /**
     * @const
     */
    const WARNING = 30;

    /**
     * @const
     */
    const NOTICE = 40;

    /**
     * @const
     */
    const INFO = 50;

    /**
     * @const
     */
    const SUCCESS = 60;

    /**
     * @var array
     */
    protected $types = [
        'error' => 10,
        'danger' => 20,
        'warning' => 30,
        'notice' => 40,
        'info' => 50,
        'success' => 60
    ];

    /**
     * @var int
     */
    protected $type;

    /**
     * @var string
     */
    protected $text;

    /**
     * @param int|string $type
     * @param string $message
     */
    public function __construct($type, $message)
    {
        $this->type = $type;
        $this->text = $message;
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
     * @param bool $asInt
     * @return int|string
     */
    public function getType($asInt = false)
    {
        if ($asInt) {
            return $this->type;
        }
        return array_search($this->type, $this->types);
    }
}
