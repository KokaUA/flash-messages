<?php

namespace Koka\Flash;

/**
 * Class Message
 * @package Koka\Flash
 */
class Message
{
    /**
     * @var array
     */
    protected $types = [
        'error' => 'error',
        'danger' => 'danger',
        'warning' => 'warning',
        'notice' => 'notice',
        'alert' => 'alert',
        'info' => 'info',
        'success' => 'success'
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
     * @param array $types
     * @param int|string $type
     * @param string $message
     */
    public function __construct($types, $type, $message)
    {
        $this->types = array_merge($this->types, $types);
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
     * @param bool $asCode
     * @return int|string
     */
    public function getType($asCode = false)
    {
        if ($asCode) {
            return $this->type;
        }
        return $this->types[$this->type];
    }
}
