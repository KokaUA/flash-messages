<?php

namespace Koka\Flash;

class Types
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
     * Types constructor.
     * @param array $types
     */
    public function __construct(array $types = [])
    {
        $this->types = array_merge($this->types, $types);
    }


    /**
     * @param string $type
     * @return string
     */
    public function getType($type)
    {
        return $this->types[$type];
    }
}
