<?php

namespace Koka\Flash;

use RuntimeException;

/**
 * Class Message
 * @package Koka\Flash
 */
class Message extends Type
{

    /**
     * @var array
     */
    protected $types = [
        'error' => 10,
        'warning' => 20,
        'notice' => 30,
        'info' => 40,
        'success' => 50
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
     * @param bool $typeAsString
     * @throws RuntimeException
     */
    public function __construct($type, $message, $typeAsString = false)
    {
        if ($typeAsString) {
            if (array_key_exists($type, $this->types)) {
                $type = $this->types[$type];
            } else {
                throw new RuntimeException('Invalid type for messages {$type}');
            }
        }
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
        return $asInt? $this->type: array_search($this->type, $this->types);
    }
}
